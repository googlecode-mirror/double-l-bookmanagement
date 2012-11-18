<h1>修改期刊基本資料</h1>
<?php    
    $book = $this->request->data["Book"];
    $book_instances = $this->request->data["Book_Instances"];
?>
<?php echo $this->Form->create('Book'); ?>
<?php echo $this->Form->input('id', array('type'=> 'hidden')); ?>
<?php echo $this->Form->input('book_type', array('type'=> 'hidden', 'value'=>'M')); ?>
<table>
<tr><td>期刊名稱 : <?php echo $this->Form->input('book_name', array('div' => false, 'label' => false)); ?></td></tr>
<tr><td>ISSN <?php echo $this->Form->input('isbn', array('div' => false, 'label' => false)); ?></td></tr>
<tr><td>
    刊   期 : <?php echo $this->Form->input('book_version', array('div' => false, 'label' => false)); ?>
    出版商 : <?php echo $this->Form->input('book_publisher', array('div' => false, 'label' => false)); ?> 
</td></tr>
<tr><td>
    創刊日期 : <?php echo $this->Form->input('publish_date',  array('dateFormat' => 'YMD','div' => false, 'label' => false)); ?> 
    書籍分類 : <?php echo $this->Form->input('cate_id', array('div' => false, 'label' => false)); ?>
</td></tr>
<tr><td>
    訂購日期 :
        <?php echo $this->Form->input('order_start_date',  array('dateFormat' => 'YMD','div' => false, 'label' => false)); ?> 
        到
        <?php echo $this->Form->input('order_end_date',  array('dateFormat' => 'YMD','div' => false, 'label' => false)); ?> 
</td></tr>
<tr><td>
    訂購期別 :
        <?php echo $this->Form->input('order_start_version',  array('dateFormat' => 'YMD','div' => false, 'label' => false)); ?> 
        到
        <?php echo $this->Form->input('order_end_version',  array('dateFormat' => 'YMD','div' => false, 'label' => false)); ?> 
</td></tr>

<tr><td>備註 : <?php echo $this->Form->input('memo', array('div' => false, 'label' => false)); ?></td></tr>
</table>
<?php echo $this->Form->end('儲存'); ?>
<table>
    <tr>
        <th>期別</th>
        <th>發行日期</th>
        <th>雜誌編號</th>
        <th>狀態</th>
        <th>可以外借</th>
        <th>
            <?php echo $this->Html->link('新增', array('action' => 'journal_instance_edit', $book['id'])); ?>
        </th>
    </tr>
    <?php foreach ($book_instances as $book_instance): ?>
    <tr>
        <td><?php echo $book_instance['book_version']; ?></td>
        <td><?php echo $book_instance['purchase_date']; ?></td>
        <td><?php echo $book_instance['id']; ?></td>
        <td><?php echo $book_instance['book_status']; ?></td>
        <td><?php echo $book_instance['is_lend']; ?></td>
        <td><?php echo $this->Html->link('修改', array('action' => 'journal_instance_edit', $book['id'], $book_instance['id'])); ?></td>
    </tr>

    <?php endforeach; ?>
</table>
