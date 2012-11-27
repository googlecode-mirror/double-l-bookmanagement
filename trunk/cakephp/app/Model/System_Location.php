<?php
class System_Location extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'system_locations';
	public $validate = array(
        'location_name' => array(
            array('rule' => 'notEmpty', 'message' => '地點名稱不可空白'),
			array('rule' => 'isUnique', 'message' => '地點名稱不可重複')
        )
    );
}
?>