<?php
class PrintsController extends AppController {
	public $uses = array('SystemPrint','System_Print_Book','System_Print_Person');
	
	public function add($type,$pid){
		$owner_id = $this->Session->read('user_id');
		$this->layout = 'ajax';
		$message = array('message' => "Print Saved");
		$id = $this->_getKey($type,$owner_id,$pid);
		$this->SystemPrint->id = $id;
		$p = $this->SystemPrint->read();
		if($p == null){
			$p = array('id' => $id, 'print_type' => $type, 'print_owner' => $owner_id, 'print_id' => $pid);
			if(!$this->SystemPrint->save($p)){
				$message['message'] = "Print Save is Faile.";
				$message['status'] = 0;
			}
		}
		$this->set('message',$message);
	}
	
	public function remove($type,$location,$pid){
		$message = array('message' => "Print Remove.", 'status' => 1);
		$id = $this->_getKey($type,$location,$pid);
		if(!$this->SystemPrint->delete($id)){
			$message['message'] = "刪除失敗";
			$message['status'] = 0;			
		}
		$this->set('message',$message);
	}
	
	public function book_list(){
		$this->System_Print_Book->recursive = 2 ;

		$options['conditions'] = array(
				'System_Print_Book.print_owner' => $this->Session->read('user_id'),
				'System_Print_Book.print_type' => 'B'
			);
		
		$items = $this->System_Print_Book->find('all', $options);
		$this->set('items',$items);
		$this->_initBarcodeXY();
		
	}
	
	public function book_list21(){
		$this->System_Print_Book->recursive = 2 ;

		$options['conditions'] = array(
				'System_Print_Book.print_owner' => $this->Session->read('user_id'),
				'System_Print_Book.print_type' => 'B'
			);
		
		$items = $this->System_Print_Book->find('all', $options);
		$this->set('items',$items);
		$this->_initBarcodeXY();
		
	}

	public function book_remove(){
		if($this->request->is('post') && $this->request->data['remove'] !==null){

			$option = array('System_Print_Book.id' => $this->request->data['remove'] );
			$this->System_Print_Book->deleteAll($option);	
		}
		$this->redirect(array('action' => 'book_list'));
	}
	
	public function book_barcode() {
		if(!$this->request->is('post') || empty($this->data)){
			$this->redirect(array('action' => 'book_list'));
		}
		$books = array();
		$filter = array();
		$intX = 1;
		$intY = 1;
		if (!empty($this->data)) {
			$intX = $this->data['Print']['start_x'];
			$intY = $this->data['Print']['start_y'];
			$books = $this->System_Print_Book->find('all',array('conditions'=>array('print_type'=>'B', 'print_owner' =>$this->Session->read('user_id'))));
		}
			
		$this->set('books', $books);
		$this->set('intX', $intX);
		$this->set('intY', $intY);
	}
	
	public function book_barcode21() {
		if(!$this->request->is('post') || empty($this->data)){
			$this->redirect(array('action' => 'book_list21'));
		}
		$books = array();
		$filter = array();
		$intX = 1;
		$intY = 1;
		if (!empty($this->data)) {
			$intX = $this->data['Print']['start_x'];
			$intY = $this->data['Print']['start_y'];
			$books = $this->System_Print_Book->find('all',array('conditions'=>array('print_type'=>'B', 'print_owner' =>$this->Session->read('user_id'))));
		}
			
		$this->set('books', $books);
		$this->set('intX', $intX);
		$this->set('intY', $intY);
	}

	public function person_list(){
		$this->System_Print_Person->recursive = 2 ;
	
		$options['conditions'] = array(
				'System_Print_Person.print_owner' => $this->Session->read('user_id'),
				'System_Print_Person.print_type' => 'P'
		);
	
		$items = $this->System_Print_Person->find('all', $options);
		$this->set('items',$items);
		$this->_initBarcodeXY();
	}	
	
	public function person_remove(){
		if($this->request->is('post') && $this->request->data['remove'] !==null){
	
			$option = array('System_Print_Person.id' => $this->request->data['remove'] );
			$this->System_Print_Person->deleteAll($option);
		}
		$this->redirect(array('action' => 'person_list'));
	}
	
	public function person_barcode() {
		if(!$this->request->is('post') || empty($this->data)){
			$this->redirect(array('action' => 'person_list'));
		}
		$persons = array();
		$filter = array();
		$intX = 1;
		$intY = 1;
		if (!empty($this->data)) {
			$intX = $this->data['Print']['start_x'];
			$intY = $this->data['Print']['start_y'];
			$persons = $this->System_Print_Person->find('all',array('conditions'=>array('print_type'=>'P', 'print_owner' =>$this->Session->read('user_id'))));
		}
			
		$this->set('persons', $persons);
		$this->set('intX', $intX);
		$this->set('intY', $intY);
	}
	
	
	
	private function _getKey($type,$owner_id,$pid){
		return $type.'_'.$owner_id.'_'.$pid;
	}
	private function _initBarcodeXY(){
		$intX = 1;
		$intY = 1;
		$this->set('intXs', array(1=>1,2=>2,3=>3));
		$this->set('intYs', array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7));
		$this->set('intX', $intX);
		$this->set('intY', $intY);		
	}
}
?>