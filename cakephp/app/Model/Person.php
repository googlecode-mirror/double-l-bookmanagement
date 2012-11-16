<?php
class Person extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'persons';
	public $validate = array(
        'name' => array(
            array('rule' => 'notEmpty', 'message' => '姓名不可空白')
        ),
		'password' => array(
			array('rule' => 'notEmpty', 'message' => '密碼不可空白')
		)
    );
}
?>