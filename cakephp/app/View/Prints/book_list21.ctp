<?php
	//var_dump($items);
?>
 <script>
    $(function() {
		$("#PrintToggleRemove").click(function() {
			if($("#PrintToggleRemove").attr("checked")){
     			$("input[checkName='removeCheck']").each(function() {
         			$(this).attr("checked", true);
     			});
   			} else {
     			$("input[checkName='removeCheck']").each(function() {
         			$(this).attr("checked", false);
     			});   
   			}
		}); 	       
    });
</script>

<div>
<div class="pageheader_div"><h1 id="pageheader">書籍列印列表</h1></div>
<div class="pagemenu_div"><?php 
	echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 
  	echo '&nbsp;';
?></div>
<div class="pagemenu_div">
<?php 	echo $this->Form->create('Print',array('action'=>'book_barcode21','div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); ?>
	<table>
		<tr>
			<td style="width:50px">開始X</td>
			<td style="width:30px"><?php echo $this->Form->select('start_x', $intXs, array('style' =>'width:50px', 'empty' =>false)); ?></td>
			<td style="width:50px">開始Y</td>
			<td style="width:30px"><?php echo $this->Form->select('start_y', $intYs, array('style' =>'width:50px', 'empty' =>false)); ?></td>
			<td style="width:80px"><?php echo $this->Form->submit('列印',array('label' => false,'div' => false)); ?></td>
			<td></td>
		</tr>
	</table>
<?php echo $this->Form->end(); ?>
</div>
<?php
    echo $this->Form->create('Print',array('action'=>'book_remove','div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); 
?>
<table>
	<tr>
        <th>書籍名稱</th>
        <th>書籍編號</th>
        <th>分校</th>
        <th>
        	<?php 
        		echo $this->Form->checkbox('toggle_remove', array('hiddenField'=>false)); 
        		echo $this->Form->submit('刪除',array('label' => false,'div' => false));	
        	?>
        </th>	
	</tr>
	<?php foreach ($items as $item): ?>
	<tr>
        <td><?php echo $item['Book_Instance']['Book']['book_name']; ?></td>
        <td><?php echo $item['Book_Instance']['id']; ?></td>		
        <td><?php echo $item['Book_Instance']['System_Location']['location_name']; ?></td>		
        <td><?php echo $this->Form->checkbox('remove.'.$item['System_Print_Book']['id'], array(
        		'value' => $item['System_Print_Book']['id'],
        		'hiddenField' => false,
        		'checkname' => 'removeCheck'
        		)); ?></td>			
	</tr>
	 <?php endforeach; ?>
</table>
<?php echo $this->Form->end(); ?>