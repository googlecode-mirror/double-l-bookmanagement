<?php
// app/Model/User.php
App::uses('AuthComponent', 'Controller/Component');
class User extends AppModel {
    public $name = 'User';
	public $useTable = 'users';
    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        ),
    	'name' => array(
    		'valid' => array(
    		'rule' => array('notEmpty'),
    		'message' => 'Please enter a name',
    		)
    	),    		
        'role' => array(
            'valid' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please enter a valid role',
            )
        ),
        'location_id' => array(
            'valid' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please enter a valid location',
            )
        )
    );
	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}
}
