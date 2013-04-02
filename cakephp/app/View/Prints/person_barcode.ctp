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
	.barcode { width:70mm; height: 30mm; float:left; }
	.barcode_tt { width:70mm; height: 30mm; float:left; clear:right; }
	</STYLE> 
	<div id='barcode_div' style="width:210mm;">
		<?php $total_div = 0; ?>
		<?php for($i=1;$i<$intY;$i++) : ?>
			<?php for($i=1;$j<=3;$j++) : ?>
				<div class="barcode" align="center"><?php echo $this->Html->image(array('controller' => 'graph', 'action'=> 'person_barcode')); ?></div>
				<?php $total_div++; ?>
			<?php endfor; ?>
		<?php endfor;?>
		<?php $record = 0; ?>
		<?php for($i=1;$i<$intX;$i++) : ?>
			<div class="barcode" align="center"><?php echo $this->Html->image(array('controller' => 'graph', 'action'=> 'person_barcode')); ?></div>
			<?php $total_div++; ?>
		<?php endfor; ?>
		<?php while ($record < sizeof($persons)): ?>
			<div class="barcode" align="center"><?php echo $this->Html->image(array('controller' => 'graph', 'action'=> 'person_barcode',$persons[$record]['Person']['id'])); ?></div>
			<?php $record++; ?>
			<?php $total_div++; ?>
		<?php endwhile; ?>	
		<?php while ($total_div % 3 != 0) : ?>
			<div class="barcode" align="center"><?php echo $this->Html->image(array('controller' => 'graph', 'action'=> 'person_barcode')); ?></div>
			<?php $total_div++; ?>
		<?php endwhile; ?>
	</div>
</div>