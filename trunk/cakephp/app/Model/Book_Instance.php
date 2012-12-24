<?php
class Book_Instance extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'book_instances';

	public $belongsTo = array(
		'Book' => array(
			'className' => 'Book',
			'foreignKey' => 'book_id',
		),
		'System_Location' => array(
			'className' => 'System_Location',
			'foreignKey' => 'location_id',
		),
		'Book_Status' => array(
			'className' => 'Book_Status',
			'foreignKey' => 'book_status',
		)
	);	
}
?>