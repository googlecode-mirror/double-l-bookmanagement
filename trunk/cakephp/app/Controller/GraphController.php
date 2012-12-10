<?php
class GraphController extends AppController {
	public $uses = array('Person', 'Book', 'Book_Instance');
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session', 'Formfunc');
	public $layout = 'ajax';
		
	public function index($type='P', $id=0) {
		$this->set('type', $type);
		$this->set('id', $id);
	}
	
	public function barcode39($type='P', $id=0) {
		define('IN_CB',true);
		App::import("Vendor", "barcodegen/BarCode");
		App::import("Vendor", "barcodegen/FColor");
		App::import("Vendor", "barcodegen/FDrawing");
		App::import("Vendor", "barcodegen/code39");
		define('IMG_FORMAT_PNG',	1);
		define('IMG_FORMAT_JPEG',	2);
		define('IMG_FORMAT_WBMP',	4);
		define('IMG_FORMAT_GIF',	8);

		$strText = 'Error';
		if ($type == 'B') {
			$result = $this->Book_Instance->find('all', array('conditions' => array('Book_Instance.id' => $id)));
			if ($result !== false) {
				$strText = $result[0]['Book_Instance']['id'];
			}
		}
		else if ($type == 'P') {
			$result = $this->Person->findById($id);
			if ($result !== false) {
				$strText = $result['Person']['id'];
			}
		}
		
		$this->set('strText', $strText);
	}
}
?>