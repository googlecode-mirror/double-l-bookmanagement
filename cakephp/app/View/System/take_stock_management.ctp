<?php
	if($isTakeStock) {
	
		echo '盤點進行中....';
		echo $this->Html->link('結束盤點', '/system/take_stock_management/0', array('class' => 'button', 'target' => '_blank'));
	} else{
		echo '未盤點';
		echo $this->Html->link('開始盤點', '/system/take_stock_management/1', array('class' => 'button', 'target' => '_blank'));
		
	}
?>