<div>
<div class="pageheader_div"><h1 id="pageheader">書籍資料列表</h1></div>
<div class="pagemenu_div"><?php 
    echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 
    echo '&nbsp;';
    echo $this->Html->link('新增', array('action' => 'book_edit'), array('class' => 'button blue'));
?></div>
<div class="pagemenu_div"><?php 
    
    if($this->Session->read('user_role') !== 'user') {
    echo $this->Form->create('Book',array('action'=>'isbn_add', 'clear'=>'right','div'=>false, 'inputDefaults' => array('label' => false,'div' => false)));
    echo 'ISBN:';
    echo $this->Form->input('isbn', array('size'=>10));
    echo $this->Form->button('新增');
    echo $this->Form->end();
    echo '&nbsp;';
    }
    
?>
</div>
<div class="pagemenu_div">
    <p><?php
            echo $this->Html->link(
            $this->Html->image("excel.jpg", array("alt" => "export")),
            "book_export",
            array('escape' => false)
            );
    ?></p>
</div>
<?php echo $this->element('book_search_zone'); ?>
<table>
	<tr>
        <th>書籍名稱</th>
        <th>作者</th>
        <th>ISBN</th>
        <th width="60px">閱讀級別</th>
        <th width="30px">數量</th>
	</tr>
	<?php foreach ($books as $book): ?>
	<tr>
        
        <td><?php echo $this->Html->link($book['Book']['book_name'], array('action' => 'book_view', $book['Book']['id']));?></td>
        <td><?php echo $book['Book']['book_author']; ?></td>		
        <td><?php echo $book['Book']['isbn']; ?></td>		
        <td align="right"><?php echo $book["Book"]["lexile_level"]; ?></td>		
		<td><?php echo sizeof($book["Book_Instances"]); ?></td>       		
	</tr>
	 <?php endforeach; ?>
</table>
