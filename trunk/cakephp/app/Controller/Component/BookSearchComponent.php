<?php
App::uses('Component', 'Controller');
class BookSearchComponent extends Component {
	/*
	 *  1 = equal
	 *  2 = like
	 */
	private $search_para = array(
		//'page'=> 1,
		//'sort'=>1,
		'book_name'=> 2,
		'isbn'=>2,
		'book_author'=>2,
		'book_publisher'=>2,
		'book_ad'=>1,
		'cate_id'=>1
	);
	public function search($query){
		//var_dump($query);
		$books = array();
		if($query==null) return $books;
		$conditions = null;
		foreach ($this->search_para as $para_key=>$para_type){
			if (!isset($query[$para_key]) || trim($query[$para_key] == ''))  {
				continue;
			}
			switch($para_type)	{
				case 1:
					$conditions['Book.'.$para_key] = $query[$para_key];
					break;
				case 2:
					$conditions['Book.'.$para_key.' Like'] = '%'.$query[$para_key].'%';
					break;
			}	
		}
		if($conditions == null) return $books;
		
		$books = ClassRegistry::init('Book')->find('all',array('conditions' => $conditions));
		return $books;
	}
}
?>