<script>
	function printDiv(divName) {
		 var printContents = document.getElementById(divName).innerHTML;
		 var originalContents = document.body.innerHTML;
		 document.body.innerHTML = printContents;
		 window.print();
		document.body.innerHTML = originalContents;
	}
</script>

<div class="pagemenu_div" style="float:left; clear:right;">
<?php echo $this->Html->link('回上一頁',"javascript:history.back();", array('class' => 'button'));?>&nbsp;
<?php echo $this->Html->link('列印標簽',"javascript:printDiv('print_div');", array('class' => 'button'));?>
</div>
<div style="height:1px;float:left; clear:left; "></div>
<div id='print_div' style="width:210mm;float:left; clear:left; ">
	<STYLE TYPE="text/css">
	.barcode { width:70mm; height: 42mm; float:left; margin:0px; }
	.barcode_tt { width:70mm; height: 42mm; float:left; clear:right; }
	.barcode_image { padding: 3px 0px 0px 0px; }
	</STYLE> 
	<div id='barcode_div' style="width:210mm;">
	<?php $total_div = 0; ?>
		<?php for($i=1;$i<$intY;$i++) : ?>
			<?php for($j=1;$j<=3;$j++) : ?>
				<div class="barcode" align="center"><?php echo $this->Html->image(array('controller' => 'graph', 'action'=> 'book_barcode21'),array('class'=>'barcode_image')); ?></div>
				<?php $total_div++; ?>
			<?php endfor;?>
		<?php endfor;?>
		<?php $record = 0; ?>
		<?php for($i=1;$i<$intX;$i++) : ?>
			<div class="barcode" align="center"><?php echo $this->Html->image(array('controller' => 'graph', 'action'=> 'book_barcode21'),array('class'=>'barcode_image')); ?></div>
			<?php $total_div++; ?>
		<?php endfor; ?>
		<?php while ($record < sizeof($books)): ?>
			<div class="barcode" align="center"><?php echo $this->Html->image(array('controller' => 'graph', 'action'=> 'book_barcode21',$books[$record]['Book_Instance']['id']),array('class'=>'barcode_image')); ?></div>
			<?php $record++; ?>
			<?php $total_div++; ?>
		<?php endwhile;?>	
		<?php while ($total_div % 3 != 0) : ?>
				<div class="barcode" align="center"><?php echo $this->Html->image(array('controller' => 'graph', 'action'=> 'book_barcode21'),array('class'=>'barcode_image')); ?></div>
				<?php $total_div++; ?>
		<?php endwhile; ?>
	</div>
</div>
