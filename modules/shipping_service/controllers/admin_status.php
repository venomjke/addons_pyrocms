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
class Admin_status extends Admin_Controller
{

	/**
	 * The current active section
	 * @access protected
	 * @var string
	 */
	protected $section = 'status';
	
	private $createstatus_validation_rules = array(
		array(
			'field' => 'name',
			'label' => 'lang:shipping_service.status_name',
			'rules' => 'required|trim'
		),
		array(
			'field' => 'comment',
			'label' => 'lang:shipping_service.status_comment',
			'rules' => 'required|trim|xss_clean'
		),
		array(
			'field' => 'default',
			'label' => 'lang:shipping_service.status_default',
			'rules' => 'is_natural'
		),
		array(
			'field' => 'notification',
			'label' => 'lang:shipping_service.status_notification',
			'rules' => 'is_natural'
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
		
	}

	/*
	*
	*
	* Show all shipping orders
	*
	*/
	public function index($offset = 0){
		$all_status     = $this->shipping_status_m->get_all();
		$this->template
		     ->title($this->module_details['name'])
			 ->build('admin/viewstatus',array( 'all_status' => $all_status ));
	}
		
	public function create(){
		$this->form_validation->set_rules($this->createstatus_validation_rules);
		
		if( $this->form_validation->run() ){
		
			if( $this->shipping_status_m->insert($this->input->post()) ){	
				$this->session->set_flashdata('success',lang('shipping_service.success_createstatus'));			
				if( $this->input->post('btnAction') == 'save_exit' ){
					redirect('admin/shipping_service/status');
				}else{
					redirect('admin/shipping_service/status/create/');
				}
			}else{
				$this->session->set_flashdata('error',lang('shipping_service.error_createstatus'));
				redirect('admin/shipping_service/status/create');
			}
			
			return TRUE;
		}
		$this->template
			 ->build('admin/createstatus');
	}
	
	public function view($id = ''){
		if( !empty($id) ) {
			$status = $this->shipping_status_m->get($id);
			
			$this->form_validation->set_rules($this->createstatus_validation_rules);
			
			if( $this->form_validation->run() ){
			
				if( $this->shipping_status_m->update($id,$this->input->post()) ){
					$this->session->set_flashdata('success',lang('shipping_service.status_successchange'));
					
					if( $this->input->post('btnAction') == 'save_exit' ){
						redirect('admin/shipping_service/status/');
					}else{
						redirect('admin/shipping_service/status/view/'.$id);
					}
				}else{
					$this->session->set_flashdata('error',lang('shipping_service.status_errorchange'));
					redirect('admin/shipping_service/status/view/'.$id);
				}
				return true;
			}
			
			if( !empty($status) ){
				$this->template
					 ->set('status',$status)
					 ->build('admin/status');
			}
			return TRUE;
		}
		redirect('admin/shipping_service/status/');
	
	}
	
	public function del($id = ''){
	
		if( $this->input->post('btnAction') == 'delete' ){
			$del_status = $this->input->post('action_to');
			foreach($del_status as $status){
				$this->shipping_status_m->delete($status);
			}
		}else{ 
			if( !empty($id) ){
				$this->shipping_status_m->delete($id);
			}
		}
		redirect('admin/shipping_service/status/');
	}
	
}
