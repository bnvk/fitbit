<?php

class OAuth_Provider_Fitbit extends OAuth_Provider {

	public $name = 'fitbit';
	public $uid_key = 'user_id';

	public function url_request_token()
	{
		return 'https://api.fitbit.com/oauth/request_token';
	}

	public function url_authorize()
	{
		return 'https://www.fitbit.com/oauth/authorize';
	}

	public function url_access_token()
	{
		return 'https://api.fitbit.com/oauth/access_token';
	}
	
	public function get_user_info(OAuth_Consumer $consumer, OAuth_Token $token)
	{		
		// Create a new GET request with the required parameters
		$request = OAuth_Request::forge('resource', 'GET', 'https://api.fitbit.com/1/user/-/profile.json', array(
			'oauth_consumer_key' 	=> $consumer->key,
			'oauth_token' 			=> $token->access_token
		));

		// Sign the request using the consumer and token
		$request->sign($this->signature, $consumer, $token);

		$user = current(json_decode($request->execute()));
		
		// Create a response from the request
		return $user;
	}

	public function get_user_activity(OAuth_Consumer $consumer, OAuth_Token $token)
	{		
		// Create a new GET request with the required parameters
		// $request = OAuth_Request::forge('resource', 'GET', 'https://api.fitbit.com/1/user/222F5Z/activities/date/'.date('Y-m-d').'.json', array(
		$request = OAuth_Request::forge('resource', 'GET', 'https://api.fitbit.com/1/user/222F5Z/activities.json', array(
			'oauth_consumer_key' 	=> $consumer->key,
			'oauth_token' 			=> $token->access_token
		));

		// Sign the request using the consumer and token
		$request->sign($this->signature, $consumer, $token);

		$activities = json_decode($request->execute());
		
		// Create a response from the request
		return $activities;
	}

	public function get_user_activity_daily(OAuth_Consumer $consumer, OAuth_Token $token)
	{		
		// Create a new GET request with the required parameters
		// $request = OAuth_Request::forge('resource', 'GET', 'https://api.fitbit.com/1/user/222F5Z/activities/date/'.date('Y-m-d').'.json', array(
		$request = OAuth_Request::forge('resource', 'GET', 'https://api.fitbit.com/1/user/222F5Z/activities/date/2012-06-30.json', array(
			'oauth_consumer_key' 	=> $consumer->key,
			'oauth_token' 			=> $token->access_token
		));

		// Sign the request using the consumer and token
		$request->sign($this->signature, $consumer, $token);

		$activities = json_decode($request->execute());
		
		// Create a response from the request
		return $activities;
	}
	
	

} // End Provider_Fitbit