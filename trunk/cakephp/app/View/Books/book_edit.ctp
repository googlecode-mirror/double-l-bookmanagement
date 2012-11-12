<h1>修改書籍資料</h1>
<?php if ($version_id != null): ?> 
	<?php echo $this->Form->create('Book'); ?>
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
			<td><?php echo $book_version['Book_Version']['isbn'];?></td>
		</tr>
		<tr>
			<td>版別</td>
			<td><?php echo $book_version['Book_Version']['book_version'];?></td>
		</tr>
		<tr>
			<td>索書號</td>
			<td><?php echo $book_version['Book_Version']['book_search_code'];?></td>
		</tr>
		<tr>
			<td>櫃別</td>
			<td><?php echo $book_version['Book_Version']['book_location'];?></td>
		</tr>
		<tr>
			<td>出版日期</td>
			<td><?php echo $book_version['Book_Version']['publish_date'];?></td>
		</tr>
		<tr>
			<td>購買金額</td>
			<td>
				<?php echo $this->Form->input('id', array('type'=> 'hidden'));?>
				<?php echo $this->Form->input('version_id', array('type'=> 'hidden', 'value' => $version_id));?>
				<?php echo $this->Form->input('purchase_price', array('label'=>false));?>
			</td>
		</tr>
		<tr>
			<td>狀態</td>
			<td><?php echo $this->Form->input('book_status', array('label'=>false, 'options' => $book_status, 'notempty'=>true));?></td>
		</tr>
		<tr>
			<td>借閱等級</td>
			<td><?php echo $this->Form->input('person_level', array('label'=>false, 'options' => $person_levels, 'notempty'=>true));?></td>
		</tr>
		<tr>
			<td>購入日期</td>
			<td><?php echo $this->Form->input('purchase_date', array('label'=>false,'dateFormat' => 'DMY'));?></td>
		</tr>
		<tr>
			<td cols=2><?php echo $this->Form->submit('儲存');?></td>
		</tr>
	</table>
	<?php echo $this->Form->end(); ?>
<?php else: ?>
	<?php echo '<div style="color:red;">'.$error_msg.'</div>'; ?>
<?php endif; ?>