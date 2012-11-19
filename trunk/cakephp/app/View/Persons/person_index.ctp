<h1>借閱者基本資料</h1>
<p></p>
<table>
    <tr>
        <th>借卡代號</th>
        <th>姓名</th>
		<th>性別</th>
		<th>群組</th>
		<th>職稱</th>
		<th>借閱等級</th>
		<th>聯絡電話</th>
		<th>發卡日期</th>
		<th>有效</th>
        <th>建立時間</th>
        <th><?php echo $this->Html->link('新增借閱者', array('action' => 'person_edit')); ?></th>
    </tr>
    <?php foreach ($persons as $person): ?>
    <tr>
        <td><?php echo $person['Person']['id']; ?></td>
        <td><?php echo $person['Person']['name']; ?></td>
        <td><?php echo $person_genders[$person['Person']['gender']]; ?></td>
        <td><?php echo $person_groups[$person['Person']['group_id']]; ?></td>
        <td><?php echo $person_levels[$person['Person']['level_id']]; ?></td>
        <td><?php echo $person_titles[$person['Person']['title_id']]; ?></td>
        <td><?php echo $person['Person']['phone']; ?></td>
		<td><?php echo $person['Person']['card_create_date']; ?></td>
        <td>
            <?php if ($person['Person']['valid']) { echo 'Y'; } else {echo 'N';}; ?>
        </td>
        <td>
            <?php echo $person['Person']['create_time']; ?>
        </td>
        <td>
            <?php 
				$delbtn = '生效';
				if ($person['Person']['valid']) {
					echo $this->Html->link('修改', array('action' => 'person_edit', $person['Person']['id']));
					$delbtn = '失效';
					echo '&nbsp';
				}
				echo $this->Form->postLink(
				$delbtn,
				array('action' => 'person_delete', $person['Person']['id']),
				array('confirm' => '確認變更?'));
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
