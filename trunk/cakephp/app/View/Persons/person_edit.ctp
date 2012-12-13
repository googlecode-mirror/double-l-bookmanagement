<?php 
?>
<script>
    $(function() {
        $( ".jquery_date" ).datepicker({dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true});
    });
</script>
<h1>借閱者本資料處理</h1>
	<?php echo $this->Form->create('Person', array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); ?>
	<table>
		<tr>
			<td style='width:80px'>借卡代號</td><td><?php echo $this->Form->input('id', array('type'=>'text','style'=>'width:200px', 'readonly'=>$isModify)); ?></td>
			<td colspan=4></td>
		</tr>
		<tr>
			<td style='width:80px'>中文姓名</td><td><?php echo $this->Form->input('name', array('style'=>'width:100px')); ?></td>
			<td style='width:80px'>英文姓名</td><td><?php echo $this->Form->input('ename', array('style'=>'width:150px')); ?></td>
			<td style='width:80px'>查詢密碼</td><td><?php echo $this->Form->input('password', array('div'=>false)); ?></td>

		</tr>
		<tr>
			<td style='width:80px'>群組</td><td><?php echo $this->Form->select('group_id', $person_groups, array('empty'=>false)); ?></td>
			<td style='width:80px'>職稱</td><td><?php echo $this->Form->select('title_id', $person_titles, array('empty'=>false)); ?></td>
			<td style='width:80px'>位置</td><td><?php echo $this->Form->select('location_id', $system_locations, array('empty'=>false)); ?></td>
		</tr>
		<tr>
			<td>性別</td><td><?php echo $this->Form->select('gender', $person_genders,array('empty'=>false)); ?></td>
			<td style='width:80px'>聯絡電話</td><td><?php echo $this->Form->input('phone', array('style'=>'width:150px')); ?></td>
			<td>電子郵件</td><td><?php echo $this->Form->input('email', array('div'=>false)); ?></td>
		</tr>
		<tr>
			<td style='width:80px'>借閱等級</td><td><?php echo $this->Form->select('level_id', $person_levels,array('empty'=>false)); ?></td>
			<td style='width:80px'>可借天數</td><td><?php echo $this->Form->input('level_day', array('readonly'=>true, 'class' => 'ref_field', 'style'=>'width:30px')); ?></td>
			<td style='width:80px'>可借數量</td><td colspan=5><?php echo $this->Form->input('level_qty', array('readonly'=>true, 'class' => 'ref_field', 'style'=>'width:30px')); ?></td>
		</tr>
		<tr>
			<td style='width:80px'>發卡日期</td><td><?php echo $this->Form->text('card_create_date', array('readonly'=>true, 'class' => 'ref_field, jquery_date', 'style'=>'width:120px')); ?></td>
			<td style='width:80px'>補卡次數</td><td colspan=5><?php echo $this->Form->input('card_create_count', array('readonly'=>true, 'class' => 'ref_field', 'style'=>'width:30px')); ?></td>
		</tr>
		<tr>
			<td style='width:80px'>退卡日期</td><td><?php echo $this->Form->text('card_return_date', array('readonly'=>true, 'class' => 'ref_field, jquery_date', 'style'=>'width:120px')); ?></td>
			<td style='width:80px'>補卡日期</td><td colspan=5><?php echo $this->Form->text('card_reissue_date', array('readonly'=>true, 'class' => 'ref_field, jquery_date', 'style'=>'width:120px')); ?></td>
		</tr>
		<tr>
			<td colspan=8>
				<?php
					if($isModify) 
						echo $this->Form->button('儲存', array('type'=>'submit','name'=>'submit','value'=>'Modify'));
					else
						echo $this->Form->button('新增', array('type'=>'submit','name'=>'submit','value'=>'New'));
				?>
			</td>
		</tr>
	</table>
	<?php echo $this->Form->end(); ?>
