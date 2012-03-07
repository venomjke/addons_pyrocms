<?php defined('BASEPATH') or exit('No direct script access allowed');

	
	function removeDir($path)
	{
		if ($objs = glob($path."/*")) {
			foreach($objs as $obj) {
				is_dir($obj) ? removeDirRec($obj) : unlink($obj);
			}
		}
		rmdir($path);
	}


class Module_Shipping_Service extends Module {

	public $version = '1.0.1';

	private $shipping_service_settings = array(
	
		array('slug' => 'create_order_template','title' => 'Template for email after create order', 'description' => '', 'type' => 'select', 'default' => '', 'value' => '', 'options' => '', 'is_required' => '1', 'is_gui' => '0', 'module' => 'shipping_service'),
		array('slug' => 'change_order_status_template','title' => 'Template for email after change status order', 'description' => '', 'type' => 'select', 'default' => '', 'value' => '', 'options' => '', 'is_required' => '1', 'is_gui' => '0', 'module' => 'shipping_service')
	);
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Shipping Service',
				'ru' => 'Сервис доставки'
			),
			'description' => array(
				'en' => 'The shipping service module let you control process make order, view order e.t.c',
				'ru' => 'Модуль сервиса доставки позволяет контролировать процесс создания, просмотра, отслеживания состояния заказа'
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'content',
			'sections' => array(
				'settings' => array(
					'name' => 'shipping_service.settings',
					'uri'  => 'admin/shipping_service/settings'
				),
				'status'   => array(
					'name' => 'shipping_service.status',
					'uri'  => 'admin/shipping_service/status',
					'shortcuts' => array(
						array(
							'name' => 'shipping_service.order_status',
							'uri' => 'admin/shipping_service/status/create',
							'class' => 'add'
						)
					)
				),
				'orders'   => array(
					'name' => 'shipping_service.orders',
					'uri'  => 'admin/shipping_service/',
					'shortcuts' => array(
						array(
						   'name' => 'shipping_service.export_orders',
						   'uri' => 'admin/shipping_service/export',
						   'class' => 'add'
						)
					)
				)
			)
		);
	}

	public function install()
	{
		$this->load->library('settings/settings');
		/*
		*
		*	1. DROP OLD TABLES 
		*	2. CHECK FILE FOR EXISTS
		*	3. LOAD AND EXECUTE DATABASE METAFILE
		*/
		$this->dbforge->drop_table('shipping_service');
		$this->dbforge->drop_table('shipping_status');
		
		$path = dirname(__FILE__);
		
		//.php - а ларчик то просто открывался :)
		//.php - because .sql and other are not copied at installation
		
		if( file_exists($path.'/database/shipping_service_db.php') && file_exists($path.'/database/shipping_status_db.php') ){

			$shipping_service_db = file_get_contents($path.'/database/shipping_service_db.php');
			$shipping_status_db  = file_get_contents($path.'/database/shipping_status_db.php');
			
			$shipping_status_db = preg_replace('@\{DATABASE_NAME\}@',$this->db->dbprefix('shipping_status'),$shipping_status_db);
			$shipping_service_db = preg_replace('@\{DATABASE_NAME\}@',$this->db->dbprefix('shipping_service'),$shipping_service_db);
			
			removeDir($path.'/database'); 
			/*
			/I think what this folder may remove
			*/
			
			if($this->db->query($shipping_service_db) && $this->db->query($shipping_status_db)){
			
			
				$this->dropOldSettings();
				foreach( $this->shipping_service_settings as $shipping_service_setting){
				
					$this->settings->add($shipping_service_setting);
				}
				return TRUE;
			}
			return FALSE;
		}else{
		
			log_message('error','module:shipping_service: The file shipping_service_db.php or shipping_status_sql missing');
			return FALSE;
		}
	}

	public function dropOldSettings(){
		foreach( $this->shipping_service_settings as $shipping_service_setting){
		
			$this->settings->delete($shipping_service_setting['slug']);
		}
	}
	
	public function uninstall()
	{
		if( $this->dbforge->drop_table('shipping_service') && $this->dbforge->drop_table('shipping_status') ){
			$this->dropOldSettings();
			return TRUE;
		}
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
		return "<h4> Shipping Service </h4>";
	}
}
/* End of file details.php */