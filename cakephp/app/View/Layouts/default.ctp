<?php echo $this->element('default_header'); ?>
		<div id="content">
			<table id='layout'>
				<tr>
					<td>
						<?php echo $this->Session->flash(); ?>

						<?php echo $this->fetch('content'); ?>
					</td>
				</tr>
			</table>
		</div>
<?php echo $this->element('default_footer'); ?>
