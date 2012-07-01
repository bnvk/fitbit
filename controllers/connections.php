<?php
class Connections extends MY_Controller
{
	protected $consumer;
	protected $fitbit;
	protected $module_site;

    function __construct()
    {
        parent::__construct();
		   
		if (config_item('fitbit_enabled') != 'TRUE') redirect(base_url());
	
		// Load Library
        $this->load->library('oauth');
		
		// Get Site
		$this->module_site = $this->social_igniter->get_site_view_row('module', 'fitbit');	
	}

	function index()
	{
		redirect(base_url());
	}

	function add()
	{
		// User Is Logged In
		if (!$this->social_auth->logged_in()) redirect('login');

        // Create Consumer
        $consumer = $this->oauth->consumer(array(
            'key' 	 	=> config_item('fitbit_consumer_key'),
            'secret' 	=> config_item('fitbit_consumer_secret'),
            'callback'	=> base_url().'fitbit/connections/add'
        ));

        // Load Provider
        $fitbit = $this->oauth->provider('fitbit');		
	
		// Send to fitbit
        if (!$this->input->get_post('oauth_token'))
        {		
            // Get request token for consumer
            $token = $fitbit->request_token($consumer);

            // Store token
            $this->session->set_userdata('oauth_token', base64_encode(serialize($token)));

            // Redirect fitbit
            $fitbit->authorize($token, array('oauth_callback' => base_url().'fitbit/connections'));
		}
		else
		{
      		// Has Stored Token
            if ($this->session->userdata('oauth_token'))
            {
                // Get the token
                $token = unserialize(base64_decode($this->session->userdata('oauth_token')));
            }

			// Has Token
            if (!empty($token) AND $token->access_token !== $this->input->get_post('oauth_token'))
            {   
                // Delete token, it is not valid
                $this->session->unset_userdata('oauth_token');

                // Send the user back to the beginning
                exit('invalid token after coming back to site');
            }

            // Store Verifier
            $token->verifier($this->input->get_post('oauth_verifier'));

            // Exchange request token for access token
            $tokens = $fitbit->access_token($consumer, $token);
		
			// Check Connection
			$check_connection = $this->social_auth->check_connection_auth('fitbit', $tokens->access_token, $tokens->secret);

			if (connection_has_auth($check_connection))
			{			
				$this->session->set_flashdata('message', "You've already connected this fitbit account");
				redirect('settings/connections', 'refresh');							
			}
			else
			{			
				// Get User Details
				$fitbit_user = $fitbit->get_user_info($consumer, $tokens);

				// Add Connection	
	       		$connection_data = array(
	       			'site_id'				=> $this->module_site->site_id,
	       			'user_id'				=> $this->session->userdata('user_id'),
	       			'module'				=> 'fitbit',
	       			'type'					=> 'primary',
	       			'connection_user_id'	=> $fitbit_user->encodedId,
	       			'connection_username'	=> $fitbit_user->nickname,
	       			'auth_one'				=> $tokens->access_token,
	       			'auth_two'				=> $tokens->secret
	       		);

	       		// Update / Add Connection	       		
	       		if ($check_connection)
	       		{
	       			$connection = $this->social_auth->update_connection($check_connection->connection_id, $connection_data);
	       		}
	       		else
	       		{
					$connection = $this->social_auth->add_connection($connection_data);
				}

				// Connection Status				
				if ($connection)
				{				
					$this->session->set_flashdata('message', "Fitbit account connected");
				 	redirect('settings/connections', 'refresh');
				}
				else
				{
				 	$this->session->set_flashdata('message', "Opps, we were not able to connect, perhaps your Fitbit account is connected to another user");
				 	redirect('settings/connections', 'refresh');
				}
			}		
		}
	}
}