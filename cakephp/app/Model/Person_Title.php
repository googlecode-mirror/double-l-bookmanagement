<?php
class Person_Title extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'Person_Titles';
	public $validate = array(
        'title_name' => array(
            array('rule' => 'notEmpty', 'message' => '職務名稱不可空白'),
			array('rule' => 'isUnique', 'message' => '職務名稱不可重複')
        )
    );
}
?>