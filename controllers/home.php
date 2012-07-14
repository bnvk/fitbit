<?php
class Home extends Dashboard_Controller
{
    function __construct()
    {
        parent::__construct();

		$this->load->config('fitbit');

		$this->data['page_title'] = 'Fitbit';
	}
	
	function overview()
	{
		$this->data['sub_title'] = 'Overview';

        // Get Connection
   		if ($connection = $this->social_auth->check_connection_user($this->session->userdata('user_id'), 'fitbit', 'primary'))
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
				'access_token' 	=> $connection->auth_one,
				'secret' 		=> $connection->auth_two
			));
	
			$this->data['activities'] = $fitbit->get_user_activity($consumer, $tokens, $connection->connection_user_id);
			$this->data['activities_daily'] = $fitbit->get_user_activity_daily($consumer, $tokens, $connection->connection_user_id, date('Y-m-d'));
		}
		else
		{
			
		}

		$this->render();
	}
}