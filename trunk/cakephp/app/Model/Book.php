<?php
class Book extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'books';
	public $validate = array(
		'lexile_level' => array(
				array('rule'=> 'numeric','message' => '閱讀級別必須是數字'),
				array('rule'=> array('between', 0, 9999),'message' => '閱讀級別必須介於0~9999之間')
		)	
	);
	public $hasMany = array(
		'Book_Instances' => array(
			'className' => 'Book_Instance',
			'foreignKey' => 'book_id',
		)
	);
	public $belongsTo = array(	
		'Book_Cate' => array(
			'className' => 'Book_Cate',
			'foreignKey' => 'cate_id',
		)
	);

	public function beforeSave($options = array()){
		
		if($this->data['Book']['lexile_level'] == 0){
			$this->data['Book']['cate_id'] = 0;
		} else if($this->data['Book']['lexile_level'] ==9999) {
			$this->data['Book']['cate_id'] = 9999;
		} else {
			$this->data['Book']['cate_id'] = (floor(($this->data['Book']['lexile_level']-1)/100)+1)*100;
		}
		return true;
	}
}
?>