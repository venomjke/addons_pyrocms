<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 */
class Shipping_status_m extends MY_Model {

	public function __construct(){
	
		parent::__construct();
		
		$this->set_table_name('shipping_status');
	}
	
	public function get_all_status(){
	
		$all_status = parent::get_all();
		$result = array();
		foreach($all_status as $status){
			$result[$status->id] = $status->name;
		}
		
		return $result;
	}
	
	public function get_status_name($id = ''){
	
		if( !empty($id) ){
		
			$this->db->where('id =',$id);
			$query = $this->db->get($this->table_name());
			
			if( $query->num_rows() > 0 ){
			
				return $query->row()->name;
			}
		}
		return NULL;
	}
	
	public function get_default_status(){
	
		$this->db->where('default =',1);
		$this->db->limit(1);
		$query = $this->db->get($this->table_name());
		
		if( $query->num_rows() > 0){
		
			return $query->row()->name;
		}
		
		return NULL;
	}
	public function insert($input){
	
		return parent::insert(array(
			'name'    => $input['name'],
			'comment' => $input['comment'],
			'default' => !empty($input['default'])?$input['default']:0,
			'notification' => !empty($input['notification'])?$input['notification']:0
		));
	}
	
	public function update($id,$input){
	
		return parent::update($id,array(
			'name'    => $input['name'],
			'comment' => $input['comment'],
			'default' => !empty($input['default'])?$input['default']:0,
			'notification' => !empty($input['notification'])?$input['notification']:0
		));
	}
}