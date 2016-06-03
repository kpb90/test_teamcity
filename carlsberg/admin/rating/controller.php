<?php
include_once "../../../new_admin/dbconnect.php";
require_once "rating_manager.php";

$task = $_REQUEST['task'];
session_start();

$rating_manager = new RatingManager();

switch($task) {
	case "getRating":
		$rating_manager->getRating();
		break;
	case "saveRating":
		$rating_manager->saveRating();
		break;
	case "editRating":
		$rating_manager->editRating();
		break;
	case "deleteRating":
		$rating_manager->deleteRating();
		break;
}

?>