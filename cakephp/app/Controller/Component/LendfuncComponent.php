<?php
	App::uses('Component', 'Controller');
	class LendfuncComponent extends Component {
		public $components = array('Session','Formfunc');
		
		public $lendStatus = array(
				'C' => '出借中', 
				'I' => '歸還', 
				'D' => '遺失', 
				'R' => '預約', 
				'S' => '取消', 
				'E' => '續借中');
		
		public function lend_status() {
			return $this->lendStatus;
		}
		
		public function book_auth($person, $book, $userinfo) {
			$result = 99;
			if (($person === false) || (empty($person))) {
				$result = 1;
			}
			else {
				if (($book === false) || (empty($book))) {
					$result = 2;
				}
				else {
					if ($book['Book_Instance']['is_lend'] != 'Y') {
						$result = 4;
					}else if ((!$person['Person_Level']['is_cross_lend']) && ($person['Person']['location_id'] != $book['Book_Instance']['location_id'])) {
						$result = 7;
					}else if (($book['Book_Instance']['book_status'] == 6) && ($book['Book_Instance']['reserve_person_id'] != $person['Person']['id'])) {
						$result = 6;
					}else if (($book['Book_Instance']['book_status'] != 1) && ($book['Book_Instance']['book_status'] != 6)) {
						$result = 3;
					//}else if ($book['Book_Instance']['level_id'] > $person['Person']['level_id']) {
					//	$result = 5;
					}else {
						$result = 0;
					}
				}
			}
			return $result;
		}
		
		public function create_userinfo() {
			$user_info = array();
			$user_info['user_id'] = $this->Session->read('user_id');
			$user_info['user_name'] = $this->Session->read('user_name');
			$user_info['user_role'] = $this->Session->read('user_role');
			$user_info['user_location'] = $this->Session->read('user_location');
			return $user_info;
		}
	}
?>