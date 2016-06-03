<?php
include_once "../../../new_admin/dbconnect.php";
include_once "users.php";
$task = $_REQUEST['task'];
session_start();

$userManager = new UserManager();

switch($task) {
	case "login":
		$userManager->login();
		break;
	case "exit":
		session_destroy();
		header("Location: ../index.php");
		break;	
	case "getUsers":
		$userManager->getUsers();
		break;
	case "saveUsers":
		$userManager->saveUsers();
		break;
	case "editUsers":
		$userManager->editUsers();
		break;
	case "deleteUsers":
		$userManager->deleteUsers();
		break;	
	case "changePassword":
		$userManager->changePassword();
		break;	
		
					
}	
?>
