<?php
class ReportsController extends AppController {
	public $uses = array('Lend_Record');
    public $helpers = array('Html', 'Form', 'Session', 'Paginator');
    public $components = array('Session', 'Formfunc', 'Lendfunc');

	public $paginate = array(
        'Lend_Record' => array(	'limit' => 10,
								'order' => array('Lend_Record.id' => 'desc')
		)
    );
	
    public function user_person_static(){
		$person_id = $this->Session->read('user_id');
		$lend_records = $this->paginate('Lend_Record', array('person_id'=>$person_id));
		$this->Person->id = $person_id;
		$person_info = $this->Person->read();
		$o_lend_records = $this->Lend_Record->find('all',array('conditions' => array('person_id' => $person_id, 'return_time' => null, 'status in ("C", "E")') ));
		$o_over_lend_records = $this->Lend_Record->find('all',array('conditions' => array('person_id' => $person_id, 'return_time' => null, 'book_instance.s_return_date < current_timestamp', 'status in ("C", "E")') ));
		$this->set('person_info', $person_info);
		$this->set('lend_status', $this->Lendfunc->lend_status());
		$this->set('o_lend_records', $o_lend_records);
		$this->set('o_over_lend_records', $o_over_lend_records); 		
    	$this->set('lend_records', $lend_records);
    }    

}
?>