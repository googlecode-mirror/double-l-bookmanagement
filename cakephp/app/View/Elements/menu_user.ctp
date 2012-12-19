<ul id="menu">
	<li><a href="#">借閱與查詢</a>
		<ul>
		<li><?php echo $this->Html->link('借閱者狀況',array('controller'=>'lend', 'action'=>'user_status')); ?></li>	
		<li><?php echo $this->Html->link('學員個人借閱資料統計',array('controller'=>'reports', 'action'=>'user_personal_static')); ?></li>	
		</ul>
	</li>
</ul>