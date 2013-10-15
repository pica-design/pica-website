<?php
 	ini_set('display_errors', 1);
	//Make sure the remote server is set to local EST time for date display
	date_default_timezone_set('America/New_York');
	//Force the php max execution time to 2min 
	ini_set('max_execution_time', '240') ;
	//Force the php memory limit be raised
	ini_set('memory_limit', '256M') ;
	
	/**
	
		HOSTING SPECIFIC - Yea, you gotta - uh - change these.. n' stuff... k?
	
	*/
	
	//LIVE @ PICA VPS
	
	$working_dir 	= '/home/pica/public_html/approval';
	$site_url 		= 'http://approval.picadesign.com';
	$manage_path 	= "/manage/index.php";
	
	//LOCAL @ Pica Dev
	/*
	$working_dir	= '/Other Pica Shares/Websites/pica_approval_2';
	$site_url 		= "http://picadesign.ath.cx/pica_approval_2";
	$manage_path 	= "/pica_approval_2/manage/index.php";
	*/

	/*
	//LOCAL @ James Home
	$working_dir 	= 'D:\My Documents\XMAPP\htdocs\pica_approval';
	$site_url 		= 'http://localhost/pica_approval';
	$manage_path 	= "/manage/index.php";
	*/
	
	/**
		INCLUDE OUR EXTERNAL CLASS LIBRARIES
	*/
	include_once('database.class.php');
	include_once('approval.class.php');
?>
