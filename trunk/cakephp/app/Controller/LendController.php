<?php
class LendController extends AppController {
	public $uses = array('Book_Cate', 'Book', 'Book_Instance','Book_Publisher', 'Person', 'Lend_Record', 'Person_Level');
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
					$lend_records = $this->Lend_Record->find('all',array('conditions' => array('person_id' => $person_info['Person']['id'], 'return_date' => null, 'status in ("C", "R", "E")') ));
					$over_lend_records = $this->Lend_Record->find('all',array('conditions' => array('person_id' => $person_info['Person']['id'], 'return_date' => null, 's_return_date > current_timestamp', 'status in ("C", "R", "E")') ));
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
		$error_code = 0;
		$this->Person->id = $this->data["person_id"];
		$person = $this->Person->read();
		if ($person === false) {
			$error_code = 1;
		}
		else {
			$this->Book_Instance->id = $this->data["book_id"];
			$book = $this->Book_Instance->read();
			if ($book === false) {
				$error_code = 2;
			}
			else {
				if ($book['Book_Instance']['is_lend'] != 'Y') {
					$error_code = 4;
				}else if ($book['Book_Instance']['book_status'] != 1) {
					$error_code = 3;
				}else if ($book['Book_Instance']['level_id'] > $person['Person']['level_id']) {
					$error_code = 5;
				}
			}
		}
		if ($error_code != 0) {
			$person = array();
			$book = array();
		}
		$this->set('person_level', $this->Person_Level->find('list', array('fields' => array('id', 'level_name'))));
		$this->set('book_status', $this->Formfunc->book_status());
		$this->set('book_cnt', $this->data["book_cnt"] - 1);
		$this->set('person', $person);
		$this->set('book', $book);
		$this->set('error_code', $error_code);
	}
}
?>