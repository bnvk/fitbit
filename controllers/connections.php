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
		// Is Logged In
		if ($this->social_auth->logged_in()) redirect('connections/fitbit/add');
		
        // Create Consumer
        $consumer = $this->oauth->consumer(array(
            'key' 	 	=> config_item('fitbit_consumer_key'),
            'secret' 	=> config_item('fitbit_consumer_secret'),
            'callback'	=> base_url().'fitbit/connections'
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

			// Load Tweet Library
			$this->load->library('tweet', array('access_key' => $tokens->access_token, 'access_secret' => $tokens->secret));	            
			
			// Get User Details
			$fitbit_user = $this->tweet->call('get', 'account/verify_credentials');
			
			// Already Connected
			if ($check_connection)
			{
				// Adds Auth Tokens (if user had already been added via fitbit without having authed in)
				if (connection_has_auth($check_connection))
				{
					$connection_data = array(
						'auth_one'	=> $tokens->access_token,
						'auth_two'	=> $tokens->secret
					);

					$this->social_auth->update_connection($check_connection->connection_id, $connection_data);
				}
				
				// Login
	        	if ($this->social_auth->social_login($check_connection->user_id, 'fitbit')) 
	        	{
		        	$this->session->set_flashdata('message', "Login with Fitbit was successful");
		        	redirect(base_url().'home', 'refresh');
		        }
		        else 
		        { 
		        	$this->session->set_flashdata('message', "Login with Fitbit in-correct");
		        	redirect("login", 'refresh');
		        }			
			}
			else
			{				
				// Signup Social Data
				echo 'HERE';			
			}
		}		
	}


	function add()
	{
		// User Is Logged In
		if (!$this->social_auth->logged_in()) redirect('connections/fitbit');

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

			// Load Tweet Library
			$this->load->library('tweet', array('access_key' => $tokens->access_token, 'access_secret' => $tokens->secret));	            
			
			// Get User Details
			$fitbit_user = $this->tweet->call('get', 'account/verify_credentials');

			if (connection_has_auth($check_connection))
			{			
				$this->session->set_flashdata('message', "You've already connected this fitbit account");
				redirect('settings/connections', 'refresh');							
			}
			else
			{
				// Add Connection	
	       		$connection_data = array(
	       			'site_id'				=> $this->module_site->site_id,
	       			'user_id'				=> $this->session->userdata('user_id'),
	       			'module'				=> 'fitbit',
	       			'type'					=> 'primary',
	       			'connection_user_id'	=> $fitbit_user->id,
	       			'connection_username'	=> $fitbit_user->screen_name,
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
					$this->social_auth->set_userdata_connections($this->session->userdata('user_id'));
				
					$this->session->set_flashdata('message', "fitbit account connected");
				 	redirect('settings/connections', 'refresh');
				}
				else
				{
				 	$this->session->set_flashdata('message', "That fitbit account is connected to another user");
				 	redirect('settings/connections', 'refresh');
				}
			}		
		}
	}
}