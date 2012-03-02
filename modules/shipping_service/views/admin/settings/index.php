<section class="title">
	<h4> <?= lang('shipping_service.settings'); ?> </h4>
</section>

<section class="item">
	
	<?php echo form_open('admin/shipping_service/settings', 'class="crud"'); ?>
	
		<div class="tabs">
	
			<ul class="tab-menu">
				<li><a href="#shipping_service-settings"><span><?php echo lang('shipping_service.settings_template'); ?></span></a></li>
			</ul>
			<div class="form_inputs" id="shipping_service-settings">	
				<fieldset>
				<ul>
					<li>
						<label for=""><?php echo lang('shipping_service.create_order_template'); ?> <span> * </span> </label>
						<div class="input"><?= form_dropdown('create_order_template',$templates,$create_order_template); ?> </div>
					</li>
					<li>
						<label for=""><?php echo lang('shipping_service.change_order_status_template'); ?> <span> * </span> </label>
						<div class="input"><?= form_dropdown('change_order_status_template',$templates,$change_status_template);?> </div>
					</li>
				</ul>
				</fieldset>
			</div>
		</div>
	
		<div class="buttons align-right padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )); ?>
		</div>
	
	<?php echo form_close(); ?>
	
</section>