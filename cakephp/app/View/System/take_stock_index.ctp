
<script>
	function check_finish(locationName) {
		var answer = confirm ("列印盤點清冊了嗎？沒有請按取消，先列印清冊。");
		if (answer) {
			answer = confirm ("要結束盤點嗎？");
			if (answer) {
				var url_str = '<?php echo $this->here; ?>/' + locationName;
				window.location=url_str;
			}
		}
	}
</script>
<div class="pageheader_div"><h1 id="pageheader">盤點作業</h1></div>
<div class="pagemenu_div"><?php 
  	echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 
?></div>
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
				echo $this->Html->link('匯出清冊', '/reports/book_inv_epxort/'.$item['System_Location']['id'], array('class' => 'button red'));
				echo " ";		 
			if($item['System_Location']['isTakeStock']){	
				echo $this->Html->link('列印清冊', '/reports/book_inv_check', array('class' => 'button red'));
				echo " ";						
				echo $this->Html->link('結束盤點', 'javascript:check_finish(\''.$item['System_Location']['id'].'\');', array('class' => 'button red'));
				echo " ";
				echo $this->Html->link('盤點書本', '/system/take_stock_operation/'.$item['System_Location']['id'], array('class' => 'button blue	'));
			}else{
				echo $this->Html->link('開始盤點', '/system/take_stock_index/'.$item['System_Location']['id'], array('class' => 'button'));
			}
		
		?></td>		
	</tr>
	<?php endforeach; ?>
</table>