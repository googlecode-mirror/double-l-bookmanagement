 <script>
    $(function() {
        $(".jquery_date" ).datepicker({dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true});
    });
</script>
<div id="pageheader">
<h1>到期書籍資料</h1>
</div>
<?php echo $this->Form->create('book',array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); ?>
<table>
	<tr>
		<td style='width:80px'>到期日期</td>	
		<td><?php echo $this->Form->text('expire_date', array('readonly'=>true, 'class' => 'ref_field, jquery_date'));?></td>
		<td><?php echo $this->Form->submit('送出', array('div'=>false));?></td>
	</tr>
</table>
<?php echo $this->Form->end(); ?>
<table>
	<tr>
		<th>分校</th>
		<th>到期日</th>
		<th>續借次數</th>
		<th>書籍名稱</th>
		<th>借卡號碼</th>
		<th>借閱者</th>
		<th>電話</th>
		<th>電子郵件</th>
	</tr>
	<?php foreach ($books as $item): ?>
	<tr>
		<td><?php echo $item['sl']['location_name'];?></td>
		<td><?php echo $item['l']['s_return_date'];?></td>
		<td><?php echo $item['l']['lend_cnt'];?></td>
		<td><?php echo $item['b']['book_name'];?></td>
		<td><?php echo $item['p']['id'];?></td>
		<td><?php echo $item['p']['name'];?></td>
		<td><?php echo $item['p']['phone'];?></td>
		<td><?php echo $item['p']['email'];?></td>
	</tr>
	<?php endforeach; ?>
</table>

