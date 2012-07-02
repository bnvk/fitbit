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
	
	function recent_activities_get()
	{
		
		// Basic Content Redirect
        $this->load->library('oauth');
        
        // Create Consumer
        $consumer = $this->oauth->consumer(array(
            'key' 	 	=> config_item('fitbit_consumer_key'),
            'secret' 	=> config_item('fitbit_consumer_secret')
        ));

        // Load Provider
        $fitbit = $this->oauth->provider('fitbit');

        // Create Tokens
		$tokens = OAuth_Token::forge('request', array(
			'access_token' 	=> '9a218d70d45fe5c32020201164e63aab',
			'secret' 		=> '7435482cd44ab295c9ed42cfa806297e'
		));

		$activities = $fitbit->get_user_activity_daily($consumer, $tokens);			
		
		$this->response($activities, 200);
	}
	

}