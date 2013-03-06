<h1>人員職務名稱資料</h1>
<table>
    <tr>
        <th>職務號</th>
        <th>職務名稱</th>
        <th>有效</th>
        <th>建立時間</th>
        <th><?php echo $this->Html->link('新增職務名稱', array('action' => 'title_edit'), array('class' => 'button')); ?></th>
    </tr>
    <?php foreach ($titles as $title): ?>
    <tr>
        <td><?php echo $title['Person_Title']['id']; ?></td>
        <td>
            <?php echo $title['Person_Title']['title_name']; ?>
        </td>
        <td>
            <?php if ($title['Person_Title']['valid']) { echo 'Y'; } else {echo 'N';}; ?>
        </td>
        <td>
            <?php echo $title['Person_Title']['create_time']; ?>
        </td>
        <td>
            <?php 
				$delbtn = '生效';
				if ($title['Person_Title']['valid']) {
					echo $this->Html->link('修改', array('action' => 'title_edit', $title['Person_Title']['id']), array('class' => 'button'));
					$delbtn = '失效';
					echo '&nbsp';
				}
				echo $this->Form->postLink(
				$delbtn,
				array('action' => 'title_delete', $title['Person_Title']['id']),
				array('class'=>'button','confirm' => '確認變更?'));
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
