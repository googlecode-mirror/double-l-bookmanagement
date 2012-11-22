<?php
class Book extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'books';
	public $hasMany = array(
		'Book_Instances' => array(
			'className' => 'Book_Instance',
			'foreignKey' => 'book_id',
		)
	);
	public $belongsTo = array(	
		'Book_Cate' => array(
			'className' => 'Book_Cate',
			'foreignKey' => 'cate_id',
		)
	);	
}
?>