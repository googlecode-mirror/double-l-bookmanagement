<?php
class Book_Instance extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'Book_Instances';

	public $belongsTo = array(
		'Book' => array(
			'className' => 'Book',
			'foreignKey' => 'book_id',
		)
	);	
}
?>