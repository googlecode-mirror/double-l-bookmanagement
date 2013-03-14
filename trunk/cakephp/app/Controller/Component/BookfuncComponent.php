<?php
App::uses('Component', 'Controller');
class BookfuncComponent extends Component {

	/*
	 * 20130307 修改為 分校代碼+兩碼級別編號+四碼流水序號+”-”+書量(本數)
	 * 級別部分 : 100 = 01, 200=02 , 1000 = 10
	 * 20130313 改回 分校+五馬書籍號碼+"-"+書量(本數)
	 */
	public function create_book_instance_id($location_id,$book_id, $cat_id){
		$bookInstanceModel = 'Book_Instance';
		$conditions = array(
				$bookInstanceModel . '.' . 'location_id' => $location_id,
				$bookInstanceModel . '.' . 'book_id' => $book_id,
		);
		$count = ClassRegistry::init($bookInstanceModel)->find('count',
				array('conditions' => $conditions)
			);
		$id = sprintf('%1$s%2$05d-%3$02d', $location_id,$book_id,$count+1);
		return $id;	
	}
	
	public function curl_post_async($url){
		/*
		foreach ($params as $key => &$val) {
			if (is_array($val)) $val = implode(',', $val);
			$post_params[] = $key.'='.urlencode($val);
		}
		$post_string = implode('&', $post_params);
		*/
		$parts=parse_url($url);
	
		$fp = fsockopen($parts['host'],
				isset($parts['port'])?$parts['port']:80,
				$errno, $errstr, 30);
	
		$out = "GET ".$parts['path']." HTTP/1.1\r\n";
		$out.= "Host: ".$parts['host']."\r\n";
		$out.= "Content-Type: application/x-www-form-urlencoded\r\n";
		//$out.= "Content-Length: ".strlen($post_string)."\r\n";
		$out.= "Connection: Close\r\n\r\n";
		if (isset($post_string)) $out.= $post_string;
	
		fwrite($fp, $out);
		fclose($fp);
	}
	/*
	 *  書籍入庫
	*   回傳值 result['isOk'] : true 成功,  false失敗
	*  	  result['returnMessag'] : 資料庫id  or 失敗 Message
	*/
	public function receive_book_instnace($book_instance_id){
		$bookInstanceModel = 'Book_Instance';
		// 檢查書籍是否存在
		$conditions = array(
				$bookInstanceModel . '.' . 'id' => $book_instance_id,
		);
		$book_instance = ClassRegistry::init($bookInstanceModel)->find('first',
				array('conditions' => $conditions)
		);
		if($book_instance == null){
			$result['isOk'] = false;
			$result['message'] = $book_instance_id . "書籍資料不存在";
			return $result;
		}
		if($book_instance['Book_Instance']['book_status'] !== '0'){
			$result['isOk'] = false;
			$result['message'] = $book_instance_id . "書籍已入庫";
			return $result;			
		}
		$book_instance['Book_Instance']['book_status'] = '1';
		if(!ClassRegistry::init($bookInstanceModel)->save($book_instance)){
			$result['isOk'] = false;
			$result['message'] = $book_instance_id . "更新失敗";
			return $result;
		}
		$result['isOk'] = true;
		$result['message'] = $book_instance_id . "入庫成功";
		return $result;
	}
	
}
?>