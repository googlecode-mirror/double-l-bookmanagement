<?php
class BooksController extends AppController {
	public $uses = array('Book_Cate', 'Book_Basic', 'Book_Version', 'Book', 'Book_Publisher', 'Person_Level');
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session', 'Formfunc');

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
	
	public function book_basic_index() {
        $this->set('book_basics', $this->Book_Basic->find('all')); //, array('conditions' => 'book.valid = 1')));
    }
	
	public function book_basic_edit($id = null) {
		$this->Book_Basic->id = $id;
		$cates = $this->Formfunc->convert_options($this->Book_Cate->find('all'), 'Book_Cate', 'id', 'catagory_name');
		$publishers = $this->Formfunc->convert_options($this->Book_Publisher->find('all'), 'Book_Publisher', 'id', 'comp_name');
		$this->set('cates', $cates);
		$this->set('publishers', $publishers);
		if ($this->request->is('get')) {
			$this->request->data = $this->Book_Basic->read();
		} else {
			if ($this->Book_Basic->save($this->request->data)) {
				$this->Session->setFlash('儲存成功.');
				$this->redirect(array('action' => 'book_basic_index'));
			} else {
				$this->Session->setFlash('儲存失敗.');
			}
		}
	}
	
	public function book_version_index($basic_id= null) {
		$book_versions = $this->Book_Version->find('all', array('conditions' => " book_version.basic_id = '$basic_id' "));
		$this->set('basic_id', $basic_id);
		$this->set('book_versions', $book_versions);
    }
	
	public function book_version_edit($basic_id=null, $id = null) {
		$error_msg = '';
		if ($basic_id != null) {
			$this->Book_Basic->id = $basic_id;
			$book_basic = $this->Book_Basic->read();
			$this->Book_Version->id = $id;
			if ($this->request->is('get')) {
				if ($id != null) {
					$this->request->data = $this->Book_Version->read();
				}
				else {
					$tmp_version = $this->Book_Version->find('all', array('condition'=>" book_version.basic_id = '$basic_id'", 'order' => 'book_version.create_time desc', 'limit' => 1));
					if (!empty($tmp_version)) {
						$tmp_version = $tmp_version[0];
						$tmp_version['Book_Version']['id'] = $id;
						$tmp_version['Book_Version']['book_version'] = null;
						$tmp_version['Book_Version']['publish_date'] = null;
					}
					$this->request->data = $tmp_version;
				}
			} else {
				if ($this->Book_Version->save($this->request->data)) {
					$this->Session->setFlash('儲存成功.');
					$this->redirect(array('action' => 'book_version_index/'.$basic_id));
				} else {
					$this->Session->setFlash('儲存失敗.');
				}
			}
		}
		else {
			$error_msg = '操作禁止';
		}
		$this->set('book_basic', $book_basic);
		$this->set('basic_id', $basic_id);
		$this->set('error_msg', $error_msg);
	}
	
	public function book_index($version_id= null) {
		if ($version_id != null) {
			$books = $this->Book->find('all', array('conditions' => " book.version_id = '$version_id' "));
		}
		else {
			$books = $this->Book->find('all');
		}
		for($i=0;$i < sizeof($books); $i++) {
			$this->Book_Basic->id = $books[$i]['Book_Version']['basic_id'];
			$book_basic = $this->Book_Basic->read();
			$books[$i]['Book_Basic'] =$book_basic['Book_Basic'];
			$books[$i]['Book_Cate'] = $book_basic['Book_Cate'];
			$books[$i]['Book_Publisher'] = $book_basic['Book_Publisher'];
		}
		$this->set('version_id', $version_id);
		$this->set('books', $books);
		$this->set('book_status', $this->Formfunc->book_status());
		$this->set('person_levels', $this->Person_Level->find('list', array('fields' => array('Person_Level.id', 'Person_Level.level_name'))));
    }
	
	public function book_edit($version_id=null, $id = null) {
		$error_msg = '';
		if ($version_id != null) {
			$this->Book_Version->id = $version_id;
			$book_version = $this->Book_Version->read();
			$this->Book_Basic->id = $book_version['Book_Version']['basic_id'];
			$book_basic = $this->Book_Basic->read();
			$this->Book->id = $id;
			if ($this->request->is('get')) {
				if ($id != null) {
					$this->request->data = $this->Book->read();
				}
				else {
					$tmp_book = $this->Book->find('all', array('condition'=>" book.version_id = '$version_id'", 'order' => 'book.create_time desc', 'limit' => 1));
					if (!empty($tmp_book)) {
						$tmp_book = $tmp_book[0];
						$tmp_book['Book']['id'] = $id;
						$tmp_book['Book']['purchase_price'] = 0;
						$tmp_book['Book']['book_status'] = null;
						$tmp_book['Book']['person_level'] = null;
						$tmp_book['Book']['purchase_date'] = null;
					}
					$this->request->data = $tmp_book;
				}
			} else {
				if ($this->Book->save($this->request->data)) {
					$this->Session->setFlash('儲存成功.');
					$this->redirect(array('action' => 'book_index/'.$version_id));
				} else {
					$this->Session->setFlash('儲存失敗.');
				}
			}
		}
		else {
			$error_msg = '操作禁止';
		}
		$this->set('book_basic', $book_basic);
		$this->set('book_version', $book_version);
		$this->set('version_id', $version_id);
		$this->set('book_status', $this->Formfunc->book_status());
		$this->set('person_levels', $this->Person_Level->find('list', array('fields' => array('Person_Level.id', 'Person_Level.level_name'))));
		$this->set('error_msg', $error_msg);
	}
	
	public function book_delete($id) {
		$this->Book->id = $id;
		$this->request->data = $this->Book->read();
		if (!empty($this->request->data)) {
			$this->request->data['Book']['valid'] = ($this->request->data['Book']['valid'] + 1)%2;
			if ($this->request->is('get')) {
				throw new MethodNotAllowedException();
			}
			if ($this->Book->save($this->request->data)) {
				$this->Session->setFlash('書籍狀態已變更.');
				$this->redirect(array('action' => 'book_index', $this->request->data['Book']['version_id']));
			} else {
				$this->Session->setFlash('作業失敗.');
			}	
		} else {
			$this->Session->setFlash('作業失敗.');
		}
	}
}
?>