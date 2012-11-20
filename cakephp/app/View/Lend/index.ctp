<h1>書籍借閱記錄資料</h1>
<table>
    <tr>
        <th>書名</th>
        <th>借閱人</th>
        <th>雜誌編號</th>
        <th>狀態</th>
        <th>預借日期</th>
		<th>出借日期</th>
		<th>歸還日期</th>
		<th>續借次數</th>
        <th></th>
    </tr>
    <?php foreach ($lend_records as $lend_record): ?>
    <tr>
        <td><?php echo $lend_record['Book']['book_name']; ?></td>
        <td><?php echo $lend_record['Person']['name']; ?></td>
        <td><?php echo $lend_record['Lead_Record']['id']; ?></td>
        <td><?php echo $lend_record['Lead_Record']['status']; ?></td>
        <td><?php echo $lend_record['Lead_Record']['reserve_date']; ?></td>
        <td><?php echo $lend_record['Lead_Record']['lead_date']; ?></td>
        <td><?php echo $lend_record['Lead_Record']['return_date']; ?></td>
        <td><?php echo $lend_record['Lead_Record']['lead_cnt']; ?></td>
        <td><?php echo $this->Html->link('修改', array('action' => 'lend_edit', $lend_record['Lead_Record']['id'])); ?></td>
    </tr>

    <?php endforeach; ?>
</table>
