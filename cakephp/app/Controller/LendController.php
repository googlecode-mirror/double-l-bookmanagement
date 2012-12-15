<?php
class LendController extends AppController {
	public $uses = array('Book_Cate', 'Book', 'Book_Instance','Book_Publisher', 'Person', 'Lend_Record', 'Person_Level', 'System_Location');
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
		$userinfo = $this->Lendfunc->create_userinfo();
		$lend_records = array();
		$over_lend_records = array();
		$person_info = array();
		if (!empty($this->data)) {
			if (isset($this->data['Lend_Record']['person_id'])) {
				$this->Person->id = $this->data['Lend_Record']['person_id'];
				$person_info = $this->Person->read();
				if ($person_info !== false) {
					if (($person_info['Person_Level']['is_cross_lend']) || ($person_info['Person']['location_id'] == $userinfo['user_location'])) {
						if (sizeof($this->data) >1) {
							foreach (array_keys($this->data) as $key)	{
								if ($key !== 'Lend_Record') {
									$book_status = $this->Book_Instance->find('all', array('conditions'=>array('book_status in (1,6)')));
									if (!empty($book_status)) {
										$lend_books = $this->data[$key];
										$reserve_rec = $this->Lend_Record->find('all', array('conditions' =>array('status' => 'R', 'Lend_Record.person_id' => $this->data['Lend_Record']['person_id'], 'Lend_Record.book_instance_id' => $lend_books['book_instance_id'])));
										if (!empty($reserve_rec)) {
											$lend_books['id'] = $reserve_rec[0]['Lend_Record']['id'];
										}else {
											$lend_books['id'] = null;
										}
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
						$over_lend_records = $this->Lend_Record->find('all',array('conditions' => array('person_id' => $person_info['Person']['id'], 'return_time' => null, 'book_instance.s_return_date < current_timestamp', 'status in ("C", "E")') ));
					}
				}
			}
		}
		$this->set('person_info', $person_info);
		$this->set('lend_records', $lend_records);
		$this->set('over_lend_records', $over_lend_records); 
		$this->set('lend_status', $this->Lendfunc->lend_status());
	}
	
	public function return_operation() {
		$msg = '';
		$userinfo = $this->Lendfunc->create_userinfo();
		$lend_records = array();
		$over_lend_records = array();
		$person_info = array();
		if (!empty($this->data)) {
			$return_record = $this->Lend_Record->find('all', array('conditions' => array('status' => 'C')));
			if (($return_record !== false) && (!empty($return_record))) {
				$return_record = $return_record[0];
				if ($userinfo['user_location'] == $return_record["Lend_Record"]['location_id']) {
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
						$book_instance_modi['reserve_person_id'] = null;
						$book_instance_modi['s_return_date'] = null;
						$reserve_rec = $this->Lend_Record->find('all', array('conditions' =>array('status' => 'R', 'Lend_Record.id' => $return_record["Lend_Record"]['book_instance_id']), 'order' => 'reserve_time'));
						//var_Dump($reserve_rec);
						if (!empty($reserve_rec)) {
							$reserve_rec = $reserve_rec[0];
							$book_instance_modi['book_status'] = 6;
							$book_instance_modi['reserve_person_id'] = $reserve_rec["Lend_Record"]['person_id'];
							$book_instance_modi['s_return_date'] = date('Y-m-d', mktime(0,0,0,date('m'),date('d')+7));
						}
						$ret = $this->Book_Instance->save($book_instance_modi);
						if ($ret === false) {
							$this->Lend_Record->save($return_record["Lend_Record"]);
						}
					}
					$this->Person->id = $return_record['Person']['id'];
					$person_info = $this->Person->read();
					$lend_records = $this->Lend_Record->find('all',array('conditions' => array('person_id' => $return_record['Person']['id'], 'return_time' => null, 'status in ("C", "E")') ));
					$over_lend_records = $this->Lend_Record->find('all',array('conditions' => array('person_id' => $return_record['Person']['id'], 'return_time' => null, 'book_instance.s_return_date < current_timestamp', 'status in ("C", "E")') ));
				}
				else {
					$msg = '本地無此書外借資料';
				}
			}
			else {
				$msg = '此書無外借資料';
			}
		}
		$this->set('msg', $msg);
		$this->set('person_info', $person_info);
		$this->set('lend_records', $lend_records);  	
		$this->set('over_lend_records', $over_lend_records); 
		$this->set('lend_status', $this->Lendfunc->lend_status());
	}

	public function reserve_book() {
		$msg = '';
		$this->layout = 'ajax'; 
		$lend_records = array();
		$person_info = array();
		if (!empty($this->data)) {
			if ($this->Session->read('user_role') !== 'user') {
				$reserve_person_id = $this->data['reserve_person_id'];
			}
			else {
				$reserve_person_id = $this->Session->read('user_id');
			}
			$person_info = $this->Person->find('all', array('conditions' =>array('Person.id' => $reserve_person_id)));
			if (empty($person_info)) {
				$msg = '無此借卡號碼：'.$reserve_person_id;
			}
			else {
				$book_instance = $this->Book_Instance->find('all', array('conditions' =>array('Book_Instance.id' => $this->data['book_instance_id'])));
				if (empty($book_instance)) {
					$msg = '無此書籍代號：'.$this->data['book_instance_id'];
				}
				else {
					if ((!$person_info[0]['Person_Level']['is_cross_lend']) && ($person_info[0]['Person']['location_id'] != $book_instance[0]['Book_Instance']['location_id'])) {
						$msg = '借卡號碼：'.$reserve_person_id.' 不可跨區借閱';
					}
					else if (!$book_instance[0]["Book_Instance"]["is_lend"]){
						$msg = '書籍代號：'.$this->data['book_instance_id'].'不可借閱';
					}
					else {
						$lend_books = array();
						$lend_books['id'] = null;
						$lend_books['record_type'] = 1;
						$lend_books['person_id'] = $reserve_person_id;
						$lend_books['book_id'] = $book_instance[0]["Book_Instance"]["book_id"];
						$lend_books['book_instance_id'] = $this->data['book_instance_id'];
						$lend_books['status'] = 'R';
						$lend_books['reserve_time'] = date('Y-m-d H:i:s');
						$lend_books['s_return_date'] = date('Y-m-d', mktime(0,0,0,date('m'),date('d')+$person_info[0]['Person_Level']['max_day'],date('Y')));
						$lend_books['create_time'] = $lend_books['reserve_time'];
						$ret = $this->Lend_Record->save($lend_books);
						if ($ret !== false) {
							if ($book_instance[0]["Book_Instance"]["book_status"] == 1)  {
								$book_instance[0]["Book_Instance"]['book_status'] = 6;
								$book_instance[0]["Book_Instance"]['reserve_person_id'] = $reserve_person_id;
								$book_instance[0]["Book_Instance"]['s_return_date'] = date('Y-m-d', mktime(0,0,0,date('m'),date('d')+7));
								$ret = $this->Book_Instance->save($book_instance[0]);
							}
							$msg = '書籍代號：'.$this->data['book_instance_id'].'預約成功';
						}
						else {
							$msg = '書籍代號：'.$this->data['book_instance_id'].'預約失敗';
						}
					}
				}
			}
		}
		else {
			$msg = '錯誤';
		}
		$this->set('msg', $msg);
	}
	
	public function user_status() {
		$lend_records = array();
		$over_lend_records = array();
		$person_info = array();
		$this->Person->id = $this->Session->read('user_id');
		$person_info = $this->Person->read();
		$lend_records = $this->Lend_Record->find('all',array('conditions' => array('person_id' => $person_info['Person']['id'], 'return_time' => null, 'status in ("C", "E")') ));
		$over_lend_records = $this->Lend_Record->find('all',array('conditions' => array('person_id' => $person_info['Person']['id'], 'return_time' => null, 'book_instance.s_return_date < current_timestamp', 'status in ("C", "E")') ));
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
		$user_info = $this->Lendfunc->create_userinfo();
		$error_code = $this->Lendfunc->book_auth($person, $book, $user_info);
		if ($error_code != 0) {
			$person = array();
			$book = array();
		}
		$this->set('user_info', $user_info);
		$this->set('person_level', $this->Person_Level->find('list', array('fields' => array('id', 'level_name'))));
		$this->set('locations', $this->System_Location->find('list', array('fields' => array('id', 'location_name'))));
		$this->set('book_status', $this->Formfunc->book_status());
		$this->set('book_cnt', $this->data["book_cnt"] - 1);
		$this->set('person', $person);
		$this->set('book', $book);
		$this->set('error_code', $error_code);
	}
}
?>