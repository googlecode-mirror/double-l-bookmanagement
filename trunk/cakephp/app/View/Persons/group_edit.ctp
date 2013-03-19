<div class="pageheader_div"><h1 id="pageheader">修改借閱者群組</h1></div>
<div class="pagemenu_div"><?php 
  	echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 
  	echo '&nbsp;';
?></div>  
<?php
    echo $this->Form->create('Person_Group');
    echo $this->Form->input('group_name', array('label'=>'群組名稱'));
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('儲存');
?>