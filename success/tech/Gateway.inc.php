<?php
	require_once("../eNews/campaignmonitor-php-1.4.3/CMBase.php");
	
	//AJAX Called Requests
	
	if ($_GET['Action'] == 'ValidateCompany') {
		$availableName = true;
		//Create an Instance of the current CM Users
		$cm = new CampaignMonitor('474c5ff0c27ac3030c897b8e68e5efd3');
		$result = $cm->userGetClients();
		//Check if the desired username is currently being used by another client
		foreach ($result['anyType']['Client'] as $Client) {
			if ($Client['Name'] == $_REQUEST['Company']) {
				$availableName = false;
			}
		}
		if ($availableName == true) {
			//Success
			echo $_REQUEST['Response']."(1);";
		} else {
			//Fail
			echo $_REQUEST['Response']."(0);";
		}
	}
	
	
	if ($_GET['Action'] == 'ValidateEmail') {
		$availableEmail = true;
		//Create an Instance of the current CM Users
		$cm = new CampaignMonitor('474c5ff0c27ac3030c897b8e68e5efd3');
		$result = $cm->userGetClients();
		
		//Check if the desired email is already in the system
		//No 2 people will have the same email
		
		//But if someone is trying to signup again or something this catch will trap errors on paid.php
		//Errors are thrown on paid.php when creating their account if the email already exists
		
		foreach ($result['anyType']['Client'] as $Client) {
			$ClientDetails = $cm->clientGetDetail($Client['ClientID']);
			if ($_REQUEST['Email'] == $ClientDetails['anyType']['BasicDetails']['EmailAddress']) {
				$availableEmail = false;
			}
		}
		
		if ($availableEmail == true) {
			//Success
			echo $_REQUEST['Response']."(1);";
		} else {
			//Fail
			echo $_REQUEST['Response']."(0);";
		}
	}
?>