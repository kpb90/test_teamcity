<?php
session_start();
include_once "{$_SERVER['DOCUMENT_ROOT']}/const.php";
$logged = false;
if(array_key_exists('id', $_SESSION['auto_user'])) {
	$user_id =$_SESSION['auto_user']['id'];
	if($user_id) {
		$logged = true;
	}
} 

if(!$logged) {
	$str_hash = '';
	if ($_REQUEST['user_hash']&&$_REQUEST['manager_hash']&&$_REQUEST['order_hash']) {
		$str_hash = '?'.http_build_query($_REQUEST, '', '&amp;');
	}
	header('Location:index.php'.$str_hash);
}

$level = $_SESSION['auto_user']['level'];
$st_menu = '<style>
				div#menu-main
				{
					width: 124%!important;
					left: -25.3%!important;
				}
			</style>';
include_once "{$_SERVER['DOCUMENT_ROOT']}/const.php";
if($_SESSION['auto_user']['role'] == SUPER_ADMIN||$_SESSION['auto_user']['role'] == MVS) {
	$menu = '<script language="JavaScript" src="js/menu_items.js?ver=2"></script>';
} else if($_SESSION['auto_user']['role'] == OM||$_SESSION['auto_user']['role'] == MANAGER_CARSLBERG) {
	$menu = '<script language="JavaScript" src="js/menu_items_other.js?ver=2"></script>';
} else {
	$menu = '<script language="JavaScript" src="js/menu_items_user.js?ver=2"></script>';
}


$_SESSION['KCFINDER']['disabled']=false;

$common_links =   ' 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
		
	<script language="JavaScript" src="js/menu.js"></script>
	'.$menu.'
	<script language="JavaScript" src="js/menu_tpl.js"></script> ';

$ext_links = '<link rel="stylesheet" type="text/css" href="ext/resources/css/ext-all.css"/>
			 <script type="text/javascript" src="ext/ext-base.js"></script>  
    		 <script type="text/javascript" src="ext/ext-all.js"></script>
			 <script type="text/javascript" src="ext/src/locale/ext-lang-ru.js"></script>';
			 			 			
$ext_extra_links = '	
			 <script type="text/javascript" src="js/extra/CheckColumn.js"></script>
			 <script type="text/javascript" src="js/extra/PageSizer.js"></script>
	
			 <script type="text/javascript" src="js/helper.js"></script>
			 <script type="text/javascript" src="js/store.js"></script>';
				

$after_ext_links = 	'<link href="css/menu.css" type="text/css" rel="stylesheet">
    <link href="css/main.css" type="text/css" rel="stylesheet">    
    <!--[if IE]><style type="text/css">.x-form-field-wrap .x-form-trigger {margin-top:1px;}</style><![endif]-->';

$common_top = '
<div id="header">		
	<div id="head_right">			
		<span>'.$_SESSION['auto_user']['name'].'('.$_SESSION['auto_user']['email'].')</span>
		<span style="padding-left: 40px">		
			<a id="exit-link" href="controller.php?task=exit">Выход</a>
		</span>
	</div>
	<div id="main_header" style="text-align:center;padding-top:7px;font-size: 12px;">	
		Административная панель сайта <a href="http://'.$_SERVER['HTTP_HOST'].'" target="_blank">'.$_SERVER['HTTP_HOST'].'</a>
	</div>		
</div>
		
<div id="menu-main">
	<div id="center-menu">
		<script language="JavaScript">	
			new menu (MENU_ITEMS, MENU_TPL);
		</script>
	</div>
</div>';
	




?>