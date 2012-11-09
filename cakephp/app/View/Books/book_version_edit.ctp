<h1>修改書籍版本資料</h1>
<?php if ($basic_id != null): ?> 
	<?php echo $this->Form->create('Book_Version'); ?>
	<table>
		<tr>
			<td>書籍名稱</td>
			<td>
				<?php echo $book_basic['Book_Basic']['book_name']; ?>
			</td>
		</tr>
		<tr>
			<td>作者</td>
			<td>
				<?php echo $book_basic['Book_Basic']['book_author']; ?>
			</td>
		</tr>
		<tr>
			<td>出版商</td>
			<td>
				<?php echo $book_basic['Book_Publisher']['comp_name']; ?>
			</td>
		</tr>
		<tr>
			<td>書籍分類</td>
			<td>
				<?php echo $book_basic['Book_Cate']['catagory_name']; ?>
			</td>
		</tr>
		<tr>
			<td>出版日期</td>
			<td>
				<?php echo $book_basic['Book_Basic']['publish_date']; ?>
			</td>
		</tr>
		<tr>
			<td>ISBN</td>
			<td>
				<?php echo $this->Form->input('id', array('type'=> 'hidden'));?>
				<?php echo $this->Form->input('basic_id', array('type'=> 'hidden', 'value' => $basic_id));?>
				<?php echo $this->Form->input('isbn', array('label'=>false));?>
			</td>
		</tr>
		<tr>
			<td>版別</td>
			<td><?php echo $this->Form->input('book_version', array('label'=>false));?></td>
		</tr>
		<tr>
			<td>索書號</td>
			<td><?php echo $this->Form->input('book_search_code', array('label'=>false));?></td>
		</tr>
		<tr>
			<td>櫃別</td>
			<td><?php echo $this->Form->input('book_location', array('label'=>false));?></td>
		</tr>
		<tr>
			<td>出版日期</td>
			<td><?php echo $this->Form->input('publish_date', array('label'=>false,'dateFormat' => 'DMY'));?></td>
		</tr>
		<tr>
			<td cols=2><?php echo $this->Form->submit('儲存');?></td>
		</tr>
	</table>
	<?php echo $this->Form->end(); ?>
<?php else: ?>
	<?php echo '<div style="color:red;">'.$error_msg.'</div>'; ?>
<?php endif; ?>