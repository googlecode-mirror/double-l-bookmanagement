 <script>
    $(function() {
        $(".jquery_date" ).datepicker({dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true});
    });
</script>
<div id="pageheader">
<h1>書籍上傳  <?php echo $this->Html->link('範例檔', '../files/Book_Instances_Upload.xls',  array('class' => 'button')); ?></h1>
</div>

<?php echo $this->Form->create('Book_Instance',array('enctype' => 'multipart/form-data', 
													 'div'=>false, 
													 'inputDefaults' => array('label' => false,'div' => false))); ?>
	<table>
		<tr>
			<td style='width:80px'>上傳檔案</td>
			<td><?php echo $this->Form->input('Upload.file', array(
    				'between' => '',
    				'type' => 'file'
			)); ?></td>
		</tr>
		<tr>
			<td style='width:80px'>分校</td>
			<td><?php echo $this->Form->input('location_id', array( 'options' => $system_locations, 'notempty'=>true));?></td>
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
			<td cols=2><?php echo $this->Form->submit('上傳');?></td>
		</tr>
	</table>
<?php echo $this->Form->end(); ?>

<table>
<?php if(isset($save_datas)):?>
	<tr>
		<td>資料列數</td>
		<td>書籍編號</td>
		<td>購買金額</td>
		<td>購入日期</td>
		<td>結果</td>
	</tr>
	<?php foreach($save_datas as $pp): ?>
	<tr>
		<td><?php echo $pp['Book_Instance']['line']; ?></td>
		<td><?php echo $pp['Book_Instance']['isbn']; ?></td>
		<td><?php echo $pp['Book_Instance']['purchase_price']; ?></td>
		<td><?php echo $pp['Book_Instance']['purchase_date']; ?></td>
		<td><?php echo $pp['Book_Instance']['isSave']; ?></td>
	</tr>
	<?php endforeach ?>
<?php endif; ?>
</table>


