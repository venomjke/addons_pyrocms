<section class="title">
	<h4> <?= lang('shipping_service.order_status'); ?> </h4>
</section>

<section class="item">
	<?php if(!empty($status)): ?>
	<?php echo form_open('admin/shipping_service/status/view/'.$status->id); ?>
		
			<div class="form_inputs">
				<fieldset>
					<ul>
						<li>
							<label for="name"> <?= lang('shipping_service.status_name'); ?> <span>*</span> </label>
							<div class="input">
							<?= form_input('name',$status->name); ?>
							</div>
						</li>
						<li>
							<label for="comment"> <?= lang('shipping_service.status_comment'); ?> </label>
							<div class="input"> <?= form_textarea('comment',$status->comment); ?> </div>
						</li>
						<li>
							<label for="default"> <?= lang('shipping_service.status_default'); ?> </label>
							<div class="input"> <?= form_checkbox('default',1, $status->default); ?> </div>
						</li>
						<li>
							<label for="notification"> <?= lang('shipping_service.status_notification'); ?></label>
							<div class="input"> <?= form_checkbox('notification',1,$status->notification); ?> </div>
						</li>
					</ul>
				</fieldset>
			</div>
	
		<div class="buttons align-right padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )); ?>
		</div>
		<?php endif; ?>
	<?php echo form_close(); ?>
</section>