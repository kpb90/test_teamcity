<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php

$meta = array();
	
$fields = array(
	array('name' => 'id', 'type' => 'int', 'visible' => false),
	array('name' => 'gid', 'type' => 'string', 'visible' => true, 'header' => 'Группа', 'width' => 100, 'required' => true, 'not_editable' => false),
	array('name' => 'title', 'type' => 'string', 'visible' => true, 'header' => 'Название', 'width' => 100, 'required' => true, 'not_editable' => false),
	array('name' => 'article', 'type' => 'string', 'visible' => true, 'header' => 'Артикул', 'width' => 100, 'required' => true, 'not_editable' => false),
	array('name' => 'price', 'type' => 'string', 'visible' => true, 'header' => 'Росс. руб.', 'width' => 100, 'required' => true, 'not_editable' => false),
	array('name' => 'bel_price', 'type' => 'string', 'visible' => true, 'header' => 'Бел. руб.', 'width' => 100, 'required' => true, 'not_editable' => false),
	array('name' => 'price_info', 'type' => 'string', 'visible' => true, 'header' => 'О цене', 'width' => 100, 'required' => true, 'not_editable' => false),
	array('name' => 'tech_info', 'type' => 'string', 'visible' => true, 'header' => 'Состав', 'width' => 100, 'required' => true, 'not_editable' => false),
	array('name' => 'brend', 'type' => 'string', 'visible' => true, 'header' => 'Бренд', 'width' => 100, 'required' => true, 'not_editable' => false),
	array('name' => 'short_descr', 'type' => 'rich_text', 'visible' => false, 'header' => 'Короткое описание', 'width' => 100, 'required' => true, 'not_editable' => false),
	array('name' => 'descr', 'type' => 'rich_text', 'visible' => false, 'header' => 'Полное описание', 'width' => 100, 'required' => true, 'not_editable' => false),
	array('name' => 'external_link', 'type' => 'string', 'visible' => false, 'header' => 'Ссылка', 'width' => 100, 'required' => true, 'not_editable' => false),
	array('name' => 'pict', 'type' => 'string', 'visible' => true, 'header' => 'Главная картинка', 'width' => 100, 'required' => true, 'not_editable' => false),
	array('name' => 'morepict', 'type' => 'string', 'visible' => false, 'header' => 'Еще картинки', 'width' => 100, 'required' => true, 'not_editable' => false),
	array('name' => 'color', 'type' => 'string', 'visible' => true, 'header' => 'Цвета', 'width' => 100, 'required' => true, 'not_editable' => false),
	array('name' => 'prot_props', 'type' => 'string', 'visible' => false, 'header' => 'Защитные свойства', 'width' => 100, 'required' => true, 'not_editable' => false),
	array('name' => 'techs', 'type' => 'string', 'visible' => false, 'header' => 'Технологии', 'width' => 100, 'required' => true, 'not_editable' => false),
	array('name' => 'gost', 'type' => 'string', 'visible' => true, 'header' => 'ГОСТ', 'width' => 100, 'required' => true, 'not_editable' => false),
	array('name' => 'advices', 'type' => 'string', 'visible' => false, 'header' => 'Советы', 'width' => 100, 'required' => true, 'not_editable' => false),
	array('name' => 'promo', 'type' => 'string', 'visible' => false, 'header' => 'Акция', 'width' => 100, 'required' => true, 'not_editable' => false),
	array('name' => 'oldprice', 'type' => 'string', 'visible' => true, 'header' => 'Старая цена', 'width' => 100, 'required' => true, 'not_editable' => false),
	array('name' => 'extra_props', 'type' => 'string', 'visible' => false, 'header' => 'Доп. свойства', 'width' => 100, 'required' => true, 'not_editable' => false)
);

$data_rating_store = array (array("0", ''), array(1, '1'),array(2, '2'), array( 3, '3'),array(4, '4'), array(5, '5'));
$stores = array ();
$store = array('storeId' => 'rating_store', 'idIndex' => 0);
$store_field_id = array('name' => 'id', 'type' => 'int');
$store_field_name = array('name' => 'name');
$store_fields = array($store_field_id, $store_field_name);
$store['fields'] = $store_fields;
$store['data'] = $data_rating_store;
$stores[] = $store;

$meta['control'] = 'assortiment/controller.php';
$meta['module'] = 'rating';
$meta['task'] = 'Rating';
$meta['fields'] = $fields;
$meta['paging_info'] = 'Показаны товары';
$meta['paging_mult'] = 'товары';
$meta['paging_show'] = 'товаров';
$meta['dialog_title'] = 'товара';
$meta['dialog_width'] = 800;
$meta['dialog_height'] = 600;
$meta['page_size'] = 100;
$meta['stores'] = $stores;
$meta_info = json_encode($meta);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Товары</title>
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
						limit:100,
						sort: 'id',
						dir: 'DESC'
			}});
  			var grid = grid_base.getGrid();  	
  			var toolbar = grid.getTopToolbar();
 			toolbar.remove('create-btn');  		
  			grid.render('code');
  		}
  	</script>
	<style>
		.x-panel-body.x-panel-body-noheader.x-panel-body-noborder {
			overflow-y: auto;
		}
	</style> 	
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

