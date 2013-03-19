<?php
// app/Controller/UsersController.php
class UsersController extends AppController {
	public $uses = array('Person');
	public $components = array('Userfunc');
	
	public $paginate = array(
			'limit' => 10,
			'order' => array(
					'User.username' => 'asc'
			)
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add'); // Letting users register themselves
	}

	public function login() {
		$this->layout = 'login';
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				if($this->Auth->user('valid') == 0){
					$this->Session->setFlash(__('帳號已被停止'));
					return;						
				}
				$uname =  $this->Auth->user('name');
				//if(empty($uname))
				//	$uname = $this->Auth->user('name');
				$this->Session->write("user_id",$this->Auth->user('id'));
				$this->Session->write("user_name",$uname);
				$this->Session->write("user_role", $this->Auth->user('role'));
				$this->Session->write("user_location", $this->Auth->user('location_id'));
				$this->Session->write('isLogin', true);
				$this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(__('錯誤的帳號或密碼,請再輸入一次'));
			}
		}
	}

	public function logout() {
		
		//$this->Session->delete('role');
		$this->_clean();
		$this->redirect($this->Auth->logout());
		
	}
	private function _clean(){
		$this->Session->delete('user_name');
		$this->Session->delete('user_id');
		$this->Session->delete('user_role');
		$this->Session->delete('user_location');
		$this->Session->delete('isLogin');
	}

    public function admin_index() {
        $this->User->recursive = 0;
        $this->paginate = array('conditions' => $this->Userfunc->getLocationCondition());
        $this->set('users', $this->paginate('User'));
        $this->set('locations', $this->Userfunc->getLocationOptions());
        $this->set('roles', $this->Userfunc->getRoleOptinons());
    }

    public function admin_edit($id=null){
    	$this->User->id = $id;
    	if ($this->request->is('get')) {
    		$this->request->data = $this->User->read();
    	}
    	else {
    		if ($this->request->data["User"]['id'] == '') {
    			$this->request->data["User"]['id'] = $this->request->data["User"]['username'];
    			$this->request->data["Person"]['created'] = date('Y-m-d H:i:s');
    		}
    		if ($this->User->save($this->request->data)) {
    			$this->Session->setFlash('管理者儲存完成.');
    			$this->redirect(array('action' => 'admin_index'));
    		} else {
    			$this->Session->setFlash('作業失敗.');
    		}
    	}
        $this->set('locations', $this->Userfunc->getLocationOptions());
        $this->set('roles', $this->Userfunc->getRoleOptinons());
        
    }
    
    public function admin_delete($id) {
    	$this->User->id = $id;
    	$this->request->data = $this->User->read();
    	$this->request->data['User']['valid'] = ($this->request->data['User']['valid'] + 1)%2;
    	if ($this->request->is('get')) {
    		throw new MethodNotAllowedException();
    	}
    	if ($this->User->save($this->request->data)) {
    		$this->Session->setFlash('管理者狀態已變更.');
    		$this->redirect(array('action' => 'admin_index'));
    	} else {
    		$this->Session->setFlash('作業失敗.');
    	}
    }
    
    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('controller'=> 'users', 'action' => 'login'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }
    }

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
}
