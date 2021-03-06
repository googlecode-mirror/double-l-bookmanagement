 <script>
    $(function() {
        $(".jquery_date" ).datepicker({dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true});
    });
</script>
<div id="pageheader">
<h1>修改書籍資料</h1>
</div>
<?php if ($book != null): ?>
	<?php echo $this->Form->create('Book_Instance',array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); ?>
	<?php echo $this->Form->input('book_id', array('type'=> 'hidden', 'value'=>$book['Book']['id']));?>
<table><tr>
<td>
	<table>
		<tr>
			<td style='width:80px'>書籍名稱</td>
			<td><?php echo $book['Book']['book_name']; ?></td>
		</tr>
		<tr>
			<td style='width:80px'>作者</td>
			<td><?php echo $book['Book']['book_author']; ?></td>
		</tr>
		<tr>
			<td style='width:80px'>出版商</td>
			<td><?php echo $book['Book']['book_publisher']; ?></td>
		</tr>
		<tr>
			<td style='width:80px'>書籍分類</td>
			<td><?php echo $book['Book_Cate']['catagory_name']; ?></td>
		</tr>
		<tr>
			<td style='width:80px'>出版日期</td>
			<td><?php echo $book['Book']['publish_date']; ?></td>
		</tr>
		<tr>
			<td style='width:80px'>ISBN</td>
			<td><?php echo $book['Book']['isbn'];?></td>
		</tr>
		<tr>
			<td style='width:80px'>版別</td>
			<td><?php echo $book['Book']['book_version'];?></td>
		</tr>
		<tr>
			<td style='width:80px'>索書號</td>
			<td><?php echo $book['Book']['book_search_code'];?></td>
		</tr>
		<tr>
			<td style='width:80px'>櫃別</td>
			<td><?php echo $book['Book']['book_location'];?></td>
		</tr>
		<tr>
			<td style='width:80px'>出版日期</td>
			<td><?php echo $book['Book']['publish_date'];?></td>
		</tr>
	</table>	
</td>		
<td>
	<table>
		<tr>
			<td style='width:80px'>書籍編號</td>
			<td><?php echo $this->Form->input('id', array('type'=> 'text', 'readonly'=>true)); ?></td>
		</tr>
		<tr>
			<td style='width:80px'>分校</td>
			<td><?php echo $this->Form->input('location_id', array( 'options' => $system_locations, 'notempty'=>true));?></td>
		</tr>
		<tr>
			<td style='width:80px'>購買金額</td>
			<td><?php echo $this->Form->input('purchase_price');?></td>
		</tr>
		<tr>			
			<td style='width:80px'>狀態</td>
			<td><?php
					echo $this->Form->input('book_status', array( 'options' => $book_status, 'notempty'=>true));
				?>
			</td>
		</tr>
		<tr>
			<td style='width:80px'>借閱等級</td>
			<td><?php echo $this->Form->input('level_id', array('options' => $person_levels, 'notempty'=>true));?></td>
		</tr>
		<tr>
			<td style='width:80px'>可借閱?</td>
			<td><?php echo $this->Form->input('is_lend', array('options' => $is_lends, 'notempty'=>true)); ?></td>
		</tr>	
		<tr>
			<td style='width:80px'>購入日期</td>	
			<td><?php echo $this->Form->text('purchase_date', array('readonly'=>true, 'class' => 'ref_field, jquery_date', 'style'=>'width:120px'));?></td>
		</tr>
		<tr>
			<td cols=2><?php echo $this->Form->submit('儲存');?></td>
		</tr>
	</table>
</td>	
</tr></table>	
	<?php echo $this->Form->end(); ?>
<?php else: ?>
	<?php echo '<div style="color:red;">'.$error_msg.'</div>'; ?>
<?php endif; ?>

