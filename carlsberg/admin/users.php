<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
require_once "header.php";
include_once "../../new_admin/dbconnect.php";
include_once "dbaccessor.php";

$GLOBALS['db_for_log'] = new DBAccessor();

$meta = array();
$fields = array();

$id_user_field = array('name' => 'id', 'type' => 'int', 'visible' => false);
$id_field = array('name' => 'id', 'type' => 'string', 'visible' => false);
$name_field = array('name' => 'name', 'type' => 'string', 'visible' => true, 'header' => 'Имя', 'width' => 100, 'required' => false);
$login_field = array('name' => 'Username', 'type' => 'string', 'visible' => true, 'header' => 'Логин', 'width' => 100,  'required' => true);
$role_field = array('name' => 'role', 'type' => 'int', 'sub_type' => 'box', 'store' => 'role_store', 'visible' => true, 'header' => 'Роль', 'width' => 100, 'required' => true);
$phone_field = array('name' => 'phone', 'type' => 'string', 'visible' => true, 'header' => 'Телефон', 'width' => 100,  'required' => false);
$email_field = array('name' => 'email', 'type' => 'string', 'visible' => true, 'header' => 'e-mail', 'width' => 100,  'required' => true);
$manager_field = array('name' => 'manager', 'type' => 'int', 'sub_type' => 'box', 'store' => 'name_manager_store', 'visible' => true, 'header' => 'Менеджер', 'width' => 100, 'required' => false);
$manager2_field = array('name' => 'manager2', 'type' => 'int', 'sub_type' => 'box', 'store' => 'name_manager_store', 'visible' => true, 'header' => 'Запасной менеджер', 'width' => 100, 'required' => false);
$factory_field = array('name' => 'factory', 'type' => 'int', 'sub_type' => 'box', 'store' => 'name_factory_store', 'visible' => true, 'header' => 'Организация', 'width' => 100, 'required' => true);
$pswd_field = array('name' => 'password', 'type' => 'string', 'sub_type' => 'pswd', 'visible' => false, 'header' => 'Пароль', 'width' => 100,  'required' => true);
$repeat_pswd_field = array('name' => 'repeat_password', 'type' => 'string', 'sub_type' => 'pswd', 'visible' => false, 'header' => 'Повторите пароль', 'width' => 100,  'required' => true);

$fields[] = $id_user_field;
$fields[] = $id_field;
$fields[] = $name_field;
$fields[] = $login_field;
$fields[] = $phone_field;
$fields[] = $email_field;
$fields[] = $role_field;
$fields[] = $manager_field;	
$fields[] = $manager2_field;	
$fields[] = $factory_field;	
$fields[] = $pswd_field;	
$fields[] = $repeat_pswd_field;

include_once "users_stores.php";
$meta['stores'] = get_stores();
$actions = array();

//$pwd_action = array('id' => 'pwd-btn', 'text' => 'Установить пароль', 'icon' => 'key.gif', 'handler' => 'showPasswordDialog');
//$actions[] = $pwd_action;
//$meta['actions'] = $actions;

$meta['control'] = 'users/controller.php';
$meta['module'] = 'users';
$meta['task'] = 'Users';
$meta['fields'] = $fields;
$meta['paging_info'] = 'Показаны пользователи';
$meta['paging_mult'] = 'Пользователя';
$meta['paging_show'] = 'пользователей';
$meta['dialog_title'] = 'пользователя';
$meta['allways_new_dialog'] = true;
$meta['dialog_width'] = 740;
$meta['dialog_height'] = 290;

$meta_info = json_encode($meta);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Пользователи</title>
<?php
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
 	<script type="text/javascript" src="users/password_dialog.js"></script>	
 	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
 	<script src="js/jquery-ui.min.js"></script>
 	<link href="js/jquery-ui.css" type="text/css" rel="stylesheet">
 	<script src="js/url_function.js"></script>
	<script type="text/javascript">
  		var meta; var grid_base; var dir; var sort;
  		function loadUsers() {
  			meta = <?php echo $meta_info; ?>;
  			setSelectedMenu(Selected_Menu_index['users']);
  			var grid_base = new Grid_Base(meta);
  			var store = grid_base.getStore();

/*
var dialog = this.create_dialog(fields);
	this.setDialog = function (d1) {
		dialog = d1;
	}
*/

  			store.on('beforeload', function(store, options) {
				var optionsSort = options.params.sort;
				var optionsDir = options.params.dir; 
				if(!optionsSort) {
					options.params.sort = sort;
				}
				if(!optionsDir) {
					options.params.dir = dir;
				} 
				store.baseParams.name_filter = Ext.getCmp('filter-name').getValue();
				store.baseParams.phone_filter = Ext.getCmp('filter-phone').getValue();
				store.baseParams.email_filter = Ext.getCmp('filter-email').getValue();
			});
  			store.load({params: {					
						start: 0,
						limit:10,
						sort: 'id',
						dir: 'DESC'
			}});

  			var grid = grid_base.getGrid();  
  			grid.getTopToolbar().addSeparator();

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
  	</script> 	
  	<script type="text/javascript" src="js/users_filters.js"></script>
</head>
<body onLoad="loadUsers()">
	<?php echo $common_top; ?>
	<div id="container">		
		<div id="content">		
			<div id="code"></div>		
		</div>		
	</div>	
</body>
</html>

