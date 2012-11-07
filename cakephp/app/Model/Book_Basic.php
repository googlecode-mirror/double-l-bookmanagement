<?php
class Book_Basic extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'Book_Basics';
	/*public $validate = array(
        'catagory_name' => array(
            array('rule' => 'notEmpty', 'message' => '書籍分類不可空白'),
			array('rule' => 'isUnique', 'message' => '書籍分類不可重複')
        )
    );*/
	public $hasMany = array('Book_Version' => array(
								'className' => 'Book_Version',
								'foreignKey' => 'basic_id',
							)
	);
	public $belongsTo = array(	'Book_Cate' => array('className' => 'Book_Cate',
													'foreignKey' => 'cate_id'),
								'Book_Publisher' => array('className' => 'Book_Publisher',
													'foreignKey' => 'book_publisher_id')
	);

}
?>