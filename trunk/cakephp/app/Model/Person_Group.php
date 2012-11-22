<?php
class Person_Group extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'person_groups';
	public $validate = array(
        'group_name' => array(
            array('rule' => 'notEmpty', 'message' => '群組名稱不可空白'),
			array('rule' => 'isUnique', 'message' => '群組名稱不可重複')
        )
    );
}
?>