<?php
App::uses('Component', 'Controller');
class BookfuncComponent extends Component {

	public function create_book_instance_id($location_id,$book_id){
		$bookInstanceModel = 'Book_Instance';
		$conditions = array(
				$bookInstanceModel . '.' . 'location_id' => $location_id,
				$bookInstanceModel . '.' . 'book_id' => $book_id,
		);
		$count = ClassRegistry::init($bookInstanceModel)->find('count',
				array('conditions' => $conditions)
			);
		$id = sprintf('%1$s%2$05d%3$02d', $location_id,$book_id,$count+1);
		return $id;	
	}
	
}
?>