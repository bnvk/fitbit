<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:			Social Igniter : Fitibt : Install
* Author: 		Brennan Novak
* 		  		contact@social-igniter.com
*          
* Created: 		Brennan Novak
*
* Project:		http://social-igniter.com/
* Source: 		http://github.com/socialigniter/fitbit
*
* Description: 	Install values for App Template for Social Igniter 
*/

/* Settings */
$config['fitbit_settings']['widgets'] 				= 'TRUE';
$config['fitbit_settings']['enabled']				= 'TRUE';
$config['fitbit_settings']['consumer_key'] 			= '';
$config['fitbit_settings']['consumer_secret'] 		= '';
$config['fitbit_settings']['social_connection'] 	= 'TRUE';
$config['fitbit_settings']['connections_redirect']	= '';
$config['fitbit_settings']['archive']				= '';

/* Sites */
$config['fitbit_sites'][] = array(
	'url'		=> 'http://fitbit.com/', 
	'module'	=> 'fitbit', 
	'type' 		=> 'remote', 
	'title'		=> 'Fitbit', 
	'favicon'	=> 'http://fitbit.com/favicon.ico'
);