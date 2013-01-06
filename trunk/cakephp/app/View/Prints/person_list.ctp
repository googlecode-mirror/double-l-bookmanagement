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
<div id="pageheader"><h1>借書證列印列表</h1></div>
<?php
    echo $this->Form->create('Print',array('action'=>'book_remove','div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); 
?>
<table>
	<tr>
        <th>分校</th>
        <th>借書編號</th>
        <th>名字</th>
        <th>
        	<?php 
        		echo $this->Form->checkbox('toggle_remove', array('hiddenField'=>false)); 
        		echo $this->Form->submit('刪除',array('label' => false,'div' => false));	
        	?>
        </th>	
	</tr>
	<?php foreach ($items as $item): ?>
	<tr>
        <td><?php echo $item['Person']['System_Location']['location_name']; ?></td>
        <td><?php echo $item['Person']['id']; ?></td>		
        <td><?php echo $item['Person']['name']; ?></td>		
        <td><?php echo $this->Form->checkbox('remove.'.$item['System_Print_Person']['id'], array(
        		'value' => $item['System_Print_Person']['id'],
        		'hiddenField' => false,
        		'checkname' => 'removeCheck'
        		)); ?></td>			
	</tr>
	 <?php endforeach; ?>
</table>
<?php echo $this->Form->end(); ?>