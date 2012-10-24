<?php
class Book_Cate extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'Book_Catagorys';
	public $validate = array(
        'catagory_name' => array(
            array('rule' => 'notEmpty', 'message' => '書籍分類不可空白'),
			array('rule' => 'isUnique', 'message' => '書籍分類重複')
        )
    );
}
?>