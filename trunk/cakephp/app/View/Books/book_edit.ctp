<h1>修改書籍基本資料</h1>
<?php
    echo $this->Form->create('Book');
	echo $this->Form->input('id', array('type'=> 'hidden'));
    echo $this->Form->input('book_type', array('type'=> 'hidden', 'value'=>'B'));
    $book = $this->request->data["Book"];
    $book_instances = $this->request->data["Book_Instances"];
?>
<table>
<tr><td>書籍名稱 : <?php echo $this->Form->input('book_name', array('div' => false, 'label' => false)); ?></td></tr>
<tr><td>作者 : <?php echo $this->Form->input('book_author', array('div' => false, 'label' => false)); ?> 
        版別 <?php echo $this->Form->input('book_version', array('div' => false, 'label' => false)); ?></td></tr>
<tr><td>出版商 : <?php echo $this->Form->input('book_publisher', array('div' => false, 'label' => false)); ?> 
        附屬媒體 <?php echo $this->Form->input('book_attachment', array('div' => false, 'label' => false)); ?></td></tr>
<tr><td>出版日期 : <?php echo $this->Form->input('publish_date',  array('dateFormat' => 'YMD','div' => false, 'label' => false)); ?> 
        ISBN <?php echo $this->Form->input('isbn', array('div' => false, 'label' => false)); ?></td></tr>
<tr><td>書籍分類 : <?php echo $this->Form->input('cate_id', array('div' => false, 'label' => false)); ?>
        索書號 : <?php echo $this->Form->input('book_search_code', array('div' => false, 'label' => false)); ?>
        櫃別 : <?php echo $this->Form->input('book_location', array('div' => false, 'label' => false)); ?></td></tr>
<tr><td>備註 : <?php echo $this->Form->input('memo', array('div' => false, 'label' => false)); ?></td></tr>
</table>
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
            <?php echo $this->Html->link('新增', array('action' => 'book_instance_edit', $book['id'])); ?>
        </th>
    </tr>
    <?php foreach ($book_instances as $book_instance): ?>
    <tr>
        <td><?php echo $book_instance['id']; ?></td>
        <td><?php echo $book_instance['purchase_price']; ?></td>
        <td><?php echo $book_instance['book_status']; ?></td>
        <td><?php echo $book_instance['person_level']; ?></td>
        <td><?php echo $book_instance['purchase_date']; ?></td>
        <td><?php echo $book_instance['is_lend']; ?></td>
        <td><?php echo $this->Html->link('修改', array('action' => 'book_instance_edit', $book['id'], $book_instance['id'])); ?></td>
    </tr>

    <?php endforeach; ?>
</table>
