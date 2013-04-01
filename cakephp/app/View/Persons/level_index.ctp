<div class="pageheader_div"><h1 id="pageheader">借閱者等級權限資料</h1></div>
<div class="pagemenu_div"><?php 
  	echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 
  	echo '&nbsp;';
?></div>  
<table>
    <tr>
        <th>等級權限號</th>
        <th>等級權限名稱</th>
		<th>借閱天數</th>
		<th>借閱數量</th>
		<th>可跨校借閱</th>
        <th>有效</th>
        <th>建立時間</th>
        <th><?php echo $this->Html->link('新增群組名稱', array('action' => 'level_edit'), array('class' => 'button')); ?></th>
    </tr>
    <?php foreach ($levels as $level): ?>
    <tr>
        <td><?php echo $level['Person_Level']['id']; ?></td>
        <td>
            <?php echo $level['Person_Level']['level_name']; ?>
        </td>
        <td>
            <?php echo $level['Person_Level']['max_day']; ?>
        </td>
        <td>
            <?php echo $level['Person_Level']['max_book']; ?>
        </td>
        <td>
            <?php if ($level['Person_Level']['is_cross_lend']) { echo 'Y'; } else {echo 'N';}; ?>
        </td>        
        <td>
            <?php if ($level['Person_Level']['valid']) { echo 'Y'; } else {echo 'N';}; ?>
        </td>
        <td>
            <?php echo $level['Person_Level']['create_time']; ?>
        </td>
        <td>
            <?php 
				$delbtn = '生效';
				if ($level['Person_Level']['valid']) {
					echo $this->Html->link('修改', array('action' => 'level_edit', $level['Person_Level']['id']), array('class' => 'button'));
					$delbtn = '失效';
					echo '&nbsp';
				}
				echo $this->Form->postLink(
				$delbtn,
				array('action' => 'level_delete', $level['Person_Level']['id']),
				array('class'=>'button','confirm' => '確認變更?'));
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
