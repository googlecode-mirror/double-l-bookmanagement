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
		}
		$this->_get_amazon_bookinfo($asin,$bookinfo);
		return $bookinfo;
	}
	private function _get_amazon_json($asin){
		$HttpSocket = new HttpSocket();
		$url = 'http://www.amazon.com/gp/search-inside/service-data';
		$query = 'asin='.$asin.'&method=getBookData';
		$response = $HttpSocket->post($url,$query);
		if(!$response->isOk()) return false;
		return json_decode($response->body);		
	}
	private function _get_amazon_bookinfo($asin, &$bookinfo){
		$HttpSocket = new HttpSocket();
		$url = 'http://www.amazon.com/dp/'.$asin;
		$query = '';
		$response = $HttpSocket->post($url,$query);
		if(!$response->isOk()) return false;	
		return $this->_parse_amazon_bookinfo($response->body, $bookinfo);	
	}
	private function _parse_amazon_bookinfo($html, &$bookinfo){
		$tmphtml = $this->catdata($html, '<h2>Product Details</h2>','</ul>');
		
		if($tmphtml < 0) return false;
		// publisher
		$tmpp = $this->trimdata($tmphtml,'<b>Publisher:</b>',')');
		if($tmpp !== false){
			$p_end = strpos($tmpp, '(');
			$bookinfo['publisher'] = trim(substr($tmpp,0,$p_end-1));
			$bookinfo['date'] = date('Y-m-d',strtotime(substr($tmpp,$p_end+1)));
		}
	}
	
	
	public function amazon_search($isbn){
		$HttpSocket = new HttpSocket();
		$url = 'http://www.amazon.com/gp/search-inside/service-data';		
		$query = 'asin='.$isbn.'&method=getBookData';
		$response = $HttpSocket->post($url,$query);
		return json_decode($response->body);
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
	// 去除非數字的字元
	public function fixIsbn($isbn=null){
		if($isbn==null) return null;
		$isbn = str_replace(array("-"," "), "", $isbn);
		
		if(strlen($isbn) == 13 || strlen($isbn) ==10) return $isbn; 
		return $isbn;
	}

	public function saveImage($isbn=null, $url=null){
		if($isbn== null || $url == null || $url=='') return $this->DEFAULT_BOOK_IMAGE;
		$http = new HttpSocket();
		$f = fopen(WWW_ROOT . 'img'.DS.'books' .DS. $isbn.'.png', 'w');
		$http->setContentResource($f);
		$http->get($url);
		fclose($f);
		return 'books/'.$isbn.'.png';
		
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
	
}
?>