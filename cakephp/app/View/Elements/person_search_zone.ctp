<table>
	<tr>
        <td>
		<?php echo $this->Form->create('Person',array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); ?>
			<table>
				<tr>
					<td style="width:100px" >所屬分校</td>
					<td colspan=3><?php echo $this->Form->input('location_id', array( 'options' => $system_locations, 'notempty'=>true));?></td>
				</tr>
				<tr>
					<td style="width:100px" >借卡代號</td>
					<td colspan=3><?php echo $this->Form->input('id', array('type'=>'text','size'=>20));?></td>
				</tr>						
				<tr>
					<td colspan=4>
					<?php echo $this->Form->hidden('page', array('value'=>1));?>
					<?php echo $this->Form->hidden('page_change', array('value'=>0));?>
					<?php echo $this->Form->submit('搜尋', array('div'=>false));?>
					</td>
				</tr>			
			</table>
		<?php echo $this->Form->end(); ?>
		</td>
	</tr>
</table>
