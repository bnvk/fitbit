<?php
class Fitbit extends Site_Controller
{
    function __construct()
    {
        parent::__construct();   

        if (config_item('fitbit_enabled') != 'TRUE') redirect(base_url());        

		$this->data['page_title'] 	= 'Fitibt';

		$this->check_connection = $this->social_auth->check_connection_user($this->session->userdata('user_id'), 'fitbit', 'primary');            
	}
	
	function index()
	{
		$this->data['page_title'] = 'Fitbit';
		$this->render();	
	}

	
}
