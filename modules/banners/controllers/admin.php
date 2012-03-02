<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * 
 *
 * @author 		alex.strigin
 * @package 	 flyweb
 * @subpackage 	 Module
 * @category 	Modules
 * @license 	Apache License v2.0
 */
class Admin extends Admin_Controller
{
	private $settings_validation_rules = array(
		array(
			'field' => 'banners_width',
			'label' => 'lang:banners.banners_width',
			'rules' => 'trim|is_natural_no_zero|required'
		),
		array(
			'field' => 'banners_height',
			'label' => 'lang:banners.banners_height',
			'rules' => 'trim|is_natural_no_zero|required'
		),
		array(
			'field' => 'banners_directory',
			'label' => 'lang:banners.banners_directory',
			'rules' => 'trim|integer|required|callback__check_folder'
		),
		array(
			'field' => 'banners_speed',
			'label' => 'lang:gallery_images.description_label',
			'rules' => 'trim|integer|required'
		),
		array(
			'field' => 'banners_buttons',
			'label' => 'lang:banners.banners_buttons',
			'rules' => 'trim|is_natural_zero|required'
		),
		array(
			'field' => 'banners_cycle',
			'label' => 'lang:banners.banners_cycle',
			'rules' => 'trim|is_natural_zero|required'
		)
	);

	public function __construct()
	{
		parent::__construct();

		$this->load->library('settings/settings');
		$this->load->model('settings/settings_m');
		$this->load->model('files/file_folders_m');
		$this->load->model('files/file_m');
		// Load all the required classes
		$this->load->library('form_validation');
		$this->load->helper('html');
	}

	/*
	* 
	* List all existing settings
	* @access public
	* @return void
	*
	*/
	public function index(){
		$this->lang->load('banners');
		$settings = $this->settings_m->get_many_by('banners');
		$file_folders = $this->file_folders_m->get_folders();
		$folders_tree = array();
		foreach($file_folders as $folder)
		{
			$indent = repeater('&raquo; ', $folder->depth);
			$folders_tree[$folder->id] = $indent.$folder->name;
		}
		$this->template
			->title($this->module_details['name'])
			->set('settings',$settings)
			->set('folders',$folders_tree)
			->build('admin/index');
	}

	public function save(){
		$this->lang->load('banners');
		$settings = $this->settings_m->get_many_by('banners');
		$file_folders = $this->file_folders_m->get_folders();
		$folders_tree = array();
		foreach($file_folders as $folder)
		{
			$indent = repeater('&raquo; ', $folder->depth);
			$folders_tree[$folder->id] = $indent.$folder->name;
		}
		// Set the validation rules
		$this->form_validation->set_rules($this->settings_validation_rules);

		if ($this->form_validation->run() )
		{
			foreach($this->settings_validation_rules as $r){
				$this->settings_m->update($r['field'],array('value' => $this->input->post($r['field'])));
			}
			$this->session->set_flashdata('success', lang('banners.success_change'));
			redirect('admin/banners');
			return TRUE;
		}
		$this->template
			->title($this->module_details['name'])
			->set('settings',$settings)
			->set('folders',$folders_tree)
			->build('admin/index');
	}




	/**
	 * Callback method that checks the file folder of the gallery
	 * @access public
	 * @param int id The id to check if file folder exists or prep to create new folder
	 * @return bool
	 */
	public function _check_folder($id = 0)
	{
		if ($this->file_folders_m->exists($id))
		{
	
			return TRUE;
		}
		return FALSE;
	}
}
