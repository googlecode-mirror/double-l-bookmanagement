<?php
App::import('Model','SystemPrint');
class System_Print_Person extends SystemPrint {
	public $belongsTo = array(
        'Person' => array(
            'className'    => 'Person',
            'foreignKey'   => 'print_id'
        )
    );

}
?>