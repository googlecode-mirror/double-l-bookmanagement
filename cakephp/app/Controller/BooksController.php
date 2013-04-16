<?php
App::uses('HttpSocket', 'Network/Http');
class BooksController extends AppController {
	public $uses = array('Book_Cate', 'Book', 'Book_Instance','Book_Publisher','Person_Level','System_Inc','System_Location', 'System_Print_Book');
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session', 'Formfunc','Systeminc','Bookfunc','Userfunc','Isbnfunc','BookSearch');

    public function book_index(){
    	// init search parameter
 		$books_sort = 0;
		$books_sorts = array(0 => 'isbn');
		
		
		$book_query = $this->request->data['Book'];
		$result = $this->BookSearch->search($book_query);
		$this->set('books', $result['books']);
		$this->set('page', $result['page']);
		$this->set('page_size',$result['page_size']);
		$this->set('count', $result['count']);
		$this->set('books_sort', $books_sort);
		$this->set('cates', $this->Book_Cate->find('list', array('fields'=>array('id', 'catagory_name'))));
	    	    	 
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
		$this->set('person_levels', $this->Person_Level->find('list', array('fields' => array('Person_Level.id', 'Person_Level.level_name'))));
		 
    }

    public function book_edit($id = null){
    	$this->Book->id = $id;
    	$book = $this->Book->read(); 
    	if($this->request->is('get')){
    		$this->request->data = $book; 
    	} else {
    		//如果有書籍檔案上傳
    		
    		$file = $this->request->data['Upload']["file"];
    		if($file['size'] > 0){
    			$isbn = $this->request->data['Book']['isbn'];
    			$image_url = $this->Bookfunc->upload_book_image($file,$isbn);
    			$this->request->data['Book']['book_image']=$image_url;
    		}
    		
			$ret = $this->Book->save($this->request->data);
    		if ($ret) {
    			
  				// 當Lexile 有變動時, 更新 book_instnce_id
  				if($book['Book']['cate_id'] != $ret['Book']['cate_id']){
  					
  					$book_instances = $book['Book_Instances'];
  					foreach($book_instances as $book_instance){
  						$book_instance_id = $book_instance['id'];
  						$new_id = $this->Bookfunc->change_book_instance_id($book_instance_id,$ret['Book']['cate_id']);
  						$this->Book_Instance->updateAll(
  								array('Book_Instance.id'=> "'".$new_id."'" ),
  								array('Book_Instance.id'=> $book_instance_id)
  						);
  						
  						//$this->Book_Instance->id = $book_instance_id;
  						//$this->Book_Instance->saveField('id',$this->Bookfunc->change_book_instance_id($book_instance_id,$ret['Book']['cate_id']));
  					}
  				}
  				$this->Session->setFlash('書籍儲存完成.');
                $this->redirect(array('action' => 'book_view',$ret['Book']['id']));
    		}else {
				$this->Session->setFlash('書籍儲存失敗.');
			}
    	}
    	 
        $cates = $this->Formfunc->convert_options($this->Book_Cate->find('all'), 'Book_Cate', 'id', 'catagory_name');
        $this->set('cates', $cates);
        $this->set('book_status', $this->Formfunc->book_status());
		$this->set('locations', $this->System_Location->find('list', array('fields' => array('id', 'location_name'))));
		$this->set('person_levels', $this->Person_Level->find('list', array('fields' => array('Person_Level.id', 'Person_Level.level_name'))));
    	
    }
    
    public function book_add_image($id=null){
    	if($id==null) {
    		$this->redirect(array('action' => 'book_index'));
    	}
    	$this->Book->id = $id;
    	$book = $this->Book->read();
    	if($book == null){
    		$this->redirect(array('action' => 'book_index'));
    	}
    	$isbn = $this->Isbnfunc->checkIsbn($book['Book']['isbn']);
    	if($isbn['isIsbn']){
    		$image_url = $this->Isbnfunc->get_bookimage($isbn['isbn']);
    		if($image_url !== null){
    			$book['Book']['book_image'] = $image_url;
    			$this->Book->save($book);
    			$this->Session->setFlash('書籍圖片更新成功');
    		} else {
    			$this->Session->setFlash('書籍圖片無法取得');
    		}
    	}
    	$this->redirect(array('action' => 'book_edit',$book['Book']['id']));

    }
    
    public function book_upload($id){
    	$url = 'http://localhost'.$this->request->base.'/'.'Books'.'/'.'book_add_image'.'/'.$id;
    	var_dump($url);
    	$this->Bookfunc->curl_post_async($url);
    	
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
    public function Book_Instance_edit($book_id=null, $id=null){
    	$error_msg = '';
    	if($book_id != null){
    		$this->Book->id = $book_id;
    		$book = $this->Book->read();
    		$this->Book_Instance->id = $id;
    		if($this->request->is('get')){
    				$Book_Instance = $this->Book_Instance->read();
					if ($Book_Instance !== false) {
						$this->request->data = $Book_Instance;
                        $this->set('is_modify',false);
					}
					else {
						$this->request->data['Book_Instance']['id'] = null;
						$this->request->data['Book_Instance']['is_lend'] = 'N';
						$this->request->data['Book_Instance']['purchase_date'] = date('Y-m-d');
						$this->request->data['Book_Instance']['purchase_price'] = 0;
                        $this->set('is_modify',true);
					}
    		}else{
    			// 如果新增, 產生 Book_instance.id
                if($this->request->data['Book_Instance']['id'] == '')  {
                     $this->request->data['Book_Instance']['id'] = $this->Bookfunc->create_Book_Instance_id(
                                                                            $this->request->data['Book_Instance']['location_id'],
                                                                            $this->request->data['Book_Instance']['book_id'],
                    														$book['Book']['cate_id']
                    												);
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
    public function Book_Info_upload(){
    	$ds = null;
    	if ($this->request->is('post')) {
    		$file = $this->request->data['Upload']["file"];
    		//var_dump($file);
    		//if($file['size'] > 0) $ds = $this->_save_bookinfo_upload($file,$this->request->data['Book_Info']);
    		if($file['size'] > 0) $ds = $this->Bookfunc->save_book_upload($file);
    		$this->Session->setFlash('書籍上傳完成.');
    	}
    
    	
    	$this->set('save_datas',$ds);
    	 
    }
    
    public function Book_Instance_upload(){
    	$ds = null;
    	if ($this->request->is('post')) {
    		//var_dump($this->request->data);
    		//var_dump($this->request->data['Book_Instance']);
    		$file = $this->request->data['Upload']["file"];
    		//var_dump($file);
    		if($file['size'] > 0) $ds = $this->_save_book_upload($file,$this->request->data['Book_Instance']);
    		$this->Session->setFlash('書籍上傳完成.');
    	}
    	$this->set('book_status', $this->Formfunc->book_status());
    	$this->set('is_lends',$this->Formfunc->is_lends());
    	$this->set('person_levels', $this->Person_Level->find('list', array('fields' => array('Person_Level.id', 'Person_Level.level_name'))));
    	$this->set('system_locations', $this->Userfunc->getLocationOptions());    	 
     	$this->set('save_datas',$ds);
     	
     	
    	
    }
    private function _save_book_upload($file,$pdata){
    	//initial result set;
    	$ds = null;
    	App::import("Vendor", "phpexcel/PHPExcel/IOFactory");
    	
    	$uploadfile = WWW_ROOT . 'img'.DS.'books' .DS. $file["name"];
    	move_uploaded_file($file["tmp_name"],$uploadfile);
    	$excel = PHPExcel_IOFactory::load($uploadfile);
    	$sheetdata = $excel->getActiveSheet()->toArray(null,true,true,true);
    	if( ($ss=count($sheetdata)) > 1 ) {
    		for($i=2;$i<=$ss;$i++){

    			$data['Book_Instance']['line'] = $i;
    			$data['Book_Instance']['isbn'] = $sheetdata[$i]['A'];
    			$data['Book_Instance']['purchase_price'] = $sheetdata[$i]['B'];
    			$data['Book_Instance']['purchase_date'] = $sheetdata[$i]['C'];
    			
    			$isbn = $sheetdata[$i]['A'];
    			if( $isbn == ''){
    				$data['Book_Instance']['isSave']= 'ISBN 不能為空.';
    				$ds[$i] = $data;
    				continue;
    			}
    			$isbn = $this->Isbnfunc->fixIsbn($isbn);
    			if( $isbn == null) {
    				$data['Book_Instance']['isSave']='ISBN 格式錯誤, 須為10碼或13碼數字.';
    				$ds[$i] = $data;
    				continue;
    			}
    			if($data['Book_Instance']['purchase_price'] == null || $data['Book_Instance']['purchase_price'] ==""){
    				$data['Book_Instance']['isSave']='購買金額不能為空';
    				$ds[$i] = $data;
    				continue;
    			}
    			if($data['Book_Instance']['purchase_date'] == null || trim($data['Book_Instance']['purchase_date']) == ""){
    				$data['Book_Instance']['isSave']='購買日期不能為空';
    				$ds[$i] = $data;
    				continue;
    			}    			
    			$book = $this->Book->find('first', array('conditions'=> array('Book.isbn'=> $isbn)));
    			if($book == null){
    				$data['Book_Instance']['isSave']='書籍不存在';
    				$ds[$i] = $data;
    				continue;
    			}

    			 
    			$data['Book_Instance']['book_id'] = $book['Book']['id'];
    			$data['Book_Instance']['location_id'] = $pdata['location_id'];
    			$data['Book_Instance']['book_status'] = $pdata['book_status'];
    			$data['Book_Instance']['level_id'] = $pdata['level_id'];
    			$data['Book_Instance']['is_lend'] = $pdata['is_lend'];
    			$data['Book_Instance']['create_time'] = date('Y-m-d H:i:s');
    			$data['Book_Instance']['id'] = $this->Bookfunc->create_Book_Instance_id(
    					$data['Book_Instance']['location_id'],
    					$data['Book_Instance']['book_id'],
    					$book['Book']['cate_id']);
    			
    			$this->Book_Instance->create();
    			if($this->Book_Instance->save($data)){
    				$data['Book_Instance']['isSave'] = 'OK';
    			} else {
    				$data['Book_Instance']['isSave'] = '存檔失敗';
    			}
    			 
    			$ds[$i] = $data;
    			
    		}
    	}
    	unlink($uploadfile);
    	return $ds;
    }
 /*   改由 Bookfunc 來完成, 不寫在Controller
    private function _save_bookinfo_upload($file){
    	//initial result set;
    	$ds = null;
    	App::import("Vendor", "phpexcel/PHPExcel/IOFactory");
    	 
    	$uploadfile = WWW_ROOT . 'img'.DS.'books' .DS. $file["name"];
    	move_uploaded_file($file["tmp_name"],$uploadfile);
    	$excel = PHPExcel_IOFactory::load($uploadfile);
    	$sheetdata = $excel->getActiveSheet()->toArray(null,true,true,true);
    	if( ($ss=count($sheetdata)) > 1 ) {
    		for($i=2;$i<=$ss;$i++){
    
    			$data['Book']['line'] = $i;
    			$data['Book']['isbn'] = $sheetdata[$i]['A'];
    			$data['Book']['book_name'] = $sheetdata[$i]['B'];
    			$data['Book']['book_author'] = $sheetdata[$i]['C'];
    			$data['Book']['book_publisher'] = $sheetdata[$i]['D'];
    			$data['Book']['cate_id'] = $sheetdata[$i]['E'];
    			$data['Book']['book_suite'] = $sheetdata[$i]['F'];
    			$data['Book']['publish_year'] = $sheetdata[$i]['G'];

    			$isbn = $this->Isbnfunc->checkIsbn($data['Book']['isbn']);
    			if($isbn['isIsbn'] == false){
    				$data['Book']['isSave']= $isbn['errorMsg'];
    				$ds[$i] = $data;
    				continue;
    			}
    			
    			$book = $this->Book->find('first', array('conditions'=> array('Book.isbn'=> $isbn['isbn'])));
    			if($book != null){
    				$data['Book']['isSave']='書籍已存在';
    				$ds[$i] = $data;
    				continue;
    			}
    	
    			$data['Book']['book_type'] = 'B';
    			$data['Book']['isbn'] = $isbn['isbn'];
    			

    
    			 
    			$this->Book->create();
    			if($this->Book->save($data)){
    				$data['Book']['isSave'] = 'OK';
    			} else {
    				$data['Book']['isSave'] = '存檔失敗';
    			}
    
    			$ds[$i] = $data;
    			 
    		}
    	}
    	unlink($uploadfile);
    	return $ds;
    }    
*/    
    //public function Book_Instance_edit($book_id=null, $id=null){
    public function journal_instance_edit($book_id=null, $id=null){
        $error_msg = '';
        if($book_id != null){
            $this->Book->id = $book_id;
            $book = $this->Book->read();
            $this->Book_Instance->id = $id;
            if($this->request->is('get')){
                    $Book_Instance = $this->Book_Instance->read();
                    if ($Book_Instance !== false) {
                        $this->request->data = $Book_Instance;
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
				$this->Session->setFlash('書籍級別資料儲存成功.');
				$this->redirect(array('action' => 'catagory_index'));
			} else {
				$this->Session->setFlash('書籍級別資料儲存失敗.');
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
			$this->Session->setFlash('書籍分類狀態變更失敗.');
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
        $book['Book']['lexile_level']=0;
        $book['Book']['isbn'] = $isbn;
        $book['Book']['book_image'] = 'book_empty.png';
        $book = $this->Isbnfunc->get_bookinfo($isbn,$book);
        if($book['Book']['publish_date'] !==null || $book['Book']['publish_date'] !==''){
        	$book['Book']['publish_year'] = date('Y', strtotime($book['Book']['publish_date']));
        }

        $this->request->data = $book;

        $cates = $this->Formfunc->convert_options($this->Book_Cate->find('all'), 'Book_Cate', 'id', 'catagory_name');
        $this->set('cates', $cates);        
        $this->set('book_status', $this->Formfunc->book_status());
        $this->render('book_edit');

    }
	/**
	 *  傳入 $isbn, 產生相對應的 image url;
	 * @param string $isbn
	 * @return string $image_url , image 的url
	 */
    public function search_book_image($isbn=null){
    	$image_url = '';
    	$isbno = $this->Isbnfunc->checkIsbn($isbn);
    	if($isbno['isIsbn']== false) {
    		
    	} else {
    		$image_url = $this->Isbnfunc->get_bookimage($isbno['isbn']);
    	}
    	return $image_url;
    }
    
    public function search_isbn($isbn=null){
        $htmlbody ="";
        $isbn = $this->Isbnfunc->fixIsbn($isbn);

        $book['Book']['isbn'] = $isbn;
        $book['Book']['book_image'] = 'book_empty.png';
        //$book = $this->Isbnfunc->get_bookinfo($isbn,$book);
        $book = $this->Isbnfunc->get_books_bookinfo($isbn);
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
		// init search parameter
		$books_sort = 0;
		$books_sorts = array(0 => 'isbn');
		
		
		$book_query = $this->request->data['Book'];
		$result = $this->BookSearch->search($book_query);
		$this->set('books', $result['books']);
		$this->set('page', $result['page']);
		$this->set('page_size',$result['page_size']);
		$this->set('count', $result['count']);
		$this->set('books_sort', $books_sort);
		$this->set('cates', $this->Book_Cate->find('list', array('fields'=>array('id', 'catagory_name'))));
		
		
		/*
		$books_sort = 0;
		$books_sorts = array(0 => 'isbn');
		$page_size = 20;
		$page = 1;
		$filter_str = '';
		$this->Person->Id = $this->Session->read('user_id');
		$person_info = $this->Person->read();
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
			$filter_str = " and  1=1 ";
		}
		$strsql = " FROM `books` LEFT JOIN (`book_instances` , `book_catagorys`)
					ON (books.id=book_instances.book_id AND books.cate_id=book_catagorys.id)
					WHERE 1=1 ";
		if (trim($filter_str) != '') {
			$strsql = $strsql.$filter_str;
		}
		$strsql1 = "SELECT count( * ) AS cnt from ( select count( * ) ";
		$strsql_group = " GROUP BY books.id, `book_type` , `book_name` , `book_author` , `book_publisher` , `cate_id` , `isbn` , `book_search_code` , `book_location` , `book_attachment` , `book_image` , `publish_date` , `order_start_date` , `order_end_date` , `order_start_version` , `order_end_version` , `memo`, books.book_version";
		$books_cnt = $this->Book->query($strsql1.$strsql.$strsql_group.') as x;');
		$strsql1 = "SELECT books.id,  `book_name` , `book_author` , `book_publisher` , `cate_id` , `isbn` , `book_search_code` , `book_location` , `book_attachment` , `book_image` , `publish_date` , `order_start_date` , `order_end_date` , `order_start_version` , `order_end_version` , `memo` , count( * ) AS cnt, books.book_version ";
		$strsql = $strsql1.$strsql.$strsql_group." LIMIT ".($page-1)*$page_size." , ".$page_size.";";
		$books = $this->Book->query($strsql);
		//$cates = $this->Formfunc->convert_options($this->Book_Cate->find('all'), 'Book_Cate', 'id', 'catagory_name');
		//$this->set('cates', $cates);
		$this->set('page', $page);
		$this->set('books', $books);
		$this->set('books_sort', $books_sort);
		$this->set('books_cnt', $books_cnt[0][0]['cnt']);
		$this->set('books_page', floor($books_cnt[0][0]['cnt'] / $page_size) + 1);
		$this->set('levels', $this->Person_Level->find('list', array('fields'=>array('id', 'level_name'))));
		$this->set('cates', $this->Book_Cate->find('list', array('fields'=>array('id', 'catagory_name'))));
		*/
	} 
	
    public function book_search_view($id=null){
        if($id == null) {
            $this->redirect(array('action' => 'book_search'));
        }
		$personinfo = $this->Person->findById($this->Session->read('user_id'));
		
		$this->Book->id = $id;	
		$this->set('book',$this->Book->read());
		$this->set('userinfo', $personinfo);
		$this->set('books', $this->Book_Instance->find('all', array('conditions' => array('book_id' => $id, 'location_id'=>$this->Session->read('user_location')))));
        $this->set('cates', $this->Book_Cate->find('list', array('fields' => array('id', 'catagory_name'))));
        $this->set('book_status', $this->Formfunc->book_status());
		$this->set('locations', $this->System_Location->find('list', array('fields' => array('id', 'location_name'))));
		$this->set('person_levels', $this->Person_Level->find('list', array('fields' => array('Person_Level.id', 'Person_Level.level_name'))));
		
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
	
	public function book_export(){
		$books = $this->Book->find('all',array(
								'recursive' => 0,
        						'conditions' => array('Book.book_type' => 'B')));
		$f = $this->_build_excel($books);
		$this->viewClass = 'Media';
		// Download app/outside_webroot_dir/example.zip
		$params = array(
				'id'        => $f['file'],
				'name'      => 'books',
				'download'  => true,
				'extension' => 'xls',
				'path'      => $f['path']
		);
		$this->set($params);
		//unlink($f['path'].$f['file']);
		
	}
	private function _build_excel($books){
		App::import("Vendor", "phpexcel/PHPExcel");
		App::import("Vendor", "phpexcel/PHPExcel/Writer/Excel5");
		
		
		 
		
		$r['path'] = TMP.'tests'.DS;
		$r['file'] = 'tmp_books_'. $this->Session->read('user_id');
		$file =  $r['path'].$r['file'];
		$excel = new PHPExcel();
		$excel->setActiveSheetIndex(0);
		//
		$excel->getActiveSheet()->setTitle('Books');
		$excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ISBN');
    	$excel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, '書籍名稱');
		$excel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, '作者');		
		$excel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, '出版公司');
		$excel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, 'AD');
		$excel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, 'Lexile 級數');
		$excel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, '集叢名');
		$excel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, '發行日期');
		$i = 1;
		foreach($books as $book){
		$i++;
		$excel->getActiveSheet()->setCellValueExplicitByColumnAndRow(0, $i,$book['Book']['isbn'],PHPExcel_Cell_DataType::TYPE_STRING);		
		$excel->getActiveSheet()->setCellValueByColumnAndRow(1, $i, $book['Book']['book_name']);
		$excel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, $book['Book']['book_author']);
		$excel->getActiveSheet()->setCellValueByColumnAndRow(3, $i, $book["Book"]["book_publisher"]);
		$excel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, $book['Book']['book_ad']);
		$excel->getActiveSheet()->setCellValueByColumnAndRow(5, $i, $book['Book']['lexile_level']);
		$excel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, $book['Book']['book_suite']);
		$excel->getActiveSheet()->setCellValueByColumnAndRow(7, $i, $book['Book']['publish_year']);
		}
		$objWriter = new PHPExcel_Writer_Excel5($excel);
		$objWriter->save($file);
		
		return $r;
				
	}
	
	public function book_instance_receive(){
		$location_id = $this->Session->read('user_location');
		if($this->request->is('post')){
			$book_instance_id = $this->request->data['Book']['book'];
			$result = $this->Bookfunc->receive_book_instnace($book_instance_id);
			$this->Session->setFlash($result['message']);
			$this->request->data['Book']['book'] = '';
		}
	}

}
?>