<h1>修改借閱者群組</h1>
<?php
    echo $this->Form->create('Person_Group');
    echo $this->Form->input('group_name', array('label'=>'群組名稱'));
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('儲存');
?>