<div class="shipping_service">
	<form method="post" action="<?= site_url("shipping_service/checkorder"); ?>">
	
	<?php if(!empty($order)): ?>
		<span class="info">
			<b><?= lang('shipping_service.checkorder_message'); ?> </b>: <?= !empty($order->status_name)?$order->status_name:lang('shipping_service.default_status'); ?> 
		</span>
	<?php elseif(!empty($msg)): ?>
		<span class="warning"><?= $msg; ?></span>
	<?php endif; ?>
		<?= validation_errors(); ?>
		<div class="checkorder_box">
			<h4> Введите код заказа </h4>
			<input type="text" name="order_id" value=""  placeholder="<?= lang("shipping_service.order_id"); ?>" /> <br /> 
			<input type="submit" value="Отправить" />
		</div>
	</form>
</div>