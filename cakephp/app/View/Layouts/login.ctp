<?php echo $this->element('default_header'); ?>
		<div id="content" style="background:#F3E378;">
			<table>
				<tr>
					<td>
						<?php echo $this->Session->flash(); ?>

						<?php echo $this->fetch('content'); ?>
					</td>
				</tr>
			</table>
		</div>
<?php echo $this->element('default_footer'); ?>
