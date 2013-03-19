<script>
	function printDiv(divName) {
		 var printContents = document.getElementById(divName).innerHTML;
		 var originalContents = document.body.innerHTML;
		 document.body.innerHTML = printContents;
		 window.print();
		 document.body.innerHTML = originalContents;
	}
</script>
<div class="pageheader_div"><h1 id="pageheader">書籍盤點清冊</h1></div>
<div class="pagemenu_div"><?php 
  	echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 
  	echo '&nbsp;';
  	echo $this->Html->link('列印清冊', "javascript:printDiv('print_div');", array('class' => 'button')); 
?></div>
<?php  if($this->Session->read('user_role') !== 'user')  { echo $this->Form->create('Book_Instance', array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); }?>
	<table>
		<tr>
			<td>學校
			<?php if ($this->Session->read('user_role') === 'admin') : ?>
				<?php echo $this->Form->select('location_id', $locations, array('empty' => false));?>
			<?php elseif ($this->Session->read('user_role') === 'localadmin'): ?>
				<?php echo $this->Form->text('location_id', array('value' => $this->Session->read('user_location'), 'readonly' => true));?>
			<?php endif;?>
			<?php echo $this->Form->submit('選取', array('div'=>false)); ?>
		</tr>
		<tr>
			<td colspan=3>
				<div id='print_div' align="center" cellspacing=0 cellpadding=0>
				<table>
					<tr>
						<th>書籍編號</th>
						<th>書籍名稱</th>
						<th>ISBN</th>
						<th>版本</th>
						<th>作者/編者</th>
						<th>出版廠商</th>						
						<th>位置</th>
						<th>購買日期</th>
						<th>地點</th>
						<th>狀態</th>
						<th>盤點</th>
					</tr>
					<?php foreach ($books as $book): ?>
					<tr>
						<td><?php echo $book['Book_Instance']['id']; ?></td>
						<td style="width:300px;word-wrap:break-word;word-break:break-all;"><?php echo $book['Book']['book_name']; ?></td>
						<td><?php echo $book['Book']['isbn']; ?></td>
						<td><?php echo $book['Book']['book_version']; ?></td>
						<td><?php echo $book['Book']['book_author']; ?></td>
						<td><?php echo $book['Book']['book_publisher']; ?></td>
						
						<td><?php echo $book['Book']['book_location']; ?></td>
						<td><?php echo $book['Book_Instance']['purchase_date']; ?></td>
						<td><?php echo $book['System_Location']['location_name']; ?></td>
						<td><?php echo $book['Book_Status']['status_name']; ?></td>
						<td><?php 
							if($book['System_Take_Stock']['id'] == null){
								echo '';
							} else {
								echo '已盤點';
							}		
						?></td>
					</tr>
					<?php endforeach; ?>
				</table>
				</div>
			</td>
		</tr>
	</table>
<?php  if($this->Session->read('user_role') !== 'user')  { echo $this->Form->end(); }?>