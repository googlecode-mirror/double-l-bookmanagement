<table>
    <tr>
	<th colspan=6>最後十筆借閱紀錄</th>
	</tr>
    <tr>
        <th>分校</th>
        <th>書籍編號</th>
        <th>書籍名稱</th>
        <th>書籍狀態</th>
        <th>借閱日期</th>
        <th>歸還日期</th>
    </tr>
	<?php if (!empty($lend_records)):?>
    <?php foreach ($lend_records as $lend_record): ?>
    <tr>
		<td><?php echo $lend_record['c']['location_name']; ?></td>
		<td><?php echo $lend_record['i']['book_instance_id']; ?></td>
		<td><?php echo $lend_record['b']['book_name']; ?></td>
		<td><?php echo $lend_record['s']['lend_status_name']; ?></td>
		<td><?php echo $lend_record['i']['lend_time']; ?></td>
		<td><?php echo $lend_record['i']['return_time']; ?></td>
	</tr>
	<?php endforeach ?>
	<?php else: ?>
    <tr>
	<td colspan=6>沒有資料</td>
	</tr>
	<?php endif; ?>
</table>

