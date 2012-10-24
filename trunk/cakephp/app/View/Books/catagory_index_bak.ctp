<h1>書籍分類資料</h1>
<p><?php echo $this->Html->link('新增書籍分類', array('action' => 'catagory_add')); ?></p>
<table>
    <tr>
        <th>分類號</th>
        <th>分類名稱</th>
        <th>建立時間</th>
    </tr>

<!-- Here's where we loop through our $posts array, printing out post info -->

    <?php foreach ($cates as $cate): ?>
    <tr>
        <td><?php echo $cate['Post']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($cate['Post']['title'], array('action' => 'view', $cate['Post']['id'])); ?>
        </td>
        <td>
            <?php echo $this->Form->postLink(
                '刪除',
                array('action' => 'catagory_delete', $cate['Post']['id']),
                array('confirm' => '確認刪除?'));
            ?>
            <?php echo $this->Html->link('修改', array('action' => 'catagory_edit', $cate['Post']['id'])); ?>
        </td>
        <td>
            <?php echo $cate['Post']['create_time']; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
