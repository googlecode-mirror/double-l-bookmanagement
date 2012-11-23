<?php
class LendController extends AppController {
	public $uses = array('Book_Cate', 'Book', 'Book_Instance','Book_Publisher', 'Person_Level', 'Lend_Record');
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session', 'Formfunc', 'Leadfunc');

    public function index(){
		$lend_records = $this->Lend_Record->find('all');
    	$this->set('lend_records', $lend_records);  	 
    } 

	public function lead_operation() {
		if (!empty($this->data)) {
		
		}
	}
}
?>