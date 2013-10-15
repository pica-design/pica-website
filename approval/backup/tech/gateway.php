<?php
 	ini_set('display_errors', 1);
	//Make sure the remote server is set to local EST time for date display
	date_default_timezone_set('America/New_York');
	//Force the php max execution time to 2min 
	ini_set('max_execution_time', '240') ;
	//Force the php memory limit be raised
	ini_set('memory_limit', '256M') ;
	
	//LOCAL
	/*
	$working_dir	= '/Other Pica Shares/Websites/pica_approval';
	$site_url 		= "http://picadesign.ath.cx/pica_approval";
	$manage_path 	= "/pica_approval/manage";
	$dbhost 		= "localhost";
    $dbname 		= "pica_project_approval";
    $dbuname    	= "root";
    $dbpassw    	= "1309piCa";
	*/
	
	//LIVE
	$working_dir 	= '/home/pica/public_html/approval';
	$site_url 		= 'http://approval.picadesign.com';
	$manage_path 	= "/manage";
	$dbhost     	= "localhost";
	$dbname 		= "pica_approval";
    $dbuname    	= "pica_dbuser";
    $dbpassw    	= "(0G6M#3*#Ot2";
	
	
	//Database Connection
    $conn = mysql_connect($dbhost, $dbuname, $dbpassw)or die("Site could not connect to the Pica Database. Try back later.");
    mysql_select_db($dbname)or die("We are currently under construction as of ".date('D, M-d', strtotime('-1 Day')).". Please try back soon.");  
	
	//Perform a sql select
	//PRE: Receive a SQL Str
	//POST: Return an array of the returned items
	function sqlSELECT ($sql, $bool_echo) {
		global $conn;
		$sql = "SELECT ".$sql;
		if ($bool_echo) echo $sql;
		$res = mysql_query($sql, $conn);
		if (mysql_num_rows($res) > 0) {
			$arr = array();									
			while ($row = mysql_fetch_assoc($res)) {
				$arr[] = $row;
			}
			return $arr;
		} else {
			return false;
		}	
	}
	//Perform a sql insert
	//PRE: Recieve a SQL Str
	//POST: Return a boolean value
	function sqlINSERT ($sql, $bool_echo) {
		global $conn;
		$sql = "INSERT INTO ".$sql;
		if ($bool_echo) echo $sql;		
		if (mysql_query($sql, $conn)) {
			return mysql_insert_id();
		} else {
			return false;
		}
	}
	//Perform a sql update
	//PRE: Recieve a SQL Str
	//POST: Return a boolean value
	function sqlUPDATE ($sql, $bool_echo) {
		global $conn;
		$sql = "UPDATE ".$sql;
		if ($bool_echo) echo $sql;		
		if (mysql_query($sql, $conn)) {
			return true;
		} else {
			return false;
		}
	}
	//Perform a sql deletion
	//PRE: Recieve a SQL Str
	//POST: Return a boolean value
	function sqlDELETE ($sql, $bool_echo) {
		global $conn;
		$sql = "DELETE ".$sql;
		if ($bool_echo) echo $sql;		
		if (mysql_query($sql, $conn)) {
			return true;
		} else {
			return false;
		}
	}
?>