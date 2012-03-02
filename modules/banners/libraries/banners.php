<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package 		Flyweb
 * @subpackage 		Banners module
 * @author			aleks.strigin - Flyweb Development Team
 *
 * 
 */
class Banners {

	public function __construct(){
	
	
	}
	
	
	
	public function render(){
	
		return '
		<div class="knopka">
				<a href="123">
					<img src="{{ theme:image_path file="knopkaleft.png" }}" />
				</a>
		</div>
		<div class="centr">
			<img src="{{ theme:image_path file="anons.jpg"}}" />
		</div>
		<div class="knopka">
			<a href="132">
				<img src="{{ theme:image_path file="knopkaright.png" }}" />
			</a>
		</div>
		';
	}
}