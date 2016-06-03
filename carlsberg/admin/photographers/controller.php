<?php


require_once "../../admin/dbconnect.php";
require_once "photographer_manager.php";

$task = $_REQUEST['task'];
session_start();

$photographer_manager = new PhotographerManager();

switch($task) {
	case "getPhotographers":
		$photographer_manager->getPhotographers();
		break;
	case "savePhotographers":
		$photographer_manager->savePhotographers();
		break;	
	case "editPhotographers":
		$photographer_manager->editPhotographers();
		break;	
	case "deletePhotographers":
		$photographer_manager->deletePhotographers();
		break;	
		
		
}

?>
