<?php
App::uses('Shell', 'Console');
App::uses('CakeEmail', 'Network/Email');

class NotificationShell extends Shell {
    public function send() {
        $Email = new CakeEmail();
		$Email->config('gmail');
		$Email->template('notification', 'default1');
		$Email->emailFormat('html');
		$Email->from(array('columbiaenglish1@gmail.com' => 'Columbia English Libary'));
		$Email->to('leokao.tw@gmail.com');
		$Email->subject('Columbia English Libary Notification');
		$Email->viewVars(array('user_name' => 'Leo','content_lines' => 'Test Cakephp Email!'));
		$Email->send();
    }
}
?>