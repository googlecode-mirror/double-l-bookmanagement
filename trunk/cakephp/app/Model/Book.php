<?php
class Book extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'Books';
	public $validate = array(
        //'catagory_name' => array(
        //    array('rule' => 'notEmpty', 'message' => '書籍分類不可空白'),
		//	array('rule' => 'isUnique', 'message' => '書籍分類不可重複')
        //)
    );
	public $belongsTo = array('Book_Version' => array(
								'className' => 'Book_Version',
								'foreignKey' => 'version_id'
							)
	);

}
?>