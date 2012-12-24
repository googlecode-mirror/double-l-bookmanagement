<script>
	function printDiv(divName) {
		 var printContents = document.getElementById(divName).innerHTML;
		 var originalContents = document.body.innerHTML;
		 document.body.innerHTML = printContents;
		 window.print();
		 document.body.innerHTML = originalContents;
	}
</script>
<?php if (empty($books)): ?>
<?php 	echo $this->Form->create('Book_Instance',array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); ?>
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
<?php echo $this->html->link('回搜尋頁',array('controller'=>'books','action'=>'print_book_barcode'));?>&nbsp;
<?php echo $this->html->link('列印標簽',"javascript:printDiv('print_div');");?>
<div id='print_div' align="center" cellspacing=0 cellpadding=0 style="width:700px;">
	<?php $total_div = 0; ?>
	<?php for($i=1;$i<=$intY;$i++) : ?>
	<?php $j =1; ?>
	<?php while((($j<=3) && ($i<$intY) )|| (($j<$intX) && ($i==$intY))) : ?>
	<div style="float:left;width:230px;height:110px;background-color:#fff;border:1px solid;">
		<table style="padding:0px; margin:0px">
			<tr style="background-color:#FFF;padding:0px; margin:0px";>
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none"></td>
			</tr>
			<tr style="background-color:#FFF;padding:0px; margin:0px">
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none"></td>
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
	<?php foreach($books as $book) : ?>
	<div style="float:left;width:230px;height:110px;background-color:#fff;border:1px solid;">
		<table style="padding:0px; margin:0px;">
			<tr style="background-color:#FFF;padding:0px; margin:0px";>
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none">哥大英語圖書館</td>
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none" rowspan=2>
					<table style="width:40px;height:40px;border:1px solid black;margin-top:15px;background-color:<?php echo $book["Book"]["Book_Cate"]['catagory_color'] ?>"><tr><td style="border:none"></td></tr></table>
				</td>
			</tr>
			<tr style="background-color:#FFF;padding:0px; margin:0px">
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none"><? echo $this->html->image(array('controller' => 'graph', 'action'=> 'barcode39','B', $book['Book_Instance']['id'])); ?></td>
			</tr>
			<tr style="background-color:#FFF;padding:0px; margin:0px">
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none;font-size:10px;word-break:break-all" colspan=2><? echo substr($book['Book']['book_name'],0,64); ?></td>
			</tr>
		</table>
	</div>
	<?php $total_div++; ?>
	<?php endforeach; ?>
	<?php while($total_div < 27) : ?>
	<div style="float:left;width:230px;height:110px;background-color:#fff;border:1px solid;">
		<table style="padding:0px; margin:0px;">
			<tr style="background-color:#FFF;padding:0px; margin:0px";>
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none"></td>
			</tr>
			<tr style="background-color:#FFF;padding:0px; margin:0px">
				<td style="text-align:center;padding:0px; margin:0px;border-bottom:none"></td>
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