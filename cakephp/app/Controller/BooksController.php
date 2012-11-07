<?php
class BooksController extends AppController {
	public $uses = array('Book_Cate', 'Book_Basic', 'Book_Version', 'Book', 'Book_Publisher');
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');

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
		$cates = $this->convert_options($this->Book_Cate->find('all'), 'Book_Cate', 'id', 'catagory_name');
		$publishers = $this->convert_options($this->Book_Publisher->find('all'), 'Book_Publisher', 'id', 'comp_name');
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
	
	private function convert_options($result, $model, $key=id, $label='name') {
		$rt = array();
		foreach($result as $item) {
			$rt[$item[$model][$key]] = $item[$model][$label];
		}
		return $rt;
	}
}
?>