<div id="pageheader">
<h1>書籍搜尋</h1>
</div>
<table>
	<tr>
        <td>
		<?php echo $this->Form->create('Book_Instance',array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); ?>
		書籍名稱<?php echo $this->Form->input('keyword');?><?php echo $this->Form->submit('搜尋');?>
		<?php echo $this->Form->end(); ?>
		</td>
	</tr>
	<tr>
        <th>書籍名稱</th>
        <th>作者</th>
        <th>ISBN</th>
        <th>版本名稱</th>
        <th>索書號</th>
        <th>櫃別</th>
        <th>數量</th>
	</tr>
	<?php foreach ($books as $book): ?>
	<tr>
        <td><?php echo $book['Book']['book_name']; ?></td>
        <td><?php echo $book['Book']['book_author']; ?></td>		
        <td><?php echo $book['Book']['isbn']; ?></td>		
        <td><?php echo $book['Book']['book_version']; ?></td>		
        <td><?php echo $book['Book']['book_search_code']; ?></td>		
        <td><?php echo $book['Book']['book_location']; ?></td>		
		<td><?php echo sizeof($book["Book_Instances"]); ?></td>
 	<td><?php
        echo $this->Html->link('查看', array('action' => 'book_view', $book['Book']['id']));
	?></td>            		
	</tr>
	 <?php endforeach; ?>
</table>
