<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php

$meta = array();
$fields = array();

$id_field = array('name' => 'id', 'type' => 'int', 'visible' => false);
$name_field = array('name' => 'name', 'type' => 'string', 'visible' => true, 'header' => 'Имя клиента', 'width' => 100, 'required' => true, 'not_editable' => true);
$email_field = array('name' => 'email', 'type' => 'string', 'visible' => true, 'header' => 'e-mail клиента', 'width' => 100, 'required' => true, 'not_editable' => true);
$text_field = array('name' => 'text', 'type' => 'text', 'visible' => false, 'header' => 'Комментарии', 'width' => 100, 'required' => true);
$protect_rating = array('name' => 'protect_rating', 'type' => 'int', 'sub_type' => 'box', 'store' => 'rating_store', 'visible' => true, 'header' => 'Защитные свойства изделия', 'width' => 100, 'required' => false);
$reliability_rating = array('name' => 'reliability_rating', 'type' => 'int', 'sub_type' => 'box', 'store' => 'rating_store', 'visible' => true, 'header' => 'Надежность', 'width' => 100, 'required' => false);
$comfort_rating = array('name' => 'comfort_rating', 'type' => 'int', 'sub_type' => 'box', 'store' => 'rating_store', 'visible' => true, 'header' => 'Удобство использования/комфорт', 'width' => 100, 'required' => false);
$exploitation_rating = array('name' => 'exploitation_rating', 'type' => 'int', 'sub_type' => 'box', 'store' => 'rating_store', 'visible' => true, 'header' => 'Соответствие условиям эксплуатации', 'width' => 100, 'required' => false);
$design_rating = array('name' => 'design_rating', 'type' => 'int', 'sub_type' => 'box', 'store' => 'rating_store', 'visible' => true, 'header' => 'Дизайн', 'width' => 100, 'required' => false);
$date_field = array('name' => 'date', 'type' => 'data', 'datetime'=>'1', 'visible' => true, 'header' => 'Дата', 'width' => 60, 'required' => true);
$archive_field = array('name' => 'access', 'type' => 'bool','visible' => true, 'header' => 'Включить в рейтинг', 'width' => 60, 'required' => true);
$item_field = array('name' => 'item', 'type' => 'text', 'visible' => true, 'header' => 'Продукт', 'width' => 100, 'required' => true, 'not_editable'=> true);
$id_item_field = array('name' => 'id_item', 'type' => 'string', 'visible' => false, 'header' => 'id Продукт', 'width' => 100, 'required' => true, 'not_editable'=> false);

$fields[] = $id_field;
$fields[] = $name_field;
$fields[] = $email_field;
$fields[] = $text_field;
$fields[] = $protect_rating;
$fields[] = $reliability_rating;
$fields[] = $comfort_rating;
$fields[] = $exploitation_rating;
$fields[] = $design_rating;
$fields[] = $date_field;
$fields[] = $archive_field;
$fields[] = $item_field;
$fields[] = $id_item_field;

$data_rating_store = array (array("0", ''), array(1, '1'),array(2, '2'), array( 3, '3'),array(4, '4'), array(5, '5'));
$stores = array ();
$store = array('storeId' => 'rating_store', 'idIndex' => 0);
$store_field_id = array('name' => 'id', 'type' => 'int');
$store_field_name = array('name' => 'name');
$store_fields = array($store_field_id, $store_field_name);
$store['fields'] = $store_fields;
$store['data'] = $data_rating_store;
$stores[] = $store;

$meta['control'] = 'rating/controller.php';
$meta['module'] = 'rating';
$meta['task'] = 'Rating';
$meta['fields'] = $fields;
$meta['paging_info'] = 'Показаны отзывы';
$meta['paging_mult'] = 'Отзывы';
$meta['paging_show'] = 'отзывов';
$meta['dialog_title'] = 'рейтинги';
$meta['dialog_width'] = 600;
$meta['dialog_height'] = 380;
$meta['stores'] = $stores;
$meta_info = json_encode($meta);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Рейтинг</title>
<?php
	require_once "header.php";
	echo $common_links;
	echo $ext_links; 
	echo $ext_extra_links;
	echo $after_ext_links;
?>	
	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
 	<script type="text/javascript" src="js/extra/ext_ckeditor.js"></script> 	 	
 	<script type="text/javascript" src="js/text_dialog.js"></script>
 	<script type="text/javascript" src="rating/text.js"></script>
 	
 	<script type="text/javascript" src="js/grid_base.js"></script> 	
 	<script type="text/javascript" src="js/main.js"></script>	
	<script type="text/javascript">
  		var meta; var grid_base;
  		function loadRating() {
  			meta = <?php echo $meta_info; ?>;
  			setSelectedMenu(Selected_Menu_index['rating']);
  			var grid_base = new Grid_Base(meta);
  			var store = grid_base.getStore();
  			store.load({params: {					
						start: 0,
						limit:10,
						sort: 'date',
						dir: 'DESC'
			}});
  			var grid = grid_base.getGrid();  	
  			var toolbar = grid.getTopToolbar();
 			toolbar.remove('create-btn');  		
  			grid.render('code');
  		}
  	</script> 	
</head>
<body onLoad="loadRating()">
	<?php echo $common_top; ?>
	<div id="container">		
		<div id="content">		
			<div id="code"></div>		
		</div>		
	</div>	
</body>
</html>

