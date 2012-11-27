<?php
	App::uses('Component', 'Controller');
	class LendfuncComponent extends Component {
		
		public function lead_status() {
			return array('C' => '出借中', 'R' => '歸還', 'D' => '遺失', 'R' => '預約', 'D' => '取消', 'E' => '續借中');
		}
	}
?>