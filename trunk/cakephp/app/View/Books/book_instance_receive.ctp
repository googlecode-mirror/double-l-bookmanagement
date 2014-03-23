<script language="JavaScript">
	function add_book(book_instance_id, e) {
		var key;
		if(window.event)
			key = window.event.keyCode;     //IE
		else
			key = e.which;     //firefox
		if(key == 13) {

		}
		else {	return true;}
	}
</script>
<div class="pageheader_div"><h1 id="pageheader">書籍入庫作業</h1></div>	
<div class="pagemenu_div"><?php 
  	echo $this->Html->link('回上一頁', "javascript:history.back();", array('class' => 'button')); 
  	echo '&nbsp;';
  	echo $this->Html->link('匯出購買中書籍', array('action' => 'book_instance_purchasing_export'), array('class' => 'button blue'));
  	echo $this->Html->link('匯出非購買中書籍', array('action' => 'book_instance_nonpurchasing_export'), array('class' => 'button blue'));
    
?></div>

<?php echo $this->Form->create('Book', array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); ?>
書籍條碼:	<?php echo $this->Form->input('book', array('label' => false,'div' => false,'onkeypress' =>'add_book(this, event);')); ?>
<?php echo $this->Form->end(); ?>

<script language="JavaScript">
	$().ready( function() {
			if ($('#BookBook').length > 0) {
				$('#BookBook').focus();
			}
		}	
	);
</script>