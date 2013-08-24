 <?php 

    $book = $this->request->data["Book"];
    $book_instances = $this->request->data["Book_Instances"];
    if($book_instances == null ) {$book_instances=array();}
 ?>
 <script>
    $(function() {
        $(".jquery_date" ).datepicker({dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true});
    });
	
	function add_print_list(book_id) {
		$.ajax(
			{	
				url:'<?php echo $this->html->url(array('controller'=>'prints', 'action' => 'add'));?>'+'/B/'+book_id, 
				data:{ type: 'B', pid: book_id }, 
				type: "post", 
				success: function(response){
					var response_obj = JSON.parse(response);
					alert(response_obj.message);
				}
			}
		);
		return false;
	}
</script>
<div class="pageheader_div"><h1 id="pageheader">書籍基本資料</h1></div>
<div class="pagemenu_div"><?php 
    if($this->Session->read('user_role') !== 'user') {
        echo $this->Html->link('修改', array('action' => 'book_edit', $book['id']), array('class' => 'button')); 
		echo '&nbsp;';
        echo $this->Html->link('新增一筆', array('action' => 'book_edit'), array('class' => 'button')); 
        echo '&nbsp;';

    }
    echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 
?></div>

<?php
    echo $this->Form->create('Book',array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false,'readonly'=>true)));
    echo $this->Form->input('id', array('type'=> 'hidden'));
    echo $this->Form->input('book_type', array('type'=> 'hidden', 'value'=>'B'));
?>   
    <table><tr> 
        <td><table>
            <tr><td>書籍名稱 : <?php echo $this->Form->input('book_name', array('size'=>70)); ?></td></tr>
            <tr><td>副標題 : <?php echo $this->Form->input('book_title', array('size'=>70)); ?></td></tr>
            <tr><td>ISBN  : <?php echo $this->Form->input('isbn', array('size'=>15)); ?>
            		版別  : <?php echo $this->Form->input('book_version', array('size'=>5)); ?>
                    集叢書:<?php echo $this->Form->input('book_suite', array('size'=>40)); ?></td></tr>
            <tr><td>出版商 : <?php echo $this->Form->input('book_publisher', array('size'=>50)); ?>
            		出版日期 : <?php echo $this->Form->text('publish_year', array('readonly'=>true,'style'=>'width:120px'));?></td></tr>
            <tr><td>作者 : <?php echo $this->Form->input('book_author', array('size'=>40)); ?> 
                    附屬媒體 <?php echo $this->Form->input('book_attachment', array('size'=>30)); ?></td></tr>
            <tr><td>閱讀級別 : <?php echo $this->Form->input('lexile_level', array('readonly'=>true,'style'=>'width:50px')); ?></td></tr>
            <tr><td>親子共讀  <?php echo $this->Form->checkbox('book_ad', array('hiddenField' => false)); ?></td></tr>
        </td></table>
        <td><?php echo $this->Html->image( $book['book_image'], array('height'=>'300px','width'=>'200px'));?></td>
    </tr></table>
<?php echo $this->Form->end(); ?>    


<table>
    <tr>
        <th>書籍編號</th>
        <th>購買金額</th>
        <th>書籍狀態</th>
        <th>借閱等級</th>
        <th>購買時間</th>
        <th>預計歸還時間</th>
        <th>可以外借</th>
        <th>地點</th>
        <th>
            <?php
                if($this->Session->read('user_role') !== 'user') {
                    echo $this->Html->link('新增書本', array('action' => 'book_instance_edit', $book['id']), array('class' => 'button')); 
                }
            ?>
        </th>
    </tr>
    <?php foreach ($book_instances as $book_instance): ?>
    <tr>
        <td><?php echo $book_instance['id']; ?></td>
        <td><?php echo $book_instance['purchase_price']; ?></td>
        <td><?php echo $book_status[$book_instance['book_status']]; ?></td>
        <td><?php echo $person_levels[$book_instance['level_id']]; ?></td>
        <td><?php echo $book_instance['purchase_date']; ?></td>
        <td><?php echo $book_instance['s_return_date']; ?></td>
        <td><?php echo $book_instance['is_lend']; ?></td>
        <td><?php echo $locations[$book_instance['location_id']]; ?></td>
        <td><?php 
                if($this->Session->read('user_role') !== 'user') {
                    echo $this->Html->link('修改', array('action' => 'book_instance_edit', $book['id'], $book_instance['id']), array('class' => 'button'));
					echo '&nbsp;';
                    echo $this->Html->link('列印',  'javascript:void(0)',array('class'=>'button','onclick'=>"add_print_list('".$book_instance['id']."')")); 
                }
				else {
				    if (($book_instance['is_lend'] == 'Y') &&
						($book_instance['book_status'] == 1)&&
						(($book_instance['location_id'] == $userinfo['Person']['location_id']) || ($userinfo['Person_Level']['is_cross_lend'] == 'Y'))
					){
						echo $this->html->link('預約', 'javascript:void(0)', array('class'=>'button','onclick' => "reserve_book('".$book_instance['id']."');")); 
					}
				}
        ?></td>
    </tr>
    <?php endforeach; ?>
</table>

