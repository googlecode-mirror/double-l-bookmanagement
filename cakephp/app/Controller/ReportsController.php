<?php //中文
class ReportsController extends AppController {
	public $uses = array('Lend_Record', 'Book_Instance', 'System_Location');
    public $helpers = array('Html', 'Form', 'Session', 'Paginator');
    public $components = array('Session', 'Formfunc', 'Lendfunc');

	public $paginate = array(
        'Lend_Record' => array(	'limit' => 10,
								'order' => array('Lend_Record.id' => 'desc')
		)
    );
	
    public function user_person_status(){
		$person_id = $this->Session->read('user_id');
		if ($this->Session->read('user_role') !== 'user') {
			if (isset($this->data['Lend_Record']['person_id'])) {
				$person_id = $this->data['Lend_Record']['person_id'];
			}
			else {
				$person_id = $this->Session->read('user_person_status');
			}
			$this->set('person_id', $person_id);
		}
		$this->Session->write('user_person_status',$person_id);
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

    public function book_inv_check(){
		$books = array();
		$location_id = '';
		if (!empty($this->data)) {
			$location_id = $this->data['Book_Instance']['location_id'];
			if ($this->Session->read('user_role') !== 'user') {
				if ($this->Session->read('user_role') === 'localadmin') {
					$location_id = $this->Session->read('user_location');
				}
				$books = $this->Book_Instance->find('all',array('conditions' => array('book_status' => '1','location_id' => $location_id)));
			}	
		}
		$options = array(
			'condiftions'=>array('valid' => 1),
			'fields'=>array('id', 'location_name'),
			'order' => array('id'),
		);
		//$this->set('locations', $this->System_Location->find('list',array('condiftions'=>array('valid' => 1), 'fields'=>array('id', 'location_name'))));
    	$this->set('locations', $this->System_Location->find('list',$options));
		$this->set('books', $books);
    }    

}
?>