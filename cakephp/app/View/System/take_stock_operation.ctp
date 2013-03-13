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
<h1>書籍盤點作業</h1>	
<?php echo $this->Form->create('System_Take_Stock', array('div'=>false, 'inputDefaults' => array('label' => false,'div' => false))); ?>
書籍條碼:	<?php echo $this->Form->input('book', array('label' => false,'div' => false,'onkeypress' =>'add_book(this, event);')); ?>
<?php echo $this->Form->end(); ?>

<script language="JavaScript">
	$().ready( function() {
			if ($('#System_Take_StockBook').length > 0) {
				$('#System_Take_StockBook').focus();
			}
		}	
	);
</script>