<h1>修改書籍分類</h1>
<?php
    echo $this->Form->create('Book_Cate');
	if ($this->request->data["Book_Cate"]["id"] == null) {
		echo $this->Form->input('id', array('type'=> 'text','label'=>'分類代號'));
	}
	else {
		echo $this->Form->input('id', array('type'=> 'text','label'=>'分類代號(不可變更)', 'readonly'=>true));
	}
    echo $this->Form->input('catagory_name', array('label'=>'分類名稱'));
    echo $this->Form->end('儲存');
?>