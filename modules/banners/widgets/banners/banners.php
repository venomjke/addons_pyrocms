<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package 		
 * @subpackage 		
 * @author			
 * @modified		-
 *
 * 
 */

class Widget_Banners extends Widgets
{
    public $title		= array(
			'en' => 'Баннер',
			'ru' => 'Баннер',
		);
    public $description	= array(
		'en' => 'Отображает баннер на вашем сайте',
		'ru' => 'Отображает баннер на вашем сайте',
	);
    public $author		= 'Alex.strigin';
    public $website		= '';
    public $version		= '1.0';

    public function run()
    {
		$this->load->library('settings/settings');
		$this->load->model('files/file_folders_m');
		$this->load->model('files/file_m');
		
		$settings = $this->settings_m->get_many_by(array('module' => 'banners'));
		$banner_settings = array();
		foreach($settings as $set){
		
			$banner_settings[$set->slug] = $set->value;
		}
		
		$folder_id = $banner_settings['banners_directory']?$banner_settings['banners_directory']:0;
		$banners = array();
		if( $folder_id )
			$banners = $this->file_m->get_many_by(array('folder_id' => $folder_id ));
		
        return array( 'banners' => $banners, 'banner_settings' => $banner_settings );
    }
}