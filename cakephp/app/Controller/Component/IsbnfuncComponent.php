<?php
App::uses('Component', 'Controller');
App::uses('HttpSocket', 'Network/Http');
class IsbnfuncComponent extends Component {

	public function catdata($html, $start_s, $end_s){
		$start_index = strpos($html, $start_s);
		if($start_index == false) return "Miss Start.";
		$end_index = stripos($html, $end_s, $start_index);
		if($end_index == false) return "Miss End.";
		return substr($html, $start_index, $end_index + strlen($end_s) - $start_index);
	}

	public function trimdata($html, $start_s, $end_s){
		$start_index = stripos($html, $start_s);
		if($start_index == null) return "Miss Start.";
		$end_index = stripos($html, $end_s, $start_index);
		if($end_index == null) return "Miss End.";
		$start_index = $start_index + strlen($start_s);
		$slen = $end_index - $start_index;
		return substr($html,$start_index,$slen );
	}
	public function cutdata($html, $start_s){
		$start_index = strpos($html, $start_s);
		if($start_index == null) return $html;
		return substr($html, $start_index+strlen($start_s));
	}

	public function amazon_search($isbn){
		$HttpSocket = new HttpSocket();
		$url = 'http://www.amazon.com/gp/search-inside/service-data';		
		$query = 'asin='.$isbn.'&method=getBookData';
		$response = $HttpSocket->post($url,$query);
		return json_decode($response->body);
	}
	
	public function isbndb_search($isbn){
		$HttpSocket = new HttpSocket();
		$url = 'http://isbndb.com/search-all.html?kw='.$isbn.'&x=10&y=13';
		$response = $HttpSocket->get($url, array(), array('redirect' => true));
		if(!$response->isOk()) return false;
		return $this->isbndb_bookinfo($response->body);
	
	}
	public function isbndb_bookinfo($html){
		$r = null;
		$tmphtml = $this->catdata($html, '<DIV CLASS="bookInfo">','</div>');
		// bookname
		$bookname = $this->trimdata($tmphtml,'<h1>','</h1>');
		$tmphtml = $this->cutdata($tmphtml,'</h1>');
		$r['bookname'] = trim($bookname);
		
		// author
		$tmpa = $this->trimdata($tmphtml,'>','Publisher:');
		$author = strip_tags($tmpa);
		$tmphtml = $this->cutdata($tmphtml,'<br>');
		$r['author'] = trim(trim($author), ',');
		// publisher
		$tmpp = $this->trimdata($tmphtml,'Publisher:','<br>');
		$publisher = strip_tags($tmpp);
		$tmphtml = $this->cutdata($tmphtml,'<br>');
		$r['publisher'] = trim($publisher);
		// publish date
		$tmpd = $this->trimdata($tmphtml,'; ','</span>');
		$r['date'] = trim($tmpd);
		if(!$this->checkDateFormat($r['date'])) $r['date'] = '';
		return $r;
	
	}
	


	function checkDateFormat($date)
	{
		//match the format of the date
		if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts))
		{
			//check weather the date is valid of not
			if(checkdate($parts[2],$parts[3],$parts[1]))
		  return true;
			else
				return false;
		}
		else
			return false;
	}
	
}
?>