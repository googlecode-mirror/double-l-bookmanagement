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
			<td style="width:80px">開始號碼</td>
			<td style="width:80px"><?php echo $this->Form->input('start_id', array('type'=> 'text', 'style' =>'width:100px')); ?></td>
			<td style="width:80px">結束號碼</td>
			<td style="width:80px"><?php echo $this->Form->input('end_id', array('type'=> 'text', 'style' =>'width:100px')); ?></td>
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
<?php echo $this->html->link('回搜尋頁',array('controller'=>'persons','action'=>'print_person_barcode'));?>&nbsp;
<?php echo $this->html->link('列印標簽',"javascript:printDiv('print_div');");?>
<div id='print_div' align="center" cellspacing=0 cellpadding=0 style="width:700px;">
	<?php $total_div = 0; ?>
	<?php for($i=1;$i<=$intY;$i++) : ?>
	<?php $j =1; ?>
	<?php while((($j<=3) && ($i<$intY) )|| (($j<$intX) && ($i==$intY))) : ?>
	<div style="float:left;width:230px;height:140px;background-color:#fff;border:1px solid;">
		<table style="padding:10px; margin:0px">
			<tr style="background-color:#FFF;padding:0px; margin:0px">
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none;"></td>
			</tr>
			<tr style="background-color:#FFF;padding:0px; margin:0px">
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none;"></td>
			</tr>
			<tr style="background-color:#FFF;padding:0px; margin:0px">
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none;"></td>
			</tr>
			<tr style="background-color:#FFF;padding:0px; margin:0px">
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none"></td>
			</tr>
		</table>
	</div>
	<?php $total_div++; ?>
	<?php $j++; ?>
	<?php endwhile; ?>
	<?php endfor; ?>
	<?php foreach($persons as $person) : ?>
	<div style="float:left;width:230px;height:140px;background-color:#fff;border:1px solid;">
		<table style="padding:10px; margin:0px;">
			<tr style="background-color:#FFF;padding:0px; margin:0px">
				<td style="text-align:left;padding:0px; margin:0px;border-bottom:none;padding-left:10px">校別：<?php echo $person['System_Location']['location_name']; ?></td>
			</tr>
			<tr style="background-color:#FFF;padding:0px; margin:0px">
				<td style="text-align:left;padding:0px; margin:0px;border-bottom:none;padding-left:10px">姓名：<?php echo $person['Person']['name']; ?></td>
			</tr>
			<tr style="background-color:#FFF;padding:0px; margin:0px">
				<td style="text-align:left;padding:0px; margin:0px;border-bottom:none;padding-left:10px">學號：<?php echo $person['Person']['id']; ?></td>
			</tr>
			<tr style="background-color:#FFF;padding:0px; margin:0px">
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none"><? echo $this->html->image(array('controller' => 'graph', 'action'=> 'barcode39','P', $person['Person']['id'])); ?></td>
			</tr>
		</table>
	</div>
	<?php $total_div++; ?>
	<?php endforeach; ?>
	<?php while($total_div < 21) : ?>
	<div style="float:left;width:230px;height:140px;background-color:#fff;border:1px solid;">
		<table style="padding:10px; margin:0px;">
			<tr style="background-color:#FFF;padding:0px; margin:0px">
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none;"></td>
			</tr>
			<tr style="background-color:#FFF;padding:0px; margin:0px">
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none;"></td>
			</tr>
			<tr style="background-color:#FFF;padding:0px; margin:0px">
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none;"></td>
			</tr>
			<tr style="background-color:#FFF;padding:0px; margin:0px">
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none"></td>
			</tr>
		</table>
	</div>
	<?php $total_div++; ?>
	<?php endwhile; ?>
</div>
<?php endif; ?>