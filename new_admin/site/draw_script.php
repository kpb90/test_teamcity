<?php

$ptitle = $page['title'];
$pkeyw = '';
$pdescr = '';
$phead_h1 = '';
$rtext = '';
$ltext = '';
$extra_top = '';

if(isset($page['outer_script']) && $page['outer_script'] != '')
{
	include($page['outer_script'] . '.php');
	$pscript = pscript_execute($PAGE_IN_DB['menu_title']);
	if(isset($GLOBALS['SCRIPT_SET_DATA_DESCR']))
		$pdescr = $GLOBALS['SCRIPT_SET_DATA_DESCR'];
	if(isset($GLOBALS['SCRIPT_SET_DATA_KEYW']))	
		$pkeyw = $GLOBALS['SCRIPT_SET_DATA_KEYW'];
	if(isset($GLOBALS['SCRIPT_SET_DATA_KEYW']))	
		$pkeyw = $GLOBALS['SCRIPT_SET_DATA_KEYW'];
	if(isset($GLOBALS['SCRIPT_SET_DATA_HPTITLE']))
	{ 
		if($GLOBALS['SCRIPT_SET_DATA_META_TITLE'])
			$ptitle = $GLOBALS['SCRIPT_SET_DATA_META_TITLE'];
		else
			$ptitle = $GLOBALS['SCRIPT_SET_DATA_HPTITLE'];
		
		$phead_h1 = $GLOBALS['SCRIPT_SET_DATA_SCRUMB'] . '<h1>' . $GLOBALS['SCRIPT_SET_DATA_HPTITLE'] . '</h1>';
	}
	if(isset($GLOBALS['SCRIPT_SET_DATA_RIGHT_SIDE']))
		$rtext = $GLOBALS['SCRIPT_SET_DATA_RIGHT_SIDE'];
	if(isset($GLOBALS['SCRIPT_SET_DATA_LEFT_SIDE']))
		$ltext = $GLOBALS['SCRIPT_SET_DATA_LEFT_SIDE'];
	if(isset($GLOBALS['SCRIPT_SET_DATA_EXTRA_TOP']))
		$extra_top = $GLOBALS['SCRIPT_SET_DATA_EXTRA_TOP'];
}

$pdescr = $PAGE_IN_DB['metadesc'] ? $PAGE_IN_DB['metadesc'] : 'Спецодежда и СИЗ от Восток-Сервис и известных мировых производителей -  ' . $ptitle . '. В нашем интернет-магазине Вы наверняка сможете купить то, что Вам нужно и цены Вас приятно удивят.';
$pkeyw = $PAGE_IN_DB['metakeyw'] ? $PAGE_IN_DB['metakeyw'] : str_replace(array('(', ')'), array('', ''), $ptitle);


//include_once('template.php');
//$content= $PAGE_TEMPLATE;
$content = str_replace(
	array('#menu#', '#menu2#', '#headtitle', '#title', '#content', '#keyw', '#desc', '#phead_h1', '#rtext#', '#ltext#', '#extra_top#'), 
	array($menu_contents['top'], $menu_contents['secondary'], $ptitle, $phead_h1, $pscript, $pkeyw, $pdescr, $phead_h1, $rtext, $ltext, $extra_top), $content);

if ($page['page_status']==1)

  $page['content']='В данный момент содержание страницы недоступно. Ведутся технические работы.';	



if ($page['group_visible']==1 && !isset($_SESSION['authorized'])) 

  $page['content']='Содержание страницы доступно только зарегистрированным пользователям.';	



$content=str_replace('#content',$page['content'],$content);

?>