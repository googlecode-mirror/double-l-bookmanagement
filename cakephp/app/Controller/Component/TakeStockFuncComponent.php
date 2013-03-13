<?php
App::uses('Component', 'Controller');
class TakeStockFuncComponent extends Component {
	/*
	 *  新增盤點資料
	 *  回傳值 result['isOk'] : true 成功,  false失敗
	 *  	  result['returnMessag'] : 資料庫id  or 失敗 Message
	 */
	
	public function add_take_stock_operation($location_id, $version, $book_instance_id){
		$bookInstanceModel = 'Book_Instance';
		$takeStockModel = 'System_Take_Stock';
		
		// 檢查書籍是否存在
		$conditions = array(
				$bookInstanceModel . '.' . 'id' => $book_instance_id,
		);
		$count = ClassRegistry::init($bookInstanceModel)->find('count',
				array('conditions' => $conditions)
		);
		if($count == 0){
			$result['isOk'] = false;
			$result['message'] = $book_instance_id . "書籍資料不存在";
			return $result;
		}
		
		//檢查該書是否已經盤點過
		$conditions = array(
				$takeStockModel . '.' . 'version' => $version,
				$takeStockModel . '.' . 'location_id' => $location_id,
				$takeStockModel . '.' . 'book_instance_id' => $book_instance_id,
		);
		$count = ClassRegistry::init($takeStockModel)->find('count',
				array('conditions' => $conditions)
		);
		if($count > 1){
			$result['isOk'] = false;
			$result['message'] = "書籍已經盤點過";
			return $result;			
		}
		
		$take_stock['System_Take_Stock']['version'] = $version;
		$take_stock['System_Take_Stock']['location_id'] = $location_id;
		$take_stock['System_Take_Stock']['book_instance_id'] = $book_instance_id;
		
		$take_stock = ClassRegistry::init($takeStockModel)->save($take_stock);
		if($take_stock){
			$result['isOk'] = true;
			$result['message'] = $take_stock['System_Take_Stock']['id'];			
		} else {
			$result['isOk'] = false;
			$result['message'] = '存檔失敗';				
		}
		

		return $result;
	}
	
}