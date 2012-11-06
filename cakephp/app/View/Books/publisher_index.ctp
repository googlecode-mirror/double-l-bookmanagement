<h1>書籍出版商資料</h1>
<p><?php echo $this->Html->link('新增出版商分類', array('action' => 'publisher_edit')); ?></p>
<table>
    <tr>
        <th>出版商號</th>
        <th>出版商名稱</th>
        <th>地址</th>
        <th>電話</th>
        <th>傳真</th>
        <th>業務姓名</th>
        <th>行動電話</th>
        <th>備註</th>
        <th>有效</th>
        <th>建立時間</th>
        <th></th>
    </tr>
    <?php foreach ($publishers as $publisher): ?>
    <tr>
        <td><?php echo $publisher['Book_Publisher']['id']; ?></td>
        <td>
            <?php echo $publisher['Book_Publisher']['comp_name']; ?>
        </td>
        <td>
            <?php echo $publisher['Book_Publisher']['address']; ?>
        </td>
        <td>
            <?php echo $publisher['Book_Publisher']['phone']; ?>
        </td>
        <td>
            <?php echo $publisher['Book_Publisher']['fax']; ?>
        </td>
        <td>
            <?php echo $publisher['Book_Publisher']['sales']; ?>
        </td>
        <td>
            <?php echo $publisher['Book_Publisher']['mobile_phone']; ?>
        </td>
        <td>
            <?php echo $publisher['Book_Publisher']['memo']; ?>
        </td>
        <td>
            <?php if ($publisher['Book_Publisher']['valid']) { echo 'Y'; } else {echo 'N';}; ?>
        </td>
        <td>
            <?php echo $publisher['Book_Publisher']['create_time']; ?>
        </td>
        <td>
            <?php 
				$delbtn = '生效';
				if ($publisher['Book_Publisher']['valid']) {
					echo $this->Html->link('修改', array('action' => 'publisher_edit', $publisher['Book_Publisher']['id']));
					$delbtn = '失效';
					echo '&nbsp';
				}
				echo $this->Form->postLink(
				$delbtn,
				array('action' => 'publisher_delete', $publisher['Book_Publisher']['id']),
				array('confirm' => '確認變更?'));
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
