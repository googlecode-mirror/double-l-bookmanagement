<?php
class LibShell extends AppShell {
    public $uses = array('Lend_Record', 'Book_Instance');
	public $tasks = array('EmailUtil');
	
	function main() {
		$this->out('Hello world.');

	}
	
	function send_overdue_mail() {
		$this->out('Overdue Batch Send Mail.'.date('Y-m-d H:i:s'));
		$overdues = $this->Lend_Record->find('all', array('conditions'=>array("Lend_Record.status in ('C', 'E')", 'Lend_Record.s_return_date < substring(CURRENT_TIMESTAMP,1,10)')));
		$strPerson = '';
		$body = '';
		foreach($overdues as $overdue) {
			if ($strPerson != $overdue['Person']['id']) {
				if ($strPerson != '') {
					$body = $body.'</table></body></html>';
					$this->EmailUtil->html_body = $body;
					$ret = $this->EmailUtil->send();
					$this->out($strPerson.' overdue send out!'.$ret."\n");
				}
				$strPerson = $overdue['Person']['id'];
				$this->EmailUtil->subject = '書籍逾期通知!';
				$this->EmailUtil->to = array(0=>array('email'=>$overdue['Person']['email'], 'name'=>$overdue['Person']['name']));
				$body = '<html><head></head><body><table><th>書籍代號</th><th>書籍名稱</th><th>應還日期</th><th>借閱分校</th>';
			}
			$body = $body.'<tr>'.
						  '<td>'.$overdue['Book_Instance']['id'].'</td>'.
						  '<td>'.$overdue['Book']['book_name'].'</td>'.
						  '<td>'.$overdue['Lend_Record']['s_return_date'].'</td>'.
						  '<td>'.$overdue['System_Location']['location_name'].'</td>'.
						  '</tr>';
		}
		if ($strPerson != '') {
			$body = $body.'</table></body></html>';
			$this->EmailUtil->html_body = $body;
			$ret = $this->EmailUtil->send();
			$this->out($strPerson.' overdue send out!'.$ret."\n");
		}
	}
}
?>