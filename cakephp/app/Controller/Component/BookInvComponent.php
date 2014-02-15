<?php
App::uses('Component', 'Controller');
class BookInvComponent extends Component {
	public $components = array('Session');
	
	public function getInvBooks($location_id, $version){
		$model = ClassRegistry::init('Book_Instance');
		$option ['joins'] = array (
				array (
						'table' => 'system_take_stocks',
						'alias' => 'System_Take_Stock',
						'type' => 'LEFT',
						'conditions' => array (
								'System_Take_Stock.book_instance_id = Book_Instance.id',
								'System_Take_Stock.version' => $version 
						) 
				) 
		);
		$option['conditions'] = array(
				'Book_Instance.book_status in (1,4)',
				'Book_Instance.location_id' => $location_id
		);
		$option['fields'] = array(
				'System_Take_Stock.*',
				'Book_Instance.*',
				'Book.*',
				'System_Location.*',
				'Book_Status.*'
		);
		//var_dump($model->find('all',$option));
		return $model->find('all',$option);		
	}
	
	public function buildInvExcel($books){
		App::import("Vendor", "phpexcel/PHPExcel");
		App::import("Vendor", "phpexcel/PHPExcel/Writer/Excel5");
		 
		$r['path'] = TMP.'tests'.DS;
		$r['file'] = 'tmp_books_inv_'. $this->Session->read('user_id');
		$file =  $r['path'].$r['file'];
		$excel = new PHPExcel();
		$excel->setActiveSheetIndex(0);
		$excel->getActiveSheet()->setTitle('Books');
		$excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, '書籍編號');
		$excel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, '書籍名稱');
		$excel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, 'ISBN');
		$excel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, '作者/編者');
		$excel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, '出版公司');
		$excel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, '購買日期');
		$excel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, '盤點日期');
		$excel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, '狀態');
		$excel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, '盤點');
		$i = 1;		
		foreach($books as $book){
			$i++;
			$excel->getActiveSheet()->setCellValueExplicitByColumnAndRow(0, $i,$book['Book_Instance']['id'],PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValueByColumnAndRow(1, $i, $book['Book']['book_name']);
			$excel->getActiveSheet()->setCellValueExplicitByColumnAndRow(2, $i,$book['Book']['isbn'],PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValueByColumnAndRow(3, $i, $book['Book']['book_author']);
			$excel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, $book["Book"]["book_publisher"]);
			$excel->getActiveSheet()->setCellValueByColumnAndRow(5, $i, $book['Book_Instance']['purchase_date']);	
			$excel->getActiveSheet()->setCellValueByColumnAndRow(7, $i, $book['Book_Status']['status_name']);
			if($book['System_Take_Stock']['id'] == null){
				$excel->getActiveSheet()->setCellValueByColumnAndRow(8, $i, '');
				$excel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, '');
			} else {
				$excel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, $book['System_Take_Stock']['update_date']);
				$excel->getActiveSheet()->setCellValueByColumnAndRow(8, $i, '已盤點');
			}
			
		}
		$objWriter = new PHPExcel_Writer_Excel5($excel);
		$objWriter->save($file);
		return $r;
	}
	
}
?>