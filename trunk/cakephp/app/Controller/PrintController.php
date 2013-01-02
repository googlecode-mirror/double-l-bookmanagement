<?php
class PrintController extends AppController {
	public $uses = array('System_Print','status' => 1);
	public function add($type,$location,$pid){
		$message = array('message' => "Print Saved");
		$id = $this->_getKey($type,$location,$pid);
		$this->System_Print->id = $id;
		$p = $this->System_Print->read();
		if($p == null){
			$p = array('id' => $id, 'print_type' => $type, 'print_location' => $location, 'print_id' => $pid);
			if(!$this->System_Print->save($p)){
				$message['message'] = "Print Save is Faile.";
				$message['status'] = 0;
			}
		}
		$this->set('message',$message);
	}
	
	public function remove($type,$location,$pid){
		$message = array('message' => "Print Remove.", 'status' => 1);
		$id = $this->_getKey($type,$location,$pid);
		if(!$this->System_Print->delete($id)){
			$message['message'] = "刪除失敗";
			$message['status'] = 0;			
		}
		$this->set('message',$message);
	}
	private function _getKey($type,$location,$pid){
		return $type.'_'.$location.'_'.$pid;
	}
}
?>