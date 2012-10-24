<h1>書籍分類資料</h1>
<p><?php echo $this->Html->link('新增書籍分類', array('action' => 'catagory_add')); ?></p>
<table>
    <tr>
        <th>分類號</th>
        <th>分類名稱</th>
        <th>建立時間</th>
        <th></th>
    </tr>
    <?php foreach ($cates as $cate): ?>
    <tr>
        <td><?php echo $cate['Book_Cate']['id']; ?></td>
        <td>
            <?php echo $cate['Book_Cate']['catagory_name']; ?>
        </td>
        <td>
            <?php echo $cate['Book_Cate']['create_time']; ?>
        </td>
        <td>
            <?php echo $this->Form->postLink(
                '刪除',
                array('action' => 'catagory_delete', $cate['Book_Cate']['id']),
                array('confirm' => '確認刪除?'));
            ?>
            <?php echo $this->Html->link('修改', array('action' => 'catagory_edit', $cate['Book_Cate']['id'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
