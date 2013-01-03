<?php
class PrintController extends AppController {
	public $uses = array('System_Print');
	
	public function add($type,$pid){
		$owner_id = $this->Session->read('user_id');
		$this->layout = 'ajax';
		$message = array('message' => "Print Saved");
		$id = $this->_getKey($type,$owner_id,$pid);
		$this->System_Print->id = $id;
		$p = $this->System_Print->read();
		if($p == null){
			$p = array('id' => $id, 'print_type' => $type, 'print_owner' => $owner_id, 'print_id' => $pid);
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
	private function _getKey($type,$owner_id,$pid){
		return $type.'_'.$owner_id.'_'.$pid;
	}
}
?>