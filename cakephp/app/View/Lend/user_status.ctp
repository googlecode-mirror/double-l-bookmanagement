<h1>借閱者狀況</h1>
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
							<th>預約日期</th>
							<th>書籍編號</th>
							<th>書籍名稱</th>
							<th>附屬媒體</th>
							<th>狀態</th>
							<th>續借次數</th>
							<th>應取日期</th>
							<th>地點</th>							
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
							<td><?php echo $lend_record['Lend_Record']['s_return_date']; ?></td>
							<td><?php echo $lend_record['System_Location']['location_name']; ?></td>
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
							<th>地點</th>							
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
						</tr>
						<?php endforeach; ?>
					</table>
				</td>
			</tr>
		</table>
	</tr>
</table>
<?php if (!isset($person_info['Person']['id'])) { echo $this->Form->end(); }?>
