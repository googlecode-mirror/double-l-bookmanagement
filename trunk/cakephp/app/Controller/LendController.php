<?php
class LendController extends AppController {
	public $uses = array('Book_Cate', 'Book', 'Book_Instance','Book_Publisher', 'Person', 'Lend_Record');
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session', 'Formfunc', 'Lendfunc');

    public function index(){
		$lend_records = $this->Lend_Record->find('all');
    	$this->set('lend_records', $lend_records);  	 
    } 

	public function lend_operation() {
		var_Dump($this->data);
		//var_Dump($this->Session);
		$lend_records = array();
		$person_info = array();
		if (!empty($this->data)) {
			if (isset($this->data['Lend_Record']['person_id'])) {
				$this->Person->id = $this->data['Lend_Record']['person_id'];
				$person_info = $this->Person->read();
				if ($person_info !== false) {
					$lend_records = $this->Lend_Record->find('all',array('conditions' => array('person_id' => $person_info['Person']['id'], 'return_date' => null) ));
					$lend_records = $this->Lend_Record->find('all',array('conditions' => array('person_id' => $person_info['Person']['id'], 'return_date' => null, 'lend_date > current_timestamp') ));
				}
			}
		}
		else {
		
		}
		$this->set('person_info', $person_info);
		$this->set('lend_records', $lend_records);  	
	}
	
	public function lend_book() {
		$this->layout = 'ajax'; 
		$this->Person->id = $this->data["person_id"];
		$person = $this->Person->read();
		if ($person === false) {
			$person = array();
		}
		$this->Book_Instance->id = $this->data["book_id"];
		$book = $this->Book_Instance->read();
		if ($book === false) {
			$book = array();
		}
		$this->set('book_cnt', $this->data["book_cnt"] - 1);
		$this->set('person', $person);
		$this->set('book', $book);
	}
}
?>