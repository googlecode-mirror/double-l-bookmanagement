<div id="pageheader"><h1>盤點作業</h1></div>

<table>
    <tr>
        <th>地點名稱</th>
        <th>狀態</th>
        <th>操作</th>
	<tr>
	<?php foreach($items as $item): ?>
	<tr>
		<td><?php echo $item['System_Location']['location_name']?></td>
		<td><?php 
			if($item['System_Location']['isTakeStock']){
				echo '盤點中';
			}else{
				echo '未盤點';
			}
		
		?></td>
		<td><?php 
			if($item['System_Location']['isTakeStock']){
				echo $this->Html->link('結束盤點', '/system/take_stock_index/'.$item['System_Location']['id'], array('class' => 'button'));
			}else{
				echo $this->Html->link('開始盤點', '/system/take_stock_index/'.$item['System_Location']['id'], array('class' => 'button'));
			}
		
		?></td>		
	</tr>
	<?php endforeach; ?>
</table>