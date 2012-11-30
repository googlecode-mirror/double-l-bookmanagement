<ul>
	<li><?php echo $this->Html->link('書籍借閱作業',array('controller'=>'lend', 'action'=>'lend_operation')); ?></li>
	<li><?php echo $this->Html->link('書籍歸還作業',array('controller'=>'lend', 'action'=>'return_operation')); ?></li>
	<li><?php echo $this->Html->link('書籍借閱紀錄',array('controller'=>'lend', 'action'=>'index')); ?></li>
	<li><?php echo $this->Html->link('書籍分類資料',array('controller'=>'books', 'action'=>'catagory_index')); ?></li>
	<li><?php echo $this->Html->link('書籍出版商資料',array('controller'=>'books', 'action'=>'publisher_index')); ?></li>
	<li><?php echo $this->Html->link('書籍基本資料',array('controller'=>'books', 'action'=>'book_index')); ?></li>
	<li><?php echo $this->Html->link('雜誌基本資料',array('controller'=>'books', 'action'=>'journal_index')); ?></li>
	<li><?php echo $this->Html->link('借閱者基本資料',array('controller'=>'persons', 'action'=>'person_index')); ?></li>
	<li><?php echo $this->Html->link('借閱者等級權限資料',array('controller'=>'persons', 'action'=>'level_index')); ?></li>
	<li><?php echo $this->Html->link('借閱者群組資料',array('controller'=>'persons', 'action'=>'group_index')); ?></li>
	<li><?php echo $this->Html->link('人員職務名稱',array('controller'=>'persons', 'action'=>'title_index')); ?></li>
	<li><?php echo $this->Html->link('地點基本資料',array('controller'=>'system', 'action'=>'location_index')); ?></li>
</ul>