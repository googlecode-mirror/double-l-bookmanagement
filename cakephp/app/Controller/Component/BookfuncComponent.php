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
	
}
?>