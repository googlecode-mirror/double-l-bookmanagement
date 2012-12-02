<?php
App::uses('Component', 'Controller');
class UserfuncComponent extends Component {
	public $components = array('Session','Formfunc');
	
	public $user_roles = array(
			'admin'=>'總部管理員', 
			'localadmin'=>'分校管理員', 
			'localmanager'=>'分校經理'
		);

	public function getRoleOptinons(){
		if($this->Session->read('user_role') !== 'admin'){
			return array('localadmin'=>'分校管理員', 'localmanager'=>'分校經理');			
		}
		return $this->user_roles;
	}
	
	public function getLocationOptions(){
		$modelName = 'System_Location';
		$conditions = array('1' => '1',$modelName.'.valid' => 1);
		if($this->Session->read('user_role') !== 'admin'){
			$conditions = array(
					$modelName.'.id' => $this->Session->read('user_location'),
					$modelName.'.valid' => 1
				);
		}
		$items = ClassRegistry::init($modelName)->find('list',
				array(
					'conditions' => $conditions,
					'order' => array($modelName.'.id '),
					'fields' => array($modelName.'.id', $modelName.'.location_name')		
				)
		);
		return $items;
	}
	
	public function getLocationCondition($model='User', $condition=null){
		if($condition == null)
			$condition = array();
		if($this->Session->read('user_role') !== 'admin'){
			$t = array($model.'.location_id' => $this->Session->read('user_location'));
			$condition = array_merge($condition, $t);
		}
		return $condition;
	}
}
?>