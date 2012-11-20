<?php
class Book_Cate extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'Book_Catagorys';
	public $validate = array(
		'id' => array(
            array('rule' => 'notEmpty', 'message' => '分類代號不可空白'),
			array('rule' => 'isUnique', 'message' => '分類代號不可重複')
        ),
        'catagory_name' => array(
            array('rule' => 'notEmpty', 'message' => '書籍分類不可空白'),
			array('rule' => 'isUnique', 'message' => '書籍分類不可重複')
        )
    );
	public $hasMany = array('Book' => array(
								'className' => 'Book',
								'foreignKey' => 'cate_id',
							)
	);
}
?>