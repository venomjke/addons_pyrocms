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
class Admin extends Admin_Controller
{

	/**
	 * The current active section
	 * @access protected
	 * @var string
	 */
	protected $section = 'orders';
	/*
	*
	*	limit_orders 
	*/
	private $limit_orders = 10;
	
	private $changestatus_validation_rules = array(
		array(
			'field' => 'id_status',
			'label' => 'lang:shipping_service.order_status',
			'rules' => 'required|is_natural_no_zero'
		),
		array(
			'field' => 'cost_shipping',
			'label' => 'lang:shipping_service.cost_shipping',
			'rules' => 'required|trim|numeric|max_length[10]'
		),
		array(
			'field' => 'note_status',
			'label' => 'lang:shipping_service.note_status',
			'rules' => 'max_length[512]'
		)
	);
	
	/*
	*
	* valid export types
	*/
	private $valid_export_types = array(
		'xls'
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
		$this->load->model('templates/email_templates_m');
		$this->template
			->set_partial('shortcuts', 'admin/partials/shortcuts')
			->append_metadata(css("admin/shipping_service.css","shipping_service"));
		
	}

	/*
	*
	*
	* Show all shipping orders
	*
	*/
	public function index($offset = 0){
	
		$base_where = array();
		
		
		/*
		*
		* check filter fields
		*
		*/
		if($this->input->post('f_nsp_customer')){
			$base_where['nsp_customer'] = $this->input->post('f_nsp_customer');
		}
		
		if($this->input->post('f_phone_customer')){
			$base_where['phone_customer'] = $this->input->post('f_phone_customer');
		}	
		
		if( $this->input->post('f_nsp_shipping') ){
			$base_where['nsp_shipping'] = $this->input->post('f_nsp_shipping');
		}
		
		if( $this->input->post('f_phone_shipping') ){
			$base_where['phone_shipping'] = $this->input->post('f_phone_shipping');
		}
		/*****************/
		
		$pagination = create_pagination('admin/shipping_service/index/',$this->shipping_service_m->count_all_where($base_where));
		$orders = $this
				  ->shipping_service_m
				  ->order_by('createDate','desc')
				  ->limit($pagination['limit'])
				  ->get_many_by($base_where);

				  
		if($this->input->is_ajax_request()) $this->template->set_layout(false);
		
		$this->template
		     ->title($this->module_details['name'])
			 ->set_partial('filters', 'admin/partials/filters')
			 ->set_partial('tables/orders','admin/tables/orders')
			 ->append_metadata(js('admin/filter.js'))
			 ->set('orders',$orders)
			 ->set('pagination',$pagination);
		
		$this->input->is_ajax_request() ? $this->template->build('admin/tables/orders') : $this->template->build('admin/index');
	}
	
	
	/*
	*
	*
	* Export orders in document
	*
	* @type - type of export
	*/
	public function export($type = 'xls'){
	
		if( in_array($type,$this->valid_export_types)){
			
			$this->load->helper('excel');
			$orders = $this->shipping_service_m->get_all();
			
			$orders_array = array(
				array( 'Код заказа' => '', 'Ф.И.О заказчика' => '', 'Адрес заказчика' =>'', 'Вложение' => '','Стоимость доставки' => '', 'Телефон заказчика' => '', 'Ф.И.О получателя' => '','Телефон получателя' => '', 'Адрес получателя' => '', 'Статус заказа' => '', 'Стоимость заказа'  => '')
			);
			
			foreach($orders as $order) {
			
				$row = array();
				$row[] = $order->id;
				$row[] = $order->nsp_customer;
				$row[] = $order->address_customer;
				$row[] = $order->investment_customer;
				$row[] = $order->cost_shipping;
				$row[] = $order->phone_customer;
				$row[] = $order->nsp_shipping;
				$row[] = $order->phone_shipping;
				$row[] = $order->address_shipping;
				$row[] = $order->id_status?$this->shipping_status_m->get_status_name($order->id):$this->shipping_status_m->get_default_status();
				$row[] = $order->price_shipping;
				$orders_array[] = $row; 
			}
			
			array_to_excel($orders_array,lang('shipping_service.export_file_name'));
		}else{
			redirect('admin/shipping_service/');
		}
	}
	
	
	/*
	*
	*
	* delete the order from database
	*
	*/
	public function del($id = ''){
	
		if( $this->input->post('btnAction') == 'delete' ){
			$del_orders = $this->input->post('action_to');
			foreach($del_orders as $del_order){
				$this->shipping_service_m->delete($del_order);
			}
		}else{
			if( !empty($id) ){
				$this->shipping_service_m->delete($id);
			}
		}
		redirect('admin/shipping_service/');
	}
	
	

	
	
	/*
	*
	*	
	* View the order
	*
	*	@id - order id
	*/
	public function view($id = ''){
	
		$order = $this->shipping_service_m->get($id);
		$all_status = $this->shipping_status_m->get_all_status();
		if( !empty($order) ){
			$this->template
				 ->set('order',$order)
				 ->set('all_status',$all_status)
				 ->build('admin/view');
			return TRUE;
		}
		redirect('admin/shipping_service');
	
	}
	
	/*
	*
	*	Change the status of order
	*	
	*	@id - order id
	*/
	public function changestatus($id = ''){
	
		$order = '';
		if( $this->shipping_service_m->exists($id,$order) ){
			$all_status = $this->shipping_status_m->get_all_status();
			$this->form_validation->set_rules($this->changestatus_validation_rules);
			
			if( $this->form_validation->run() ){
			
				if( $this->shipping_service_m->update($id,$this->input->post()) ){
				
					/*
					*
					*	Send notification about change the status
					*
					*/
					$this->_change_status_email($order);
					
					$this->session->set_flashdata('success',lang('shipping_service.success_changestatus'));			
					if( $this->input->post('btnAction') == 'save_exit' ){
						redirect('admin/shipping_service/');
					}else{
						redirect('admin/shipping_service/view/'.$id);
					}
				}else{
					$this->session->set_flashdata('error',lang('shipping_service.error_changestatus'));
					redirect('admin/shipping_service/view/'.$id);
				}
			}
			
			$this->template
				 ->set('order',$order)
				 ->set('all_status',$all_status)
				 ->build('admin/view');
			return TRUE;
		}
		redirect('admin/shipping_service/');
	}
	
	private function _change_status_email($order){
		$change_order_status_template = Settings::get('change_order_status_template');
		if(!empty($change_order_status_template) ){
		
			$template = $this->email_templates_m->get($change_order_status_template);
			$status   = $this->shipping_status_m->get($this->input->post('id_status'));
			/**
			*
			*	email notification send only when notification label is set 
			*
			*/
			if( !empty($template) && $status->notification ){
		
				// Add in some extra details about the visitor
				$data['name']			= 'no-reply';
				$data['slug'] 			= $template->slug;
				$data['order_status']	= $this->shipping_status_m->get_status_name($this->input->post('id_status'));
				
				// they may have an email field in the form. If they do we'll use that for reply-to.
				$data['to']				= $order->email_customer;
				$data['from']			= Settings::get("server_email");
				$data = array_merge($data,(array)$order);
				// Try to send the email
				$results = Events::trigger('email', $data, 'array');
				
						
				foreach ($results as $result)
				{
					if ( ! $result)
					{					
						$this->session->set_flashdata('error', $result);
					}
				}
			}
		}
		
		return FALSE;
	
	}

	
	
	
	

}
