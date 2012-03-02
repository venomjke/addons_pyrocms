<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Banners extends Module {

	public $version = '1.0';

	private $banner_settings = array();
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Banners',
				'ru' => 'Баннеры'
			),
			'description' => array(
				'en' => '- no description -',
				'ru' => 'Баннеры - это модуль, позволяющий создавать на странице область для прокручивания фотографий',
			),
			'frontend' => FALSE,
			'backend' => TRUE,
			'menu' => 'content',

		    'shortcuts' => array(
			),
		);
	}

	public function install()
	{
		
		/*
		*
		*
		*	Модуль баннеров работает с модулем settings и files
		*
		*	Settings:
		*		- banners_width   - px
		*		- banners_height  - px
		*		- banners_speed   - milliseconds
		*		- banners_buttons - true or false
		*		- banners_cycle   - true of false
		*		- banners_directory - text 
		*/
		
		$this->load->library('settings/settings');
		
		$this->banner_settings = array(
			
			array('slug' => 'banners_width','title' => 'Banner Width', 'description' => '', 'type' => 'text', 'default' => '400', 'value' => '', 'options' => '', 'is_required' => '1', 'is_gui' => '1', 'module' => 'banners'),
			array('slug' => 'banners_height','title' => 'Banner Height', 'description' => '', 'type' => 'text', 'default' => '400', 'value' => '', 'options' => '', 'is_required' => '1', 'is_gui' => '1', 'module' => 'banners'),
			array('slug' => 'banners_speed','title' => 'Banner Speed', 'description' => '', 'type' => 'text', 'default' => '3000', 'value' => '', 'options' => '', 'is_required' => '1', 'is_gui' => '1', 'module' => 'banners' ),
			array('slug' => 'banners_buttons','title' => 'Banner Button','description' => '','type' => 'radio', 'default' => '1', 'value' => '', 'options' => '1=On|0=Off', 'is_required' => '1', 'is_gui' => '1', 'module' => 'banners' ),
			array('slug' => 'banners_cycle','title' => 'Banner Cycle','description' => '','type' => 'radio', 'default' => '1', 'value' => '', 'options' => '1=On|0=Off', 'is_required' => '1', 'is_gui' => '1', 'module' => 'banners'),
			array('slug' => 'banners_directory','title' => 'Banner Directory','description' => '','type' => 'text', 'default' => 'banners', 'value' => '', 'options' => '', 'is_required' => '1', 'is_gui' => '1', 'module' => 'banners' )
		);
		
		$this->dropOldSettings($this->banner_settings);
		foreach( $this->banner_settings as $banner_setting){
		
			$this->settings->add($banner_setting);
		}
		return true;
		
	}

	private function dropOldSettings($settings){
	
		foreach($settings as $setting){
		
			$this->settings->delete($setting['slug']);
		}
	}
	public function uninstall()
	{
		/*
		*
		* Удаление настроек
		*
		*/
		$this->dropOldSettings($this->banner_settings);
		return TRUE;
	}


	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "Help banners";
	}
}
/* End of file details.php */