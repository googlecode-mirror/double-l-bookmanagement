<h1>維護地點名稱</h1>
<?php echo $this->Form->create('System_Location', array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); ?>
	<table>
		<tr>
			<td>地點名稱</td><td><?php echo $this->Form->input('id');?><?php echo $this->Form->input('location_name');?></td>
		</tr>
		<tr>
			<td colspan=2><?php echo $this->Form->submit('儲存');?></td>
		</tr>
	</table>
<?php echo $this->Form->end(); ?>