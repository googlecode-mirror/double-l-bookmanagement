<?php
App::import('Model','SystemPrint');
class System_Print_Book extends SystemPrint {
	public $belongsTo = array(
        'Book_Instance' => array(
            'className'    => 'Book_Instance',
            'foreignKey'   => 'print_id'
        )
    );

}
?>