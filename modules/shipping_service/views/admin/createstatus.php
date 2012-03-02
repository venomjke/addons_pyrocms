<section class="title">
	<h4> <?= lang('shipping_service.order_status'); ?> </h4>
</section>

<section class="item">
	
	<?php echo form_open('admin/shipping_service/status/create'); ?>
		
			<div class="form_inputs">
				<fieldset>
					<ul>
						<li>
							<label for="name"> <?= lang('shipping_service.status_name'); ?> <span>*</span> </label>
							<div class="input">
							<?= form_input('name'); ?>
							</div>
						</li>
						<li>
							<label for="comment"> <?= lang('shipping_service.status_comment'); ?> </label>
							<div class="input"> <?= form_textarea('comment'); ?> </div>
						</li>
						<li>
							<label for="default"> <?= lang('shipping_service.status_default'); ?> </label>
							<div class="input"> <?= form_checkbox('default',1, FALSE); ?> </div>
						</li>
						<li>
							<label for="notification"> <?= lang('shipping_service.status_notification'); ?> </label>
							<div class="input"><?= form_checkbox('notification',1,FALSE); ?></div>
						</li>
					</ul>
				</fieldset>
			</div>
	
		<div class="buttons align-right padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )); ?>
		</div>
	
	<?php echo form_close(); ?>
</section>