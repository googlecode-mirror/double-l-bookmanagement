
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
<?php echo $this->element('book_search_zone'); ?>
<table>	
	<tr>
        <th>書籍名稱</th>
        <th>作者</th>
        <th>ISBN</th>
        <th></th>
	</tr>
	<?php foreach ($books as $book): ?>
	<tr>
        <td><?php echo $this->Html->link($book['Book']['book_name'], array('action' => 'book_search_view', $book['Book']['id']));?></td>
        <td><?php echo $book['Book']['book_author']; ?></td>		
        <td><?php echo $book['Book']['isbn']; ?></td>		
			

         		
	</tr>
    <?php endforeach; ?>
</table>
