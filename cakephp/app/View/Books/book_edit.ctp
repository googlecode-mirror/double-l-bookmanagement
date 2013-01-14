  <?php 
    $book = $this->request->data["Book"];
    $book_instances = $this->request->data["Book_Instances"];
    if($book_instances == null ) {$book_instances=array();}
 ?>

 <script>
    $(function() {
        $(".jquery_date" ).datepicker({dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true});
    });
</script>
<div class="pageheader_div"><h1 id="pageheader">修改書籍基本資料</h1></div>
<div class="pagemenu_div"></div>
<?php
    echo $this->Form->create('Book',array('action'=>'book_edit','div'=>false, 'inputDefaults' => array('label' => false,'div' => false)));
	echo $this->Form->input('id', array('type'=> 'hidden'));
    echo $this->Form->input('book_type', array('type'=> 'hidden', 'value'=>'B'));
    echo $this->Form->input('book_image', array('type'=> 'hidden', 'value'=>$book['book_image']));
    $book = $this->request->data["Book"];
    $book_instances = $this->request->data["Book_Instances"];
	if($book_instances == null ) {$book_instances=array();}
?>
<div id="book_zone">
<div id="book_info" style="float:left; clear:left;">
<table>
<tr><td>書籍名稱 : <?php echo $this->Form->input('book_name'); ?>
        副標題 : <?php echo $this->Form->input('book_title', array('size'=>50)); ?></td></tr>
<tr><td>作者 : <?php echo $this->Form->input('book_author'); ?> 
        版別 <?php echo $this->Form->input('book_version', array('size'=>5)); ?>
        集叢書:<?php echo $this->Form->input('book_suite', array('size'=>20)); ?></td></tr>
<tr><td>出版日期 : <?php echo $this->Form->text('publish_date', array('readonly'=>true, 'class' => 'ref_field, jquery_date', 'style'=>'width:120px'));?> 
        ISBN <?php echo $this->Form->input('isbn', array('size'=>10)); ?>
        出版商 : <?php echo $this->Form->input('book_publisher'); ?> 
        附屬媒體 <?php echo $this->Form->input('book_attachment', array('size'=>10)); ?></td></tr>
<tr><td>閱讀級別 : <?php echo $this->Form->input('cate_id', array('div' => false, 'label' => false)); ?>
        索書號 : <?php echo $this->Form->input('book_search_code', array('div' => false, 'label' => false)); ?>
        櫃別 : <?php echo $this->Form->input('book_location', array('div' => false, 'label' => false)); ?></td></tr>
<tr><td>備註 : <?php echo $this->Form->input('memo', array('div' => false, 'label' => false)); ?></td></tr>
</table>
</div>
<div id="book_image" style="float:left; clear:right;">
<?php echo $this->Html->image( $book['book_image'], array('height'=>'300px','width'=>'190px'));?>
</div>
</div>
<?php echo $this->Form->end('儲存'); ?>
<table>
    <tr>
        <th>書籍編號</th>
        <th>購買金額</th>
        <th>書籍狀態</th>
        <th>借閱等級</th>
        <th>購買時間</th>
        <th>可以外借</th>
        <th>
            <?php echo $this->Html->link('新增書本', array('action' => 'book_instance_edit', $book['id'])); ?>
        </th>
    </tr>
    <?php foreach ($book_instances as $book_instance): ?>
    <tr>
        <td><?php echo $book_instance['id']; ?></td>
        <td><?php echo $book_instance['purchase_price']; ?></td>
        <td><?php echo $book_status[$book_instance['book_status']]; ?></td>
        <td><?php echo $book_instance['level_id']; ?></td>
        <td><?php echo $book_instance['purchase_date']; ?></td>
        <td><?php echo $book_instance['is_lend']; ?></td>
        <td><?php echo $this->Html->link('修改', array('action' => 'book_instance_edit', $book['id'], $book_instance['id'])); ?></td>
    </tr>
    <?php endforeach; ?>
</table>
