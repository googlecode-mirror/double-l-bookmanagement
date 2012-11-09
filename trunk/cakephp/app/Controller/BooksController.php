<?php
class BooksController extends AppController {
	public $uses = array('Book_Cate', 'Book_Basic', 'Book_Version', 'Book', 'Book_Publisher');
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
}
?>