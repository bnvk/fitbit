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

		$this->data['activities'] = $fitbit->get_user_activity($consumer, $tokens);
		$this->data['activities_daily'] = $fitbit->get_user_activity_daily($consumer, $tokens, date('Y-m-d'));		

		$this->render();
	}
}