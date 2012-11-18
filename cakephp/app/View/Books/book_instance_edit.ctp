<h1>修改書籍資料</h1>
<?php if ($book != null): ?>
	<?php echo $this->Form->create('Book_Instance'); ?>
	<?php echo $this->Form->input('book_id', array('type'=> 'hidden', 'value'=>$book['Book']['id']));?>
	<table>
		<tr>
			<td>書籍名稱</td>
			<td><?php echo $book['Book']['book_name']; ?></td>
		</tr>
		<tr>
			<td>作者</td>
			<td><?php echo $book['Book']['book_author']; ?></td>
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
			<td>出版日期</td>
			<td><?php echo $book['Book']['publish_date']; ?></td>
		</tr>
		<tr>
			<td>ISBN</td>
			<td><?php echo $book['Book']['isbn'];?></td>
		</tr>
		<tr>
			<td>版別</td>
			<td><?php echo $book['Book']['book_version'];?></td>
		</tr>
		<tr>
			<td>索書號</td>
			<td><?php echo $book['Book']['book_search_code'];?></td>
		</tr>
		<tr>
			<td>櫃別</td>
			<td><?php echo $book['Book']['book_location'];?></td>
		</tr>
		<tr>
			<td>出版日期</td>
			<td><?php echo $book['Book']['publish_date'];?></td>
		</tr>
		<tr>
			<td>書籍編號</td>
			<td><?php 
				$is_readonly = true;
				if($this->request->data["Book_Instance"]["id"] == null)
					$is_readonly=false;
				echo $this->Form->input('id', array('div'=>false,'label'=>false,'type'=> 'text', 'readonly'=>$is_readonly)); 
			?></td>
		</tr>
		<tr>
			<td>購買金額</td>
			<td><?php echo $this->Form->input('purchase_price', array('div'=>false,'label'=>false));?></td>
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
			<td>購入日期</td>
			<td><?php echo $this->Form->input('purchase_date', array('div'=>false,'label'=>false,'dateFormat' => 'DMY'));?></td>
		</tr>
		<tr>
			<td cols=2><?php echo $this->Form->submit('儲存');?></td>
		</tr>
	</table>
	<?php echo $this->Form->end(); ?>
<?php else: ?>
	<?php echo '<div style="color:red;">'.$error_msg.'</div>'; ?>
<?php endif; ?>