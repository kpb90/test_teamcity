<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
require_once "header.php";
include_once "../../new_admin/dbconnect.php";
include_once "dbaccessor.php";

$GLOBALS['db_for_log'] = new DBAccessor();
$meta = array();
$fields = array();
$price_not_editable = false;
if ($_SESSION['auto_user']['role']==SUPER_ADMIN) {
	$status_MVS_id_not_editable = false;
	$status_OM_id_not_editable = false;	
} else if ($_SESSION['auto_user']['role']==MVS){
	$status_MVS_id_not_editable = false;
	$status_OM_id_not_editable = true;	
} else if ($_SESSION['auto_user']['role']==OM || $_SESSION['auto_user']['role']==MANAGER_CARSLBERG || $_SESSION['auto_user']['Username']=='zaytceva_mi'){
	$status_MVS_id_not_editable = true;
	$status_OM_id_not_editable = false;	
} else {
	$status_MVS_id_not_editable = true;
	$status_OM_id_not_editable = true;	
	$price_not_editable = true;
	$meta['dialog_action'] = "ok";
}

$id_field = array('name' => 'id', 'type' => 'string', 'visible' => true,  'header' => 'Номер заявки', 'width' => 50, 'not_editable' => true);
$customer_name_field = array('name' => 'customer_name', 'type' => 'string', 'visible' => true, 'header' => 'Имя клиента', 'width' => 100, 'required' => false, 'not_editable' => true);
$customer_phone_field = array('name' => 'customer_phone', 'type' => 'string', 'visible' => true, 'header' => 'Телефон клиента', 'width' => 100, 'required' => false, 'not_editable' => true);
$customer_email_field  = array('name' => 'customer_email', 'type' => 'string', 'visible' => true, 'header' => 'email клиента', 'width' => 100, 'required' => false, 'not_editable' => true);
$factory_field = array('name' => 'factory', 'type' => 'int', 'sub_type' => 'box', 'store' => 'name_factory_store', 'visible' => true, 'header' => 'Организация', 'width' => 100, 'required' => false, 'not_editable'=> true);
$price_field  = array('name' => 'price', 'type' => 'string', 'visible' => true, 'header' => 'Сумма', 'width' => 60, 'required' => false);
$currency_field   = array('name' => 'currency', 'type' => 'string', 'visible' => true, 'header' => 'Валюта', 'width' => 60, 'required' => false, 'not_editable'=> true);

$price_field['not_editable'] = $price_not_editable;
$status_MVS_id_field = array('name' => 'status_MVS_id', 'type' => 'int', 'sub_type' => 'box', 'store' => 'status_MVS_store', 'visible' => true, 'header' => 'Статус Восток Сервис', 'width' => 80, 'required' => false);
$status_MVS_id_field['not_editable'] = $status_MVS_id_not_editable;
$comment_to_status_field = array('name' => 'comment_to_status', 'type' => 'string', 'header' => 'Комментарии к статусу', 'width' => 100, 'required' => false, 'visible' => false);
$status_OM_id_field = array('name' => 'status_OM_id', 'type' => 'int', 'sub_type' => 'box', 'store' => 'status_OM_id_store', 'visible' => true, 'header' => 'Статус ОМ', 'width' => 80, 'required' => false);
$status_OM_id_field['not_editable'] = $status_OM_id_not_editable;

$manager_name_field = array('name' => 'manager_name', 'type' => 'string', 'visible' => true, 'header' => 'Имя менеджера', 'width' => 100, 'required' => false, 'not_editable' => true);
$manager_email_field  = array('name' => 'manager_email', 'type' => 'string', 'visible' => true, 'header' => 'email менеджера', 'width' => 100, 'required' => false, 'not_editable' => true);

$text_field  = array('name' => 'text_order', 'type' => 'rich_text', 'visible' => false, 'header' => 'Текст Заявки', 'width' => 100, 'height' => 300, 'required' => false);
$history_log_field  = array('name' => 'history_log', 'type' => 'string', 'visible' => false, 'header' => 'История изменений', 'width' => 100, 'height' => 300, 'required' => false);
$date_field = array('name' => 'date', 'type' => 'data', 'visible' => true, 'header' => 'Дата', 'width' => 80, 'required' => true, 'not_editable' => true);

$fields[] = $id_field;
$fields[] = $customer_name_field;
$fields[] = $customer_phone_field;
$fields[] = $customer_email_field;
$fields[] = $factory_field;
$fields[] = $status_OM_id_field;
$fields[] = $manager_name_field;
$fields[] = $manager_email_field;
$fields[] = $status_MVS_id_field;

if ($status_MVS_id_not_editable==false||$status_OM_id_not_editable==false) {
	$fields[] = $comment_to_status_field;
}
$fields[] = $price_field;
$fields[] = $currency_field;
$fields[] = $text_field;
$fields[] = $history_log_field;
$fields[] = $date_field;

$data_MVS_store = array (array("0", ''), array(ORDER_RECEIVED_IN_VOSTOK, 'Получен в Восток Сервис'),array( ORDER_COMPILED, 'Скомплентован'),array( ORDER_SEND, 'Отправлен'), array(PARTIALLY_SENT, 'Отправлен частично'));

$data_OM_store = array (array("0", ''), array(ORDER_REJECTED, 'Отклонен'), array(ORDER_APPROVED, 'Одобрен'), array(ORDER_GOODS_RECEIVED, 'Товар получен'),array(ORDER_GOODS_RECEIVED_NOT_FULL, 'Товар получен не в полном объеме'), array(ORDER_SENT_REQUEST_TO_SPARE_MANAGER, 'Запрос отправлен запасному менеджеру'));

$stores = array ();
$store = array('storeId' => 'status_MVS_store', 'idIndex' => 0);
$store_field_id = array('name' => 'id', 'type' => 'int');
$store_field_name = array('name' => 'name');
$store_fields = array($store_field_id, $store_field_name);
$store['fields'] = $store_fields;
$store['data'] = $data_MVS_store;
$stores[] = $store;

$store = array('storeId' => 'status_OM_id_store', 'idIndex' => 1);
$store_field_id = array('name' => 'id', 'type' => 'int');
$store_field_name = array('name' => 'name');
$store_fields = array($store_field_id, $store_field_name);
$store['fields'] = $store_fields;
$store['data'] = $data_OM_store;
$stores[] = $store;


include_once "users_stores.php";
$store = array('storeId' => 'name_factory_store', 'idIndex' => 2);
$store_field_id = array('name' => 'id', 'type' => 'string');
$store_field_name = array('name' => 'name');
$store_fields = array($store_field_id, $store_field_name);
$store['fields'] = $store_fields;
$store['data'] = get_factories ($condition_for_store_factory);
$stores[] = $store;

$pwd_action = array('id' => 'pwd-btn', 'text' => 'Сохранить PDF', 'icon' => 'key.gif', 'handler' => 'savePdf');
$actions[] = $pwd_action;
$meta['actions'] = $actions;

$meta['stores'] = $stores;
$meta['control'] = 'orders/controller.php';
$meta['module'] = 'orders';
$meta['task'] = 'Orders';
$meta['fields'] = $fields;
$meta['paging_info'] = 'Показаны заявки';
$meta['paging_mult'] = 'Заявка';
$meta['paging_show'] = 'заявок';
$meta['dialog_title'] = 'заявка';
$meta['dialog_width'] = 800;
$meta['dialog_height'] = 820;
$meta['page_size'] = 100;
$meta['role_user'] = $_SESSION['auto_user']['role'];

$meta_info = json_encode($meta);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Заявки</title>
<?php
	require_once "header.php";
	echo $common_links;
	echo $ext_links; 
	echo $ext_extra_links;
	echo $after_ext_links;
?>	
 	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
 	<script type="text/javascript" src="js/extra/ext_ckeditor.js"></script> 	 	 	 	
	<script type="text/javascript" src="js/extra/FileUploadField.js"></script>	
 	<script type="text/javascript" src="js/grid_base.js"></script> 	
 	<script type="text/javascript" src="js/main.js"></script>	
 	<script type="text/javascript" src="js/dialog_reject_order.js?ver=2"></script>	
 	<script type="text/javascript" src="js/url_function.js"></script>	
 	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
 	<script type="text/javascript" src="js/orders_filters.js"></script>
 		<style> 
			#x-form-el-comment-edit {
				padding-left:0!important;
			}
			#comment-edit {
				width: 428px !important;
			}
		</style>
	<script type="text/javascript">
	SUPER_ADMIN =  1;
	MVS = 2;
	OM = 3;
	PS =  4;
	$(document).ready(function()
	{
		var query_search = document.location.search.split("&amp;").join("&");
		var query = getQueryParams(query_search);
		if (query['user_hash']&&query['manager_hash']&&query['order_hash']) {
			if (query['approve']) {
				showAproveDialog(query)	
			} else {
				showRejectDialog(query)	
			}
			
		}
	});

  		var meta; var grid_base; var dir; var sort;
  		function loadOrders() {
  			meta = <?php echo $meta_info; ?>;
  			setSelectedMenu(Selected_Menu_index['orders']);
  			var grid_base = new Grid_Base(meta);
  			var grid_orders  = grid_base.getGrid();  	
  			var toolbar = grid_orders.getTopToolbar();

  			toolbar.remove('create-btn');  
  			
  			if (meta['role_user'] != SUPER_ADMIN && meta['role_user'] != MVS) {
  				  toolbar.remove('remove-btn');
  			}

  			if (meta['role_user'] == PS) {
  				  toolbar.remove('edit-btn');
  			}

  			var store = grid_base.getStore();
  		
  			store.on('beforeload', function(store, options) {
				var optionsSort = options.params.sort;
				var optionsDir = options.params.dir; 
				if(!optionsSort) {
					options.params.sort = sort;
				}
				if(!optionsDir) {
					options.params.dir = dir;
				} 
				
				store.baseParams.number_filter = Ext.getCmp('filter-number').getValue();
				store.baseParams.name_filter = Ext.getCmp('filter-name').getValue();
				store.baseParams.phone_filter = Ext.getCmp('filter-phone').getValue();
				store.baseParams.email_filter = Ext.getCmp('filter-email').getValue();
				store.baseParams.start_filter = getDatabaseDate(Ext.getCmp('filter-start'));
				store.baseParams.end_filter =  getDatabaseDate(Ext.getCmp('filter-end'));							
			});  			

  			store.load({params: {					
						start: 0,
						limit: 100,
						sort: 'id',
						dir: 'DESC'
			}});
			
  			var grid = grid_base.getGrid();  

  			var dialog = grid_base.getDialog ();
			dialog.on('show', function(win) {
				if ($("#history_log").length) {
					setTimeout(function () {
		           		var $wrap_blc = $("#history_log").parent().parent();
		           		$(".qq").remove();
		           		$wrap_blc.hide();
		           		$wrap_blc.replaceWith(function(index, oldHTML)
			            {	
			            	return "<h2 style = 'text-align:center;' class = 'qq'>История заявки</h2><div style = 'text-align: left;border: 1px solid blue;padding: 15px 15px;height: 312px;overflow-y: scroll;margin: 10px 0 10px 106px;' class = 'qq'>"+$("#history_log").val()+"</div>";
			            });

		        	}, 20);
				}
			});

  			var orderPanel = new Ext.Panel({
  				layout:'form',
				border:false, 
				items:[searchPanel,
				{
					border:false,
					height: 4,
					width: 10
				}, 
				grid]
  			});
  			grid.setHeight(tableHeight - 73);	
  			orderPanel.render('code');
 		}

  		function savePdf () {
  			var grid = Ext.getCmp('orders-list');
  			var record = grid.getSelectionModel().getSelected();
			id_order = record.get('id');
			send_obj = {'task':'generatePDF', 'id':id_order,'rand':Math.random()}; 
			Ext.Ajax.request({ 		
				url:'orders/controller.php', 
				params:send_obj, 					 
				method:'POST',										 
				callback: function (options, success, response) {			 				 	
					window.open('orders/PDF_FILES/'+response.responseText+'.pdf','PDF','status=no, width=930,height=690,scrollbars=1');
				 }, 
				 failure:function(response,options){
					showErrorMessage('Нет соединения с сервером');
				}	
			});		
		}
  	</script> 	
</head>
<body onLoad="loadOrders()">
	<?php echo $common_top; ?>
	<div id="container">		
		<div id="content">		
			<div id="code"></div>		
		</div>		
	</div>	
</body>
</html>

