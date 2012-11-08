<?php
class PersonsController extends AppController {
	public $uses = array('Person_Title', 'Person_Group', 'Person_Level');
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');

    public function title_index() {
        $this->set('titles', $this->Person_Title->find('all', array('order' => 'valid DESC, id')));
    }
	
	public function title_edit($id = null) {
		$this->Person_Title->id = $id;
		if ($this->request->is('get')) {
			$this->request->data = $this->Person_Title->read();
		} else {
			if ($this->Person_Title->save($this->request->data)) {
				$this->Session->setFlash('�x�s���\.');
				$this->redirect(array('action' => 'title_index'));
			} else {
				$this->Session->setFlash('�x�s����.');
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
			$this->Session->setFlash('¾�Ȫ��A�w�ܧ�.');
			$this->redirect(array('action' => 'title_index'));
		} else {
			$this->Session->setFlash('�@�~����.');
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
				$this->Session->setFlash('�x�s���\.');
				$this->redirect(array('action' => 'group_index'));
			} else {
				$this->Session->setFlash('�x�s����.');
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
			$this->Session->setFlash('�s�ժ��A�w�ܧ�.');
			$this->redirect(array('action' => 'group_index'));
		} else {
			$this->Session->setFlash('�@�~����.');
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
				$this->Session->setFlash('�x�s���\.');
				$this->redirect(array('action' => 'level_index'));
			} else {
				$this->Session->setFlash('�x�s����.');
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
			$this->Session->setFlash('�����v�����A�w�ܧ�.');
			$this->redirect(array('action' => 'level_index'));
		} else {
			$this->Session->setFlash('�@�~����.');
		}	
	}
}
?>