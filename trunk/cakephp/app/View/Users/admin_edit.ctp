<div class="pageheader_div"><h1 id="pageheader">管理者修改</h1></div>
<div class="pagemenu_div"><?php 
  	echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 
?></div>
<?php
    echo $this->Form->create('User');
    echo $this->Form->input('id', array('type'=> 'hidden'));
	if ($this->request->data["User"]["id"] == null) {
		echo $this->Form->input('username', array('type'=> 'text','label'=>'管理者代號'));
	}
	else {
		echo $this->Form->input('username', array('type'=> 'text','label'=>'管理者代號(不可變更)', 'readonly'=>true));
	}
    echo $this->Form->input('name', array('label'=>'名稱'));
    echo $this->Form->input('password', array('label'=>'密碼'));
    echo $this->Form->input('role', array('label'=>'角色'));
    echo $this->Form->input('location_id', array('label'=>'分校'));
    echo $this->Form->end('儲存');
?>
