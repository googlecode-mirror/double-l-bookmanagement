<?php
class Book_Version extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'book_versions';
	/*public $validate = array(
        'catagory_name' => array(
            array('rule' => 'notEmpty', 'message' => '書籍分類不可空白'),
			array('rule' => 'isUnique', 'message' => '書籍分類不可重複')
        )
    );*/
	public $belongsTo = array('Book_Basic' => array(
								'className' => 'Book_Basic',
								'foreignKey' => 'basic_id'
							)
	);
	public $hasMany = array('Book' => array(
								'className' => 'Book',
								'foreignKey' => 'version_id',
							)
	);
}
?>