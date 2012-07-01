<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends Oauth_Controller
{
    function __construct()
    {
        parent::__construct();
	}

    /* Install App */
	function install_get()
	{
		// Load
		$this->load->library('installer');
		$this->load->config('install');        

		// Settings & Create Folders
		$settings = $this->installer->install_settings('fitbit', config_item('fitbit_settings'));

		// Site
		$site = $this->installer->install_sites(config_item('fitbit_sites'));
	
		if ($settings == TRUE)
		{
            $message = array('status' => 'success', 'message' => 'Yay, the Fitbit was installed');
        }
        else
        {
            $message = array('status' => 'error', 'message' => 'Dang Fitbit could not be uninstalled');
        }		
		
		$this->response($message, 200);
	} 

}