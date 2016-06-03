<?php
	function checkPOSTGETvalue(&$str, $key)
	{
		if($_SESSION['user_id'] || is_array($str) || strlen($str) < 30) return;
		if(	stripos($str, 'select') !== FALSE || 
			stripos($str, 'insert') !== FALSE || 
			stripos($str, 'update') !== FALSE || 
			stripos($str, 'delete') !== FALSE || 
			stripos($str, 'truncate') !== FALSE || 
			stripos($str, 'alter') !== FALSE)
		{
			exit(0);
		}
	}
    
	function dbconnect ()
	{
		array_walk($_GET, 'checkPOSTGETvalue');
		array_walk($_POST, 'checkPOSTGETvalue');
		mysql_connect("localhost", "root", "root");
		mysql_select_db("vostok");

		mysql_query("SET NAMES 'utf8'");
	}

	function dbconnect_new ()
	{
		array_walk($_GET, 'checkPOSTGETvalue');
		array_walk($_POST, 'checkPOSTGETvalue');
		
		$mysql_var = new mysqli("localhost", "root", "root", "vostok");
		$mysql_var->set_charset("utf8");
		return $mysql_var;
	}
?>
