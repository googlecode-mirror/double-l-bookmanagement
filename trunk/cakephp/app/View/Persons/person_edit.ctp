<h1>借閱者本資料處理</h1>
	<?php echo $this->Form->create('Person', array('div'=>false)); ?>
	<table>
		<tr>
			<td style='width:80px'>借卡代號</td><td><?php echo $this->data['Person']['id'];?></td><td colspan=6><?php echo $this->Form->input('id', array('label'=>false, 'div'=>false)); ?></td>
		</tr>
		<tr>
			<td style='width:80px'>姓名</td><td><?php echo $this->Form->input('name', array('label'=>false, 'style'=>'width:100px', 'div'=>false)); ?></td>
			<td>性別</td><td><?php echo $this->Form->select('gender', $person_genders,array('label'=>false, 'empty'=>false, 'div'=>false)); ?></td>
			<td style='width:80px'>身份證</td><td><?php echo $this->Form->text('social_id', array('label'=>false, 'style'=>'width:100px', 'div'=>false)); ?></td>
			<td style='width:80px'>生日</td><td><?php echo $this->Form->input('birthday', array('label'=>false, 'style'=>'width:120px', 'div'=>false)); ?></td>
		</tr>
		<tr>
			<td style='width:80px'>群組</td><td colspan=5><?php echo $this->Form->select('group_id', $person_groups, array('label'=>false, 'empty'=>false, 'div'=>false)); ?></td>
			<td style='width:80px'>職稱</td><td><?php echo $this->Form->select('title_id', $person_titles, array('label'=>false, 'empty'=>false, 'div'=>false)); ?></td>
		</tr>
		<tr>
			<td style='width:80px'>聯絡電話</td><td><?php echo $this->Form->input('phone', array('label'=>false, 'style'=>'width:150px', 'div'=>false)); ?></td>
			<td>住家電話</td><td><?php echo $this->Form->input('home_phone', array('label'=>false, 'style'=>'width:150px', 'div'=>false)); ?></td>
			<td style='width:80px'>行動電話</td><td colspan=3><?php echo $this->Form->input('mobile_phone', array('label'=>false, 'style'=>'width:150px', 'div'=>false)); ?></td>
		</tr>
		<tr>
			<td style='width:80px'>傳真電話</td><td><?php echo $this->Form->input('fax', array('label'=>false, 'style'=>'width:150px', 'div'=>false)); ?></td>
			<td>電子郵件</td><td colspan=5><?php echo $this->Form->input('email', array('label'=>false, 'div'=>false)); ?></td>
		</tr>
		<tr>
			<td style='width:80px'>通訊地址</td><td colspan=7><?php echo $this->Form->input('address', array('label'=>false, 'div'=>false)); ?></td>
		</tr>
		<tr>
			<td style='width:80px'>備註</td><td colspan=7><?php echo $this->Form->input('memo', array('label'=>false, 'div'=>false)); ?></td>
		</tr>
		<tr>
			<td style='width:80px'>借閱等級</td><td colspan=2><?php echo $this->Form->select('level_id', $person_levels,array('label'=>false, 'empty'=>false, 'div'=>false)); ?></td>
			<td>借閱權利</td><td colspan=2></td>
			<td style='width:80px'>查詢密碼</td><td><?php echo $this->Form->input('password', array('label'=>false, 'div'=>false)); ?></td>
		</tr>
		<tr>
			<td style='width:80px'>可借天數</td><td><?php echo $this->Form->input('level_day', array('label'=>false, 'readonly'=>true, 'class' => 'ref_field', 'style'=>'width:30px', 'div'=>false)); ?></td>
			<td style='width:80px'>可借數量</td><td colspan=5><?php echo $this->Form->input('level_qty', array('label'=>false, 'readonly'=>true, 'class' => 'ref_field', 'style'=>'width:30px', 'div'=>false)); ?></td>
		</tr>
		<tr>
			<td style='width:80px'>發卡日期</td><td><?php echo $this->Form->input('card_create_date', array('label'=>false, 'style'=>'width:120px')); ?></td>
			<td style='width:80px'>補卡次數</td><td colspan=5><?php echo $this->Form->input('card_create_count', array('label'=>false, 'readonly'=>true, 'class' => 'ref_field', 'style'=>'width:30px', 'div'=>false)); ?></td>
		</tr>
		<tr>
			<td style='width:80px'>退卡日期</td><td><?php echo $this->Form->input('card_return_date', array('label'=>false, 'style'=>'width:120px', 'div'=>false)); ?></td>
			<td style='width:80px'>補卡日期</td><td colspan=5><?php echo $this->Form->text('card_reissue_date', array('label'=>false, 'readonly'=>true, 'class' => 'ref_field', 'style'=>'width:120px', 'div'=>false)); ?></td>
		</tr>
		<tr>
			<td colspan=8><?php echo $this->Form->submit('儲存', array('div'=>false));?></td>
		</tr>
	</table>
	<?php echo $this->Form->end(); ?>
