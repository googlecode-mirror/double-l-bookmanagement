	<ul id="menu">
	<li ><a href="#">借閱與歸還</a>
		<ul>
		<li ><?php echo $this->Html->link('借書作業',array('controller'=>'lend', 'action'=>'lend_operation')); ?></li>		
		<li ><?php echo $this->Html->link('還書作業',array('controller'=>'lend', 'action'=>'return_operation')); ?></li>	
		<li ><?php echo $this->Html->link('在庫查詢',array('controller'=>'books', 'action'=>'book_search')); ?></li>
		<li ><?php echo $this->Html->link('學員借閱資料',array('controller'=>'reports', 'action'=>'user_person_status')); ?></li>	
		<li ><?php echo $this->Html->link('到期書籍查詢',array('controller'=>'reports', 'action'=>'book_overdue_report')); ?></li>	
		</ul>
	</li>
	<li ><a href="#">書籍基本資料</a>
		<ul>
			<li ><?php echo $this->Html->link('書籍基本資料查詢',array('controller'=>'books', 'action'=>'book_index')); ?></li>
		</ul>
	</li>	


</ul>