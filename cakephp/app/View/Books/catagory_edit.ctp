<h1>修改書籍分類</h1>
<?php
    echo $this->Form->create('Book_Cate');
    echo $this->Form->input('catagory_name', array('label'=>'分類名稱'));
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('儲存');
?>