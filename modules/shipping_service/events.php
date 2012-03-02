<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Events_Shipping_Service {

    protected $ci;

    protected $fallbacks = array();

    public function __construct()
    {
        $this->ci =& get_instance();

        //register the email event
        Events::register('post_user_login', array($this, 'post_user_login'));
    }
	
	public function post_user_login(){
	
		redirect(base_url());
	}
}
/* End of file events.php */