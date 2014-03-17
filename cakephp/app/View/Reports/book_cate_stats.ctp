<div class="pageheader_div"><h1 id="pageheader">書籍級別借閱統計</h1></div>
<div class="pagemenu_div"><?php 
	echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 
?></div>
<script type="text/javascript">
    $(function() {
        $(".jquery_date" ).datepicker({dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true});
        $(".jquery_date" ).datepicker({dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true});
    });
 
	function change_page(page_no) {
		$("#BookPage").val(page_no);
		$("#BookBookCateStatsForm").submit();
	}

	function export_stat(){
  		url = '<?php  echo $this->Html->url(array("controller" => "reports","action" => "book_stat_export"));?>';
  		url = url+'?cate='+$("#BookCate").val()+'&star_date='+$("#BookStartDate").val()+'&end_date='+$("#BookEndDate").val();
  		window.location.href=url;
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
					<?php echo $this->Html->link('匯出清冊','javascript:void(0);',  array('class' => 'button','onclick'=>'export_stat();'));?>
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
