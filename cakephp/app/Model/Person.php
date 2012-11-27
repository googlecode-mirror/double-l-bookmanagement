<?php
class Person extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'persons';
	public $validate = array(
        'name' => array(
            array('rule' => 'notEmpty', 'message' => '姓名不可空白')
        ),
		'password' => array(
			array('rule' => 'notEmpty', 'message' => '密碼不可空白')
		)
    );
	public $belongsTo = array(	
		'Person_Level' => array(
			'className' => 'Person_Level',
			'foreignKey' => 'level_id',
		),
		'Person_Group' => array(
			'className' => 'Person_Group',
			'foreignKey' => 'group_id',
		),
		'Person_Title' => array(
			'className' => 'Person_Title',
			'foreignKey' => 'title_id',
		),
		'System_Location' => array(
			'className' => 'System_Location',
			'foreignKey' => 'location_id',
		)
	);	
	/*public $hasMany = array(	
		'Lend_Record' => array(
			'className' => 'Lend_Record',
			'foreignKey' => 'person_id',
		)
	);*/
}
?>