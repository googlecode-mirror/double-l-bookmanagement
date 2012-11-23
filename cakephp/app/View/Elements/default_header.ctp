<?php
/**中文*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php //echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		echo $this->Html->css('application');
		echo $this->Html->css('redmond/jquery-ui-1.9.1.custom.css');
        echo $this->Html->script('jquery-1.8.2.js');
        echo $this->Html->script('jquery-ui-1.9.1.custom.js');
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			
			<div id="account">
			<?php
				if($this->Session->read('isLogin')){
					echo '<li>';
					echo $this->Session->read('username');
					echo '</li>';
					echo '<li>';
					echo $this->Html->link(
    					'logout',
    					array('controller' => 'users', 'action' => 'logout'),
  						array(),
    					"Are you sure you wish to logout?"
					);
					echo '</li>';
				}
			?>
			</div>		
			<h1>Book Management</h1>	
		</div>
