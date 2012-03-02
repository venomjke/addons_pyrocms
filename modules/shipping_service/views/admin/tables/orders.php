<table border="0" class="table-list">
	<thead>
		<tr>
			<th width="30"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
			<th><?= lang('shipping_service.nsp_customer'); ?></th>
			<th><?= lang('shipping_service.phone_customer'); ?> </th>
			<th><?= lang('shipping_service.nsp_shipping'); ?> </th>
			<th><?= lang('shipping_service.phone_shipping'); ?> </th>
			<th>
			</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="5">
				<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
			</td>
		</tr>
	</tfoot>
	<tbody>
		<?php if (!empty($orders)): ?>
		<?php foreach( $orders as $order ): ?>
		<tr>
			<td><?=  form_checkbox('action_to[]', $order->id); ?></td>
			<td><?= anchor('admin/shipping_service/view/'.$order->id,$order->nsp_customer); ?> </td>
			<td><?= $order->phone_customer; ?></td>
			<td><?= $order->nsp_shipping; ?></td>
			<td><?= $order->phone_shipping; ?> </td>
			<td class="align-center buttons buttons-small">
				<?php echo anchor('admin/shipping_service/view/'.$order->id, lang('shipping_service.view_label'), 'class="button"'); ?>
				<?php echo anchor('admin/shipping_service/del/'.$order->id, lang('global:delete'), array('class'=>'confirm button delete')); ?>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>