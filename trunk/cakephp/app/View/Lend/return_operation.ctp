<script language="JavaScript">
	function add_book(book_instance_id, e) {
		var key;
		if(window.event)
			key = window.event.keyCode;     //IE
		else
			key = e.which;     //firefox
		if(key == 13) {

		}
		else {	return true;}
	}
</script>
<div class="pageheader_div"><h1 id="pageheader">書籍歸還作業</h1></div>
<div class="pagemenu_div"><?php 
  	echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 
  	echo '&nbsp;';
  	echo $this->Html->link('書籍借閱作業', array('controller'=>'lend', 'action'=>'lend_operation'), array('class' => 'button')); 
?></div>

<table>
	<tr>
		<table>
			<?php if($msg != ''): ?>
			<tr>
				<td colspan=6 class="notice_msg"><?php echo $msg;?></td>
			</tr>
			<?php endif;?>
			<?php if (isset($person_info['Person']['id'])): ?>
			<tr>
				<td>借卡號碼</td>
				<td><?php echo $person_info['Person']['id']; ?></td>
				<td>借卡狀況</td>
				<td><?php echo $person_info['Person']['valid'];?></td>
				<td>目前狀況</td>
				<td></td>
			</tr>
			<tr>
				<td>姓名</td>
				<td><?php echo $person_info['Person']['name']; ?></td>
				<td>群組</td>
				<td><?php echo $person_info['Person_Group']['group_name'];?></td>
				<td>電話</td>
				<td><?php echo $person_info['Person']['phone']; ?></td>
			</tr>
			<tr>
				<td>等級權限</td>
				<td><?php echo $person_info['Person_Level']['level_name']; ?></td>
				<td>可借天數</td>
				<td><?php echo $person_info['Person_Level']['max_day']; ?></td>
				<td>可借本數</td>
				<td><?php echo $person_info['Person_Level']['max_book']; ?></td>
			</tr>
			<tr>
				<td>已借未還</td>
				<td><?php echo sizeof($lend_records); ?></td>
				<td>已逾期數</td>
				<td><?php echo sizeof($lend_records); ?></td>
				<td>可借數</td>
				<td id='can_lend1'><?php echo $person_info['Person_Level']['max_book'] - sizeof($lend_records); ?></td>
			</tr>
			<?php endif; ?>
			<tr>
				<td>請輸入書籍代號</td><td colspan=5> 
					<?php echo $this->Form->create('Lend_Record', array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); ?>
					<?php echo $this->Form->input('book', array('label' => false,'div' => false,'onkeypress' =>'add_book(this, event);')); ?>
					<?php echo $this->Form->end(); ?>				
				</td>
			</tr>
			<tr>
				<td colspan=5>借出尚未歸還明細</td><td style="text-align:right">共<?php echo sizeof($lend_records);?>本</td>
			</tr>
			<tr>
				<td colspan=6>
					<table>
						<tr>
							<th>出借日期</th>
							<th>書籍編號</th>
							<th>書籍名稱</th>
							<th>附屬媒體</th>
							<th>狀態</th>
							<th>續借次數</th>
							<th>應還日期</th>
						</tr>
						<?php foreach ($lend_records as $lend_record): ?>
						<tr>
							<td><?php echo $lend_record['Lend_Record']['lend_time']; ?></td>
							<td><?php echo $lend_record['Book_Instance']['id']; ?></td>
							<td><?php echo $lend_record['Book']['book_name']; ?></td>
							<td><?php echo $lend_record['Book']['book_attachment']; ?></td>
							<td><?php echo $lend_status[$lend_record['Lend_Record']['status']]; ?></td>
							<td><?php echo $lend_record['Lend_Record']['lend_cnt']; ?></td>
							<td><?php echo $lend_record['Lend_Record']['s_return_date']; ?></td>
						</tr>
						<?php endforeach; ?>
					</table>
				</td>
			</tr>
		</table>
	</tr>
</table>
<script language="JavaScript">
	$().ready( function() {
			if ($('#Lend_RecordBook').length > 0) {
				$('#Lend_RecordBook').focus();
			}
		}	
	);
</script>