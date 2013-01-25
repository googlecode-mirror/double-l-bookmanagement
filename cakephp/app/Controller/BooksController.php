<?php
App::uses('HttpSocket', 'Network/Http');
class BooksController extends AppController {
	public $uses = array('Book_Cate', 'Book', 'Book_Instance','Book_Publisher','Person_Level','System_Inc','System_Location', 'System_Print_Book');
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session', 'Formfunc','Systeminc','Bookfunc','Userfunc','Isbnfunc');

    public function book_index(){
    	$this->set('books', $this->Book->find('all',array(
        						'conditions' => array('Book.book_type' => 'B'))
    	));  	 
    }    
    
    public function journal_index(){
    	$this->set('books', $this->Book->find('all',array(
        						'conditions' => array('Book.book_type' => 'M'))
    	));  	 
    }
    public function book_view($id=null){
        if($id == null) {
            $this->redirect(array('action' => 'book_index'));
        }
        $this->Book->id = $id;
        $this->request->data = $this->Book->read(); 

        $cates = $this->Formfunc->convert_options($this->Book_Cate->find('all'), 'Book_Cate', 'id', 'catagory_name');
        $this->set('cates', $cates);
        $this->set('book_status', $this->Formfunc->book_status());
		$this->set('locations', $this->System_Location->find('list', array('fields' => array('id', 'location_name'))));
    }

    public function book_edit($id = null){
    	$this->Book->id = $id;
    	$cates = $this->Formfunc->convert_options($this->Book_Cate->find('all'), 'Book_Cate', 'id', 'catagory_name');
    	$this->set('cates', $cates);
    	
    	if($this->request->is('get')){
    		$this->request->data = $this->Book->read(); 
    	} else {
			$ret = $this->Book->save($this->request->data);
    		if ($ret) {
  				$this->Session->setFlash('儲存成功.');
                $this->redirect(array('action' => 'book_view',$ret['Book']['id']));
				//$this->Book->id = $ret['Book']['id'];
				//$this->request->data = $this->Book->read(); 
    		}else {
				$this->Session->setFlash('儲存失敗.');
			}
    	}
        $this->set('book_status', $this->Formfunc->book_status());
    }
    
    public function journal_edit($id = null){
    	$this->Book->id = $id;
    	$cates = $this->Formfunc->convert_options($this->Book_Cate->find('all'), 'Book_Cate', 'id', 'catagory_name');
    	$this->set('cates', $cates);
    	 
    	if($this->request->is('get')){
    		$this->request->data = $this->Book->read();
    	} else {
			$ret = $this->Book->save($this->request->data);
    		if ($ret) {
    			$this->Session->setFlash('儲存成功.');
				$this->Book->id = $ret['Book']['id'];
				$this->request->data = $this->Book->read(); 
    		}else {
    			$this->Session->setFlash('儲存失敗.');
    		}
    	}
    }
    
    //public function journal_instance_edit($book_id=null, $id=null){
    public function book_instance_edit($book_id=null, $id=null){
    	$error_msg = '';
    	if($book_id != null){
    		$this->Book->id = $book_id;
    		$book = $this->Book->read();
    		$this->Book_Instance->id = $id;
    		if($this->request->is('get')){
    				$book_instance = $this->Book_Instance->read();
					if ($book_instance !== false) {
						$this->request->data = $book_instance;
                        $this->set('is_modify',false);
					}
					else {
						$this->request->data['Book_Instance']['id'] = null;
						$this->request->data['Book_Instance']['is_lend'] = 'N';
                        $this->set('is_modify',true);
					}
    		}
    		else{
    			
                if($this->request->data['Book_Instance']['id'] == '')  {
    				//$this->request->data['Book_Instance']['id'] = $this->Systeminc->get_id("BOOK_B");
                    $this->request->data['Book_Instance']['id'] = $this->Bookfunc->create_book_instance_id(
                                                                            $this->request->data['Book_Instance']['location_id'],
                                                                            $this->request->data['Book_Instance']['book_id']);
    			}	
                
    			if ($this->Book_Instance->save($this->request->data)) {
    				$this->Session->setFlash('儲存成功.');
                    $this->redirect(array('action' => 'book_view',$book_id));

    			} else {
    				$this->Session->setFlash('儲存失敗.');
    			}
                

    		}
    	} else{
    		$error_msg = '操作禁止';
    	}

        $this->set('book_status', $this->Formfunc->book_status());
        $this->set('is_lends',$this->Formfunc->is_lends());
        $this->set('person_levels', $this->Person_Level->find('list', array('fields' => array('Person_Level.id', 'Person_Level.level_name'))));
        $this->set('book',$book);
        $this->set('error_msg', $error_msg);
        //$this->set('system_locations', $this->System_Location->find('list',array('fields' => array('System_Location.id', 'System_Location.location_name'))));
        $this->set('system_locations', $this->Userfunc->getLocationOptions());
    }
    //public function book_instance_edit($book_id=null, $id=null){
    public function journal_instance_edit($book_id=null, $id=null){
        $error_msg = '';
        if($book_id != null){
            $this->Book->id = $book_id;
            $book = $this->Book->read();
            $this->Book_Instance->id = $id;
            if($this->request->is('get')){
                    $book_instance = $this->Book_Instance->read();
                    if ($book_instance !== false) {
                        $this->request->data = $book_instance;
                    }
                    else {
                        $this->request->data['Book_Instance']['id'] = null;
                        $this->request->data['Book_Instance']['is_lend'] = 'N';
                    }
            }
            else{
                
                if($this->request->data['Book_Instance']['id'] == '')  {
                    $this->request->data['Book_Instance']['id'] = $this->Systeminc->get_id("BOOK_M");
                }   
                
                if ($this->Book_Instance->save($this->request->data)) {
                    $this->Session->setFlash('儲存成功.');
                    $this->redirect(array('action' => 'journal_edit',$book_id));

                } else {
                    $this->Session->setFlash('儲存失敗.');
                }
                

            }
        } else{
            $error_msg = '操作禁止';
        }
    	 
    	$this->set('book_status', $this->Formfunc->book_status());
    	$this->set('is_lends',$this->Formfunc->is_lends());
    	$this->set('person_levels', $this->Person_Level->find('list', array('fields' => array('Person_Level.id', 'Person_Level.level_name'))));
    	$this->set('book',$book);
    	$this->set('error_msg', $error_msg);
        $this->set('system_locations', $this->System_Location->find('list',array('fields' => array('System_Location.id', 'System_Location.location_name'))));

    }    
    

    public function catagory_index() {
        $this->set('cates', $this->Book_Cate->find('all', array('order' => 'valid DESC, id')));
    }
	
	public function catagory_edit($id = null) {
		$this->Book_Cate->id = $id;
		if ($this->request->is('get')) {
			$this->request->data = $this->Book_Cate->read();
		} else {
			if ($this->Book_Cate->save($this->request->data)) {
				$this->Session->setFlash('儲存成功.');
				$this->redirect(array('action' => 'catagory_index'));
			} else {
				$this->Session->setFlash('儲存失敗.');
			}
		}
	}
	
	public function catagory_delete($id) {
		$this->Book_Cate->id = $id;
		$this->request->data = $this->Book_Cate->read();
		$this->request->data['Book_Cate']['valid'] = ($this->request->data['Book_Cate']['valid'] + 1)%2;
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if ($this->Book_Cate->save($this->request->data)) {
			$this->Session->setFlash('書籍分類狀態已變更.');
			$this->redirect(array('action' => 'catagory_index'));
		} else {
			$this->Session->setFlash('作業失敗.');
		}	
	}

    public function publisher_index() {
        $this->set('publishers', $this->Book_Publisher->find('all', array('order' => 'valid DESC, id')));
    }
	
	public function publisher_edit($id = null) {
		$this->Book_Publisher->id = $id;
		if ($this->request->is('get')) {
			$this->request->data = $this->Book_Publisher->read();
		} else {
			if ($this->Book_Publisher->save($this->request->data)) {
				$this->Session->setFlash('儲存成功.');
				$this->redirect(array('action' => 'publisher_index'));
			} else {
				$this->Session->setFlash('儲存失敗.');
			}
		}
	}
	
	public function publisher_delete($id) {
		$this->Book_Publisher->id = $id;
		$this->request->data = $this->Book_Publisher->read();
		$this->request->data['Book_Publisher']['valid'] = ($this->request->data['Book_Publisher']['valid'] + 1)%2;
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if ($this->Book_Publisher->save($this->request->data)) {
			$this->Session->setFlash('出版商狀態已變更.');
			$this->redirect(array('action' => 'publisher_index'));
		} else {
			$this->Session->setFlash('作業失敗.');
		}	
	}
    public function isbn_add($isbn=null){
        $isbn = $this->request->data['Book']['isbn'];
        if( $isbn == ''){
            $this->Session->setFlash('ISBN 不能為空.');
            $this->redirect(array('action' => 'book_index'));
        }
        $isbn = $this->Isbnfunc->fixIsbn($isbn);
        if( $isbn == null) {
            $this->Session->setFlash('ISBN 格式錯誤, 須為10碼或13碼數字.');
            $this->redirect(array('action' => 'book_index'));
        }

        $book = $this->Book->find('first', array('conditions'=> array('Book.isbn'=> $isbn)));
        if($book != null){
            $this->request->data = $book;
            $this->redirect(array('action' => 'book_edit',$book['Book']['id']));
        }
        // 找尋圖片
        $book['Book']['isbn'] = $isbn;
        $book['Book']['book_image'] = 'book_empty.png';
        $book = $this->Isbnfunc->get_bookinfo($isbn,$book);
        if($book['Book']['publish_date'] !==null || $book['Book']['publish_date'] !==''){
        	$book['Book']['publish_year'] = date('Y', strtotime($book['Book']['publish_date']));
        }
        /*
        $amazon_asin = $this->Isbnfunc->get_amazon_asin($isbn);
        //如果存在asin 就可用 amazon
        if($amazon_asin !== false){
            $bookinfo = $this->Isbnfunc->get_amazon_bookinfo($amazon_asin);
            if($bookinfo != null){
                    if(array_key_exists('book_image',$bookinfo))
                        $book['Book']['book_image'] = $this->Isbnfunc->saveImage($isbn, $bookinfo['book_image']);
                    if(array_key_exists('publisher',$bookinfo))
                        $book['Book']['book_publisher'] = $bookinfo['publisher'];
                    if(array_key_exists('author',$bookinfo))
                        $book['Book']['book_author'] = $bookinfo['author'];
                    if(array_key_exists('bookname',$bookinfo))
                        $book['Book']['book_name'] = $bookinfo['bookname'];
                    if(array_key_exists('bookname',$bookinfo))
                        $book['Book']['publish_date'] = $bookinfo['date'];
            }
        } else { //否則使用 isbndb 找尋
            $bookinfo = $this->Isbnfunc->isbndb_search($isbn);
            if($bookinfo != null){
                    if(array_key_exists('book_image',$book_info))
                        $book['Book']['book_image'] = $this->Isbnfunc->saveImage($isbn, $bookinfo['book_image']);
                    if(array_key_exists('publisher',$book_info))
                        $book['Book']['book_publisher'] = $bookinfo['publisher'];
                    if(array_key_exists('author',$book_info))
                        $book['Book']['book_author'] = $bookinfo['author'];
                    if(array_key_exists('bookname',$book_info))
                        $book['Book']['book_name'] = $bookinfo['bookname'];
                    if(array_key_exists('bookname',$book_info))
                        $book['Book']['publish_date'] = $bookinfo['date'];
            }
        }
        */
        $this->request->data = $book;

        $cates = $this->Formfunc->convert_options($this->Book_Cate->find('all'), 'Book_Cate', 'id', 'catagory_name');
        $this->set('cates', $cates);        
        $this->set('book_status', $this->Formfunc->book_status());
        $this->render('book_edit');

    }

    public function search_isbn($isbn=null){
        $htmlbody ="";
        $isbn = $this->Isbnfunc->fixIsbn($isbn);

        $book['Book']['isbn'] = $isbn;
        $book['Book']['book_image'] = 'book_empty.png';
        $book = $this->Isbnfunc->get_bookinfo($isbn,$book);
        $htmlbody = "Book : ".$htmlbody.var_export($book, true)."<br>";
        /*
        $amazon_asin = $this->Isbnfunc->get_amazon_asin($isbn);
        $htmlbody = "ASIN : ".$htmlbody.var_export($amazon_asin, true)."<br>";


        //var_dump("ASIN : ".$amazon_asin."<br>");
        $bookinfo = $this->Isbnfunc->get_amazon_bookinfo($amazon_asin);
        $htmlbody = "Amazon : ".$htmlbody.var_export($bookinfo, true)."<br>";
        //var_dump($bookinfo);
        $bookinfo = $this->Isbnfunc->get_isbndb_bookinfo($isbn);
        $htmlbody = "IsbnDB : ".$htmlbody.var_export($bookinfo, true)."<br>";
		*/
        
        //$bookinfo = $this->Isbnfunc->amazon_search($isbn);
        
        //$imgs = (array)$bookinfo->largeImageUrls;
        //sort($imgs);
        //$this->set('imgs',$imgs);
        
      


        //$htmlbody = $this->isbndb_search();
        $this->set('html_body', $htmlbody);
        //$code_start = strpos($result->body, '<pre>')+5;
        //$code_end = strpos($result->body, '</pre>');
        //$this->set('html_body',$result->raw);

    }
    private function isbndb_search($isbn=null){
        $HttpSocket = new HttpSocket();
        $response = $HttpSocket->get('http://isbndb.com/search-all.html?kw=1586853333&x=10&y=13', array(), array('redirect' => true));
        return $this->isbndb_cat($response->body);

    }

    private function isbndb_cat($html){
        $r = $this->catdata($html, '<DIV CLASS="bookInfo">','</div>');
        return $r;
    }

	public function book_search($sort_index=0) {
		$books_sort = 0;
		$books_sorts = array(0 => 'isbn');
		$page_size = 20;
		$page = 1;
		$filter_str = '';
		$this->Person->Id = $this->Session->read('user_id');
		$person_info = $this->Person->read();
		$filter = array();
		//if ($person_info['Person_Level']['is_cross'] == 0) {
		//	$filter = array_merge($filter,array('Book_Instance.location_id' => $this->Session->read('user_location')));
		//}
		if ((isset($this->data['Book']['page'])) && (trim($this->data['Book']['page']) != ''))  {
			$page = trim($this->data['Book']['page']);
		}
		if ((isset($this->data['Book']['sort'])) && (trim($this->data['Book']['sort']) != ''))  {
			$books_sort = trim($this->data['Book']['sort']);
		}
		if ((isset($this->data['Book']['book_name'])) && (trim($this->data['Book']['book_name']) != ''))  {
			$filter_str = $filter_str." and book_name like '".mysql_real_escape_string($this->data['Book']['book_name'])."%' ";
		}
		if ((isset($this->data['Book']['remark'])) && (trim($this->data['Book']['remark']) != ''))  {
			$filter_str = $filter_str." and memo like '".mysql_real_escape_string($this->data['Book']['remark'])."%' ";
		}
		if ((isset($this->data['Book']['author'])) && (trim($this->data['Book']['author']) != ''))  {
			$filter_str = $filter_str." and book_author like '".mysql_real_escape_string($this->data['Book']['author'])."%' ";
		}
		if ((isset($this->data['Book']['publisher'])) && (trim($this->data['Book']['publisher']) != ''))  {
			$filter_str = $filter_str." and book_publisher like '".mysql_real_escape_string($this->data['Book']['publisher'])."%' ";
		}
		if ((isset($this->data['Book']['search_code'])) && (trim($this->data['Book']['search_code']) != ''))  {
			$filter_str = $filter_str." and book_search_code like '".mysql_real_escape_string($this->data['Book']['search_code'])."%' ";
		}
		if ((isset($this->data['Book']['location'])) && (trim($this->data['Book']['location']) != ''))  {
			$filter_str = $filter_str." and book_location like '".mysql_real_escape_string($this->data['Book']['location'])."%' ";
		}
		if ((isset($this->data['Book']['isbn'])) && (trim($this->data['Book']['isbn']) != ''))  {
			$filter_str = $filter_str." and isbn like '".mysql_real_escape_string($this->data['Book']['isbn'])."%' ";
		}
		if ((isset($this->data['Book']['level'])) && (trim($this->data['Book']['level']) != ''))  {
			$filter_str = $filter_str." and level_id = '".mysql_real_escape_string($this->data['Book']['level'])."' ";
		}
		if ((isset($this->data['Book']['cate'])) && (trim($this->data['Book']['cate']) != ''))  {
			$filter_str = $filter_str." and cate_id = '".mysql_real_escape_string($this->data['Book']['cate'])."' ";
		}
		if (trim($filter_str) == '') {
			if ($filter_str = '') {  $filter_str = $filter_str." and "; };
			$filter_str = " and = 1=2 ";
		}
		$strsql = "  FROM `book_instances` , `books` , book_catagorys, person_levels
					WHERE books.id = book_instances.book_id
					  AND books.cate_id = book_catagorys.id
					  AND person_levels.id = book_instances.level_id";
		if (trim($filter_str) != '') {
			$strsql = $strsql.$filter_str;
		}
		$strsql1 = "SELECT count( * ) AS cnt ";
		$books_cnt = $this->Book->query($strsql1.$strsql.';');
		$strsql1 = "SELECT books.id, `book_type` , `book_name` , `book_author` , `book_publisher` , `cate_id` , `isbn` , `book_search_code` , `book_location` , `book_attachment` , `book_image` , `publish_date` , `order_start_date` , `order_end_date` , `order_start_version` , `order_end_version` , `memo` , count( * ) AS cnt, books.book_version ";
		$strsql = $strsql1.$strsql." GROUP BY books.id, `book_type` , `book_name` , `book_author` , `book_publisher` , `cate_id` , `isbn` , `book_search_code` , `book_location` , `book_attachment` , `book_image` , `publish_date` , `order_start_date` , `order_end_date` , `order_start_version` , `order_end_version` , `memo`, books.book_version
					       LIMIT ".($page-1)*$page_size." , ".$page_size.";";
		$books = $this->Book->query($strsql);
		//$books_cnt = $this->Book->find('count', array('conditions' => $filter));
		//$books = $this->Book->find('all', array('conditions' => $filter, 'limit' => $page_size, 'page' =>$page, 'order' => $books_sorts[$books_sort]));
		$this->set('page', $page);
		$this->set('books', $books);
		$this->set('books_sort', $books_sort);
		$this->set('books_cnt', $books_cnt[0][0]['cnt']);
		$this->set('books_page', floor($books_cnt[0][0]['cnt'] / $page_size) + 1);
		$this->set('levels', $this->Person_Level->find('list', array('fields'=>array('id', 'level_name'))));
		$this->set('cates', $this->Book_Cate->find('list', array('fields'=>array('id', 'catagory_name'))));
	} 
	
    public function book_search_view($id=null){
        if($id == null) {
            $this->redirect(array('action' => 'book_search'));
        }
		$personinfo = $this->Person->findById($this->Session->read('user_id'));
		$this->set('userinfo', $personinfo);
		$this->set('books', $this->Book_Instance->find('all', array('conditions' => array('book_id' => $id))));
        $this->set('cates', $this->Book_Cate->find('list', array('fields' => array('id', 'catagory_name'))));
        $this->set('book_status', $this->Formfunc->book_status());
		$this->set('locations', $this->System_Location->find('list', array('fields' => array('id', 'location_name'))));
    }
	
    private function catdata($html, $start_s, $end_s){
        $start_index = strpos($html, $start_s);
        if($start_index == false) return "Miss Start.";
        $end_index = stripos($html, $end_s, $start_index);
        if($end_index == false) return "Miss End.";
        return substr($html, $start_index, $end_index + strlen($end_s) - $start_index);
    }
	
	public function print_book_barcode() {
		$books = array();
		$filter = array();
		$intX = 1;
		$intY = 1;
		if (!empty($this->data)) {
			$intX = $this->data['Book_Instance']['start_x'];
			$intY = $this->data['Book_Instance']['start_y'];
			if ($this->Session->read('user_role') != 'admin') {
				$filter = array_merge($filter,array('Book_Instance.location_id' => $this->Session->read('user_location')));
			}
			if ((isset($this->data['Book_Instance']['start_id'])) && (trim($this->data['Book_Instance']['start_id'])!='')) {
				$filter = array_merge($filter,array("Book_Instance.id >= '".$this->data['Book_Instance']['start_id']."' "));
			}
			if ((isset($this->data['Book_Instance']['end_id'])) && (trim($this->data['Book_Instance']['end_id'])!='')) {
				$filter = array_merge($filter,array("Book_Instance.id <= '".$this->data['Book_Instance']['end_id']."' "));
			}		
			$books = $this->Book_Instance->find('all', array('conditions' => $filter,'recursive' => 2));
		}
		
		$this->set('books', $books);
		$this->set('intXs', array(1=>1,2=>2,3=>3));
		$this->set('intYs', array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9));
		$this->set('intX', $intX);
		$this->set('intY', $intY);
	}
	
	public function print_book_barcode_sel() {
		$books = array();
		$filter = array();
		$intX = 1;
		$intY = 1;
		if (!empty($this->data)) {
			$intX = $this->data['Book_Instance']['start_x'];
			$intY = $this->data['Book_Instance']['start_y'];
			$books = $this->System_Print_Book->find('all',array('conditions'=>array('print_type'=>'B', 'print_owner' =>$this->Session->read('user_id'))));
		}
		
		$this->set('books', $books);
		$this->set('intXs', array(1=>1,2=>2,3=>3));
		$this->set('intYs', array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9));
		$this->set('intX', $intX);
		$this->set('intY', $intY);
	}

}
?>