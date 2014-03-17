<?php
App::uses('Component', 'Controller');
class ReportfuncComponent extends Component {
	public $components = array('Session');
	
	public function getBookStatReport($cate, $start_date, $end_date, $page=null){
		$model = ClassRegistry::init('Lend_Record');
		$page_size = 20;
		$report_conut_SQL = "SELECT count( * ) AS cnt from ( select count( * ) ";
		$report_item_SQL = "SELECT books.id,  `book_name` , `book_author` , `book_publisher` , `cate_id` , `isbn` , `book_search_code` , `book_location` , `book_attachment` , `book_image` , `publish_date` , `order_start_date` , `order_end_date` , `order_start_version` , `order_end_version` , `memo` , count( * ) AS cnt, books.book_version, location_id, location_name  ";
		$report_group_SQL = " GROUP BY books.id, `book_type` , `book_name` , `book_author` , `book_publisher` , `cate_id` , `isbn` , `book_search_code` , `book_location` , `book_attachment` , `book_image` , `publish_date` , `order_start_date` , `order_end_date` , `order_start_version` , `order_end_version` , `memo`, books.book_version, location_id, location_name ";
		$report_group_end = ") as x;";
		$strsql = " FROM `lend_records`, books, system_locations
				   WHERE lend_records.status <> 'L'
					 and lend_records.status <> 'R'
					 and lend_records.status <> 'S'
					 and books.id = lend_records.book_id
					 and location_id = system_locations.id ";
		if (($page != null) && (trim($page) != ''))  {
			$page = trim($page);
		} else {
			$page = -1;
		}		
		//依據條件篩選
		$filter_str = '';	
		if (($cate != null) && (trim($cate) != ''))  {
			$filter_str = $filter_str." and cate_id = '".mysql_real_escape_string($cate)."' ";
		}
		if (($start_date != null) && (trim($start_date) != ''))  {
			$filter_str = $filter_str." and substring(lend_time,1,10) >= '".mysql_real_escape_string($start_date)."' ";
		}
		if (($end_date != null) && (trim($end_date) != ''))  {
			$filter_str = $filter_str." and lend_time <= '".mysql_real_escape_string($end_date)."' ";
		}
		if (trim($filter_str) == '') {
			$filter_str = " and  1=2 ";
		}	
		if (trim($filter_str) != '') {
			$strsql = $strsql.$filter_str;
		}
		
		$books_cnt = $model->query($report_conut_SQL.$strsql.$report_group_SQL.$report_group_end);
		if($page == -1){
			$books = $model->query($report_item_SQL.$strsql.$report_group_SQL);
		} else {
			$books = $model->query($report_item_SQL.$strsql.$report_group_SQL." LIMIT ".($page-1)*$page_size." , ".$page_size.";");
		}
		
		$result['book_cnt'] = $books_cnt[0][0]['cnt'];
		$result['books'] = $books;
		return $result;
	}
	
	public function buildBookStatReportExcel($books){
		App::import("Vendor", "phpexcel/PHPExcel");
		App::import("Vendor", "phpexcel/PHPExcel/Writer/Excel5");
		 
		$r['path'] = TMP.'tests'.DS;
		$r['file'] = 'tmp_books_stat_'. $this->Session->read('user_id');
		$file =  $r['path'].$r['file'];
		$excel = new PHPExcel();
		$excel->setActiveSheetIndex(0);
		$excel->getActiveSheet()->setTitle('Books');
		$excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, '書籍名稱');
		$excel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, '作者');		
		$excel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, 'ISBN');
		$excel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, '索書號');
		$excel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, '出借分校');
		$excel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, '出借次數');
		$i = 1;		
		foreach($books as $book){
			$i++;
			$excel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, $book['books']['book_name']);
			$excel->getActiveSheet()->setCellValueByColumnAndRow(1, $i, $book['books']['book_author']);			
			$excel->getActiveSheet()->setCellValueExplicitByColumnAndRow(2, $i,$book['books']['isbn'],PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValueExplicitByColumnAndRow(3, $i,$book['books']['book_search_code'],PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, $book['system_locations']['location_name']);	
			$excel->getActiveSheet()->setCellValueByColumnAndRow(5, $i, $book[0]['cnt']);
			
		}
		$objWriter = new PHPExcel_Writer_Excel5($excel);
		$objWriter->save($file);
		return $r;
	}
	
}
?>