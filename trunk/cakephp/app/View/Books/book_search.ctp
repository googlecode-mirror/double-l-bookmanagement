
<div class="pageheader_div"><h1 id="pageheader">在庫搜尋</h1></div>
<div class="pagemenu_div"><?php 
  	echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 
  	echo '&nbsp;';
?></div>


<script type="text/javascript">
	function change_page(page_no) {
		$("#BookPage").val(page_no);
		$("#BookBookSearchForm").submit();
	}
</script>
<table>
	<tr>
        <td>
		<?php echo $this->Form->create('Book',array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); ?>
			<table>
				<tr>
					<td style="width:100px">閱讀等級</td>
					<td><?php echo $this->Form->select('cate', $cates);?></td>
					<!--
					<td style="width:100px">借閱等級</td>
					<td><?php echo $this->Form->select('level', $levels);?></td>
					-->
				</tr>
				<tr>
					<td style="width:100px" >書籍名稱</td>
					<td colspan=3><?php echo $this->Form->input('book_name', array('size'=>80));?></td>
				</tr>
				<tr>
					<td style="width:100px">ISBN</td>
					<td><?php echo $this->Form->input('isbn', array('size'=>20));?></td>
					<td style="width:100px"></td>
					<td></td>
				</tr>
				<tr>
					<td style="width:100px">出版社</td>
					<td><?php echo $this->Form->input('publisher');?></td>
					<td style="width:100px">作者</td>
					<td><?php echo $this->Form->input('author');?></td>
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
</table>
<table>	
	<tr>
        <th>書籍名稱</th>
        <th>作者</th>
        <th>ISBN</th>
        <th></th>
	</tr>
	<?php foreach ($books as $book): ?>
	<tr>
        <td><?php echo $book['books']['book_name']; ?></td>
        <td><?php echo $book['books']['book_author']; ?></td>		
        <td><?php echo $book['books']['isbn']; ?></td>		
			

 	<td><?php
        echo $this->Html->link('查看', array('action' => 'book_search_view', $book['books']['id']), array('class' => 'button'));
	?></td>            		
	</tr>
    <?php endforeach; ?>
	<tr>
        <td colspan=4>
		<?php 
			$start_page = $page - 3;
			if ($start_page < 1) {$start_page = 1;}
			$end_page = $page + 3;
			if ($end_page > $books_page) {$end_page = $books_page;}
			for($i = $start_page; $i<=$end_page;$i++) {
				if ($page <> $i) {
					echo $this->html->link($i, 'javascript:void(0);', array('onclick'=>'change_page('.$i.');'));
				}
				else {
					echo $i;
				}
			}
			echo '(共 '.$books_page.' 頁，'.$books_cnt.' 筆)';
		?>
		</td>
	</tr>
</table>
