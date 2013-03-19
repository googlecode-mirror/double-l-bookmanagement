<div class="pageheader_div"><h1 id="pageheader">維護地點名稱</h1></div>
<div class="pagemenu_div"><?php 
  	echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 
?></div>
<?php echo $this->Form->create('System_Location', array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); ?>
	<table>
		<tr>
			<td>地點代碼(不可變更)</td>
			<td>
				<?php 
					if($this->request->data['System_Location']['id'] == null)
						echo $this->Form->input('id', array('type'=>'text'));
					else
						echo $this->Form->input('id', array('type'=>'text','readonly'=>true));
				?>
			</td>
		</tr>	
		<tr>
			<td>地點名稱</td><td><?php echo $this->Form->input('location_name');?></td>
		</tr>
		<tr>
			<td colspan=2><?php echo $this->Form->submit('儲存');?></td>
		</tr>
	</table>
<?php echo $this->Form->end(); ?>