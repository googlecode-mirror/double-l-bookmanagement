  <?php 
    $book = $this->request->data["Book"];
    $book_instances = $this->request->data["Book_Instances"];
    if($book_instances == null ) {$book_instances=array();}
    if($book['id'] !== null) $page_title = '修改書籍基本資料';
    else $page_title = '新增書籍基本資料';
 ?>

 <script>
    $(function() {
        $(".jquery_date" ).datepicker({dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true});
    });
</script>
<div class="pageheader_div"><h1 id="pageheader"><?php echo $page_title; ?></h1></div>
<div class="pagemenu_div">
<?php 
    if($book['id'] !== null){
        echo $this->Html->link('更新圖片', array('action' => 'book_add_image', $book['id']), array('class' => 'button')); 
        echo '&nbsp;';
        echo $this->Html->link('更新中文圖片', array('action' => 'book_add_cn_image', $book['id']), array('class' => 'button')); 
        echo '&nbsp;';
    }
    echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 

?>
</div>
<?php
    echo $this->Form->create('Book',array('action'=>'book_edit',
                                            'enctype' => 'multipart/form-data', 
                                            'div'=>false, 
                                            'inputDefaults' => array('label' => false,'div' => false)));
	echo $this->Form->input('id', array('type'=> 'hidden'));
    echo $this->Form->input('book_type', array('type'=> 'hidden', 'value'=>'B'));
    echo $this->Form->input('book_image', array('type'=> 'hidden', 'value'=>$book['book_image']));
    $book = $this->request->data["Book"];
    $book_instances = $this->request->data["Book_Instances"];
	if($book_instances == null ) {$book_instances=array();}
?>
 <table><tr> 
    <td><table>
    <tr><td>書籍名稱 : <?php echo $this->Form->input('book_name', array('size'=>70)); ?></td></tr>
    <tr><td>副標題 : <?php echo $this->Form->input('book_title', array('size'=>70)); ?></td></tr>
    <tr><td>ISBN :  <?php echo $this->Form->input('isbn', array('size'=>15)); ?>
            版別  : <?php echo $this->Form->input('book_version', array('size'=>5)); ?>
            集叢書:<?php echo $this->Form->input('book_suite', array('size'=>40)); ?></td></tr>
    <tr><td>出版商 : <?php echo $this->Form->input('book_publisher', array('size'=>50)); ?>
            出版日期 : <?php echo $this->Form->text('publish_year', array( 'class' => 'ref_field', 'style'=>'width:120px'));?>  </td></tr>
    <tr><td>作者 : <?php echo $this->Form->input('book_author', array('size'=>40)); ?>
            附屬媒體 : <?php echo $this->Form->input('book_attachment', array('size'=>10)); ?> </td></tr>
    <tr><td>閱讀級別 : <?php echo $this->Form->input('lexile_level'); ?></td></tr>
    <tr><td>親子共讀 : <?php echo $this->Form->checkbox('book_ad', array('hiddenField' => false)); ?></td></tr>
    <tr><td>圖片上傳 : <?php echo $this->Form->input('Upload.file', array('between' => '','type' => 'file'));?></td></tr>
    <tr><td><?php echo $this->Form->end('儲存',array('label' => false,'div' => false)); ?></td></tr>
    </td></table>
    <td><?php echo $this->Html->image( $book['book_image'], array('height'=>'300px','width'=>'190px'));?></td>
</tr></table>

<table>
    <tr>
        <th>書籍編號</th>
        <th>購買金額</th>
        <th>書籍狀態</th>
        <th>借閱等級</th>
        <th>購買時間</th>
        <th>可以外借</th>
        <th>
            <?php echo $this->Html->link('新增書本', array('action' => 'book_instance_edit', $book['id']), array('class' => 'button')); ?>
        </th>
    </tr>
    <?php foreach ($book_instances as $book_instance): ?>
    <tr>
        <td><?php echo $book_instance['id']; ?></td>
        <td><?php echo $book_instance['purchase_price']; ?></td>
        <td><?php echo $book_status[$book_instance['book_status']]; ?></td>
        <td><?php echo $person_levels[$book_instance['level_id']]; ?></td>
        <td><?php echo $book_instance['purchase_date']; ?></td>
        <td><?php echo $book_instance['is_lend']; ?></td>
        <td><?php echo $this->Html->link('修改', array('action' => 'book_instance_edit', $book['id'], $book_instance['id']), array('class' => 'button')); ?></td>
    </tr>
    <?php endforeach; ?>
</table>
