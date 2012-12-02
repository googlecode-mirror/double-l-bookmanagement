 <script>
    $(function() {
        $(".jquery_date" ).datepicker({dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true});
    });
</script>
<div>
<h1 id="pageheader">書籍基本資料</h1>
</div>
<?php
    echo $this->Form->create('Book',array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false,'readonly'=>true)));
	echo $this->Form->input('id', array('type'=> 'hidden'));
    echo $this->Form->input('book_type', array('type'=> 'hidden', 'value'=>'B'));
    $book = $this->request->data["Book"];
    $book_instances = $this->request->data["Book_Instances"];
	if($book_instances == null ) {$book_instances=array();}
?>
<table>
<tr><td>書籍名稱 : <?php echo $this->Form->input('book_name'); ?></td></tr>
<tr><td>作者 : <?php echo $this->Form->input('book_author'); ?> 
        版別 <?php echo $this->Form->input('book_version'); ?></td></tr>
<tr><td>出版商 : <?php echo $this->Form->input('book_publisher'); ?> 
        附屬媒體 <?php echo $this->Form->input('book_attachment'); ?></td></tr>
<tr><td>出版日期 : <?php echo $this->Form->text('publish_date', array('style'=>'width:120px'));?> 
        ISBN <?php echo $this->Form->input('isbn'); ?></td></tr>
<tr><td>書籍分類 : <?php echo $this->Form->input('cate_id'); ?>
        索書號 : <?php echo $this->Form->input('book_search_code'); ?>
        櫃別 : <?php echo $this->Form->input('book_location'); ?></td></tr>
<tr><td>備註 : <?php echo $this->Form->input('memo'); ?></td></tr>
</table>
<?php echo $this->Form->end(); ?>
<table>
    <tr>
        <th>書籍編號</th>
        <th>購買金額</th>
        <th>書籍狀態</th>
        <th>借閱等級</th>
        <th>購買時間</th>
        <th>預計歸還時間</th>
        <th>可以外借</th>
        <th>
            <?php
                if($this->Session->read('user_role') !== 'user') {
                    echo $this->Html->link('新增書本', array('action' => 'book_instance_edit', $book['id'])); 
                }
            ?>
        </th>
    </tr>
    <?php foreach ($book_instances as $book_instance): ?>
    <tr>
        <td><?php echo $book_instance['id']; ?></td>
        <td><?php echo $book_instance['purchase_price']; ?></td>
        <td><?php echo $book_status[$book_instance['book_status']]; ?></td>
        <td><?php echo $book_instance['level_id']; ?></td>
        <td><?php echo $book_instance['purchase_date']; ?></td>
        <td><?php echo $book_instance['s_return_date']; ?></td>
        <td><?php echo $book_instance['is_lend']; ?></td>
        <td><?php 
                if($this->Session->read('user_role') !== 'user') {
                    echo $this->Html->link('修改', array('action' => 'book_instance_edit', $book['id'], $book_instance['id'])); 
                }
        ?></td>
    </tr>
    <?php endforeach; ?>
</table>
