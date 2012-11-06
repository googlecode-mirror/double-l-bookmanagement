<?php
class Book_Publisher extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'Book_Publishers';
	public $validate = array(
		'id' => array(
            array('rule' => 'notEmpty', 'message' => '出版商代號不可空白'),
			array('rule' => 'isUnique', 'message' => '出版商代號不可重複')
        ),
        'catagory_name' => array(
            array('rule' => 'notEmpty', 'message' => '出版商公司不可空白'),
			array('rule' => 'isUnique', 'message' => '出版商公司不可重複')
        )
    );
}
?>