<?php
class Fitbit extends Site_Controller
{
    function __construct()
    {
        parent::__construct();   

        if (config_item('fitbit_enabled') != 'TRUE') redirect(base_url());        

		$this->data['page_title'] 	= 'Fitibt';
	}
	
	function index()
	{
		redirect();	
	}

	/* Widgets */
	function widgets_daily_activity($widget_data)
	{
        // Get Connection
        // Need to address user_id
   		if ($connection = $this->social_auth->check_connection_user(config_item('fitbit_widgets_daily_activity'), 'fitbit', 'primary'))
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
	
			$widget_data['activities_daily'] = $fitbit->get_user_activity_daily($consumer, $tokens, $connection->connection_user_id, date('Y-m-d'));	
		}
		else
		{
			$widget_data['activities_daily'] = FALSE;
		}
		
		$this->load->view('widgets/daily_activity', $widget_data);
	}
	
}
