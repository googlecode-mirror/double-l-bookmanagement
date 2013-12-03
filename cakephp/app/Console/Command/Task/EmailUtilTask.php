<?php  
/** 郵件
 * This is a component to send email from CakePHP using PHPMailer 
 * @link http://bakery.cakephp.org/articles/view/94 
 * @see http://bakery.cakephp.org/articles/view/94 
 */ 

App::import('Vendor', 'PHPMailer', array('file' => 'phpmailer' . DS . 'class.phpmailer.php'));
class EmailUtilTask extends Shell {    
    
	//Send email using SMTP Auth by default. 
    var $from         	= 'columbiaenglish.tw@gmail.com'; 
    var $fromName     	= "哥大圖書自動警示系統"; 
	/*
    var $UserName 		= 'columbiaenglish.tw@gmail.com';  // SMTP username 
    var $Password		= '1qazse432w'; // SMTP password 
	var $SMTPAuth 		= true;
	var $SMTPSecure 	= "ssl"; // Gmail的SMTP主機需要使用SSL連線   
	var $Host 			= "smtp.gmail.com"; //Gamil的SMTP主機        
	var $Port 			= 465;  //Gamil的SMTP主機的SMTP埠位為465埠。        */
    var $UserName 		= ''; 
    var $Password		= ''; 
	var $SMTPAuth 		= false;
	var $SMTPSecure 	= "";
	var $Host 			= "192.168.0.206"; 
	var $Port 			= 25;  
	var $CharSet 		= "utf-8"; //設定郵件編碼     
    var $text_body 		= null; 
    var $html_body 		= null; 
    var $to 			= array(); 
    var $toName 		= null; 
    var $subject 		= "PHPMailer 測試信件"; //設定郵件標題   
    var $cc 			= array(); 
    var $bcc 			= array(); 
    var $template 		= 'email/default'; 
    var $attachments 	= null; 
	var $SMTPDebug		= false;

    function attach($filename, $asfile = '') { 
		if (empty($this->attachments)) { 
			$this->attachments = array(); 
			$this->attachments[0]['filename'] = $filename; 
			$this->attachments[0]['asfile'] = $asfile; 
		} 
		else { 
			$count = count($this->attachments); 
			$this->attachments[$count+1]['filename'] = $filename; 
			$this->attachments[$count+1]['asfile'] = $asfile; 
		} 
    } 


    function send() { 
		$mail = new PHPMailer(); 
		
		$mail->SMTPDebug = $this->SMTPDebug;
		$mail->IsSMTP();            // set mailer to use SMTP 
		$mail->SMTPAuth = $this->SMTPAuth; //設定SMTP需要驗證        
		$mail->SMTPSecure = $this->SMTPSecure; // Gmail的SMTP主機需要使用SSL連線   
		$mail->Host = $this->Host; //Gamil的SMTP主機        
		$mail->Port = $this->Port;  //Gamil的SMTP主機的SMTP埠位為465埠。        
		$mail->CharSet = $this->CharSet; //設定郵件編碼        
		$mail->Username = $this->UserName; 
		$mail->Password = $this->Password; 

		$mail->From     = $this->from; 
		$mail->FromName = $this->fromName; 
		foreach ($this->to as $to_address) {
			$mail->AddAddress($to_address['email'],$to_address['name']); 
		}
		foreach ($this->cc as $to_address) {
			$mail->AddCC($to_address['email'],$to_address['name']); 
		}
		foreach ($this->bcc as $to_address) {
			$mail->AddBCC($to_address['email'],$to_address['name']); 
		}
		$mail->AddReplyTo($this->from, $this->fromName ); 

		$mail->WordWrap = 50;  // set word wrap to 50 characters 

		if (!empty($this->attachments)) { 
		  foreach ($this->attachments as $attachment) { 
			if (empty($attachment['asfile'])) { 
			  $mail->AddAttachment($attachment['filename']); 
			} else { 
			  $mail->AddAttachment($attachment['filename'], $attachment['asfile']); 
			} 
		  } 
		} 

		$mail->IsHTML(true);  // set email format to HTML 

		$mail->Subject = $this->subject; 
		$mail->Body = $this->html_body; //設定郵件內容     

		$result = $mail->Send(); 
		if($result === false ) { 
			$result = $mail->ErrorInfo; 
		}
		return $result; 
    } 
} 
?>