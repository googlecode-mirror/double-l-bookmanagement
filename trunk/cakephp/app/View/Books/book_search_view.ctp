<script language="JavaScript">
	function reserve_book(book_instance_id) {
		if (jQuery('#Lend_RecordReservePersonId')[0].value.trim() != '') {
			$.ajax(
				{	
					url:'<?php echo $this->html->url(array('controller'=>'lend', 'action' => 'reserve_book'));?>', 
					data:{ reserve_person_id: jQuery('#Lend_RecordReservePersonId')[0].value, book_instance_id: book_instance_id }, 
					type: "post", 
					success: function(response){
						if (response.length <= 2) {
							if (response == 1) {
								alert('借卡號碼：' + jQuery('#person_id')[0].value + '不存在');
							}
							else if (response == 2){
								alert('書籍代號：' + book_instance_id.value + '不存在');
							}
							else if (response == 3) {							
								alert('書籍代號：' + book_instance_id.value + '不在庫');
							}
							else if (response == 4) {							
								alert('書籍代號：' + book_instance_id.value + '不可外借');
							}
							else if (response == 5) {							
								alert('借閱等級不足');
							}
							else if (response == 6) {							
								alert('書籍代號：' + book_instance_id.value + '有人預約中');
							}
							else {
								alert('錯誤');
							}
						}
						else {
							jQuery('#lend_table').append(response);
							jQuery('#lend_cnt')[0].innerHTML = jQuery('#lend_table tr').length - 1;
							jQuery('#can_lend')[0].innerHTML = jQuery('#can_lend1')[0].innerHTML - jQuery('#lend_table tr').length + 1;
						}
						if (jQuery('#lend_table tr').length > 1) {
							jQuery('#SaveData').show();
						}
					}
				}
			)
		}
		else {
			alert('借卡號碼：不可為空白');
		}
		return false;
	}
</script>
<div class="pageheader_div"><h1 id="pageheader">書籍資料查詢結果</h1></div>
<div class="pagemenu_div">
</div>
<?php
    echo $this->Form->create('Lend_Record',array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false)));
	echo $this->Form->input('book_instance_id', array('type'=> 'hidden'));
    if($this->Session->read('user_role') !== 'user') {
		echo '借閱者卡號：'.$this->Form->input('reserve_person_id', array('type'=> 'text'));
    }
	else {
		echo $this->Form->input('reserve_person_id', array('type'=> 'hidden', 'value' => $this->Session->read('user_id')));
	}
	echo $this->Form->end(); 
?>
<table>
    <tr>
        <th>書籍編號</th>
        <th>書籍名稱</th>
        <th>ISBN</th>
        <th>購買金額</th>
        <th>書籍狀態</th>
        <th>借閱等級</th>
        <th>購買時間</th>
        <th>預計歸還時間</th>
        <th>可以外借</th>
        <th>地點</th>
        <th>操作</th>
    </tr>
    <?php foreach ($books as $book): ?>
    <tr>
        <td><?php echo $book["Book_Instance"]['id']; ?></td>
        <td><?php echo $book["Book"]['book_name']; ?></td>
        <td><?php echo $book["Book"]['isbn']; ?></td>
        <td><?php echo $book["Book_Instance"]['purchase_price']; ?></td>
        <td><?php echo $book_status[$book["Book_Instance"]['book_status']]; ?></td>
        <td><?php echo $book["Book_Instance"]['level_id']; ?></td>
        <td><?php echo $book["Book_Instance"]['purchase_date']; ?></td>
        <td><?php echo $book["Book_Instance"]['s_return_date']; ?></td>
        <td><?php echo $book["Book_Instance"]['is_lend']; ?></td>
        <td><?php echo $locations[$book["Book_Instance"]['location_id']]; ?></td>
        <td><?php 
                if (($book["Book_Instance"]['is_lend'] == 'Y') &&
					($book["Book_Instance"]['book_status'] == 1)&&
					(($book["Book_Instance"]['location_id'] == $userinfo['Person']['location_id']) || ($userinfo['Person_Level']['is_cross_lend'] == 'Y') || ($this->Session->read('user_role') !== 'user'))
				){
                    echo $this->html->link('預約', 'javascript:void(0)', array('onclick' => "reserve_book('".$book["Book_Instance"]['id']."');")); 
                }
        ?></td>
    </tr>
    <?php endforeach; ?>
</table>
