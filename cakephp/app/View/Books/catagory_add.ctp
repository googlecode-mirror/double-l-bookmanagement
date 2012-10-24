<h1>新增書籍分類</h1>
<?php
	echo $this->Form->create('Book_Cate');
	echo $this->Form->input('catagory_name', array('label'=>'分類名稱'));
	echo $this->Form->end('儲存');
?>
