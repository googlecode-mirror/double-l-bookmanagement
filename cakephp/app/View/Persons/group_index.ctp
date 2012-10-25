<h1>借閱者群組資料</h1>
<p><?php echo $this->Html->link('新增群組名稱', array('action' => 'group_edit')); ?></p>
<table>
    <tr>
        <th>群組號</th>
        <th>群組名稱</th>
        <th>有效</th>
        <th>建立時間</th>
        <th></th>
    </tr>
    <?php foreach ($groups as $group): ?>
    <tr>
        <td><?php echo $group['Person_Group']['id']; ?></td>
        <td>
            <?php echo $group['Person_Group']['group_name']; ?>
        </td>
        <td>
            <?php if ($group['Person_Group']['valid']) { echo 'Y'; } else {echo 'N';}; ?>
        </td>
        <td>
            <?php echo $group['Person_Group']['create_time']; ?>
        </td>
        <td>
            <?php 
				$delbtn = '生效';
				if ($group['Person_Group']['valid']) {
					echo $this->Html->link('修改', array('action' => 'group_edit', $group['Person_Group']['id']));
					$delbtn = '失效';
					echo '&nbsp';
				}
				echo $this->Form->postLink(
				$delbtn,
				array('action' => 'group_delete', $group['Person_Group']['id']),
				array('confirm' => '確認變更?'));
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
