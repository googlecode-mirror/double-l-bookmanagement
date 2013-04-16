<?php
//UTF8編碼
App::uses('Component', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class IsbnfuncComponent extends Component {

	static $DEFAULT_BOOK_IMAGE = 'book_empty.png';
	public function catdata($html, $start_s, $end_s){
		$start_index = strpos($html, $start_s);
		if($start_index == false) return -1;
		$end_index = stripos($html, $end_s, $start_index);
		if($end_index == false) return -2;
		return substr($html, $start_index, $end_index + strlen($end_s) - $start_index);
	}

	public function trimdata($html, $start_s, $end_s){
		$start_index = stripos($html, $start_s);
		if($start_index == null) return -1;
		$end_index = stripos($html, $end_s, $start_index);
		if($end_index == null) return -2;
		$start_index = $start_index + strlen($start_s);
		$slen = $end_index - $start_index;
		return substr($html,$start_index,$slen );
	}
	public function cutdata($html, $start_s){
		$start_index = strpos($html, $start_s);
		if($start_index == null) return $html;
		return substr($html, $start_index+strlen($start_s));
	}

	public function search_bookinfo($isbn){
		$bookinfo = $this->isbndb_search($isbn);
		$aminfo = $this->amazon_search($bookinfo['isbn10']);
		
		if($aminfo != null){
			$imgs = (array)$aminfo->largeImageUrls;
			sort($imgs);
			//$book['Book']['book_image'] = reset($imgs);
			$bookinfo['book_image'] = reset($imgs);
		}		

		return $bookinfo;
	}
	// 整合全部資訊回復一個Book Info
	public function get_bookinfo($isbn, $book){
		$amazon_asin = $this->get_amazon_asin($isbn);
		$amazon_info = $this->get_amazon_bookinfo($amazon_asin);
		$isbn_info = $this->get_isbndb_bookinfo($isbn);
		$bookinfo = $this->_add_bookinfo($amazon_info,$isbn_info);
		$books_info = $this->get_books_bookinfo($isbn);
		$bookinfo = $this->_add_bookinfo($bookinfo,$books_info);
		//var_dump($bookinfo);
		if($bookinfo != null){
			if(array_key_exists('book_image',$bookinfo))
				$book['Book']['book_image'] = $this->saveImage($isbn, $bookinfo['book_image']);
			if(array_key_exists('publisher',$bookinfo))
				$book['Book']['book_publisher'] = $bookinfo['publisher'];
			if(array_key_exists('author',$bookinfo))
				$book['Book']['book_author'] = $bookinfo['author'];
			if(array_key_exists('bookname',$bookinfo))
				$book['Book']['book_name'] = $bookinfo['bookname'];
			if(array_key_exists('bookname',$bookinfo))
				$book['Book']['publish_date'] = $bookinfo['date'];
		}	
		return $book;	
	}
	// 
	/**
	 * 整合抓取 BookImage , 如果抓取不到則傳回 null
	 * @param unknown $isbn
	 * @return string $image_url, 完整的 image路徑
	 */
	public function get_bookimage($isbn){
		$image_url = null;
		$amazon_asin = $this->get_amazon_asin($isbn);
		$bookinfo = $this->get_amazon_bookinfo($amazon_asin);	
		$books_info = $this->get_books_bookinfo($isbn);
		$bookinfo = $this->_add_bookinfo($bookinfo,$books_info);
		
		if($bookinfo != null){
			if(array_key_exists('book_image',$bookinfo))
				$image_url = $this->saveImage($isbn, $bookinfo['book_image']);
			if($image_url == false) $image_url = null;
		}	
		return $image_url;
	}
	/**
	 * 
	 * @param string $isbn  10碼或13碼
	 * @return boolean|Ambigous <boolean, string> return false if dont get amazon asin, or return amazon asin
	 * 
	 */
	public function get_amazon_asin($isbn){
		$HttpSocket = new HttpSocket();
		$url = 'http://www.amazon.com/s/ref=nb_sb_noss';
		$query='url=search-alias%3Dstripbooks&field-keywords='.$isbn;
		$response = $HttpSocket->post($url,$query);
		if(!$response->isOk()) return false;
		$asin = $this->_parse_amazon_asin($response->body);
	
		return $asin;		
	}
	private function _parse_amazon_asin($html){
		$tmphtml = $this->catdata($html, 'result_0','>');
		if($tmphtml < 0 ) return false;
		$tmphtml = $this->trimdata($tmphtml,'name="','">');
		if(strlen($tmphtml) !== 10) return false;
		return $tmphtml;
	}
	public function get_amazon_bookinfo($asin){
		$bookinfo = null;
		/*
		$amazon_json = $this->_get_amazon_json($asin);
		if($amazon_json !== false){
			if(property_exists($amazon_json,'title')){
				$bookinfo['bookname'] = $amazon_json->title;
			}
			if(property_exists($amazon_json,'authorNameList')){
				$as = (array)$amazon_json->authorNameList;
				$bookinfo['author'] = implode(", ", $as);;
			}			
			if(property_exists($amazon_json,'largeImageUrls')){
				$imgs = (array)$amazon_json->largeImageUrls;
				sort($imgs);
				$bookinfo['book_image'] = reset($imgs);				
			}
		}*/
		$bookinfo = $this->_get_amazon_json($asin);
		$htmlinfo = $this->_get_amazon_bookinfo($asin,$bookinfo);
		
		return $this->_add_bookinfo($bookinfo,$htmlinfo);
	}
	// 運用amazon得jaon service 來得到相關商品資訊
	private function _get_amazon_json($asin){
		$bookinfo = null;
		$HttpSocket = new HttpSocket();
		$url = 'http://www.amazon.com/gp/search-inside/service-data';
		$query = 'asin='.$asin.'&method=getBookData';
		$response = $HttpSocket->post($url,$query);
		if(!$response->isOk()) return false;
		$amazon_json = json_decode($response->body);
		if($amazon_json !== false){
			if(property_exists($amazon_json,'title')){
				$bookinfo['bookname'] = $amazon_json->title;
			}
			if(property_exists($amazon_json,'authorNameList')){
				$as = (array)$amazon_json->authorNameList;
				$bookinfo['author'] = implode(", ", $as);;
			}
			if(property_exists($amazon_json,'largeImageUrls')){
				$imgs = (array)$amazon_json->largeImageUrls;
				sort($imgs);
				$bookinfo['book_image'] = reset($imgs);
			}
		}		
		//return json_decode($response->body);	
		return $bookinfo;	
	}
	// 運用amazon得商品頁面, 來得到相關資訊
	private function _get_amazon_bookinfo($asin){
		$HttpSocket = new HttpSocket();
		$url = 'http://www.amazon.com/dp/'.$asin;
		$query = '';
		$response = $HttpSocket->post($url,$query);
		if(!$response->isOk()) return false;
		//$this->saveFile($response->body);	
		return $this->_parse_amazon_bookinfo($response->body);	
	}
	private function _parse_amazon_bookinfo($html){
		$bookinfo = null;
		$tmphtml = $this->catdata($html, '<h2>Product Details</h2>','</ul>');
		
		if($tmphtml < 0) return false;
		// publisher
		$tmpp = $this->trimdata($tmphtml,'<b>Publisher:</b>',')');

		if($tmpp !== false){
			$p_end = strpos($tmpp, '(');
			$bookinfo['publisher'] = trim(substr($tmpp,0,$p_end-1));
			$bookinfo['date'] = date('Y-m-d',strtotime(substr($tmpp,$p_end+1)));
		}
		
		$tmphtml = $this->catdata($html, '<tr id="prodImageContainer">','</tr>');
		$tmpp = $this->trimdata($tmphtml,'<img onload="','/>');
		$tmpp = $this->trimdata($tmphtml,'src="','" id');
		if($tmpp !== false){
			$bookinfo['book_image'] = $tmpp;
		}


		return $bookinfo;
	}
	
	
	public function amazon_search($isbn){
		$HttpSocket = new HttpSocket();
		$url = 'http://www.amazon.com/gp/search-inside/service-data';		
		$query = 'asin='.$isbn.'&method=getBookData';
		$response = $HttpSocket->post($url,$query);
		return json_decode($response->body);
	}
	public function get_books_bookinfo($isbn){
		$HttpSocket = new HttpSocket();
		$url = 'http://search.books.com.tw/exep/prod_search.php?cat=BKA&key='.$isbn.'&apid=books&areaid=head_wel_search';
		$response = $HttpSocket->get($url, array(), array('redirect' => true));
		if(!$response->isOk()) return false;
		return $this->books_bookinfo($response->body);
	}
	
	public function books_bookinfo($html){
		
		$bookinfo = null;
		$tmphtml = $this->catdata($html, '<ul class="searchbook">','</ul>');		
		if($tmphtml < 0) return false;
		$bookitem = $this->catdata($tmphtml, '<li class="item">','</li>');		
		if($bookitem < 0) return false;
		$bookimage = $this->trimdata($bookitem,'src="','"');		
		if($bookimage < 0) return false;
		$image_url = $this->trimdata($bookimage,'?i=','&w=');
		//var_dump($image_url);
		if($image_url < 0) return false;
		$bookinfo['book_image'] = $image_url;
		return $bookinfo;
	}
	
	public function get_isbndb_bookinfo($isbn){
		$HttpSocket = new HttpSocket();
		$url = 'http://isbndb.com/search-all.html?kw='.$isbn.'&x=10&y=13';
		$response = $HttpSocket->get($url, array(), array('redirect' => true));
		if(!$response->isOk()) return false;
		return $this->isbndb_bookinfo($response->body);		
	}
	public function isbndb_search($isbn){
		$HttpSocket = new HttpSocket();
		$url = 'http://isbndb.com/search-all.html?kw='.$isbn.'&x=10&y=13';
		$response = $HttpSocket->get($url, array(), array('redirect' => true));
		if(!$response->isOk()) return false;
		return $this->isbndb_bookinfo($response->body);
	
	}
	public function isbndb_bookinfo($html){
		$r = null;
		$tmphtml = $this->catdata($html, '<DIV CLASS="bookInfo">','</div>');
		 if($tmphtml < 0) return false;
 		// bookname
		$bookname = $this->trimdata($tmphtml,'<h1>','</h1>');
		$tmphtml = $this->cutdata($tmphtml,'</h1>');
		$r['bookname'] = trim($bookname);
		
		// author
		$tmpa = $this->trimdata($tmphtml,'>','Publisher:');
		$author = strip_tags($tmpa);
		$tmphtml = $this->cutdata($tmphtml,'<br>');
		$r['author'] = trim(trim($author), ',');
		// publisher
		$tmpp = $this->trimdata($tmphtml,'Publisher:','<br>');
		$publisher = strip_tags($tmpp);
		$tmphtml = $this->cutdata($tmphtml,'<br>');
		$r['publisher'] = trim($publisher);
		// ISBN10
		$tmp10 = $this->trimdata($tmphtml,'ISBN: ','&nbsp;');
		$r['isbn10'] = trim($tmp10);
		// ISBN13
		$tmp13 = $this->trimdata($tmphtml,'ISBN13: ','&nbsp;');
		$r['isbn13'] = trim($tmp13);
		// publish date
		$tmpd = $this->trimdata($tmphtml,'; ','</span>');
		$tmpd = trim($tmpd);
		if($this->checkDateFormat($tmpd)) $r['date'] = $tmpd;
		return $r;
	
	}

	public function checkIsbn($isbn=null){
		$result = null;
		$result['isIsbn'] = false;
		$result['errorMsg'] = "";
		$result['isbn'] = null; 
		if( $isbn==null || $isbn == ''){
			$result['errorMsg'] = 'ISBN 不能為空.';
			$result['isIsbn'] = false;
		}
		$isbn = str_replace(array("-"," "), "", $isbn);
		if(strlen($isbn) == 13 || strlen($isbn) ==10){
			$result['isbn'] = $isbn;
			$result['isIsbn'] = true;
		} else {
			$result['errorMsg'] = 'ISBN 格式錯誤, 須為10碼或13碼數字.';
			$result['isIsbn'] = false;
		}
		return $result;
	}
	// 去除非數字的字元
	public function fixIsbn($isbn=null){
		if($isbn==null) return null;
		$isbn = str_replace(array("-"," "), "", $isbn);
		
		if(strlen($isbn) == 13 || strlen($isbn) ==10) return $isbn; 
		return $isbn;
	}

	public function saveImage($isbn=null, $url=null){		
		if($isbn== null || $url == null || $url=='') return false;		
		$http = new HttpSocket();
		try{
		$f = fopen(WWW_ROOT . 'img'.DS.'books' .DS. $isbn.'.png', 'w');
		$http->setContentResource($f);
		$http->get($url);
		fclose($f);
		}catch(Exception $e){
			return false;
		}
		
		return 'books/'.$isbn.'.png';
		
	}
	
	public function saveFile($response){
		if($response == null) return false;
		try{
		$f = fopen(WWW_ROOT . 'img'.DS.'books' .DS. 'html.txt', 'w'); 
		fwrite($f,$response);
		fclose($f);
		} catch (Exception $e){
			return false;
		} 
		
		return true;
	}
	function checkDateFormat($date)
	{
		//match the format of the date
		if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts))
		{
			//check weather the date is valid of not
			if(checkdate($parts[2],$parts[3],$parts[1]))
		  return true;
			else
				return false;
		}
		else
			return false;
	}
	/**
	 * 將兩個不同來源的book_info, 組合成一個 $book_info. 
	 * 如果 main_info 已經存在該資料, 則用 add_info來取代
	 * @param mix $main_info
	 * @param mix $add_info
	 * @return mixed. $book_info
	 */
	private function _add_bookinfo($main_info, $add_info){
		$book_key = array('book_image','publisher','author','bookname','date');
		if($add_info != null){
			foreach($book_key as $key=>$pkey){
			if(($main_info == null || !array_key_exists($pkey,$main_info))
					&& array_key_exists($pkey,$add_info))
				$main_info[$pkey] = $add_info[$pkey];
			}
		}
		return $main_info;
	}
	
}
?>