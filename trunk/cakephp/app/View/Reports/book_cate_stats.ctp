<div id="pageheader">
<h1>書籍搜尋</h1>
</div>
<script type="text/javascript">
    $(function() {
        $(".jquery_date" ).datepicker({dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true});
        $(".jquery_date" ).datepicker({dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true});
    });
 
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
					<td style="width:100px">開始日期</td>
					<td><?php echo $this->Form->input('start_date', array('class'=>'jquery_date'));?></td>
					<td style="width:100px">結束日期</td>
					<td><?php echo $this->Form->input('end_date', array('class'=>'jquery_date'));?></td>
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
        <th>出借分校</th>
        <th>出借次數</th>
	</tr>
	<?php foreach ($books as $book): ?>
	<tr>
        <td><?php echo $book['books']['book_name']; ?></td>
        <td><?php echo $book['books']['book_author']; ?></td>		
        <td><?php echo $book['books']['isbn']; ?></td>		
        <td><?php echo $book['books']['book_version']; ?></td>		
        <td><?php echo $book['books']['book_search_code']; ?></td>		
        <td><?php echo $book['system_locations']['location_name']; ?></td>		
        <td><?php echo $book[0]['cnt']; ?></td>		         		
	</tr>
    <?php endforeach; ?>
	<tr>
        <td colspan=7>
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
