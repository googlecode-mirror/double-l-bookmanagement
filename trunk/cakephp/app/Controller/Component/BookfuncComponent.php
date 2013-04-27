<?php
App::uses('Component', 'Controller');
class BookfuncComponent extends Component {
	public $components = array('Isbnfunc');

	/*
	 * 20130307 修改為 分校代碼+兩碼級別編號+四碼流水序號+”-”+書量(本數)
	 * 級別部分 : 100 = 01, 200=02 , 1000 = 10
	 * 20130313 改回 分校+五馬書籍號碼+"-"+書量(本數)
	 * 20130320 改回 0307 版本 , 外加 分校代碼+兩碼級別編號+五碼流水序號+”-”+書量(本數)
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
                if($cat_id==6666){
                	$id = sprintf('%1$s%2$s%3$05d-%4$02d', $location_id,"CH",$book_id,$count+1);
                } else if($cat_id==9999){
                	$id = sprintf('%1$s%2$s%3$05d-%4$02d', $location_id,"DV",$book_id,$count+1);
                } else {
                	$id = sprintf('%1$s%2$02d%3$05d-%4$02d', $location_id,$cat_id/100,$book_id,$count+1);
                }
                return $id;    
        }
        
    /*
     *  依據新的$cate_id 變更 book_instance.id 
     */
    public function change_book_instance_id($book_instance_id,$cate_id){
    	$cate_code = $this->get_cate_code($cate_id);
    	return substr_replace($book_instance_id,$cate_code, 1, 2);
    	//return substr($book_instance_id,0,1).$cate_code.substr($book_instance_id,3);
    }
	/*
	 *  $cate_id :
	 *  return book_instance.id 所需要的級數編碼 
	 */
	private function get_cate_code($cate_id){
		if($cate_id==0){
			return 'CH';
		} else {
			return sprintf('%1$02d',$cate_id/100);
		}
		
	}
	public function curl_post_async($url){
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
	
	/*
	 * 書本整批上傳
	 * $file = file path
	 */
	public function save_book_upload($file){
		$bookModel = ClassRegistry::init('Book');
		$ds = null;
		App::import("Vendor", "phpexcel/PHPExcel/IOFactory");
		
		$uploadfile = WWW_ROOT . 'img'.DS.'books' .DS. $file["name"];
		move_uploaded_file($file["tmp_name"],$uploadfile);
		$excel = PHPExcel_IOFactory::load($uploadfile);
		$sheetdata = $excel->getActiveSheet()->toArray(null,true,true,true);
		if( ($ss=count($sheetdata)) > 1 ) {
			for($i=2;$i<=$ss;$i++){
		
				$data['Book']['line'] = $i;
				$data['Book']['isbn'] = $sheetdata[$i]['A'];
				$data['Book']['book_name'] = $sheetdata[$i]['B'];
				$data['Book']['book_author'] = $sheetdata[$i]['C'];
				$data['Book']['book_publisher'] = $sheetdata[$i]['D'];
				$data['Book']['book_ad'] = $sheetdata[$i]['E'];
				$data['Book']['lexile_level'] = $sheetdata[$i]['F'];
				$data['Book']['book_suite'] = $sheetdata[$i]['G'];
				$data['Book']['publish_year'] = $sheetdata[$i]['H'];
		
				if($data['Book']['lexile_level']==9999){
					//if($data['Book']['isbn']==null || $data['Book']['isbn']=="" ) $data['Book']['isbn'] = " ";
				}else{
					$isbn = $this->Isbnfunc->checkIsbn($data['Book']['isbn']);
					if($isbn['isIsbn'] == false){
						$data['Book']['isSave']= $isbn['errorMsg'];
						$ds[$i] = $data;
						continue;
					}
					$book = $bookModel->find('first', array('conditions'=> array('Book.isbn'=> $isbn['isbn'])));
					if($book != null){
						$data['Book']['isSave']='書籍已存在';
						$ds[$i] = $data;
						continue;
					}
					$data['Book']['isbn'] = $isbn['isbn'];
				}

				 
				$data['Book']['book_type'] = 'B';
					
		
		
				$bookModel->create();
				if($bookModel->save($data)){
					$data['Book']['isSave'] = 'OK';
				} else {
					$data['Book']['isSave'] = '存檔失敗';
				}
		
				$ds[$i] = $data;
		
			}
		}
		unlink($uploadfile);
		return $ds;
	}
	/*
	 * 書本實體整批上傳
	* $file = file path
	* $pdata = 分校資料
	*/
	public  function save_book_instance_upload($file,$pdata){
		$bookModel = ClassRegistry::init('Book');
		$bookiModel = ClassRegistry::init('Book_Instance');
		$ds = null;
		App::import("Vendor", "phpexcel/PHPExcel/IOFactory");
		 
		$uploadfile = WWW_ROOT . 'img'.DS.'books' .DS. $file["name"];
		move_uploaded_file($file["tmp_name"],$uploadfile);
		$excel = PHPExcel_IOFactory::load($uploadfile);
		$sheetdata = $excel->getActiveSheet()->toArray(null,true,true,true);
		if( ($ss=count($sheetdata)) > 1 ) {
			for($i=2;$i<=$ss;$i++){
	
				$data['Book_Instance']['line'] = $i;
				$data['Book_Instance']['book_search_code'] = $sheetdata[$i]['A'];
				$data['Book_Instance']['purchase_price'] = $sheetdata[$i]['B'];
				$data['Book_Instance']['purchase_date'] = $sheetdata[$i]['C'];
				 
				$isbn = $sheetdata[$i]['A'];
				if( $isbn == ''){
					$data['Book_Instance']['isSave']= '索書碼不能為空.';
					$ds[$i] = $data;
					continue;
				}
				if($data['Book_Instance']['purchase_price'] == null || $data['Book_Instance']['purchase_price'] ==""){
					$data['Book_Instance']['isSave']='購買金額不能為空';
					$ds[$i] = $data;
					continue;
				}
				if($data['Book_Instance']['purchase_date'] == null || trim($data['Book_Instance']['purchase_date']) == ""){
					$data['Book_Instance']['isSave']='購買日期不能為空';
					$ds[$i] = $data;
					continue;
				}
				$book = $bookModel->find('first', array('conditions'=> array('Book.book_search_code'=> $isbn)));
				if($book == null){
					$data['Book_Instance']['isSave']='書籍不存在';
					$ds[$i] = $data;
					continue;
				}
	
	
				$data['Book_Instance']['book_id'] = $book['Book']['id'];
				$data['Book_Instance']['location_id'] = $pdata['location_id'];
				$data['Book_Instance']['book_status'] = $pdata['book_status'];
				$data['Book_Instance']['level_id'] = $pdata['level_id'];
				$data['Book_Instance']['is_lend'] = $pdata['is_lend'];
				$data['Book_Instance']['create_time'] = date('Y-m-d H:i:s');
				$data['Book_Instance']['id'] = $this->create_Book_Instance_id(
						$data['Book_Instance']['location_id'],
						$data['Book_Instance']['book_id'],
						$book['Book']['cate_id']);
				 
				$bookiModel->create();
				if($bookiModel->save($data)){
					$data['Book_Instance']['isSave'] = 'OK';
				} else {
					$data['Book_Instance']['isSave'] = '存檔失敗';
				}
	
				$ds[$i] = $data;
				 
			}
		}
		unlink($uploadfile);
		return $ds;
	}
	
	
	/*
	 * 更新書籍圖片
	* $file = 從網頁傳送過來的圖片
	* $isbn : isbn 碼
	* return $image_url or false
	*/	
	public function upload_book_image($file, $isbn){
		if($isbn==null || trim($isbn)=='') $isbn = time();
		$uploadfile = WWW_ROOT . 'img'.DS.'books' .DS. $isbn.'.png';
		move_uploaded_file($file["tmp_name"],$uploadfile);	
		
		return 'books/'.$isbn.'.png';
	}
}
?>