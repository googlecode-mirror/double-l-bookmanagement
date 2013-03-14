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
<h1>書籍入庫作業</h1>	
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