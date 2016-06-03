<?php


$rtext = isset($GLOBALS['SCRIPT_SET_DATA_RIGHT_SIDE']) ? $GLOBALS['SCRIPT_SET_DATA_RIGHT_SIDE'] : '';

$ltext = isset($GLOBALS['SCRIPT_SET_DATA_LEFT_SIDE']) ? $GLOBALS['SCRIPT_SET_DATA_LEFT_SIDE'] : '';

if(isset($GLOBALS['SCRIPT_SET_DATA_HPTITLE']))
	$page['title'] = $GLOBALS['SCRIPT_SET_DATA_HPTITLE'];

$pkeyw = $PAGE_IN_DB['metakeyw'] ? $PAGE_IN_DB['metakeyw'] : str_replace(' ', ',', $page['title']);
$pdescr = $PAGE_IN_DB['metadesc'] ? $PAGE_IN_DB['metadesc'] : 'добро пожаловать в раздел ' . $page['title'];

//include_once('template.php');
//$content= $PAGE_TEMPLATE;

$content = str_replace(
	array('#menu#', '#menu2#', '#headtitle', '#title', '#keyw', '#desc', '#rtext#', '#ltext#'), 
	array($menu_contents['top'], $menu_contents['secondary'], $PAGE_IN_DB['metatitle'] ? $PAGE_IN_DB['metatitle'] : $page['title'], "<h1>{$page['title']}</h1>", $pkeyw, $pdescr, $rtext, $ltext), $content);


if ($page['page_status']==1)
	$page['content']='В данный момент содержание страницы недоступно. Ведутся технические работы.';	


if ($page['group_visible']==1 && !isset($_SESSION['authorized'])) 
	$page['content']='Содержание страницы доступно только зарегистрированным пользователям.';	


if($page['menu_title'])
	$page['menu_title'] = "<h1>{$page['menu_title']}</h1>";


$content=str_replace(array('#content', '<div id="script_div">#pscript</div>', '#phead_h1', '#extra_top#'), array($GLOBALS['PAGE_IN_DB']['content'], '', $page['menu_title'], ''), $content);

?>