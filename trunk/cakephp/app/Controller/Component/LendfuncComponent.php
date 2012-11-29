<?php
	App::uses('Component', 'Controller');
	class LendfuncComponent extends Component {
		
		public function lead_status() {
			return array('C' => '出借中', 'R' => '歸還', 'D' => '遺失', 'R' => '預約', 'D' => '取消', 'E' => '續借中');
		}
		
		public function book_auth($person, $book) {
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
					}else if ($book['Book_Instance']['book_status'] != 1) {
						$result = 3;
					//}else if ($book['Book_Instance']['level_id'] > $person['Person']['level_id']) {
					//	$result = 5;
					}
					else {
						$result = 0;
					}
				}
			}
			return $result;
		}
	}
?>