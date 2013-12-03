<?php
class LibShell extends AppShell {
    public $uses = array('Lend_Record', 'Book_Instance');
	public $tasks = array('EmailUtil');
	public $debug = false;
	
	function main() {
		$this->out('Hello world.');

	}
	
	function send_overdue_mail() {
		$this->out('Overdue Batch Send Mail.'.date('Y-m-d H:i:s'));
		$overdues = $this->Lend_Record->find('all', array('conditions'=>array("Lend_Record.status in ('C', 'E')", 'Lend_Record.s_return_date < substring(CURRENT_TIMESTAMP,1,10)', 'Lend_Record.s_return_date >= DATE_SUB(CURDATE(),INTERVAL 4 DAY)'),
		                                                  'order' => array('Lend_Record.person_id')));
		$strPerson = '';
		$strPersonName = '';
		$intBook = 0;
		$body = '';
		$tbl_body = '';
		$this->out('Overdue batch!'.sizeof($overdues));
		$this->log('Overdue batch!'.sizeof($overdues), 'debug');
		foreach($overdues as $overdue) {
			if ($strPerson != $overdue['Person']['id']) {
				if ($strPerson != '') {
					$body = '<html><head></head><body>
					<p>親愛的家長您好：提醒您，'.$strPersonName.'有'.$intBook.'本哥大圖書，已逾期未歸還。<p></p>請協助提醒孩子儘快歸還，讓學生可以一起維護圖書館的完整並養成多多閱讀的好習慣。</p>
					<p><table border="1"><th>書籍代號</th><th>書籍名稱</th><th>應還日期</th><th>借閱分校</th>';
					$body = $body.$tbl_body.'</table></p>';
					$body = $body.'<p>哥大英語，感謝您的配合。</p></body></html>';
					$this->EmailUtil->html_body = $body;
					if (sizeof($this->EmailUtil->to) > 0) {
						$ret = $this->EmailUtil->send();
						$this->out($strPerson.' overdue send out!'.$ret);
						$this->log($strPerson.' overdue send out!'.$ret, 'debug');
					}
					$tbl_body = '';
				}
				$strPerson = $overdue['Person']['id'];
				$this->EmailUtil->subject = '哥大圖書書籍逾期通知!';
				if ($this->debug) {
					$this->EmailUtil->to = array(0=>array('email'=>'leokao.tw@gmail.com', 'name'=>'leo.kao'));
				}
				else {
					if ($overdue['Person']['email'] <> '') {
						$this->EmailUtil->to = array(0=>array('email'=>$overdue['Person']['email'], 'name'=>$overdue['Person']['name']));
					}
				}
				$strPersonName = $overdue['Person']['name'];
				$intBook = 0;
				$this->out($overdue['Person']['name']."_".$overdue['Person']['email']);
				$this->log($overdue['Person']['name']."_".$overdue['Person']['email'], 'debug');
			}
			$tbl_body = $tbl_body.'<tr>'.
						  '<td>'.$overdue['Book_Instance']['id'].'</td>'.
						  '<td>'.$overdue['Book']['book_name'].'</td>'.
						  '<td>'.$overdue['Lend_Record']['s_return_date'].'</td>'.
						  '<td>'.$overdue['System_Location']['location_name'].'</td>'.
						  '</tr>';
			$intBook++;
		}
		if ($strPerson != '') {
			$body = '<html><head></head><body>
			<p>親愛的家長您好：提醒您，'.$strPersonName.'有'.$intBook.'本哥大圖書，已逾期未歸還。<p></p>請協助提醒孩子儘快歸還，讓學生可以一起維護圖書館的完整並養成多多閱讀的好習慣。</p>
			<p><table border="1"><th>書籍代號</th><th>書籍名稱</th><th>應還日期</th><th>借閱分校</th>';
			$body = $body.$tbl_body.'</table></p>';
			$body = $body.'<p>哥大英語，感謝您的配合。</p></body></html>';
			$this->EmailUtil->html_body = $body;
			if (sizeof($this->EmailUtil->to) > 0) {
				$ret = $this->EmailUtil->send();
				$this->out($strPerson.' overdue send out!'.$ret);
				$this->log($strPerson.' overdue send out!'.$ret, 'debug');
			}
		}
	}
}
?>