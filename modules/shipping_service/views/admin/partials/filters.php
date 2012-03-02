<fieldset id="filters">

	<legend><?php echo lang('global:filters'); ?></legend>
	<?php echo form_open(); ?>
	<?php echo form_hidden('f_module', 'customer'); ?>
	<table>
		<tr>
			<td>
				<fieldset>
					<legend> Заказчик </legend>
					<table>
						<tr>
							<td>
								<?= lang('shipping_service.nsp_customer'); ?>
							</td>
							<td>
								<?= form_input('f_nsp_customer'); ?>
							</td>
						<tr>
						<tr>
							<td>
								<?= lang('shipping_service.phone_customer'); ?>
							</td>
							<td>
								<?= form_input('f_phone_customer'); ?>
							</td>
						</tr>
					</table>
				</fieldset>
			</td>
			<?php //echo anchor(current_url(), lang('buttons.cancel'), 'class="cancel"'); ?>
			<td>
				<fieldset>
					<legend> Получатель </legend>
					<table>
						<tr>
							<td>
								<?= lang('shipping_service.nsp_shipping'); ?>
							</td>
							<td>
								<?= form_input('f_nsp_shipping');?>
							</td>
						</tr>
						<tr>
							<td>
								<?= lang('shipping_service.phone_shipping'); ?>
							</td>
							<td>
								<?= form_input('f_phone_shipping'); ?>
							</td>
						</tr>
					</table>
				</fieldset>
			</td>
			

			
		</tr>
	</table>
	<?php echo form_close(); ?>
</fieldset>