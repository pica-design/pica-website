<?php
	//Database Class Controller
	class database {
		public function __construct () {
			/*
			//LIVE @ BlueHost		
			$this->dbhost     	= "localhost";
			$this->dbname 		= "askpersp_project_approval";
			$this->dbuname    	= "askpersp_approve";
			$this->dbpassw    	= "UgEJHL()^D!m";
			*/
			
			
			//LOCAL @ Pica Dev
			/*
			$this->dbhost 		= "localhost";
			$this->dbname 		= "pica_project_approval";
			$this->dbuname    	= "root";
			$this->dbpassw    	= "1309piCa";
			*/
			
			//LOCAL @ James Home
			/*
			$this->dbhost     	= "localhost";
			$this->dbname 		= "askpersp_project_approval";
			$this->dbuname    	= "root";
			$this->dbpassw    	= "1309jamM@";
			*/
			
			//LIVE at InMotionHosting Pica VPS
			
			$this->dbhost     	= "localhost";
			$this->dbname 		= "pica_approval";
			$this->dbuname    	= "pica_dbuser";
			$this->dbpassw    	= "(0G6M#3*#Ot2";
			

			//Database Connection
			$this->conn = mysql_connect($this->dbhost, $this->dbuname, $this->dbpassw)or die("Site could not connect to the database. Try back later.");
			mysql_select_db($this->dbname)or die("We are currently under construction as of ".date('D, M-d', strtotime('-1 Day')).". Please try back soon.");
		}
		//Perform a sql select
		//PRE: Receive a SQL Str
		//POST: Return an array of the returned items
		public function select ($sql, $bool_echo) {
			if ($bool_echo) echo $sql;
			$res = mysql_query($sql, $this->conn);
			if ($res !== false) :
				if (mysql_num_rows($res) > 0) :
					$arr = array();
					while ($row = mysql_fetch_assoc($res)) : $arr[] = $row; endwhile;
					return $arr;
				else : return false; endif;
			else : return false; endif;
		}
		
		//Perform a sql insert
		//PRE: Recieve a SQL Str
		//POST: Return a boolean value
		public function insert ($sql, $bool_echo) {
			if ($bool_echo ) echo $sql;
			if (mysql_query($sql, $this->conn)) : return mysql_insert_id() ;
			else : return false; endif;
		}
		
		//Perform a sql update
		//PRE: Recieve a SQL Str
		//POST: Return a boolean value
		public function update ($sql, $bool_echo) {
			if ($bool_echo) echo $sql;		
			if (mysql_query($sql, $this->conn)) : return true;
			else : return false; endif;
		}
		
		//Perform a sql deletion
		//PRE: Recieve a SQL Str
		//POST: Return a boolean value
		public function delete ($sql, $bool_echo) {
			if ($bool_echo) echo $sql;		
			if (mysql_query($sql, $this->conn)) : return true;
			else : return false; endif;
		}
		
	}// END database class
	
	global $db;
	$db = new database;
?>