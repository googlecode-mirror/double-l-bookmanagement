<script>
	function printDiv(divName) {
		 var printContents = document.getElementById(divName).innerHTML;
		 var originalContents = document.body.innerHTML;
		 document.body.innerHTML = printContents;
		 window.print();
		 document.body.innerHTML = originalContents;
	}
</script>
<?php if (empty($persons)): ?>
<?php 	echo $this->Form->create('Person',array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); ?>
	<table>
		<tr>
			<td style="width:50px">開始X</td>
			<td style="width:30px"><?php echo $this->Form->select('start_x', $intXs, array('style' =>'width:50px', 'empty' =>false)); ?></td>
			<td style="width:50px">開始Y</td>
			<td style="width:30px"><?php echo $this->Form->select('start_y', $intYs, array('style' =>'width:50px', 'empty' =>false)); ?></td>
			<td style="width:80px"><?php echo $this->Form->submit('查詢',array('label' => false,'div' => false)); ?></td>
			<td></td>
		</tr>
	</table>
<?php echo $this->Form->end(); ?>
<?php else: ?>
<?php echo $this->html->link('回上一頁',array('controller'=>'persons','action'=>'print_person_barcode_sel'));?>&nbsp;
<?php echo $this->html->link('列印標簽',"javascript:printDiv('print_div');");?>
<div id='print_div' align="center" cellspacing=0 cellpadding=0 style="width:828px;">
	<?php $total_div = 0; ?>
	<table style="padding:0px; margin:0px">
		<?php for($i=1;$i<$intY;$i++) : ?>
		<tr style="background-color:#FFF;padding:0px; margin:0px">
			<td style="text-align:center;padding:0px; margin:0px;border-bottom:none"><? echo $this->html->image(array('controller' => 'graph', 'action'=> 'person_barcode')); ?></td>
			<td style="text-align:center;padding:0px; margin:0px;border-bottom:none"><? echo $this->html->image(array('controller' => 'graph', 'action'=> 'person_barcode')); ?></td>
			<td style="text-align:center;padding:0px; margin:0px;border-bottom:none"><? echo $this->html->image(array('controller' => 'graph', 'action'=> 'person_barcode')); ?></td>
		</tr>
		<?php $total_div = $total_div + 3; ?>
		<?php endfor;?>
		<?php $record = 0; ?>
		<?php $col = 1; ?>
		<tr style="background-color:#FFF;padding:0px; margin:0px">
			<?php for($i=1;$i<$intX;$i++) : ?>
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none"><? echo $this->html->image(array('controller' => 'graph', 'action'=> 'person_barcode')); ?></td>
				<?php $total_div++; ?>
				<?php $col++; ?>
			<?php endfor; ?>
			<?php while (($col <= 3) && ($record < sizeof($persons))): ?>
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none"><? echo $this->html->image(array('controller' => 'graph', 'action'=> 'person_barcode',$persons[$record]['persons']['id'])); ?></td>
				<?php $record++; ?>
				<?php $col++; ?>
				<?php $total_div++; ?>
			<?php endwhile; ?>	
			<?php while ($col <= 3) : ?>
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none"><? echo $this->html->image(array('controller' => 'graph', 'action'=> 'person_barcode')); ?></td>
				<?php $total_div++; ?>
				<?php $col++; ?>
			<?php endwhile; ?>
		</tr>
		<?php $col = 1; ?>
		<tr style="background-color:#FFF;padding:0px; margin:0px">
			<?php while (($col < 3) && ($record < sizeof($persons))): ?>
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none"><? echo $this->html->image(array('controller' => 'graph', 'action'=> 'person_barcode',$persons[$record]['Person']['id'])); ?></td>
				<?php $record++; ?>
				<?php $col++; ?>
				<?php $total_div++; ?>
			<?php endwhile; ?>	
			<?php while ($col <= 3) : ?>
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none"><? echo $this->html->image(array('controller' => 'graph', 'action'=> 'person_barcode')); ?></td>
				<?php $total_div++; ?>
				<?php $col++; ?>
			<?php endwhile; ?>
		</tr>
		<?php while($total_div < 27) : ?>
		<tr style="background-color:#FFF;padding:0px; margin:0px">
			<td style="text-align:center;padding:0px; margin:0px;border-bottom:none"><? echo $this->html->image(array('controller' => 'graph', 'action'=> 'person_barcode')); ?></td>
			<td style="text-align:center;padding:0px; margin:0px;border-bottom:none"><? echo $this->html->image(array('controller' => 'graph', 'action'=> 'person_barcode')); ?></td>
			<td style="text-align:center;padding:0px; margin:0px;border-bottom:none"><? echo $this->html->image(array('controller' => 'graph', 'action'=> 'person_barcode')); ?></td>
		</tr>
		<?php $total_div = $total_div + 3; ?>
		<?php endwhile;?>
	</table>
</div>
<?php endif; ?>