<?php
	App::uses('Component', 'Controller');
	class FormfuncComponent extends Component {
		public $adminRoles = array(
				'admin'=>'總管理員',
				'localadmin' => '分校管理員',
				'localmanager' => '分校經理'
				);
		
		public function convert_options($result, $model, $key=id, $label='name') {
			$rt = array();
			foreach($result as $item) {
				$rt[$item[$model][$key]] = $item[$model][$label];
			}
			return $rt;
		}
		
		public function book_status() {
			return array(0=>"購買中",1=>"在庫",2=>"借出",3=>"已歸還",4=>"整理中",5=>"運送中", 6=>"預約中", 7=>"遺失", 8=>"已賠償");
		}
		public function is_lends(){
			return array("Y"=>"Y","N"=>"N");
		}
		
		public function person_gender() {
			return array(0=>"女",1=>"男");
		}
		
		public function person_valid(){
			return array(1=>"生效",0=>"未生效",-1=>"停權");
		}
	}
?>