<ul id="menu">
	<li ><a href="#">借閱與查詢</a>
		<ul>
		<li ><?php echo $this->Html->link('借閱者狀況',array('controller'=>'lend', 'action'=>'user_status')); ?></li>	
		<li ><?php echo $this->Html->link('個人借閱資料',array('controller'=>'reports', 'action'=>'user_person_status')); ?></li>	
		<li ><?php echo $this->Html->link('變更密碼',array('controller'=>'persons', 'action'=>'change_password')); ?></li>			
		<li ><?php echo $this->Html->link('書籍基本資料查詢',array('controller'=>'books', 'action'=>'book_index')); ?></li>
		</ul>
	</li>
</ul>