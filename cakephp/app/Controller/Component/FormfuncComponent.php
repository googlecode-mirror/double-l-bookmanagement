<?php
	App::uses('Component', 'Controller');
	class FormfuncComponent extends Component {
		public function convert_options($result, $model, $key=id, $label='name') {
			$rt = array();
			foreach($result as $item) {
				$rt[$item[$model][$key]] = $item[$model][$label];
			}
			return $rt;
		}
		
		public function book_status() {
			return array(0=>"購買中",1=>"在庫",2=>"借出",3=>"已歸還",4=>"整理中",5=>"運送中", 6=>"預約中");
		}
		public function is_lends(){
			return array("Y"=>"Y","N"=>"N");
		}
		
		public function person_gender() {
			return array(0=>"女",1=>"男");
		}
	}
?>