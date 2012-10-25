<?php
class Person_Level extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'Person_Levels';
	public $validate = array(
        'level_name' => array(
            array('rule' => 'notEmpty', 'message' => '等級權限名稱不可空白'),
			array('rule' => 'isUnique', 'message' => '等級權限名稱不可重複')
        ),
		'max_day' => array(
			array('rule' => 'notEmpty', 'message' => '最大借閱天數不可空白'),
			array('rule' => '/^[1-9][0-9]*$/', 'message' => '最大借閱天數必須是正整數')
		),
		'max_book' => array(
			array('rule' => 'notEmpty', 'message' => '最大借閱數量不可空白'),
			array('rule' => '/^[1-9][0-9]*$/', 'message' => '最大借閱數量必須是正整數')
		)
    );
}
?>