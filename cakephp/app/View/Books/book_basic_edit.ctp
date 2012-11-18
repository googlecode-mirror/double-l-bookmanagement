<h1>修改書籍基本資料</h1>
<?php
    echo $this->Form->create('Book_Basic');
	echo $this->Form->input('id', array('type'=> 'hidden'));
    echo $this->Form->input('book_type', array('label'=>'書籍名稱', 'options' => array(0=>'書', 1=> '期刊')));
    echo $this->Form->input('book_name', array('label'=>'書籍名稱'));
    echo $this->Form->input('book_author', array('label'=>'作者'));
    echo $this->Form->input('book_publisher_id', array('label'=>'出版商', 'options' => $publishers));
    echo $this->Form->input('cate_id', array('label'=>'書籍分類'));
    echo $this->Form->input('publish_date', array('label'=>'出版日期','dateFormat' => 'YMD'));
    echo $this->Form->end('儲存');
?>