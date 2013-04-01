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
					case 3:
						$conditions['Book.id'] = $this->book_ids($query[$para_key]);
						break;
				}	
			}
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
}
?>