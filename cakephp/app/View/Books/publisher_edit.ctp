<h1>修改書籍出版商</h1>
<?php
    echo $this->Form->create('Book_Publisher');
	if ($this->request->data["Book_Publisher"]["id"] == null) {
		echo $this->Form->input('id', array('type'=> 'text','label'=>'出版商代號'));
	}
	else {
		echo $this->Form->input('id', array('type'=> 'text','label'=>'出版商代號(不可變更)', 'readonly'=>true));
	}
    echo $this->Form->input('comp_name', array('label'=>'出版商名稱'));
    echo $this->Form->input('address', array('label'=>'地址'));
    echo $this->Form->input('phone', array('label'=>'電話'));
    echo $this->Form->input('fax', array('label'=>'傳真'));
    echo $this->Form->input('sales', array('label'=>'業務姓名'));
    echo $this->Form->input('mobile_phone', array('label'=>'行動電話'));
    echo $this->Form->input('memo', array('label'=>'備註'));
    echo $this->Form->end('儲存');
?>