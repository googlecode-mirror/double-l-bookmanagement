<?php
class Book_Cate extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'book_catagorys';
	public $validate = array(
		'id' => array(
            array('rule' => 'notEmpty', 'message' => '級別代號不可空白'),
			array('rule' => 'isUnique', 'message' => '級別代號不可重複')
        ),
        'catagory_name' => array(
            array('rule' => 'notEmpty', 'message' => '級別名稱不可空白'),
			array('rule' => 'isUnique', 'message' => '級別名稱不可重複')
        ),
		'catagory_color' => array(
			array('rule' => 'notEmpty', 'message' => '顏色不可空白')
		)			
    );
}
?>