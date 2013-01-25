<div id="pageheader">
<h1>書籍搜尋</h1>
</div>
<table>
	<tr>
        <td>
		<?php echo $this->Form->create('Book',array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); ?>
			<table>
				<tr>
					<td style="width:100px">書籍分類</td>
					<td><?php echo $this->Form->select('cate', $cates);?></td>
					<td style="width:100px">借閱等級</td>
					<td><?php echo $this->Form->select('level', $levels);?></td>
				</tr>
				<tr>
					<td style="width:100px">書籍名稱</td>
					<td><?php echo $this->Form->input('book_name');?></td>
					<td style="width:100px">備註</td>
					<td><?php echo $this->Form->input('remark');?></td>
				</tr>
				<tr>
					<td style="width:100px">ISBN</td>
					<td><?php echo $this->Form->input('isbn');?></td>
					<td style="width:100px">索書號</td>
					<td><?php echo $this->Form->input('search_code');?></td>
				</tr>
				<tr>
					<td style="width:100px">出版社</td>
					<td><?php echo $this->Form->input('publisher');?></td>
					<td style="width:100px">作者</td>
					<td><?php echo $this->Form->input('author');?></td>
				</tr>
				<tr>
					<td style="width:100px">櫃位</td>
					<td><?php echo $this->Form->input('location');?></td>
				</tr>
				<tr>
					<td colspan=4>
					<?php echo $this->Form->hidden('books_sort', array('value'=>$books_sort));?>
					<?php echo $this->Form->hidden('page', array('value'=>$page));?>
					<?php echo $this->Form->submit('搜尋', array('div'=>false));?>
					</td>
				</tr>
			</table>
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
        <td><?php echo $book['books']['book_name']; ?></td>
        <td><?php echo $book['books']['book_author']; ?></td>		
        <td><?php echo $book['books']['isbn']; ?></td>		
        <td><?php echo $book['books']['book_version']; ?></td>		
        <td><?php echo $book['books']['book_search_code']; ?></td>		
        <td><?php echo $book['books']['book_location']; ?></td>		
		<td><?php echo $book[0]['cnt']; ?></td>
 	<td><?php
        echo $this->Html->link('查看', array('action' => 'book_search_view', $book['books']['id']));
	?></td>            		
	</tr>
	 <?php endforeach; ?>
</table>
