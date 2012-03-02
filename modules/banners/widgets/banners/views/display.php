<script language="javascript" src=""></script>
<style type="text/css">
	#slider{
		margin-bottom:15px;
		margin-top:5px;
		margin-left:15px;
	}
	
	#slider ul, #slider li{
		margin:0;
		padding:0;
		list-style:none;
	}

	 #slider img{ 
		width:<?= !empty($banner_settings)?$banner_settings['banners_width']:0;?>px;
		height:<?=  !empty($banner_settings)?$banner_settings['banners_height']:0; ?>px;
		margin:0 auto;
		overflow:hidden; 
	}
	<?php if(!empty($banner_settings) && $banner_settings['banners_buttons'] == FALSE ): ?>
	
	#prevBtn,#nextBtn{
		display:none;
	}
	<?php endif; ?>
</style>
<div class="knopka" id="prevId">
	<a href="javascript:void(0);">
		<img src="{{ theme:image_path file='knopkaleft.png' }}" />
	</a>
</div>
<div class="centr">
	<div id="slider" >
		<ul>
			<?php
			
				if(!empty($banners)):
					foreach($banners as $banner):
				?>
					<li >
						<a href="#"><img title="<?= !empty($banner->name)?$banner->name:""; ?>" alt="<?= !empty($banner->name)?$banner->name:"";?>" src="<?= site_url('files/large/'.$banner->id); ?>" /></a>
					</li>
				<?php
					endforeach;
				endif;
			?>
		</ul>
	</div>
</div>
<div class="knopka" id="nextId">
	<a href="javascript:void(0);">
		<img src="{{ theme:image_path file='knopkaright.png' }}" />
	</a>
</div>
<script language="javascript" >
$(function(){
	$('#slider').easySlider({
			nextId:'nextId',
			prevId:'prevId',
			controlsShow:false,
			pause:<?= !empty($banner_settings)?$banner_settings['banners_speed']:1;?>,
			controlFase:false,
			auto:<?= !empty($banner_settings)&&$banner_settings['banners_cycle']?"true":"false"; ?>,
			continuous:<?= !empty($banner_settings)&&$banner_settings['banners_cycle']?"true":"false"; ?>
	});
});
</script>