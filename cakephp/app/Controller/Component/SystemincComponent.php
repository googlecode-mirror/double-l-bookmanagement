<?php
App::uses('Component', 'Controller');
class SystemincComponent extends Component {
	/*
	public function __construct(){
		//$this->System_Inc = ClassRegistry::init('System_Inc');
	}
*/
	public function __construct(ComponentCollection $collection, $settings = array()) {
		//$this->System_Inc = ClassRegistry::init('System_Inc');
		$this->Controller = $collection->getController();
		parent::__construct($collection, $settings);
		
	}
	/*
	public function initialize(&$controller) {
		$this->Controller =& $controller;
		return parent::initialize($controller); 	
	}
	*/
	public function get_Id($key){
		$id = "B000000";
		$this->Controller->loadModel('System_Inc');
		//var_dump($this->Controller->System_Inc);
		
		$this->Controller->System_Inc->id = $key;
		$inc = $this->Controller->System_Inc->read();
		//var_dump($inc);
		$inc["System_Inc"]["count"] = $inc["System_Inc"]["count"] + 1;
		$id = sprintf($inc["System_Inc"]["format"], $inc["System_Inc"]["count"]);
		$this->Controller->System_Inc->saveField('count',$inc["System_Inc"]["count"]);
		return $id;
		//return "B00123";
	}
}
?>