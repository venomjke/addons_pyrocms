<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 */
class Shipping_service_m extends MY_Model {

	public function __construct(){
	
		parent::__construct();
		
		$this->set_table_name('shipping_service');
	}
	
	
	/*
	* check for exists
	*
	*/
	
	public function exists($id,&$order) {
	
		$this->db->where('id =',$id);
		$this->db->limit(1);
		$query = $this->db->get($this->table_name());
		
		if( $query->num_rows() > 0 )
		{
			$order = $query->row();
			return TRUE;
		}
		return FALSE;
	}
	
	public function count_all_where($params = array()){
	
		$this->filter($params);
		return $this->db->count_all_results($this->table_name());
	}
	/*
	*
	*	Fields filter. Fields name same as fields in the db table
	*	param array
	*
	*/
	public function filter($args = array()){
		if ( ! empty($args['nsp_customer']))
		{
			$this->db->like('shipping_service.nsp_customer',trim($args['nsp_customer']));
		}

		if ( !empty($args['phone_customer']))
		{
		    $this->db
			    ->like('shipping_service.phone_customer', trim($args['phone_customer']));
		}
		
		if( !empty($args['nsp_shipping']) ){
		
			$this->db
				 ->like('shipping_service.nsp_shipping',trim($args['nsp_shipping']));
		}
		
		if( !empty($args['phone_shipping']) ){
		
			$this->db
				 ->like('shipping_service.phone_shipping',trim($args['phone_shipping']));
		}
	}
	public function get_many_by($params = array())
    {
		$this->filter($params);
		return $this->get_all();
    }
	
	public function get_all($limit = false, $offset = false){
	
		if( $limit && $offset ){
		
			$this->db->limit($limit,$offset);
		}else if($limit) {
		
			$this->db->limit($limit);
		}
		
		$this->db
			 ->select("
				shipping_service.*, shipping_status.name as status_name
			 ")
			 ->join('shipping_status','shipping_status.id = shipping_service.id_status','left');
			
		$this->db->order_by('createDate','DESC');
		$orders = parent::get_all();
		return $orders;
	}
	
	
	public function insert($post){

		$order_key = '';
		do{
			$order_key = random_string(5)."-".random_string(5);
		}while(!$this->checkid($order_key));
		
		parent::insert(array(
			'id' => $order_key,
			'nsp_customer'   => $post['nsp_customer'],
			'phone_customer' => $post['phone_customer'],
			'email_customer' => $post['email_customer'],
			'nsp_shipping'	 => $post['nsp_shipping'],
			'phone_shipping' => $post['phone_shipping'],
			'price_shipping' => $post['price_shipping'],
			'note_customer'  => $post['note_customer'],
			'address_customer' => $post['address_customer'],
			'address_shipping' => $post['address_shipping'],
			'investment_customer' => $post['investment_customer']
		));
		return $order_key;
	}
	
	public function update($id,$input){
		return parent::update($id,array(
			'id_status'     => $input['id_status'],
			'cost_shipping' => $input['cost_shipping'],
			'note_status'   => $input['note_status']
		));
	}
	public function checkid($id = ''){
	
		if( !empty($id) ){
		
			$this->db->where('id =',$id);
			$query = $this->db->get($this->table_name());
			if( $query->num_rows() > 0 )
				return FALSE;
			return TRUE;
		}
		return TRUE;
	}
	
	
	public function get($id){
	
		$this->db->where('id =',$id);
		$this->db->limit(1);
		$query = $this->db->get($this->table_name());
		if( $query->num_rows() > 0 ){
		
			return $query->row();
		}
		return NULL;
	}
}