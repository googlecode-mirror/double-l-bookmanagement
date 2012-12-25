<?php
class PersonsController extends AppController {
	public $uses = array('Person_Title', 'Person_Group', 'Person_Level', 'Person', 'System_Location');
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
		$isModify = true;
		$isSave = true;
		if($id == null) {
			$isModify = false;
		}
		$this->Person->id = $id;
		if ($this->request->is('get')) {
			$this->request->data = $this->Person->read();
		}
		else {
			if($this->request->data["submit"] == 'New'){
				$isModify = false;
				$isSave = $this->_check_new_person($this->request->data);
				$this->request->data["Person"]['create_time'] = date('Y-m-d H:i:s');
				
			}
			$p['Person'] = $this->request->data['Person'];

			if($isSave){
			if ($isSave && $this->Person->save($p)) {
				$this->Session->setFlash('借閱者儲存完成.');
				$this->redirect(array('action' => 'person_index'));
			} else {
				$this->Session->setFlash('作業失敗.');
			}
			}
		}
		$this->set('person_titles', $this->Person_Title->find('list', array('fields' => array('id', 'title_name'))));
		$this->set('person_levels', $this->Person_Level->find('list', array('fields' => array('id', 'level_name'))));
		$this->set('person_groups', $this->Person_Group->find('list', array('fields' => array('id', 'group_name'))));
		$this->set('system_locations', $this->System_Location->find('list', array('fields' => array('id', 'location_name'))));
		$this->set('person_genders', $this->Formfunc->person_gender());
		$this->set('isModify',$isModify);
		$this->set('id', $id);
	}

	private function _check_new_person($data){
		$id = trim($data["Person"]['id']);
		if( $id == ''){
			$this->Session->setFlash('請輸入借卡代號.');
			return false;
		}
		$p = $this->Person->find('first',array('conditions'=>array('Person.id'=>$id)));
		if($p != null){
			$this->Session->setFlash('借卡代號已存在.');
			return false;
		}
		return true;

	}
	
	public function person_index() {
		$this->set('person_titles', $this->Person_Title->find('list', array('fields' => array('id', 'title_name'))));
		$this->set('person_levels', $this->Person_Level->find('list', array('fields' => array('id', 'level_name'))));
		$this->set('person_groups', $this->Person_Group->find('list', array('fields' => array('id', 'group_name'))));
		$this->set('system_locations', $this->System_Location->find('list', array('fields' => array('id', 'location_name'))));
		$this->set('person_genders', $this->Formfunc->person_gender());
        $this->set('persons', $this->Person->find('all', array('order' => 'Person.valid DESC, Person.id')));
    }
	
	public function person_delete($id) {
		$this->Person->id = $id;
		$this->request->data = $this->Person->read();
		$this->request->data['Person']['valid'] = ($this->request->data['Person']['valid'] + 1)%2;
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if ($this->Person->save($this->request->data)) {
			$this->Session->setFlash('借閱者狀態已變更.');
			$this->redirect(array('action' => 'person_index'));
		} else {
			$this->Session->setFlash('作業失敗.');
		}	
	}
	
	public function print_person_barcode() {
		$persons = array();
		$filter = array();
		$intX = 1;
		$intY = 1;
		if (!empty($this->data)) {
			$intX = $this->data['Person']['start_x'];
			$intY = $this->data['Person']['start_y'];
			if ($this->Session->read('user_role') != 'admin') {
				$filter = array_merge($filter,array('Person.location_id' => $this->Session->read('user_location')));
			}
			if ((isset($this->data['Person']['start_id'])) && (trim($this->data['Person']['start_id'])!='')) {
				$filter = array_merge($filter,array("Person.id >= '".$this->data['Person']['start_id']."' "));
			}
			if ((isset($this->data['Person']['end_id'])) && (trim($this->data['Person']['end_id'])!='')) {
				$filter = array_merge($filter,array("Person.id <= '".$this->data['Person']['end_id']."' "));
			}		
			$persons = $this->Person->find('all', array('conditions' => $filter,'recursive' => 2));
		}
		
		$this->set('persons', $persons);
		$this->set('intXs', array(1=>1,2=>2,3=>3));
		$this->set('intYs', array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9));
		$this->set('intX', $intX);
		$this->set('intY', $intY);
	}
}
?>