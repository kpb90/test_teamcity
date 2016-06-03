<?php
require_once "../../new_admin/dbconnect.php";
require_once "users.php";

session_start();
$task = $_REQUEST['task'];
switch($task) {
	case "login":
		$userManager = new UserManager();
		$userManager->login();
		break;
	case "exit":
		session_destroy();
		header("Location: index.php");
?>
<script type="text/javascript">
	window.location="index.php";
</script>
<?php
		break;	
}	
?>
