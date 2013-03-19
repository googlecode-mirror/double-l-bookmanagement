<div>
<div class="pageheader_div"><h1 id="pageheader">書籍資料列表</h1></div>
<div class="pagemenu_div"><?php echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); ?></div>
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
<p>         <?php
            echo $this->Html->link(
            $this->Html->image("excel.jpg", array("alt" => "export")),
            "book_export",
            array('escape' => false)
            );
            ?></p>
</div>
<table>
	<tr>
        <th>書籍名稱</th>
        <th>作者</th>
        <th>ISBN</th>
        <th>閱讀級別</th>
        <th>數量</th>
        <th width="50px">
            <?php echo $this->Html->link('新增', array('action' => 'book_edit'), array('class' => 'button blue')); ?>
        </th>	
	</tr>
	<?php foreach ($books as $book): ?>
	<tr>
        <td><?php echo $book['Book']['book_name']; ?></td>
        <td><?php echo $book['Book']['book_author']; ?></td>		
        <td><?php echo $book['Book']['isbn']; ?></td>		
        <td><?php echo $book["Book"]["lexile_level"]; ?></td>		
		<td><?php echo sizeof($book["Book_Instances"]); ?></td>
		<td width="50px">
			<?php echo $this->Html->link('查看', array('action' => 'book_view', $book['Book']['id']), array('class' => 'button'));?>
		</td>            		
	</tr>
	 <?php endforeach; ?>
</table>
