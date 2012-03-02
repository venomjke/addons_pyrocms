<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * The shipping service lets you to control orders
 *
 * @author 		FlyWeb Dev Team
 * @package 	Flyweb Pyrocms
 * @subpackage 	shipping_service
 * @category 	Modules
 * @license 	Apache License v2.0
 */
class Admin_settings extends Admin_Controller
{

	/**
	 * The current active section
	 * @access protected
	 * @var string
	 */
	protected $section = 'settings';
	
	
	private $settings_validation_rules = array(
		array( 
			'field' => 'create_order_template',
			'lang'  =>  'lang:shipping_service.create_order_template',
			'rules' => 'required|is_natural'
		),
		array(
			'field' => 'change_order_status_template',
			'lang'  => 'lang:shipping_service.change_order_status_template',
			'rules' => 'required|is_natural'
		)
	);
	public function __construct()
	{
		parent::__construct();

		$this->load->model('shipping_service_m');
		$this->load->model('shipping_status_m');
		$this->load->library('form_validation');
		$this->lang->load('shipping_service');
		$this->load->helper('html');
		$this->load->helper('string');
		$this->load->helper('pagination');
		
		$this->load->library('settings/settings');
		$this->load->model('templates/email_templates_m');
		
	}

	public function index(){
	
		$create_order_template  = Settings::get('create_order_template');
		$change_status_template = Settings::get('change_order_status_template');
		
		$all_templates = $this->email_templates_m->get_all();
		$templates = array();
		foreach($all_templates as $template){
		
			$templates[$template->id]=$template->slug;
		}
		$this->form_validation->set_rules($this->settings_validation_rules);
		
		if( $this->form_validation->run() ){
		
			settings::set('create_order_template',$this->input->post('create_order_template'));
			settings::set('change_order_status_template',$this->input->post('change_order_status_template'));
			$this->session->set_flashdata('success',lang('shipping_service.success_settings'));
			redirect('admin/shipping_service/settings');
			return TRUE;
		}
		
		$this->template
			 ->set('create_order_template',$create_order_template)
			 ->set('change_status_template',$change_status_template)
			 ->set('templates',$templates)
			 ->build('admin/settings/index');
	}
	
	public function _check_valild_template($id = 0){
	
		$template = $this->email_templates_m->get_by('id',$id);
		if (!empty($template))
		{
			return TRUE;
		}
		return FALSE;
	}
}
