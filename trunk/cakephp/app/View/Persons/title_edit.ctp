<h1>修改職務名稱</h1>
<?php
    echo $this->Form->create('Person_Title');
    echo $this->Form->input('title_name', array('label'=>'分類名稱'));
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('儲存');
?>