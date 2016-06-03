<?php
include_once "../../../new_admin/dbconnect.php";
require_once "orders.php";

$task = $_REQUEST['task'];
session_start();

$orderManager = new OrderManager();

switch($task) {
	case "getOrders":
		$orderManager->getOrders();
		break;
	case "deleteOrders":
		$orderManager->deleteOrders();
		break;	
	case "saveOrders":
		$orderManager->saveOrders();
		break;
	case "editOrders":
		$orderManager->editOrders();
	break;
	
	case "get_data_for_reject_dialog":
		$orderManager->get_data_for_reject_dialog();
	break;

	case "reject_this_order":
		$orderManager->reject_this_order();
	break;

	case "set_this_order_approve":
		$orderManager->set_this_order_approve();
	break;

	case "generatePDF":
		$orderManager->generatePDF();
	break;
}	
?>