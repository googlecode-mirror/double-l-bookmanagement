
<script>
    $(function() {
        $( ".jquery_date" ).datepicker({dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true});
    });
	
	function level_change() {
		level_id = jQuery('#PersonLevelId').val();
		$.ajax(
			{	
				url:'<?php echo $this->html->url(array('controller'=>'persons', 'action' => 'level_info'));?>'+'/'+level_id, 
				type: "post", 
				success: function(response){
					var response_obj = JSON.parse(response);
					jQuery('#PersonLevelDay').val(response_obj.Person_Level.max_day);
					jQuery('#PersonLevelQty').val(response_obj.Person_Level.max_book);
				}
			}
		);
		return false;
	}
</script>

<div class="pageheader_div"><h1 id="pageheader">借閱者資料批次上傳</h1></div>
<div class="pagemenu_div"><?php
  echo $this->Html->link('範例檔', '../files/Persons_Upload.xls',  array('class' => 'button')); 
  echo '&nbsp;';

  echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 
?></div>
<?php echo $this->Form->create('Person', array('enctype' => 'multipart/form-data', 
												'div'=>false, 
												'inputDefaults' => array('label' => false,'div' => false))
							); ?>
	<table>
		<tr>
			<td style='width:80px'>上傳檔案</td><td colspan=7>
			<?php echo $this->Form->input('Person.submittedfile', array(
    				'between' => '',
    				'type' => 'file'
			)); ?></td>
		</tr>
		<tr>
			<td style='width:80px'>群組</td><td><?php echo $this->Form->select('group_id', $person_groups, array('empty'=>false)); ?></td>
			<td style='width:80px'>職稱</td><td><?php echo $this->Form->select('title_id', $person_titles, array('empty'=>false)); ?></td>
			<td style='width:80px'>位置</td><td><?php echo $this->Form->select('location_id', $system_locations, array('empty'=>false)); ?></td>
		</tr>
		<tr>
			<td style='width:80px'>借閱等級</td><td><?php echo $this->Form->select('level_id', $person_levels, array('empty'=>false, 'onchange'=>'level_change()')); ?></td>
			<td style='width:80px'>可借天數</td><td><?php echo $this->Form->input('level_day', array('readonly'=>true, 'class' => 'ref_field', 'style'=>'width:30px')); ?></td>
			<td style='width:80px'>可借數量</td><td colspan=5><?php echo $this->Form->input('level_qty', array('readonly'=>true, 'class' => 'ref_field', 'style'=>'width:30px')); ?></td>
		</tr>
		<tr>
			<td style='width:80px'>發卡日期</td><td colspan=7><?php echo $this->Form->text('card_create_date', array('readonly'=>true, 'class' => 'ref_field, jquery_date', 'style'=>'width:120px')); ?></td>
		</tr>
		<tr>
			<td colspan=8>
				<?php
						echo $this->Form->button('新增', array('type'=>'submit','name'=>'submit','value'=>'New'));
				?>
			</td>
		</tr>
	</table>
<script>
	level_change();
</script>
	<?php echo $this->Form->end(); ?>

<table>
<?php if($save_persons !== null):?>
	<tr>
		<td>借卡代號</td>
		<td>中文姓名</td>
		<td>英文姓名</td>
		<td>查詢密碼</td>
		<td>結果</td>
	</tr>
	<?php foreach($save_persons as $pp): ?>
	<tr>
		<td><?php echo $pp['Person']['id']; ?></td>
		<td><?php echo $pp['Person']['name']; ?></td>
		<td><?php echo $pp['Person']['ename']; ?></td>
		<td><?php echo $pp['Person']['password']; ?></td>
		<td><?php echo $pp['Person']['isSave']; ?></td>
	</tr>
	<?php endforeach ?>
<?php endif; ?>
</table>
