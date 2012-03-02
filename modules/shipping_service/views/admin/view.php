<section class="title">
	<h4> <?= lang('shipping_service.order'); ?> </h4>
</section>

<section class="item">
	
	<?php $form_url = !empty($order)?"admin/shipping_service/changestatus/{$order->id}":"admin/shipping_service"; ?>
	<?php echo form_open($form_url); ?>
	
		<div class="tabs">
	
				<ul class="tab-menu">
					<li><a href="#shipping-service-main"><span><?php echo lang('shipping_service.main_label'); ?></span></a></li>
					<li><a href="#shipping-service-sender"><span><?php echo lang('shipping_service.sender_label'); ?></span></a></li>
					<li><a href="#shipping-service-reciver"><span><?php echo lang('shipping_service.reciver_label'); ?></span></a></li>
				</ul>
				
				<div class="form_inputs" id="shipping-service-main">
				
				<fieldset>
					<ul>
						<li>
							<label for=""><?= lang('shipping_service.order_id'); ?> </label>
							<div>
								<?= !empty($order)?$order->id:"- empty -"; ?>
							</div>
						</li>
						<li>
							<label for=""><?= lang('shipping_service.order_status'); ?> </label>
							<div class="input"><?= form_dropdown('id_status', array(lang('global:select-pick')) + $all_status, !empty($order) && $order->id_status ? $order->id_status:"", 'id="id_status" class="required"'); ?></div>
						</li>
						<li>
							<label for=""><?= lang('shipping_service.note_status'); ?> </label>
							<div class="input"> <?= form_input('note_status',!empty($order)?$order->note_status:"") ?> </div>
						</li>
						<li>
							<label for=""> <?= lang('shipping_service.order_date'); ?> </label>
							<div>
								<?= !empty($order)?date('Y-m-d H:i:s'):"- empty -"; ?>
							</div>
						</li>
						<li>
							<label for=""> <?= lang('shipping_service.price_shipping'); ?> </label>
							<div> <?= !empty($order)?$order->price_shipping:"- empty -"; ?> </div>
						</li>
						<li>
							<label for=""> <?= lang('shipping_service.cost_shipping'); ?> </label>
							<div> <?= form_input('cost_shipping',!empty($order)?$order->cost_shipping:0);?> </div>
						</li>
					</ul>
				</fieldset>
			</div>
	
			<!-- Design tab -->
			<div class="form_inputs" id="shipping-service-sender">
				<fieldset>
				<ul>
				<?php if(!empty($order)): ?>
					<li>
						<label for=""> <?= lang('shipping_service.nsp_customer'); ?> </label>
						<div> <?= $order->nsp_customer; ?> </div>
					</li>
					<li>
						<label for=""> <?= lang('shipping_service.phone_customer'); ?> </label>
						<div> <?= $order->phone_customer; ?> </div>
					</li>
					<li>
						<label for=""> <?= lang('shipping_service.email_customer'); ?> </label>
						<div> <?= $order->email_customer; ?> </div>
					</li>
					<li>
						<label for=""> <?= lang('shipping_service.address_customer'); ?> </label>
						<div> <?= $order->address_customer; ?> </div>
					</li>
					<li>
						<label for=""> <?= lang('shipping_service.investment_customer'); ?> </label>
						<div> <?= $order->investment_customer; ?> </div>
					</li>
					<li>
						<label for=""> <?= lang('shipping_service.note_customer'); ?> </label>
						<div> <?= $order->note_customer; ?> </div>
					</li>
				<?php endif; ?>
				<ul>
				</fieldset>
	
			</div>
	
			<!-- Script tab -->
			<div class="form_inputs" id="shipping-service-reciver">
	
				<fieldset>
				<ul>
				<?php if(!empty($order)): ?>
					<li>
						<label for=""> <?= lang('shipping_service.nsp_shipping'); ?> </label>
						<div><?= $order->nsp_shipping; ?></div>
					</li>
					<li>
						<label for=""> <?= lang('shipping_service.phone_shipping'); ?> </label>
						<div><?= $order->phone_shipping; ?></div>
					</li>
					<li>
						<label for=""> <?= lang('shipping_service.address_shipping'); ?> </label>
						<div><?= $order->address_shipping; ?></div>
					</li>
				<?php endif; ?>
				<ul>
	
				</fieldset>
	
			</div>
	
		</div>
	
		<div class="buttons align-right padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )); ?>
		</div>
	
	<?php echo form_close(); ?>
</section>