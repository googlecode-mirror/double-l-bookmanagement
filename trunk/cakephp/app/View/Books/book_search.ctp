
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
<div align="center"><?php
	if($count>0){
		$lastpage = ceil($count/$page_size);
		if($page>1){
			echo $this->html->link('<<', 'javascript:void(0);', array('class'=>'button','onclick'=>'change_page(1);'));
			echo '&nbsp;';
			echo $this->html->link('<', 'javascript:void(0);', array('class'=>'button','onclick'=>'change_page('.($page-1).');'));
		}
		echo '&nbsp;';
		echo '<select>';
		for($i=1;$i<=$lastpage;$i++){
			if($i==$page) $selected = 'selected';
			else $selected = '';
			echo '<option '.$selected.' onclick="change_page('.$i.')">'.$i.'</option>';
		}
		echo '</select>';
		echo '&nbsp;';
		
		if($lastpage > $page) {
		echo $this->html->link('>', 'javascript:void(0);', array('class'=>'button','onclick'=>'change_page('.($page+1).');'));
		echo '&nbsp;';
		echo $this->html->link('>>', 'javascript:void(0);', array('class'=>'button','onclick'=>'change_page('.$lastpage.');'));
		echo '&nbsp;';
		}
		echo '('.$count.')';
	}
?></div>
