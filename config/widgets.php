<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:			Social Igniter : Fitbit : Widgets
* Author: 		Brennan Novak
* 		  		contact@social-igniter.com
*         		@brennannovak
*          
* Project:		http://social-igniter.com/
* Source: 		http://github.com/brennannovak/fitibt
*
* Description: 	Widgets for Fitbit App for Social-Igniter
*/

$config['fitbit_widgets'][] = array(
	'regions'	=> array('sidebar','content','wide'),
	'widget'	=> array(
		'module'	=> 'fitbit',
		'name'		=> 'Daily Activity',
		'method'	=> 'run',
		'path'		=> 'widgets_daily_activity',
		'multiple'	=> 'FALSE',
		'order'		=> '1',
		'title'		=> 'Daily Activity',
		'content'	=> ''
	)
);