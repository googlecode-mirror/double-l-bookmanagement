<h1>書籍分類資料</h1>
<p><?php echo $this->Html->link('新增書籍分類', array('action' => 'catagory_edit')); ?></p>
<table>
    <tr>
        <th>分類號</th>
        <th>分類名稱</th>
        <th>有效</th>
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
            <?php if ($cate['Book_Cate']['valid']) { echo 'Y'; } else {echo 'N';}; ?>
        </td>
        <td>
            <?php echo $cate['Book_Cate']['create_time']; ?>
        </td>
        <td>
            <?php 
				$delbtn = '生效';
				if ($cate['Book_Cate']['valid']) {
					echo $this->Html->link('修改', array('action' => 'catagory_edit', $cate['Book_Cate']['id']));
					$delbtn = '失效';
					echo '&nbsp';
				}
				echo $this->Form->postLink(
				$delbtn,
				array('action' => 'catagory_delete', $cate['Book_Cate']['id']),
				array('confirm' => '確認變更?'));
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
