<?php
	App::uses('Component', 'Controller');
	class LendfuncComponent extends Component {
		
		public $lendStatus = array(
				'C' => '出借中', 
				'R' => '歸還', 
				'D' => '遺失', 
				'R' => '預約', 
				'D' => '取消', 
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
					}else if ((!$person['Person_Level']['is_cross_lend']) && ($person['Person']['location_id'] != $userinfo['user_location'])) {
						$result = 7;
					}else if ($book['Book_Instance']['book_status'] == 6) {
						$result = 6;
					}else if ($book['Book_Instance']['book_status'] != 1) {
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
	}
?>