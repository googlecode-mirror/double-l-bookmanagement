<h1>雜誌資料列表</h1>
<table>
	<tr>
        <th>雜誌名稱</th>
        <th>出版社</th>
        <th>ISSN</th>
        <th>分類</th>

        <th>
            <?php echo $this->Html->link('新增', array('action' => 'journal_edit')); ?>
        </th>	
	</tr>
	<?php foreach ($books as $book): ?>
	<tr>
        <td><?php echo $book['Book']['book_name']; ?></td>
        <td><?php echo $book['Book']['book_publisher']; ?></td>		
        <td><?php echo $book['Book']['isbn']; ?></td>		
        <td><?php echo $book['Book']['cate_id']; ?></td>		
 	<td><?php
 	      echo $this->Html->link('修改', array('action' => 'journal_edit', $book['Book']['id']));
	?></td>            		
	</tr>
	 <?php endforeach; ?>
</table>
