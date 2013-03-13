<?php
class System_Take_Stock extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'system_take_stocks';
	public $validate = array(
        'book_instance_id' => array(
            array('rule' => 'notEmpty', 'message' => '書籍條碼不可為空白')
        )
    );
}
?>