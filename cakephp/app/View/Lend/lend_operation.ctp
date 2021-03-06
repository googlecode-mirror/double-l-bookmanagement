<script language="JavaScript">
	
	function delete_row(row_id) {
		jQuery('#'+row_id).remove();
		jQuery('#lend_cnt')[0].innerHTML = jQuery('#lend_table tr').length - 1;
		jQuery('#can_lend')[0].innerHTML = jQuery('#can_lend1')[0].innerHTML - jQuery('#lend_table tr').length + 1;
		if (jQuery('#lend_table tr').length <= 1) {
			jQuery('#SaveData').hide();
		}
		return false;
	}
	
	function search_person_id(e) {
	var key;
		if(window.event)
			key = window.event.keyCode;     //IE
		else
			key = e.which;     //firefox
		if(key != 13) {
			return false;
		}
		else {	
			jQuery('#Lend_RecordLendOperationForm')[0].submit();
			return true;
		}
	}

	function add_book(book_instance_id, e) {
		var key;
		if(window.event)
			key = window.event.keyCode;     //IE
		else
			key = e.which;     //firefox
		if(key == 13) {
			if ((jQuery("#lend_table tr td:contains('"+book_instance_id.value.trim()+"')").length == 0) 
			   && (parseInt(jQuery('#can_lend')[0].innerHTML) > 0))   {
				$.ajax(
					{	
						url:'<?php echo $this->html->url(array('controller'=>'lend', 'action' => 'lend_book'));?>', 
						data:{ person_id: jQuery('#person_id')[0].value, book_instance_id: book_instance_id.value, book_cnt: jQuery('#lend_table tr').length }, 
						type: "post", 
						success: function(response){
							if (response.length <= 2) {
								if (response == 1) {
									alert('借卡號碼：' + jQuery('#person_id')[0].value + '不存在');
								}
								else if (response == 2){
									alert('書籍代號：' + book_instance_id.value + '不存在');
								}
								else if (response == 3) {							
									alert('書籍代號：' + book_instance_id.value + '借出中');
								}
								else if (response == 4) {							
									alert('書籍代號：' + book_instance_id.value + '不可外借');
								}
								else if (response == 5) {							
									alert('借閱等級不足');
								}
								else if (response == 6) {							
									alert('書籍代號：' + book_instance_id.value + '有人預約中');
								}
								else if (response == 7) {							
									alert('借卡號碼：' + jQuery('#person_id')[0].value + '不可跨校借閱');
								}
								else if (response == 8) {							
									alert('書籍代號：' + book_instance_id.value + '非本校藏書');
								}
								else {
									alert('錯誤');
								}
							}
							else {
								jQuery('#lend_table').append(response);
								jQuery('#lend_cnt')[0].innerHTML = jQuery('#lend_table tr').length - 1;
								jQuery('#can_lend')[0].innerHTML = jQuery('#can_lend1')[0].innerHTML - jQuery('#lend_table tr').length + 1;
							}
							if (jQuery('#lend_table tr').length > 1) {
								jQuery('#SaveData').show();
							}
						}
					}
				);
			}
			else {
				alert('書籍代號：' + book_id.value + '已選取');
			}
			return false;
		}
		else {	return true;}
	}
	
	function extend_lend(book_instance_id) {
		if (jQuery('#Lend_RecordPersonId')[0].value.trim() != '') {
			$.ajax(
				{	
					url:'<?php echo $this->html->url(array('controller'=>'lend', 'action' => 'extend_book'));?>', 
					data:{ extend_person_id: jQuery('#Lend_RecordPersonId')[0].value, book_instance_id: book_instance_id }, 
					type: "post", 
					success: function(response){
						alert(response);
					}
				}
			)
		}
		else {
			alert('借卡號碼：不可為空白');
		}
		//return false;
	}
</script>
<div class="pageheader_div"><h1 id="pageheader">書籍借閱作業</h1></div>
<div class="pagemenu_div"><?php 
  	echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 
  	echo '&nbsp;';
  	echo $this->Html->link('書籍歸還作業', array('controller'=>'lend', 'action'=>'return_operation'), array('class' => 'button')); 
?></div>
<?php if (!isset($person_info['Person']['id'])) { echo $this->Form->create('Lend_Record', array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); }?>
<table>
	<tr>
		<table>
			<tr>
				<td>借卡號碼</td>
				<td><?php if (isset($person_info['Person']['id'])) {echo $person_info['Person']['id']; echo $this->Form->hidden('person_id', array('value' => $person_info['Person']['id']));} else {echo $this->Form->text('person_id', array('onkeypress' => 'search_person_id(event);'));}?></td>
				<td>借卡狀況</td>
				<td><?php if (isset($person_info['Person']['id'])) {echo $person_info['Person']['valid'];}?></td>
				<td>目前狀況</td>
				<td></td>
			</tr>
			<tr>
				<td>姓名</td>
				<td><?php if (isset($person_info['Person']['id'])) { echo $person_info['Person']['name'];} ?></td>
				<td>群組</td>
				<td><?php if (isset($person_info['Person']['id'])) { echo $person_info['Person_Group']['group_name'];} ?></td>
				<td>電話</td>
				<td><?php if (isset($person_info['Person']['id'])) { echo $person_info['Person']['phone'];} ?></td>
			</tr>
			<tr>
				<td>等級權限</td>
				<td><?php if (isset($person_info['Person']['id'])) { echo $person_info['Person_Level']['level_name'];} ?></td>
				<td>可借天數</td>
				<td><?php if (isset($person_info['Person']['id'])) { echo $person_info['Person_Level']['max_day'];} ?></td>
				<td>可借本數</td>
				<td><?php if (isset($person_info['Person']['id'])) { echo $person_info['Person_Level']['max_book'];} ?></td>
			</tr>
			<tr>
				<td>已借未還</td>
				<td><?php echo sizeof($lend_records); ?></td>
				<td>已逾期數</td>
				<td><?php echo sizeof($over_lend_records); ?></td>
				<td>可借數</td>
				<td id='can_lend1'><?php if (isset($person_info['Person']['id'])) { echo $person_info['Person_Level']['max_book'] - sizeof($lend_records); } ?></td>
			</tr>
			<tr>
				<td colspan=4>欲借出明細</td>
				<td style="text-align:right">已輸入<span id='lend_cnt'>0</span>本</td>
				<td style="text-align:right">還可借出<span id='can_lend'><?php if (isset($person_info['Person']['id'])) { echo $person_info['Person_Level']['max_book'] - sizeof($lend_records); } ?></span>本</td>
			</tr>
			<tr>
				<td>請輸入書籍代號</td><td colspan=5> <?php if (isset($person_info['Person']['id'])) { echo $this->Form->input('book', array('label' => false,'div' => false,'onkeypress' =>'add_book(this, event);')); } ?></td>
			</tr>
			<tr>
				<td colspan=6>
					<?php if (isset($person_info['Person']['id'])) { echo $this->Form->create('Lend_Record', array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); }?>
					<?php if (isset($person_info['Person']['id'])) { echo $this->Form->hidden('person_id', array('value'=>$person_info['Person']['id'])); }?>
					<table id='lend_table'>
						<tr>
							<th>書籍編號</th>
							<th>書籍名稱</th>
							<th>附屬媒體</th>
							<th>應還日期</th>
							<th>借閱等級</th>
							<th>狀態</th>
							<th>地點</th>
							<th><?php echo $this->Form->submit('儲存', array('style'=>'display:none', 'id' => 'SaveData')); ?></th>
						</tr>
					</table>
					<?php if (isset($person_info['Person']['id'])) { echo $this->Form->end(); }?>
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
							<th>地點</th>
							<th></th>
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
							<td><?php echo $lend_record['System_Location']['location_name']; ?></td>
							<td>
								<?php 
									if ((strtotime($lend_record['Lend_Record']['s_return_date']) >= strtotime(date('Y-m-d')))
										&& (strtotime($lend_record['Lend_Record']['s_return_date']) <= strtotime(date('Y-m-d', strtotime('+3 days'))))
									    && ($lend_record['Lend_Record']['status'] == 'C' ) && ($lend_record['Lend_Record']['lend_cnt'] < 1 )) {
										echo $this->Html->link('續借', 'javascript:void(0);', array('onclick' => "extend_lend('".$lend_record['Book_Instance']['id']."');")); 
									}	
								?>
							</td>
						</tr>
						<?php endforeach; ?>
					</table>
				</td>
			</tr>
		</table>
	</tr>
</table>
<?php if (!isset($person_info['Person']['id'])) { echo $this->Form->end(); }?>
<script language="JavaScript">
	$().ready( function() {
			if ($('#Lend_RecordPersonId').length > 0) {
				$('#Lend_RecordPersonId').focus();
			}
			if ($('#book').length > 0) {
				$('#book').focus();
			}
		}	
	);
</script>
