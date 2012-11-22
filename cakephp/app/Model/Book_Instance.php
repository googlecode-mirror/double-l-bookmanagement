<?php
class Book_Instance extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'book_instances';

	public $belongsTo = array(
		'Book' => array(
			'className' => 'Book',
			'foreignKey' => 'book_id',
		)
	);	
}
?>