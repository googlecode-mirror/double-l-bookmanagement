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
	
	public function book_barcode( $id=0) {
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
		$strTitle = '';
		$strColor = array('r'=>0,'g'=>0,'b'=>0);
		$result = $this->Book_Instance->find('all', array('conditions' => array('Book_Instance.id' => $id),'recursive' => 2));
		if (($result !== false)&& (!empty($result))) {
			$strText = $result[0]['Book_Instance']['id'];
			$strTitle = substr($result[0]['Book']['book_name'],0,34);
			if (strlen($result[0]['Book']['book_name']) > 34) {
				$strTitle = $strTitle."\n".substr($result[0]['Book']['book_name'],34,34);
			}
			$strColor = $this->hex2rgb($result[0]['Book']['Book_Cate']['catagory_color']);
		}	
		$this->set('strText', $strText);
		$this->set('strTitle', $strTitle);
		$this->set('strColor', $strColor);
	}
	
	private function hex2rgb($hex) {
		$hex = str_replace("#", "", $hex);

		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} 
		else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array('r'=>$r, 'g'=>$g, 'b'=>$b);
		//return implode(",", $rgb); // returns the rgb values separated by commas
		return $rgb; // returns an array with the rgb values
	}
}
?>