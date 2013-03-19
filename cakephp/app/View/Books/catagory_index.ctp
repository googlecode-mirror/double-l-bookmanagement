<div class="pageheader_div"><h1 id="pageheader">書籍級別資料</h1></div>
<div class="pagemenu_div">
<?php 
	echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 
?>
</div>
<table>
    <tr>
        <th>級別代號</th>
        <th>級別名稱</th>
        <th>顏色</th>
        <th>有效</th>
        <th>建立時間</th>
        <th><?php echo $this->Html->link('新增級別', array('action' => 'catagory_edit'), array('class' => 'button')); ?></th>
    </tr>
    <?php foreach ($cates as $cate): ?>
    <tr>
        <td><?php echo $cate['Book_Cate']['id']; ?></td>
        <td>
            <?php echo $cate['Book_Cate']['catagory_name']; ?>
        </td>
        <td>
            <?php echo $cate['Book_Cate']['catagory_color']; ?>
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
					echo $this->Html->link('修改', array('action' => 'catagory_edit', $cate['Book_Cate']['id']), array('class' => 'button'));
					$delbtn = '失效';
					echo '&nbsp';
				}
				echo $this->Form->postLink(
				$delbtn,
				array('action' => 'catagory_delete', $cate['Book_Cate']['id']),
				array('class'=>'button','confirm' => '確認變更?'));
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
