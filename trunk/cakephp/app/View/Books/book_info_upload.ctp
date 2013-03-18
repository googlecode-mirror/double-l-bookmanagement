 <script>
    $(function() {
        $(".jquery_date" ).datepicker({dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true});
    });
</script>
<div id="pageheader">
<h1>書籍資料上傳  <?php echo $this->Html->link('範例檔', '../files/Books_Upload.xls',  array('class' => 'button')); ?></h1> 

</div>

<?php echo $this->Form->create('Book_Info',array('enctype' => 'multipart/form-data', 
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
			<td cols=2><?php echo $this->Form->submit('上傳');?></td>
		</tr>
	</table>
<?php echo $this->Form->end(); ?>

<table>
<?php if(isset($save_datas)):?>
	<tr>
		<td>資料列數</td>
		<td>ISBN</td>
		<td>書籍名稱</td>
		<td>作者</td>
		<td>出版公司</td>
		<td>Lexile 級數</td>
		<td>集叢名</td>
		<td>發行日期</td>
		<td>結果</td>
	</tr>
	<?php foreach($save_datas as $pp): ?>
	<tr>
		<td><?php echo $pp['Book']['line']; ?></td>
		<td><?php echo $pp['Book']['isbn']; ?></td>
		<td><?php echo $pp['Book']['book_name']; ?></td>
		<td><?php echo $pp['Book']['book_author']; ?></td>
		<td><?php echo $pp['Book']['book_publisher']; ?></td>
		<td><?php echo $pp['Book']['cate_id']; ?></td>
		<td><?php echo $pp['Book']['book_suite']; ?></td>
		<td><?php echo $pp['Book']['publish_year']; ?></td>			
		<td><?php echo $pp['Book']['isSave']; ?></td>
	</tr>
	<?php endforeach ?>
<?php endif; ?>
</table>


