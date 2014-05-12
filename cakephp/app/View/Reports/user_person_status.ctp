<script language="JavaScript">
	function extend_lend(book_instance_id) {
		x = confirm("是否續借？");
		if (x) {
			jQuery(jQuery('#btn_extend_'+book_instance_id)[0]).hide();
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
		}
		//return false;
	}
	function mark_lost(book_instance_id) {
		x = confirm("標示為遺失？");
		if (x) {
			jQuery(jQuery('#btn_lost_'+book_instance_id)[0]).hide();
			if (jQuery('#Lend_RecordPersonId')[0].value.trim() != '') {
				$.ajax(
					{	
						url:'<?php echo $this->html->url(array('controller'=>'lend', 'action' => 'mark_lost_operation'));?>', 
						data:{  book_instance_id: book_instance_id }, 
						type: "post", 
						success: function(response){
							alert(response);
							window.location = document.URL;
						}
					}
				)
			}
			else {
				alert('借卡號碼：不可為空白');
			}
		}
		//return false;
	}
</script>
<div class="pageheader_div">
	<h1 id="pageheader">學員借閱資料統計</h1>
</div>
<div class="pagemenu_div"><?php
echo $this->Html->link ( '回上一頁', "javascript:history.back();", array (
		'class' => 'button' 
) );
?></div>
<?php  if($this->Session->read('user_role') !== 'user')  { echo $this->Form->create('Lend_Record', array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); }?>
<table>
	<tr>
		<table>
			<tr>
				<td>借卡號碼</td>
				<td>
					<?php
					
if ($this->Session->read ( 'user_role' ) == 'user') {
						echo $person_info ['Person'] ['id'];
						echo $this->Form->hidden ( 'person_id', array (
								'value' => $person_info ['Person'] ['id'] 
						) );
					} else {
						if (isset ( $person_id )) {
							echo $this->Form->text ( 'person_id', array (
									'onkeypress' => 'search_person_id(event);',
									'onfocus' => 'this.select()',
									'value' => $person_id 
							) );
						} else {
							echo $this->Form->text ( 'person_id', array (
									'onkeypress' => 'search_person_id(event);',
									'onfocus' => 'this.select()' 
							) );
						}
					}
					?>
				</td>
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
				<td><?php echo sizeof($o_lend_records); ?></td>
				<td>已逾期數</td>
				<td><?php echo sizeof($o_over_lend_records); ?></td>
				<td>可借數</td>
				<td id='can_lend1'><?php if (isset($person_info['Person']['id'])) { echo $person_info['Person_Level']['max_book'] - sizeof($o_lend_records); } ?></td>
			</tr>
			<tr>
				<td colspan=6>
					<table>
						<tr>
							<th><?php echo $this->Paginator->sort('Book_Instance.id','書籍編號'); ?></th>
							<th><?php echo $this->Paginator->sort('Book.book_name','書籍名稱'); ?></th>
							<th>附屬媒體</th>
							<th><?php echo $this->Paginator->sort('Lend_Record.status','狀態'); ?></th>
							<th>續借次數</th>
							<th><?php echo $this->Paginator->sort('Lend_Record.lend_time','出借日期'); ?></th>
							<th><?php echo $this->Paginator->sort('Lend_Record.reserve_time','預約日期'); ?></th>
							<th><?php echo $this->Paginator->sort('Lend_Record.s_return_date','應還日期'); ?></th>
							<th><?php echo $this->Paginator->sort('Lend_Record.return_time','歸還日期'); ?></th>
							<th><?php echo $this->Paginator->sort('System_Location.location_name','地點'); ?></th>
							<th></th>
						</tr>
						<?php foreach ($lend_records as $lend_record): ?>
						<tr>
							<td><?php echo $lend_record['Book_Instance']['id']; ?></td>
							<td
								style="width: 300px; word-wrap: break-word; word-break: break-all;"><?php echo $lend_record['Book']['book_name']; ?></td>
							<td><?php echo $lend_record['Book']['book_attachment']; ?></td>
							<td><?php echo $lend_record['Lend_Status']['lend_status_name']; ?></td>
							<td><?php echo $lend_record['Lend_Record']['lend_cnt']; ?></td>
							<td><?php echo $lend_record['Lend_Record']['lend_time']; ?></td>
							<td><?php echo $lend_record['Lend_Record']['reserve_time']; ?></td>
							<td style='<?php if ((strtotime($lend_record['Lend_Record']['s_return_date']) < strtotime(date('Y-m-d')))&& ($lend_record['Lend_Record']['status'] == 'C' || $lend_record['Lend_Record']['status'] == 'E')) {echo 'color:red';}?>'><?php echo $lend_record['Lend_Record']['s_return_date']; ?></td>
							<td><?php echo $lend_record['Lend_Record']['return_time']; ?></td>
							<td><?php echo $lend_record['System_Location']['location_name']; ?></td>
							<td>
								<table>
									<tr>
								<?php
							if ((strtotime ( $lend_record ['Lend_Record'] ['s_return_date'] ) >= strtotime ( date ( 'Y-m-d' ) )) && (strtotime ( $lend_record ['Lend_Record'] ['s_return_date'] ) <= strtotime ( date ( 'Y-m-d', strtotime ( '+3 days' ) ) )) && ($lend_record ['Lend_Record'] ['status'] == 'C') && ($lend_record ['Lend_Record'] ['lend_cnt'] < 1)) {
								echo "<td>" . $this->Html->link ( '續借', 'javascript:void(0);', array (
										'onclick' => "extend_lend('" . $lend_record ['Book_Instance'] ['id'] . "');" ,
                                        'id' => "btn_extend_".$lend_record ['Book_Instance'] ['id']
								) ) . "</td>";
							}
							?>
								<?php
							if (($this->Session->read ( 'user_role' ) != 'user') && ($lend_record ['Lend_Record'] ['status'] == 'C')) {
								echo "<td>" . $this->Html->link ( '遺失', 'javascript:void(0);', array (
										'onclick' => "mark_lost('" . $lend_record ['Book_Instance'] ['id'] . "');" ,
                                        'id' => "btn_lost_".$lend_record ['Book_Instance'] ['id']
								) ) . "</td>";
							}
							?>
								</tr>
								</table>
							</td>
						</tr>
						<?php endforeach; ?>
						<tr>
							<td colspan=10>
							<?php
							echo $this->Paginator->first ( '<<' );
							echo $this->Paginator->numbers ( array (
									'first' => 2,
									'last' => 2 
							) );
							echo $this->Paginator->last ( '>>' );
							?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</tr>
</table>
<?php  if($this->Session->read('user_role') !== 'user')  { echo $this->Form->end(); }?>