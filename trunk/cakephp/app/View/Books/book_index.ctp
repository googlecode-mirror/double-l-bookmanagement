<div id="pageheader">
<h1>書籍資料列表</h1>
</div>
<table>
	<tr>
        <th>書籍名稱</th>
        <th>作者</th>
        <th>ISBN</th>
        <th>版本名稱</th>
        <th>索書號</th>
        <th>櫃別</th>
        <th>數量</th>
        <th>
            <?php echo $this->Html->link('新增書籍', array('action' => 'book_edit')); ?>
        </th>	
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
