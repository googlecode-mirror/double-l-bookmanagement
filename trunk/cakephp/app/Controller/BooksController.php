<?php
App::uses('HttpSocket', 'Network/Http');
class BooksController extends AppController {
	public $uses = array('Book_Cate', 'Book', 'Book_Instance','Book_Publisher','Person_Level','System_Inc','System_Location');
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
        $book = $this->Book->find('first', array('conditions'=> array('Book.isbn'=> $isbn)));
        if($book != null){
            $this->request->data = $book;
            $this->redirect(array('action' => 'book_edit',$book['Book']['id']));
        }
        // 找尋圖片
        $book['Book']['isbn'] = $isbn;
        $book['Book']['book_image'] = 'book_empty.png';
        $bookinfo = $this->Isbnfunc->amazon_search($isbn);
        if($bookinfo != null){
                $imgs = (array)$bookinfo->largeImageUrls;
                sort($imgs);
                $book['Book']['book_image'] = reset($imgs);
        }
        $bookinfo = $this->Isbnfunc->isbndb_search($isbn);
        if($bookinfo != null){
            $book['Book']['book_publisher'] = $bookinfo['publisher'];
            $book['Book']['book_author'] = $bookinfo['author'];
            $book['Book']['book_name'] = $bookinfo['bookname'];
            $book['Book']['publish_date'] = $bookinfo['date'];
        }
        $this->request->data = $book;

        $cates = $this->Formfunc->convert_options($this->Book_Cate->find('all'), 'Book_Cate', 'id', 'catagory_name');
        $this->set('cates', $cates);        
        $this->set('book_status', $this->Formfunc->book_status());
        $this->render('book_edit');

    }

    public function search_isbn($isbn=null){
        //$url = "http://192.83.186.170/search*cht?/i9789861993454/i9789861993454/0,0,0/marc&FF=i9789861993454";
        //$url = "http://search.books.com.tw/exep/prod_search.php?cat=BKA&key=9789861993454";
        //$url = "http://isbndb.com/search-all.html?kw=1586853333&x=10&y=13";
        //$HttpSocket = new HttpSocket();
        //$result = $HttpSocket->get($url);
        //$htmlbody = $result->body;
        //$htmlbody = $this->isbndb_cat($htmlbody);
        //$htmlbody = $this->catdata($htmlbody,'<li class="item">', '</li>');
        //var_dump($response->body());
        
        $bookinfo = $this->Isbnfunc->amazon_search($isbn);
        //$bookinfo = $this->Isbnfunc->isbndb_search($isbn);
        $imgs = (array)$bookinfo->largeImageUrls;
        sort($imgs);
        $this->set('imgs',$imgs);
        //var_dump($bookinfo);
      


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

	public function book_search() {
		$this->Person->Id = $this->Session->read('user_id');
		$person_info = $this->Person->read();
		$filter = array();
		//if ($person_info['Person_Level']['is_cross'] == 0) {
		//	$filter = array_merge($filter,array('Book_Instance.location_id' => $this->Session->read('user_location')));
		//}
		if ((isset($this->data['Book']['keyword'])) && (trim($this->data['Book']['keyword']) != ''))  {
			$filter = array_merge($filter,array("book_name like '".$this->data['Book']['keyword']."%'"));
		}
		else {
			$filter = array_merge($filter,array(" 1= 2 "));
		}
		$books = $this->Book->find('all', array('conditions' => $filter));
		$this->set('books', $books);
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
}
?>