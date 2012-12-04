<? if (!empty($book)): ?>
<tr id='lend_row_<?php echo $book_cnt; ?>'>
	<td>
		<?php echo $book['Book_Instance']['id']; ?>
		<?php echo $this->Form->hidden($book_cnt.'.book_instance_id', array('value' => $book['Book_Instance']['id'])); ?>
		<?php echo $this->Form->hidden($book_cnt.'.book_id', array('value' => $book['Book']['id'])); ?>
	</td>
	<td>
		<?php echo $book['Book']['book_name']; ?>
		<?php echo $this->Form->hidden($book_cnt.'.book_name', array('value' =>$book['Book']['book_name'])); ?>
	</td>
	<td>
		<?php echo $book['Book']['book_attachment']; ?>
		<?php echo $this->Form->hidden($book_cnt.'.book_attachment', array('value' =>$book['Book']['book_attachment'])); ?>
	</td>
	<td>
		<?php echo date('Y-m-d', mktime(0,0,0,date('m'),date('d')+$person['Person_Level']['max_day'],date('Y'))); ?>
		<?php echo $this->Form->hidden($book_cnt.'.s_return_date', array('value' =>date('Y-m-d', mktime(0,0,0,date('m'),date('d')+$person['Person_Level']['max_day'],date('Y'))))); ?>
	</td>
	<td>
		<?php echo $person_level[$book['Book_Instance']['level_id']]; ?>
		<?php echo $this->Form->hidden($book_cnt.'.level_id', array('value' =>$book['Book_Instance']['level_id'])); ?>
	</td>
	<td>
		<?php echo $book_status[$book['Book_Instance']['book_status']]; ?>
		<?php echo $this->Form->hidden($book_cnt.'.book_status', array('value' =>$book['Book_Instance']['book_status'])); ?>
	</td>
	<td>
		<?php echo $locations[$user_info['user_location']]; ?>
		<?php echo $this->Form->hidden($book_cnt.'.location_id', array('value' =>$user_info['user_location'])); ?>
	</td>
	<td><?php echo $this->html->link('刪除', 'javascript:void(0)', array('onclick' => 'delete_row("lend_row_'.$book_cnt.'");')); ?></td>
</tr>
<?php else: ?>
	<?php echo $error_code; ?>
<?php endif; ?>