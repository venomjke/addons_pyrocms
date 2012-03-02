<script language="javascript">
	$(function(){
		// select all desired input fields and attach tooltips to them
		$(".content  form.createorder :input").tooltip({

			// place tooltip on the right edge
			position: "center right",

			// a little tweaking of the position
			offset: [-2, 10],

			// use the built-in fadeIn/fadeOut effect
			effect: "fade",

			// custom opacity setting
			opacity: 0.7

		});

	})
</script>
<div class="shipping_service">
	<?php if(!empty($order_id)): ?>
		<div class="message success"> <?= $msg; ?>. Код заказа: <b> <?= $order_id; ?> </b> </div>
	<?php endif; ?>
	
	<?= validation_errors(); ?>
	<form class="createorder" method="post" action="<?= site_url("shipping_service/createorder"); ?>" >
		<table>
			<tr>
				<td>
					<fieldset>
						<legend> <?= lang("shipping_service.sender_label"); ?> </legend>
						<div>
							<div class="form_row">
								<label for="nsp_customer"> <?= lang("shipping_service.nsp_customer"); ?> <span> * </span> </label> 
								<input title="<?= lang("shipping_service.nsp_customer"); ?>" type="text" name="nsp_customer" value="<?= !empty($user)?$user->last_name.' '.$user->first_name:set_value("nsp_customer"); ?>" placeholder="<?= lang("shipping_service.nsp_customer");?>" required />
							</div>
							<div class="form_row">
								<label for="phone_customer"> <?= lang("shipping_service.phone_customer"); ?> <span> * </span> </label> 
								<input type="text" title="<?= lang("shipping_service.phone_customer"); ?>" name="phone_customer" value="<?= !empty($user)?$user->mobile:set_value("phone_customer"); ?>" placeholder="<?= lang("shipping_service.phone_customer"); ?>"  required />
							</div>
							<div class="form_row">
								<label for="email_customer"> <?= lang("shipping_service.email_customer"); ?> <span> * </span>  </label> 
								<input type="email" title="<?= lang("shipping_service.email_customer"); ?>" name="email_customer" value="<?= !empty($user)?$user->email:set_value("email_customer");?>" placeholder="<?= lang("shipping_service.email_customer"); ?>"  required />
							</div>
							<div class="form_row">
								<label for="address_customer"> <?= lang('shipping_service.address_customer'); ?> <span>*</span> </label>
								<input type="text" title="<?= lang("shipping_service.address_customer"); ?>" name="address_customer" value="<?= !empty($user)?$user->address_line1.' '.$user->address_line2:set_value("address_customer"); ?>" placeholder="<?= lang("shipping_service.address_customer"); ?>" />
							</div>
							<div class="form_row">
								<label for="investment_customer"> <?= lang("shipping_service.investment_customer"); ?> <span>*</span></label>
								<input type="text" name="investment_customer" title="<?= lang("shipping_service.description_investment_customer"); ?>" value="<?= set_value("investment_customer"); ?>" placeholder="<?= lang("shipping_service.investment_customer"); ?>" />
							</div>
							<div class="form_row">
								<label for="note_customer"> <?= lang("shipping_service.note_customer"); ?> </label>
								<textarea title="<?= lang("shipping_service.description_note_customer"); ?>" name="note_customer"><?= set_value("note_customer"); ?></textarea>
							</div>
						</div>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td>
				<fieldset>
						<legend> <?= lang("shipping_service.reciver_label"); ?> </legend>
						
						<div>
							<div class="form_row">
								<label for="nsp_shipping"><?= lang("shipping_service.nsp_shipping"); ?> <span> * </span>  </label>
								<input type="text" title="<?= lang("shipping_service.nsp_shipping");  ?>" name="nsp_shipping" value="<?= set_value("nsp_shipping"); ?>" placeholder="<?= lang("shipping_service.nsp_shipping");  ?>" required />
							</div>
							<div class="form_row">
								<label for="phone_shipping"><?= lang("shipping_service.phone_shipping"); ?> <span> * </span>  </label>
								<input type="text" name="phone_shipping" title="<?= lang("shipping_service.phone_shipping"); ?>" value="<?= set_value("phone_shipping"); ?>" placeholder="<?= lang("shipping_service.phone_shipping"); ?>" required />
							</div>
							<div class="form_row">
								<label for="address_shipping"><?= lang("shipping_service.address_shipping"); ?> <span>*</span></label>
								<input type="text" title="<?= lang("shipping_service.address_shipping"); ?>" name="address_shipping" value="<?= set_value("address_shipping"); ?>" placeholder="<?= lang("shipping_service.address_shipping"); ?>" />
							</div>
							<div class="form_row">
								<label for="price_shipping"> <?= lang("shipping_service.price_shipping"); ?> <span> * </span>  </label>
								<input type="text" name="price_shipping" value="<?= set_value("price_shipping"); ?>" title="<?= lang("shipping_service.description_price_shipping"); ?>" placeholder="<?= lang("shipping_service.price_shipping"); ?>" required />
							</div>
						<div>
				</fieldset>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="Отправить" />
				</td>
			</tr>
		</table>
	<form>
</div>