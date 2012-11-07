		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => '2twn.com', 'border' => '0')),
					'http://www.2twn.com/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	
	<?php echo $this->element('sql_dump'); //中文?>
</body>
</html>