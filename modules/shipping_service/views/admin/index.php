<section class="title">
	<h4><?php echo lang('shipping_service.shipping_service_label'); ?></h4>
</section>

<section class="item">

			<?php template_partial('filters'); ?>
			<?php echo form_open('admin/shipping_service/del');?>
			<div id="filter-stage">
				<?php template_partial('tables/orders'); ?>
			</div>
			<div class="table_action_buttons">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
			</div>
			<?php echo form_close(); ?>
</section>