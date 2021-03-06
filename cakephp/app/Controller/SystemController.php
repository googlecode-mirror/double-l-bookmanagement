<?php
class SystemController extends AppController {
	public $uses = array('System_Location', 'Person');
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session', 'Formfunc', 'Userfunc','TakeStockFunc');

    public function location_index() {
        $this->set('titles', $this->System_Location->find('all', array('order' => 'valid DESC, id')));
    }
	
	public function location_edit($id = null) {
		$this->System_Location->id = $id;
		if ($this->request->is('get')) {
			$this->request->data = $this->System_Location->read();
		} else {
			if ($this->request->data['System_Location']['id'] == ''){
				$this->request->data['System_Location']['create_time'] = date('Y-m-d H:i:s');
			}
			if ($this->System_Location->save($this->request->data)) {
				$this->Session->setFlash('儲存成功.');
				$this->redirect(array('action' => 'location_index'));
			} else {
				$this->Session->setFlash('儲存失敗.');
			}
		}
	}
	
	public function location_delete($id) {
		$this->System_Location->id = $id;
		$this->request->data = $this->System_Location->read();
		$this->request->data['System_Location']['valid'] = ($this->request->data['System_Location']['valid'] + 1)%2;
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if ($this->System_Location->save($this->request->data)) {
			$this->Session->setFlash('地點狀態已變更.');
			$this->redirect(array('action' => 'location_index'));
		} else {
			$this->Session->setFlash('作業失敗.');
		}	
	}
	
	public function take_stock_management($isTakeStock = null){
		if($isTakeStock !== null){
		if($isTakeStock == 1 ) Cache::write($this->Session->read("user_location").'_take_stock', true);
		if($isTakeStock == 0 ) Cache::write($this->Session->read("user_location").'_take_stock', false);
			$this->Session->setFlash('盤點作業變更.');
		}
		$this->set('isTakeStock',Cache::read($this->Session->read("user_location").'_take_stock'));
	}
	
	public function take_stock_index($location = null){
		if($location !== null){
			$isTake = Cache::read($location.'_take_stock');	
			if($isTake){
				Cache::write($location.'_take_stock_version',$location . time());
			}
			Cache::write($location.'_take_stock',!$isTake);
		}
		if($this->Session->read('user_role') !== 'admin'){
			$condition = array('valid'=>1,'id'=>$this->Session->read('user_location'));
		}else{
			$condition = array('valid'=>1);
		}
		$locations = $this->System_Location->find('all', array(
				'conditions'=> $condition, 
				'order' => 'id'));
		
		foreach($locations as &$item){
			$item['System_Location']['isTakeStock'] = Cache::read($item['System_Location']['id'].'_take_stock');
		}
		$this->set('items',$locations);
	}
	public function take_stock_operation($location = null){
		if($location == null){
			$this->Session->setFlash('請選擇盤點分校');
			$this->redirect(array('action' => 'take_stock_index'));
		}
		$isTake = Cache::read($location.'_take_stock');
		if(!$isTake){
			$this->Session->setFlash('該分校尚未進入盤點');
			$this->redirect(array('action' => 'take_stock_index'));			
		}
		if ($this->request->is('post')) {
			$book_instance_id = $this->request->data['System_Take_Stock']['book'];
			$version = Cache::read($location.'_take_stock_version');
			$result = $this->TakeStockFunc->add_take_stock_operation($location,$version,$book_instance_id);
			if($result['isOk']){
				$this->Session->setFlash($book_instance_id . '已經盤點完畢');
				
			} else {
				$this->Session->setFlash($result['message']);
			}
			$this->request->data['System_Take_Stock']['book'] ='';
		}
		
	}
}
?>