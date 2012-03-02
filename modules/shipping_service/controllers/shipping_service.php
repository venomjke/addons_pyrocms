<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * The shipping service module enables users to create order, check order
 *
 * @author 		Flyweb Dev Team
 * @package 	Flyweb pyrocms
 * @subpackage 	Gallery Module
 * @category 	Modules
 * @license 	Apache License v2.0
 */
class Shipping_Service extends Public_Controller
{

	private $createorder_validation_rules = array(	
		array(
			'field' => 'nsp_customer',
			'label' => 'lang:shipping_service.nsp_customer',
			'rules' => 'trim|min_length[1]|max_length[100]|required'
		),
		array(
			'field' => 'phone_customer',
			'label'	=> 'lang:shipping_service.phone_customer',
			'rules' => 'trim|min_length[7]|max_length[30]|required'
		),
		array(
			'field' => 'email_customer',
			'label' => 'lang:shipping_service.email_customer',
			'rules' => 'trim|valid_email|required'
		),
		array(
		
			'field' => 'address_customer',
			'label' => 'lang:shipping_service.address_customer',
			'rules' => 'trim|required|max_length[256]'
		),
		array(
			'field' => 'address_shipping',
			'label' => 'lang:shipping_service.address_shipping',
			'rules' => 'trim|required|max_length[256]'
		),
		array(
			'field' => 'investment_customer',
			'label' => 'lang:shipping_service.investment_customer',
			'rules' => 'trim|required|max_length[512]'
		),
		array(
			'field' => 'nsp_shipping',
			'label' => 'lang:shipping_service.nsp_shipping',
			'rules' => 'trim|min_length[1]|max_length[100]|required'
		),
		array(
			'field' => 'phone_shipping',
			'label' => 'lang:shipping_service.phone_shipping',
			'rules' => 'trim|min_length[7]|max_length[30]|required',
		),
		array(
			'field' => 'price_shipping',
			'label' => 'lang:shipping_service.price_shipping',
			'rules' => 'trim|numeric|required|max_length[16]'
		),
		array(
			'field' => 'note_customer',
			'label' => 'label:shipping_service.note_customer',
			'rules' => 'trim|xss_clean'
		)
	);
	
	
	private $checkorder_validation_rules = array(
		array(
			'field' => 'order_id',
			'label' => 'lang:shipping_service.order_id',
			'rules' => 'trim|required|min_length[1]|max_length[10]'
		)
	);
	/**
	 * Constructor method
	 *
	 * @author Flyweb Dev Team
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		// Load the required classes
		$this->load->model('shipping_service_m');
		$this->load->model('shipping_status_m');
		$this->load->model('templates/email_templates_m');
		/*************************/
		$this->load->library('form_validation');
		$this->load->library('settings/settings');
		/*************************/
		$this->lang->load('shipping_service');
		$this->load->helper('html');
		$this->load->helper('string');
		/*************************/
	}
	
	
	public function index(){
		redirect('shipping_service/createorder');
	}
	
	/*
	*
	*	Creating order for shipping something
	*
	*/
	public function createorder(){
	
		$this->template
			 ->set('user',$this->current_user)
			 ->append_metadata('<script src="http://cdn.jquerytools.org/1.2.6/full/jquery.tools.min.js"></script>');
		/*
		*
		*	1. Check form validation
		*	2. Insert order
		*	3. Send email about create order to customer ? and may be admin ?
		*	4. View form
		*/
		
		$this->form_validation->set_rules($this->createorder_validation_rules);
		
		if( $this->form_validation->run() ){
		
			if( $order_id = $this->shipping_service_m->insert($this->input->post()) ){
			
				/*
				*
				* SEND Email notification
				*
				*/
				$this->_create_order_email($order_id,$this->input->post('email_customer'));
			
				$this->template
					 ->build('createorder',array(
							'msg'      => lang('shipping_service.success_insert_order'),
							'order_id' => $order_id
					));
				return TRUE;
			}
		}
		
		$this->template
			 ->build('createorder',array());
	}
	
	/*
	*
	*	Prepare data and send email
	*
	*	@param string
	*	@param string
	*	
	*	The function try to get 'create_order_template' from settings
	*/
	private function _create_order_email($order_id,$to){
		
		$create_order_template = Settings::get('create_order_template');
		
		if( !empty($create_order_template) ){
		
			$template = $this->email_templates_m->get($create_order_template);
			if( !empty($template) ){
				$data['name']			= 'no-reply'; 
				$data['slug'] 			= $template->slug;
				$data['order_id']		= $order_id;
				// they may have an email field in the form. If they do we'll use that for reply-to.
				$data['to']				= $this->input->post('email_customer');
				$data['from']			= Settings::get("server_email");; // need to change
				// Try to send the email
				$results = Events::trigger('email', $data, 'array');
			}
			return TRUE;
		}
		log_message('error','shipping_service:_create_order_email \'create_order_template\' is null');
		return FALSE;
	}
	
	/*
	*
	*	
	*	Checking the order status
	*
	*/
	public function checkorder(){
	
		$this->form_validation->set_rules($this->checkorder_validation_rules);
		
		if( $this->form_validation->run() ){
			$order = $this->shipping_service_m->get($this->input->post('order_id'));
			if( !empty($order) && empty($order->id_status) ){
				
			}
			
			if( !empty($order) ){
				 if( !empty($order->id_status) ){
					$order->status_name = $this->shipping_status_m->get_status_name($order->id_status);
				 }else{
					$order->status_name = $this->shipping_status_m->get_default_status();
				 }
				$this->template->set('order',$order)->build('checkorder');
			}else{
				$this->template->set('msg',lang('shipping_service.null_order'))->build('checkorder');
			}
			return TRUE;
		}
		$this->template
			 ->build('checkorder',array());
	}
}