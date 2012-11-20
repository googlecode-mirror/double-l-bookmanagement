<h1>修改雜誌資料</h1>
<?php if ($book != null): ?>
	<?php echo $this->Form->create('Book_Instance'); ?>
	<?php echo $this->Form->input('book_id', array('type'=> 'hidden', 'value'=>$book['Book']['id']));?>
	<table>
		<tr>
			<td>雜誌名稱</td>
			<td><?php echo $book['Book']['book_name']; ?></td>
		</tr>
		<tr>
			<td>出版商</td>
			<td><?php echo $book['Book']['book_publisher']; ?></td>
		</tr>
		<tr>
			<td>書籍分類</td>
			<td><?php echo $book['Book_Cate']['catagory_name']; ?></td>
		</tr>
		<tr>
			<td>ISSN</td>
			<td><?php echo $book['Book']['isbn'];?></td>
		</tr>
		<tr>
			<td>刊期</td>
			<td><?php echo $book['Book']['book_version'];?></td>
		</tr>
		<tr>
			<td>創刊日期</td>
			<td><?php echo $book['Book']['publish_date'];?></td>
		</tr>
		<tr>
			<td>雜誌編號</td>
			<td><?php 
				echo $this->Form->input('id', array('div'=>false,'label'=>false,'type'=> 'text', 'readonly'=>true)); 
			?></td>
		</tr>
		<tr>
			<td>期別</td>
			<td><?php echo $this->Form->input('book_version', array('div'=>false,'label'=>false));?></td>
		</tr>
		<tr>
			<td>發行日期</td>
			<td><?php echo $this->Form->input('purchase_date', array('div'=>false,'label'=>false,'dateFormat' => 'DMY'));?></td>
		</tr>		
		<tr>
			<td>狀態</td>
			<td><?php echo $this->Form->input('book_status', array('div'=>false, 'label'=>false, 'options' => $book_status, 'notempty'=>true));?></td>
		</tr>
		<tr>
			<td>借閱等級</td>
			<td><?php echo $this->Form->input('person_level', array('div'=>false,'label'=>false, 'options' => $person_levels, 'notempty'=>true));?></td>
		</tr>
		<tr>
			<td>可借閱?</td>
			<td><?php echo $this->Form->input('is_lend', array('div'=>false,'label'=>false, 'options' => $is_lends, 'notempty'=>true));?></td>
		</tr>	
		<tr>
			<td cols=2><?php echo $this->Form->submit('儲存');?></td>
		</tr>
	</table>
	<?php echo $this->Form->end(); ?>
<?php else: ?>
	<?php echo '<div style="color:red;">'.$error_msg.'</div>'; ?>
<?php endif; ?>