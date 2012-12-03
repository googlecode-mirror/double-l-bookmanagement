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
			if (jQuery("#lend_table tr td:contains('"+book_instance_id.value.trim()+"')").length == 0) {
				$.ajax(
					{	
						url:"lend_book", 
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
									alert('書籍代號：' + book_instance_id.value + '不在庫');
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
								else if (response == 5) {							
									alert('借卡號碼：' + jQuery('#person_id')[0].value + '不可跨區');
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
</script>
<h1>書籍借閱作業</h1>
<?php if (!isset($person_info['Person']['id'])) { echo $this->Form->create('Lend_Record', array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); }?>
<table>
	<tr>
		<table>
			<tr>
				<td>借卡號碼</td>
				<td><?php if (isset($person_info['Person']['id'])) {echo $person_info['Person']['id']; echo $this->Form->hidden('person_id', array('value' => $person_info['Person']['id']));} else {echo $this->Form->text('person_id', array('onkeypress' => 'search_person_id(event);'));}?></td>
				<td>借閱人姓名</td>
				<td></td>
				<td>借卡狀況</td>
				<td><?php if (isset($person_info['Person']['id'])) {echo $person_info['Person']['valid'];}?></td>
			</tr>
			<tr>
				<td>已借未還</td>
				<td><?php echo sizeof($lend_records); ?></td>
				<td>已逾期數</td>
				<td><?php echo sizeof($lend_records); ?></td>
				<td>可借數</td>
				<td id='can_lend1'><?php if (isset($person_info['Person']['id'])) { echo $person_info['Person_Level']['max_book'] - sizeof($lend_records); } ?></td>
			</tr>
			<tr>
				<td colspan=5>已預約明細</td><td style="text-align:right">共<?php echo sizeof($lend_records);?>本</td>
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
						</tr>
						<?php foreach ($reserve_records as $lend_record): ?>
						<tr>
							<td><?php echo $lend_record['Lend_Record']['lend_time']; ?></td>
							<td><?php echo $lend_record['Book_Instance']['id']; ?></td>
							<td><?php echo $lend_record['Book']['book_name']; ?></td>
							<td><?php echo $lend_record['Book']['book_attachment']; ?></td>
							<td>
								<?php echo $lend_status[$lend_record['Lend_Record']['status']]; ?>
								<?php if (($lend_record['Lend_Record']['person_id'] == $lend_record['Book_Instance']['reserve_person_id']) 
										&& $lend_record['Book_Instance']['book_status'] == 6) {
									echo '(已到請取書)';
								}?>
							</td>
							<td><?php echo $lend_record['Lend_Record']['lend_cnt']; ?></td>
						</tr>
						<?php endforeach; ?>
					</table>
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
<?php if (!isset($person_info['Person']['id'])) { echo $this->Form->end(); }?>
