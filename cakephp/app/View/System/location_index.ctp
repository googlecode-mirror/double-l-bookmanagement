<h1>系統地點名稱資料</h1>
<table>
    <tr>
        <th>地點代號</th>
        <th>地點名稱</th>
        <th>有效</th>
        <th>建立時間</th>
        <th><?php echo $this->Html->link('新增地點', array('action' => 'location_edit')); ?></th>
    </tr>
    <?php foreach ($titles as $title): ?>
    <tr>
        <td><?php echo $title['System_Location']['id']; ?></td>
        <td>
            <?php echo $title['System_Location']['location_name']; ?>
        </td>
        <td>
            <?php if ($title['System_Location']['valid']) { echo 'Y'; } else {echo 'N';}; ?>
        </td>
        <td>
            <?php echo $title['System_Location']['create_time']; ?>
        </td>
        <td>
            <?php 
				$delbtn = '生效';
				if ($title['System_Location']['valid']) {
					echo $this->Html->link('修改', array('action' => 'location_edit', $title['System_Location']['id']));
					$delbtn = '失效';
					echo '&nbsp';
				}
				echo $this->Form->postLink(
				$delbtn,
				array('action' => 'location_delete', $title['System_Location']['id']),
				array('confirm' => '確認變更?'));
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
