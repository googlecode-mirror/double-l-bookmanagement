<h1>修改借閱者等級權限</h1>
<?php
    echo $this->Form->create('Person_Level');
    echo $this->Form->input('level_name', array('label'=>'等級權限名稱'));
    echo $this->Form->input('max_day', array('label'=>'借閱天數'));
    echo $this->Form->input('max_book', array('label'=>'借閱數量'));
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('儲存');
?>