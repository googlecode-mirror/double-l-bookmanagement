<?php
class LendController extends AppController {
	public $uses = array('Book_Cate', 'Book', 'Book_Instance','Book_Publisher', 'Person', 'Lend_Record', 'Person_Level');
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session', 'Formfunc', 'Lendfunc');

    public function index(){
		$lend_records = $this->Lend_Record->find('all');
    	$this->set('lend_records', $lend_records);  
    	$this->set('lend_status', $this->Lendfunc->lend_status());		
    } 

	public function lend_operation() {
		//var_Dump($this->data);
		//var_Dump($this->Session);
		$lend_records = array();
		$over_lend_records = array();
		$person_info = array();
		if (!empty($this->data)) {
			if (isset($this->data['Lend_Record']['person_id'])) {
				$this->Person->id = $this->data['Lend_Record']['person_id'];
				$person_info = $this->Person->read();
				if ($person_info !== false) {
					if (sizeof($this->data) >1) {
						foreach (array_keys($this->data) as $key)	{
							if ($key !== 'Lend_Record') {
								$book_status = $this->Book_Instance->find('all', array('conditions'=>array('book_status'=>1)));
								if (!empty($book_status)) {
									$lend_books = $this->data[$key];
									$lend_books['person_id'] = $this->data['Lend_Record']['person_id'];
									$lend_books['status'] = 'C';
									$lend_books['lend_time'] = date('Y-m-d H:i:s');
									$lend_books['create_time'] = $lend_books['lend_time'];
									$ret = $this->Lend_Record->save($lend_books);
									if ($ret !== false) {
										$record_id = $ret["Lend_Record"]["id"];
										$book_instance_modi = array();
										$book_instance_modi['id'] = $lend_books['book_instance_id'];
										$book_instance_modi['book_status'] = 2;
										$book_instance_modi['s_return_date'] = $lend_books['s_return_date'];
										$book_instance_modi['reserve_person_id'] = null;
										$ret = $this->Book_Instance->save($book_instance_modi);
										if ($ret === false) {
											$this->Lend_Record->delete($record_id);
										}
									}
								}
							}
						}
					}
					$lend_records = $this->Lend_Record->find('all',array('conditions' => array('person_id' => $person_info['Person']['id'], 'return_time' => null, 'status in ("C", "E")') ));
					$over_lend_records = $this->Lend_Record->find('all',array('conditions' => array('person_id' => $person_info['Person']['id'], 'return_time' => null, 'book_instance.s_return_date > current_timestamp', 'status in ("C", "E")') ));
				}
			}
		}
		$this->set('person_info', $person_info);
		$this->set('lend_records', $lend_records);
		$this->set('over_lend_records', $over_lend_records); 
		$this->set('lend_status', $this->Lendfunc->lend_status());
	}
	
	public function return_operation() {
		$lend_records = array();
		$over_lend_records = array();
		$person_info = array();
		if (!empty($this->data)) {
			$return_record = $this->Lend_Record->find('all', array('conditions' => array('status' => 'C')));
			if (($return_record !== false) && (!empty($return_record))) {
				if (($person['Person_Level']['is_cross_lend']) || ($person['Person']['location_id'] == $userinfo['user_location'])) {
					$return_record = $return_record[0];
					$return_rec = array();
					$return_rec["id"] = $return_record["Lend_Record"]["id"];
					$return_rec["status"] = 'I';
					$return_rec["return_time"] = date('Y-m-d H:i:s');
					$ret = $this->Lend_Record->save($return_rec);
					if ($ret !== false) {
						$record_id = $ret["Lend_Record"]["id"];
						$book_instance_modi = array();
						$book_instance_modi['id'] = $return_record["Lend_Record"]['book_instance_id'];
						$book_instance_modi['book_status'] = 1;
						$book_instance_modi['s_return_date'] = null;
						$reserve_rec = $this->Lend_Record->find('all', array('conditions' =>array('status' => 'R'), 'order' => 'reserve_time'));
						//var_Dump($reserve_rec);
						if (!empty($reserve_rec)) {
							$reserve_rec = $reserve_rec[0];
							$book_instance_modi['book_status'] = 6;
							$book_instance_modi['reserve_person_id'] = $reserve_rec["Lend_Record"]['person_id'];
						}
						$ret = $this->Book_Instance->save($book_instance_modi);
						if ($ret === false) {
							$this->Lend_Record->save($return_record["Lend_Record"]);
						}
					}
					$this->Person->id = $return_record['Person']['id'];
					$person_info = $this->Person->read();
					$lend_records = $this->Lend_Record->find('all',array('conditions' => array('person_id' => $return_record['Person']['id'], 'return_time' => null, 'status in ("C", "E")') ));
					$over_lend_records = $this->Lend_Record->find('all',array('conditions' => array('person_id' => $return_record['Person']['id'], 'return_time' => null, 'book_instance.s_return_date > current_timestamp', 'status in ("C", "E")') ));
				}
			}
		}
		$this->set('person_info', $person_info);
		$this->set('lend_records', $lend_records);  	
		$this->set('over_lend_records', $over_lend_records); 
		$this->set('lend_status', $this->Lendfunc->lend_status());
	}

	public function reserve_operation() {
		//var_Dump($this->data);
		//var_Dump($this->Session->read('id'));
		$lend_records = array();
		$over_lend_records = array();
		$person_info = array();
		$this->Person->id = $this->Session->read('user_id');
		var_Dump($this->Session->read('user_id'));
		var_Dump($this->Session->read('user_name'));
		var_Dump($this->Session->read('user_role'));
		var_Dump($this->Session->read('user_location'));
		$person_info = $this->Person->read();
		if (!empty($this->data)) {
		/*	if (isset($this->data['Lend_Record']['person_id'])) {
				$this->Person->id = $this->data['Lend_Record']['person_id'];
				$person_info = $this->Person->read();
				if ($person_info !== false) {
					if (sizeof($this->data) >1) {
						foreach (array_keys($this->data) as $key)	{
							if ($key !== 'Lend_Record') {
								$book_status = $this->Book_Instance->find('all', array('conditions'=>array('book_status'=>1)));
								if (!empty($book_status)) {
									$lend_books = $this->data[$key];
									$lend_books['person_id'] = $this->data['Lend_Record']['person_id'];
									$lend_books['status'] = 'C';
									$lend_books['lend_time'] = date('Y-m-d H:i:s');
									$lend_books['create_time'] = $lend_books['lend_time'];
									$ret = $this->Lend_Record->save($lend_books);
									if ($ret !== false) {
										$record_id = $ret["Lend_Record"]["id"];
										$book_instance_modi = array();
										$book_instance_modi['id'] = $lend_books['book_instance_id'];
										$book_instance_modi['book_status'] = 2;
										$book_instance_modi['s_return_date'] = $lend_books['s_return_date'];
										$book_instance_modi['reserve_person_id'] = null;
										$ret = $this->Book_Instance->save($book_instance_modi);
										if ($ret === false) {
											$this->Lend_Record->delete($record_id);
										}
									}
								}
							}
						}
					}
				}
			}*/
		}
		$lend_records = $this->Lend_Record->find('all',array('conditions' => array('person_id' => $person_info['Person']['id'], 'return_time' => null, 'status in ("C", "E")') ));
		$over_lend_records = $this->Lend_Record->find('all',array('conditions' => array('person_id' => $person_info['Person']['id'], 'return_time' => null, 'book_instance.s_return_date > current_timestamp', 'status in ("C", "E")') ));
		$reserve_records = $this->Lend_Record->find('all',array('conditions' => array('person_id' => $person_info['Person']['id'], 'return_time' => null, 'status' => "R") ));
		$this->set('person_info', $person_info);
		$this->set('lend_records', $lend_records);
		$this->set('reserve_records', $reserve_records);
		$this->set('over_lend_records', $over_lend_records); 
		$this->set('lend_status', $this->Lendfunc->lend_status());
	}
	
	public function lend_book() {
		$this->layout = 'ajax'; 
		$error_code = 0;
		$this->Person->id = $this->data["person_id"];
		$person = $this->Person->read();
		$this->Book_Instance->id = $this->data["book_instance_id"];
		$book = $this->Book_Instance->read();
		$error_code = $this->Lendfunc->book_auth($person, $book, $this->create_userinfo());
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
	
	private function create_userinfo() {
		$user_info = array();
		$user_info['user_id'] = $this->Session->read('user_id');
		$user_info['user_name'] = $this->Session->read('user_name');
		$user_info['user_role'] = $this->Session->read('user_role');
		$user_info['user_location'] = $this->Session->read('user_location');
		return $user_info;
	}
}
?>