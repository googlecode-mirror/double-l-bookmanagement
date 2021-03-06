<div class="pageheader_div"><h1 id="pageheader">書籍借閱記錄資料</h1></div>
<div class="pagemenu_div"><?php 
  	echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 
  	echo '&nbsp;';
?></div>
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
        <td><?php echo $lend_record['Lend_Record']['book_instance_id']; ?></td>
        <td><?php echo $lend_status[$lend_record['Lend_Record']['status']]; ?></td>
        <td><?php echo $lend_record['Lend_Record']['reserve_time']; ?></td>
        <td><?php echo $lend_record['Lend_Record']['lend_time']; ?></td>
        <td><?php echo $lend_record['Lend_Record']['return_time']; ?></td>
        <td><?php echo $lend_record['Lend_Record']['lend_cnt']; ?></td>
        <td><?php echo $this->Html->link('修改', array('action' => 'lend_edit', $lend_record['Lend_Record']['id'])); ?></td>
    </tr>

    <?php endforeach; ?>
</table>
