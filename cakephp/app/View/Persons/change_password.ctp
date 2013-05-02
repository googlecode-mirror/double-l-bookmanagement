<div class="pageheader_div"><h1 id="pageheader">變更密碼</h1></div>
<div class="pagemenu_div"><?php 
  	echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 
  	echo '&nbsp;';
?></div>  
<?php
    echo $this->Form->create('Person');
    echo $this->Form->input('password', array('label'=>'密碼'));
    echo $this->Form->input('password_confirm', array('label'=>'密碼確認','type' => 'password'));
    echo $this->Form->end('儲存');
?>