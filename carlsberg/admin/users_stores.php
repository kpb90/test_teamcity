<?php
require_once "header.php";
include_once "../../new_admin/dbconnect.php";
include_once "dbaccessor.php";

$condition_for_store_factory = "";
global $data_role; 
global $condition_for_store_name_manager;
global $condition_for_store_factory;
if ($_SESSION['auto_user']['role']==SUPER_ADMIN) {
	$data_role = array (array(MVS, 'Менеджер Восток Сервис'),array(MANAGER_CARSLBERG, 'Менеджер Carlsberg'), array( OM, 'Ответственный менеджер'),array( PS, 'Пользователь'),array( VO, 'Только просмотр'));
	$condition_for_store_name_manager = " where role = '".OM."' ";
} else if ($_SESSION['auto_user']['role']==MVS){
	$data_role = array (array(MVS, 'Менеджер Восток Сервис'),array(MANAGER_CARSLBERG, 'Менеджер Carlsberg'), array( OM, 'Ответственный менеджер'),array( PS, 'Пользователь'));
	$condition_for_store_name_manager = " where role = '".OM."' ";
} else if ($_SESSION['auto_user']['role']==MANAGER_CARSLBERG){
	$data_role = array (array(MANAGER_CARSLBERG, 'Менеджер Carlsberg'), array( OM, 'Ответственный менеджер'),array( PS, 'Пользователь'));
	$condition_for_store_name_manager = " where role = '".OM."' ";
} else if ($_SESSION['auto_user']['role']==OM){
	$data_role = array (array( PS, 'Пользователь'));
	$condition_for_store_name_manager = " where id = '{$_SESSION['auto_user']['id']}' ";
	$g_latin = $_SESSION['auto_user']['g_latin'];
	if ($g_latin == '/') {
		$g_latin = '/%';
	}
	$condition_for_store_factory = " where g2_latin like '{$g_latin}' or g1_latin like '{$g_latin}'";
}

if ($_REQUEST['task'] == 'get_stores') {
	echo json_encode(get_stores ());
	exit;
}

function get_stores () {
	global $data_role; 
	global $condition_for_store_name_manager;
	global $condition_for_store_factory;
	if (!$GLOBALS['db_for_log']) {
		$GLOBALS['db_for_log'] = new DBAccessor();
	}

	$stores = array();
	//------ Роль ------------------
	$store = array('storeId' => 'role_store', 'idIndex' => 0);
	$store_field_id = array('name' => 'id', 'type' => 'int');
	$store_field_name = array('name' => 'name');
	$store_fields = array($store_field_id, $store_field_name);
	$store['fields'] = $store_fields;
	$store['data'] = $data_role;
	$stores[] = $store;
	//------------------------

	//------ Менеджер ------------------
	$store = array('storeId' => 'name_manager_store', 'idIndex' => 1);
	$store_field_id = array('name' => 'id', 'type' => 'string');
	$store_field_name = array('name' => 'name');
	$store_fields = array($store_field_id, $store_field_name);
	$store['fields'] = $store_fields;

	$query  = "select * from users_enc {$condition_for_store_name_manager}";

	include_once "../../new_admin/dbconnect.php";
	$GLOBALS['DB_CONNECTION'] = dbconnect_new();
	$r=$GLOBALS['DB_CONNECTION']->query($query);
	$store['data'][] = array ('0','');
	while($r&&$row=$r->fetch_assoc ()) {
		$store['data'][] = array($row['id'], $row['name']);
	}

	$GLOBALS['db_for_log']->wrp_log_history(array('type_query'=>'none', 'message' => "Получение хранилища менеджеров: ". $query.print_r($store['data'],true)));
	$stores[] = $store;
	//------------------------

	//------ Заводы ------------------
	$store = array('storeId' => 'name_factory_store', 'idIndex' => 2);
	$store_field_id = array('name' => 'id', 'type' => 'string');
	$store_field_name = array('name' => 'name');
	$store_fields = array($store_field_id, $store_field_name);
	$store['fields'] = $store_fields;
	$store['data'] = get_factories ($condition_for_store_factory);
	$stores[] = $store;
	//------------------------
	return $stores;
}

function get_factories ($condition_for_store_factory)
{
	$query  = " SELECT *
				FROM `cms2_factories_carslberg` 
				{$condition_for_store_factory}";

	if (!$GLOBALS['DB_CONNECTION']) {
		$GLOBALS['DB_CONNECTION'] = dbconnect_new();
	}
	$r=$GLOBALS['DB_CONNECTION']->query($query);
	$factories_arr = array ();
	while($r&&$row=$r->fetch_assoc ()) {
		$factories_arr [$row['gtitle']][] = array('id'=> $row['id'], 'title' => $row['subgtitle']);
	}

	$data_factories = array ();
	$data_factories[] = array("", "");
	
	if ($_SESSION['auto_user']['role']!=PS) {
		$data_factories[] = array(ALL_FACTORY, "Восток-Сервис");
		$data_factories[] = array(HEADQUARTERS, "Штаб квартира Carlsberg");
	}

	foreach ($factories_arr as $k => $v)
	{
		foreach ($v as $w)
		{
			$data_factories[] = array("{$w['id']}", "{$k}".($w['title'] ? " / {$w['title']}" : ''));	
		}
	}

	$GLOBALS['db_for_log']->wrp_log_history(array('type_query'=>'none', 'message' => "Получение хранилища заводов: ". $query));
	return $data_factories;
}
?>