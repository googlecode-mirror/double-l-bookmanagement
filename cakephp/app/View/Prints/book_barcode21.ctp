<script>
	function printDiv(divName) {
		 var printContents = document.getElementById(divName).innerHTML;
		 var originalContents = document.body.innerHTML;
		 document.body.innerHTML = printContents;
		 window.print();
		document.body.innerHTML = originalContents;
	}
</script>
<?php echo $this->Html->link('回上一頁',"javascript:history.back();");?>&nbsp;
<?php echo $this->Html->link('列印標簽',"javascript:printDiv('print_div');");?>
<div id='print_div' style="width:210mm;">
	<STYLE TYPE="text/css">
	.barcode { width:70mm; height: 42mm; float:left; }
	.barcode_tt { width:70mm; height: 42mm; float:left; clear:right; }
	</STYLE> 
	<div id='barcode_div' style="width:210mm;">
	<?php $total_div = 0; ?>
		<?php for($i=1;$i<$intY;$i++) : ?>
			<?php for($j=1;$j<=3;$j++) : ?>
				<div class="barcode" align="center"><?php echo $this->Html->image(array('controller' => 'graph', 'action'=> 'book_barcode21')); ?></div>
				<?php $total_div++; ?>
			<?php endfor;?>
		<?php endfor;?>
		<?php $record = 0; ?>
		<?php for($i=1;$i<$intX;$i++) : ?>
			<div class="barcode" align="center"><?php echo $this->Html->image(array('controller' => 'graph', 'action'=> 'book_barcode21')); ?></div>
			<?php $total_div++; ?>
		<?php endfor; ?>
		<?php while ($record < sizeof($books)): ?>
			<div class="barcode" align="center"><?php echo $this->Html->image(array('controller' => 'graph', 'action'=> 'book_barcode21',$books[$record]['Book_Instance']['id'])); ?></div>
			<?php $record++; ?>
			<?php $total_div++; ?>
		<?php endwhile;?>	
		<?php while ($total_div % 3 != 0) : ?>
				<div class="barcode" align="center"><?php echo $this->Html->image(array('controller' => 'graph', 'action'=> 'book_barcode21')); ?></div>
				<?php $total_div++; ?>
		<?php endwhile; ?>
	</div>
</div>
