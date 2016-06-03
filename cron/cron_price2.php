<?php
	session_start();
	ini_set("track_errors", 1);
	ini_set("html_errors", 1);
	ini_set("memory_limit","1200M");
	ignore_user_abort(1);

	error_reporting(E_ALL);
	ini_set('display_errors','on');

	$GLOBALS['root'] = '/home/u335171/vostok.spb.ru/www';

	include_once "{$GLOBALS['root']}/new_admin/dbconnect.php";
	$GLOBALS['DB_CONNECTION'] = dbconnect_new();

	$ok = false;	
	$cnt = file_get_contents('http://vvostoke.ru/products.txt');
	if(strlen($cnt) > 1000)
	{
		$ok = $GLOBALS['DB_CONNECTION']->multi_query($cnt);
		//var_dump(mysqli_error($GLOBALS['DB_CONNECTION']));
	}
	
	if(!$ok)
	{			
		echo 'error';
		$header	= "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/plain; charset=utf-8\r\n";
		$header .= 'From: quality@vostok.spb.ru' . "\r\n" .
		    'Reply-To: quality@vostok.spb.ru' . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();
		@mail('alexei@intraseti.ru', 'ОШИБКА цены на vostok.spb.ru', 'Обновились цены на vostok.spb.ru', $header);
	}
	else
		echo 'success';

?>