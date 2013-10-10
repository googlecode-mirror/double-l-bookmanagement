<?php
App::uses('Component', 'Controller');
class BookSearchComponent extends Component {
	public $components = array('Session');
	/*
	 *  1 = equal
	 *  2 = like
	 *  3 = in
	 */
	private $search_para = array(
		//'page'=> 1,
		//'sort'=>1,
		'book_instance_id'=>3,
		'book_name'=> 2,
		'isbn'=>2,
		'book_author'=>2,
		'book_publisher'=>2,
		'book_ad'=>1,
		'cate_id'=>1,
		'book_suite'=>2	
	);
	public function search($query){
		//var_dump($query);
		$page_size = 10;
		$page = $query['page'];
		$books = array();
		$count = 0;

		if($query!==null){ 
			// 產生 conditions
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
					//case 3:
					//	$conditions['Book.id'] = $this->book_ids($query[$para_key]);
					//	break;
				}	
			}
			if($this->Session->read('user_role') == 'admin'){
				$conditions[] = $this->book_instance_subquery(
												null,
												$query['book_instance_id']);
			} else {
				$conditions[] = $this->book_instance_subquery(
											$this->Session->read('user_location')
											,$query['book_instance_id']);
				
			}
			//$conditions[$this->book_instance_subquery($query['book_instance_id'])];
			// 抓取資料
			if($conditions !== null){
				$bookModel = ClassRegistry::init('Book');
				$count = $bookModel->find('count',array('conditions' => $conditions));
				$books = $bookModel->find('all',
							array(	
									'conditions' => $conditions,
									'page'=> $page,
									'limit'=> $page_size
							)
						);
			}
		}
		$result['books'] = $books;
		$result['page'] = $page;
		$result['count'] = $count;
		$result['page_size'] =$page_size;
		return $result;
	}
	private function book_ids($para){
			$books = ClassRegistry::init('Book_Instance')->find('list',
						array(
							'recursive' => 0, 
							'conditions'=>array('Book_Instance.id like'=>'%'.$para.'%'),
							'fields'=>'Book_Instance.book_id'	
						)
					);
			$book_ids = array_values($books);
			return ($book_ids);
		
	}
	// 沒有實體書籍不要列出來
	private function book_instance_subquery($location_id=null, $book_instance_id=null){
		$book_instance_model = ClassRegistry::init('Book_Instance');
		//$this->Session->read('user_role');
		//$location_id = $this->Session->read('user_location');
		//$conditionsSubQuery['1'] = 1 ;
		if($location_id != null){
			$conditionsSubQuery['Book_Instance.location_id'] = $location_id;
		}
		if($book_instance_id != null){
			$conditionsSubQuery['Book_Instance.id like'] = '%'.$para.'%';
		}
		$db = $book_instance_model->getDataSource();
		$subQuery = $db->buildStatement(
				array(
						'fields'     => array('Book_Instance.book_id'),
						'table'      => $db->fullTableName($book_instance_model),
						'alias'      => 'Book_Instance',
						'limit'      => null,
						'offset'     => null,
						'joins'      => array(),
						'conditions' => $conditionsSubQuery,
						'order'      => null,
						'group'      => null
				),
				$book_instance_model
		);
		$subQuery = 'Book.id in (' . $subQuery . ') ';
		//$subQuery = $db->expression($subQuery);
		//var_dump($subQuery);
		return $subQuery;
	}
}
?>