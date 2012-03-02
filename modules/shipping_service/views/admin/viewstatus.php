<section class="title">
	<h4><?php echo lang('shipping_service.shipping_service_label'); ?></h4>
</section>

<section class="item">			
	<div class="form_inputs" id="shipping-service-status">	
		<?php echo form_open('admin/shipping_service/status/del');?>
		<?php if (!empty($all_status)): ?>
		
			<table border="0" class="table-list">
				<thead>
					<tr>
						<th width="30"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
						<th><?= lang('shipping_service.status_name'); ?></th>
						<th><?= lang('shipping_service.status_comment'); ?> </th>
						<th>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach( $all_status as $status ): ?>
					<tr>
						<td><?=  form_checkbox('action_to[]', $status->id); ?></td>
						<td><?= anchor('admin/shipping_service/status/view/'.$status->id,$status->name); ?> </td>
						<td><?= $status->comment; ?></td>
						<td class="align-center buttons buttons-small">
							<?php echo anchor('admin/shipping_service/status/view/'.$status->id, lang('shipping_service.view_label'), 'class="button" '); ?>
							<?php echo anchor('admin/shipping_service/status/del/'.$status->id, lang('global:delete'), array('class'=>'confirm button delete')); ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		
			<div class="table_action_buttons">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
			</div>
		<?= form_close(); ?>
		<?php else: ?>
			<div class="blank-slate">
				<div class="no_data">
					<?php echo lang('shipping_service.no_status'); ?>
				</div>
			</div>
		<?php endif;?>
	</div>
</section>