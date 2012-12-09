<h1>書籍出版商資料</h1>
<?php echo '<pre>'.$html_body.'</pre>'; ?>
<?php foreach($imgs as $img){
		echo $this->Html->image($img);
		echo '<br>';
	}
?>