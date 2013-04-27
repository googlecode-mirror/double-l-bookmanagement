 <script>
    $(function() {
        $(".jquery_date" ).datepicker({dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true});
    });
	
	function add_print_list(person_id) {
		$.ajax(
			{	
				url:'<?php echo $this->html->url(array('controller'=>'prints', 'action' => 'add'));?>'+'/P/'+person_id, 
				data:{ type: 'P', pid: person_id }, 
				type: "post", 
				success: function(response){
					var response_obj = JSON.parse(response);
					alert(response_obj.message);
				}
			}
		);
		return false;
	}

	function change_page(page_no) {
        $("#PersonPage").val(page_no);
        $("#PersonPersonIndexForm").submit();
    }

</script>
<div class="pageheader_div"><h1 id="pageheader">借閱者基本資料</h1></div>
<div class="pagemenu_div"><?php 
  	echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 
  	echo '&nbsp;';
?></div>  	
<div class="pagemenu_div"><?php   		
	echo $this->Html->link('匯出借閱者資料', array('action' => 'person_export'), array('class' => 'button blue'));
    echo '&nbsp;';
		
?></div>
<?php echo $this->element('person_search_zone'); ?>
<table>
    <tr>
        <th>借卡代號</th>
        <th>姓名</th>
		<th>性別</th>
		<th>所屬分校</th>
		<th>借閱等級</th>		
		<th>聯絡電話</th>
		<th>發卡日期</th>
		<th>有效</th>
        <th>建立時間</th>
        <th><?php echo $this->Html->link('新增借閱者', array('action' => 'person_edit'), array('class' => 'button')); ?></th>
    </tr>
    <?php foreach ($persons as $person): ?>
    <tr>
        <td><?php echo $person['Person']['id']; ?></td>
        <td><?php echo $person['Person']['name']; ?></td>
        <td><?php echo $person_genders[$person['Person']['gender']]; ?></td>
        <td><?php echo $person['System_Location']['location_name']; ?></td>
        <td><?php echo $person_levels[$person['Person']['level_id']]; ?></td>
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
					echo $this->Html->link('修改', array('action' => 'person_edit', $person['Person']['id']), array('class' => 'button'));
					$delbtn = '失效';
					echo '&nbsp';
				}
				echo $this->Form->postLink(
					$delbtn,
					array('action' => 'person_delete', $person['Person']['id']),
					array('confirm' => '確認變更?','class' => 'button'));
				echo '&nbsp;';
                echo $this->Html->link('列印',  'javascript:void(0)',array('class' => 'button','onclick'=>"add_print_list('".$person['Person']['id']."')")); 
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<div align="center"><?php
    if($count>0){
        $lastpage = ceil($count/$page_size);
        if($page>1){
            echo $this->html->link('<<', 'javascript:void(0);', array('class'=>'button','onclick'=>'change_page(1);'));
            echo '&nbsp;';
            echo $this->html->link('<', 'javascript:void(0);', array('class'=>'button','onclick'=>'change_page('.($page-1).');'));
        }
        echo '&nbsp;';
        echo '<select>';
        for($i=1;$i<=$lastpage;$i++){
            if($i==$page) $selected = 'selected';
            else $selected = '';
            echo '<option '.$selected.' onclick="change_page('.$i.')">'.$i.'</option>';
        }
        echo '</select>';
        echo '&nbsp;';
        
        if($lastpage > $page) {
        echo $this->html->link('>', 'javascript:void(0);', array('class'=>'button','onclick'=>'change_page('.($page+1).');'));
        echo '&nbsp;';
        echo $this->html->link('>>', 'javascript:void(0);', array('class'=>'button','onclick'=>'change_page('.$lastpage.');'));
        echo '&nbsp;';
        }
        echo '('.$count.')';
    }
?></div>

