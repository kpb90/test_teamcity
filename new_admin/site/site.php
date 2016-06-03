<?php
//include('menu.php');
//include('blocks.php');

function draw($page_id) 
{
	
	if($page_id == 'catalog_carlsberg') {
		$page = array('content' => '', 'page_type' => 'script', 'outer_script' => 'carlsberg_catalog_src');
	} else if($page_id == '/gendir.php') {
		$page = array('content' => '', 'page_type' => 'script', 'outer_script' => 'gendir_src');
	} else if($page_id != 'catalog') {
		$page=afetchrowset(mysql_query("select * from cms2_pages where file_name='".$page_id."'"));
	
		if(!$page)
		{
			$bbody = 'Указанная Вами страница не существует.';
			echo '
				<html>
					<title>Страница не найдена</title>
				<head>
				<META http-equiv="content-type" content="text/html; charset=windows-1251" />
				</head>
				<body>
					' . $bbody . '
				</body>
				</html>
			';
			exit(0);
		}
		$page=$page[0];
		if(strlen($page['content']) < 10)
			$page['content'] = '';		
	}
	else
		$page = array('content' => '', 'page_type' => 'script', 'outer_script' => 'catalog_src');


	$TEMPLATE_ID = $page['template'];
	$GLOBALS['PAGE_IN_DB'] = $PAGE_IN_DB = $page;
	
	include_once('template.php');
	$content= $PAGE_TEMPLATE;
	$fname="draw_".$page['page_type'].".php";
	
	if ("site/".file_exists($fname))
	{
		include_once($fname);
	}

	echo $content;
}



?>