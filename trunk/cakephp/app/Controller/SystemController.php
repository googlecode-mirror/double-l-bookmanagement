<?php
class SystemController extends AppController {
	public $uses = array('System_Location', 'Person');
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session', 'Formfunc');

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
		}
		$this->set('isTakeStock',Cache::read($this->Session->read("user_location").'_take_stock'));
	}
}
?>