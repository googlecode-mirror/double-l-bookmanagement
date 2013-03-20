<ul id="menu">
	<li class='suboff'><a href="#">借閱與歸還</a>
		<ul>
		<li class='suboff'><?php echo $this->Html->link('借書作業',array('controller'=>'lend', 'action'=>'lend_operation')); ?></li>		
		<li class='suboff'><?php echo $this->Html->link('還書作業',array('controller'=>'lend', 'action'=>'return_operation')); ?></li>	
		<li class='suboff'><?php echo $this->Html->link('書籍查詢',array('controller'=>'books', 'action'=>'book_search')); ?></li>
		<li class='suboff'><?php echo $this->Html->link('學員借閱資料',array('controller'=>'reports', 'action'=>'user_person_status')); ?></li>	
		</ul>
	</li>
	<li class='suboff'><a href="#">書籍基本資料維護</a>
		<ul>
			<li class='suboff'><?php echo $this->Html->link('書籍級別資料',array('controller'=>'books', 'action'=>'catagory_index')); ?></li>
			<li class='suboff'><?php echo $this->Html->link('書籍基本資料',array('controller'=>'books', 'action'=>'book_index')); ?></li>
			<li class='suboff'><?php echo $this->Html->link('書籍基本資料上傳',array('controller'=>'books', 'action'=>'book_info_upload')); ?></li>	
			<li class='suboff'><?php echo $this->Html->link('書籍上傳',array('controller'=>'books', 'action'=>'book_instance_upload')); ?></li>	
			<li class='suboff'><?php echo $this->Html->link('書籍入庫',array('controller'=>'books', 'action'=>'book_instance_receive')); ?></li>	
			<li class='suboff'><?php echo $this->Html->link('書籍標籤列印',array('controller'=>'prints', 'action'=>'book_list')); ?></li>
			<li class='suboff'><?php echo $this->Html->link('級數別書籍借閱統計',array('controller'=>'reports', 'action'=>'book_cate_stats')); ?></li>	
		</ul>
	</li>
	<li class='suboff'><a href="#">人員管理</a>
		<ul>
			<li class='suboff'><?php echo $this->Html->link('借閱者管理',array('controller'=>'persons', 'action'=>'person_index')); ?></li>	
			<li class='suboff'><?php echo $this->Html->link('借閱者上傳',array('controller'=>'persons', 'action'=>'person_upload')); ?></li>	
			<li class='suboff'><?php echo $this->Html->link('借閱者等級權限資料',array('controller'=>'persons', 'action'=>'level_index')); ?></li>
			<li class='suboff'><?php echo $this->Html->link('借閱者群組資料',array('controller'=>'persons', 'action'=>'group_index')); ?></li>
			<li class='suboff'><?php echo $this->Html->link('人員職務名稱',array('controller'=>'persons', 'action'=>'title_index')); ?></li>
			<li class='suboff'><?php echo $this->Html->link('借書證核發列印',array('controller'=>'prints', 'action'=>'person_list')); ?></li>
		</ul>
	</li>
	<li class='suboff'><a href="#">系統資料維護</a>
		<ul>
			<li class='suboff'><?php echo $this->Html->link('分校資料維護',array('controller'=>'system', 'action'=>'location_index')); ?></li>
			<li class='suboff'><?php echo $this->Html->link('盤點作業',array('controller'=>'system', 'action'=>'take_stock_index')); ?></li>
			<li class='suboff'><?php echo $this->Html->link('盤點清冊',array('controller'=>'reports', 'action'=>'book_inv_check')); ?></li>
			<li class='suboff'><?php echo $this->Html->link('管理者維護',array('controller'=>'users', 'action'=>'admin_index')); ?></li>
		</ul>
	</li>	

</ul>