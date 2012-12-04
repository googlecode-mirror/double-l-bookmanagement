<?php
class Lend_Record extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'lend_records';
	public $belongsTo = array(	
		'Book_Instance' => array(
			'className' => 'Book_Instance',
			'foreignKey' => 'book_instance_id',
		),
		'Book' => array(
			'className' => 'Book',
			'foreignKey' => 'book_id',
		),
		'Person' => array(
			'className' => 'Person',
			'foreignKey' => 'person_id',
		),
		'System_Location' => array(
			'className' => 'System_Location',
			'foreignKey' => 'location_id',
		)
	);	
}
?>