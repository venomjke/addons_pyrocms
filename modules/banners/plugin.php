<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Settings Plugin
 *
 * Create a list of images
 *
 * @package		Flyweb
 * @author		Alex.strigin - Flyweb Dev Team
 * @copyright	Copyright (c) 2008 - 2010, PyroCMS
 *
 */
class Plugin_Banners extends Plugin
{
	/*
	*
	*	load the banner images
	*	{{ banners:render }}
	*/
	function render(){
		$this->load->library('banners/banners');
		return $this->banners->render();
	}
}

/* End of file plugin.php */