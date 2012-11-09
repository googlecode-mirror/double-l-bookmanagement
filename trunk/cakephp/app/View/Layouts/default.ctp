<?php echo $this->element('default_header'); ?>
		<div id="content">
			<table>
				<tr>
					<td style="width:200px">
						<?php echo $this->element('left_menu'); ?>
					</td>
					<td>
						<?php echo $this->Session->flash(); ?>

						<?php echo $this->fetch('content'); ?>
					</td>
				</tr>
			</table>
		</div>
<?php echo $this->element('default_footer'); ?>
