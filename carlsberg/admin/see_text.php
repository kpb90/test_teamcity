<?php
	if ($_REQUEST['id']) {
		require_once "../../new_admin/functions.php";
		$id = intval($_REQUEST['id']);
		$GLOBALS['DB_CONNECTION'] = dbconnect_new();
		$query = "SELECT * FROM  `cms2_orders_carslberg_text` where id = {$id} limit 1";
		$r = $GLOBALS['DB_CONNECTION']->query($query);
		if ($r&&$row=$r->fetch_assoc()) {
			echo $row['text'];
		}
		
	}
 	

	
?>