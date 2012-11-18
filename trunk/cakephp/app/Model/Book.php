<?php
class Book extends AppModel {
	public $useDbConfig = 'default';
	public $useTable = 'Books';
	public $validate = array(
        //'catagory_name' => array(
        //    array('rule' => 'notEmpty', 'message' => '�貊����銝��蝛箇�'),
		//	array('rule' => 'isUnique', 'message' => '�貊����銝�����')
        //)
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
}
?>