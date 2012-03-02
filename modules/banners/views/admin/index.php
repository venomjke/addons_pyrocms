<section class="title">
	<h4> Баннер </h4>
</section>

<section class="item">
	
	<?php echo form_open('admin/banners/save', 'class="crud"'); ?>
	
		<div class="tabs">
	
			<ul class="tab-menu">
				<li><a href="#banners-settings"><span><?php echo lang('banners.settings_label'); ?></span></a></li>
			</ul>
			<?php echo lang('banners.banners_direcotry'); ?>
			<div class="form_inputs" id="banners-settings">	
				<fieldset>
				<ul>
					<?php
					
						if(!empty($settings)):
							foreach($settings as $setting):
							
								if( $setting->slug != 'banners_directory'):
						?>
							<li>
								<label for=""><?php echo lang('banners.'.$setting->slug); ?> <span> * </span> </label>
								<div class="input"><?= $this->settings->form_control($setting); ?> </div>
							</li>
						<?php
								else:
						?>
							<li>
								<label for=""><?php echo lang('banners.banners_directory'); ?> <span> * </span> </label>
								<div class="input"><?= form_dropdown('banners_directory',$folders,$setting->value);?> </div>
							</li>
						<?php
								endif;
							endforeach;
						endif;
					?>
				</ul>
				</fieldset>
			</div>
		</div>
	
		<div class="buttons align-right padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )); ?>
		</div>
	
	<?php echo form_close(); ?>
	
</section>