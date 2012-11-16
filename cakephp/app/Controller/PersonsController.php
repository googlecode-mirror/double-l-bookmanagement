<?php
class PersonsController extends AppController {
	public $uses = array('Person_Title', 'Person_Group', 'Person_Level', 'Person');
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session', 'Formfunc');

    public function title_index() {
        $this->set('titles', $this->Person_Title->find('all', array('order' => 'valid DESC, id')));
    }
	
	public function title_edit($id = null) {
		$this->Person_Title->id = $id;
		if ($this->request->is('get')) {
			$this->request->data = $this->Person_Title->read();
		} else {
			if ($this->Person_Title->save($this->request->data)) {
				$this->Session->setFlash('儲存成功.');
				$this->redirect(array('action' => 'title_index'));
			} else {
				$this->Session->setFlash('儲存失敗.');
			}
		}
	}
	
	public function title_delete($id) {
		$this->Person_Title->id = $id;
		$this->request->data = $this->Person_Title->read();
		$this->request->data['Person_Title']['valid'] = ($this->request->data['Person_Title']['valid'] + 1)%2;
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if ($this->Person_Title->save($this->request->data)) {
			$this->Session->setFlash('職務狀態已變更.');
			$this->redirect(array('action' => 'title_index'));
		} else {
			$this->Session->setFlash('作業失敗.');
		}	
	}
	
    public function group_index() {
        $this->set('groups', $this->Person_Group->find('all', array('order' => 'valid DESC, id')));
    }

	public function group_edit($id = null) {
		$this->Person_Group->id = $id;
		if ($this->request->is('get')) {
			$this->request->data = $this->Person_Group->read();
		} else {
			if ($this->Person_Group->save($this->request->data)) {
				$this->Session->setFlash('儲存成功.');
				$this->redirect(array('action' => 'group_index'));
			} else {
				$this->Session->setFlash('儲存失敗.');
			}
		}
	}
	
	public function group_delete($id) {
		$this->Person_Group->id = $id;
		$this->request->data = $this->Person_Group->read();
		$this->request->data['Person_Group']['valid'] = ($this->request->data['Person_Group']['valid'] + 1)%2;
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if ($this->Person_Group->save($this->request->data)) {
			$this->Session->setFlash('群組狀態已變更.');
			$this->redirect(array('action' => 'group_index'));
		} else {
			$this->Session->setFlash('作業失敗.');
		}	
	}

    public function level_index() {
        $this->set('levels', $this->Person_Level->find('all', array('order' => 'valid DESC, id')));
    }

	public function level_edit($id = null) {
		$this->Person_Level->id = $id;
		if ($this->request->is('get')) {
			$this->request->data = $this->Person_Level->read();
		} else {
			if ($this->Person_Level->save($this->request->data)) {
				$this->Session->setFlash('儲存成功.');
				$this->redirect(array('action' => 'level_index'));
			} else {
				$this->Session->setFlash('儲存失敗.');
			}
		}
	}
	
	public function level_delete($id) {
		$this->Person_Level->id = $id;
		$this->request->data = $this->Person_Level->read();
		$this->request->data['Person_Level']['valid'] = ($this->request->data['Person_Level']['valid'] + 1)%2;
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if ($this->Person_Level->save($this->request->data)) {
			$this->Session->setFlash('等級權限狀態已變更.');
			$this->redirect(array('action' => 'level_index'));
		} else {
			$this->Session->setFlash('作業失敗.');
		}	
	}
	
	public function person_edit($id=null) {
		$this->Person->id = $id;
		if ($this->request->is('get')) {
			$this->request->data = $this->Person->read();
		}
		else {
			if ($this->request->data["Person"]['id'] == '') {
				$this->request->data["Person"]['id'] = date('YmdHis');
			}
			if ($this->Person->save($this->request->data)) {
				$this->Session->setFlash('借閱者新增完成.');
				$this->redirect(array('action' => 'level_index'));
			} else {
				$this->Session->setFlash('作業失敗.');
			}
		}
		$this->set('person_titles', $this->Person_Title->find('list', array('fields' => array('id', 'title_name'))));
		$this->set('person_levels', $this->Person_Level->find('list', array('fields' => array('id', 'level_name'))));
		$this->set('person_groups', $this->Person_Group->find('list', array('fields' => array('id', 'group_name'))));
		$this->set('person_gender', $this->Formfunc->person_gender());
		$this->set('id', $id);
	}
}
?>