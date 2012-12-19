<h1>學員借閱資料統計</h1>
<?php  if($this->Session->read('user_role') !== 'user')  { echo $this->Form->create('Lend_Record', array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); }?>
<table>
	<tr>
		<table>
			<tr>
				<td>借卡號碼</td>
				<td><?php if ($this->Session->read('user_role') == 'user') {echo $person_info['Person']['id']; echo $this->Form->hidden('person_id', array('value' => $person_info['Person']['id']));} else {echo $this->Form->text('person_id', array('onkeypress' => 'search_person_id(event);'));}?></td>
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
						</tr>
						<?php foreach ($lend_records as $lend_record): ?>
						<tr>
							<td><?php echo $lend_record['Book_Instance']['id']; ?></td>
							<td style="width:300px;word-wrap:break-word;word-break:break-all;"><?php echo $lend_record['Book']['book_name']; ?></td>
							<td><?php echo $lend_record['Book']['book_attachment']; ?></td>
							<td><?php echo $lend_status[$lend_record['Lend_Record']['status']]; ?></td>
							<td><?php echo $lend_record['Lend_Record']['lend_cnt']; ?></td>
							<td><?php echo $lend_record['Lend_Record']['lend_time']; ?></td>
							<td><?php echo $lend_record['Lend_Record']['reserve_time']; ?></td>
							<td><?php echo $lend_record['Lend_Record']['s_return_date']; ?></td>
							<td><?php echo $lend_record['Lend_Record']['return_time']; ?></td>
							<td><?php echo $lend_record['System_Location']['location_name']; ?></td>
						</tr>
						<?php endforeach; ?>
						<tr>
							<td colspan=10>
							<?php 
								echo $this->Paginator->first('<<');
								echo $this->Paginator->numbers(array('first' => 2, 'last' => 2)); 
								echo $this->Paginator->last('>>');
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