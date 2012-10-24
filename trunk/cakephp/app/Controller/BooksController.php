<?php
class BooksController extends AppController {
	public $uses = array('Book_Cate');
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');

    public function catagory_index() {
        $this->set('cates', $this->Book_Cate->find('all'));
    }

 	public function catagory_add() {
		if ($this->request->is('post')) {
			if ($this->Book_Cate->save($this->request->data)) {
				$this->Session->setFlash('儲存成功.');
				$this->redirect(array('action' => 'catagory_index'));
			}
			else {
				$this->Session->setFlash('儲存失敗.');
			}
		}
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
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if ($this->Book_Cate->delete($id)) {
			$this->Session->setFlash('書籍分類已刪除.');
			$this->redirect(array('action' => 'catagory_index'));
		}
	}


}
?>