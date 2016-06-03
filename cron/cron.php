<?php
	session_start();
	ini_set("track_errors", 1);
	ini_set("html_errors", 1);
	ini_set("memory_limit","1200M");
	ignore_user_abort(1);

	error_reporting(E_ALL);
	ini_set('display_errors','on');

	$GLOBALS['root'] = '/home/u335171/vostok.spb.ru/www';

	require_once "{$GLOBALS['root']}/new_admin/importer/excel_reader/reader.php";
	$data = new Spreadsheet_Excel_Reader();
	$data->read('./prodmap2.xls');
	$oid2art = array();
	foreach($data->sheets[0]['cells'] as $v)
		if(isset($v[1]) && isset($v[2]))
			$oid2art[$v[2]] = $v[1];

	include_once "{$GLOBALS['root']}/new_admin/dbconnect.php";
	$GLOBALS['DB_CONNECTION'] = dbconnect_new();

        $file = file_get_contents('http://vvostoke.ru/products.txt', true);
	if($file)
	{
		
		$allinfo = explode('#', $file);
		if(count($allinfo) > 2)
		foreach($allinfo as $e)
		{
			$eparsed = explode(';', $e);
			if($eparsed[0] && $eparsed[1] && isset($oid2art[$eparsed[0]]))
				$GLOBALS['DB_CONNECTION']->query("update studio_catalog set price='{$eparsed[1]}' where article='{$oid2art[$eparsed[0]]}'");
		}
	}
	else
		echo "Error :- Unable to open the info File";

	$GLOBALS['DB_CONNECTION']->query("update studio_catalog set price='3990' where article='120-0135-01'");
	$GLOBALS['DB_CONNECTION']->query("update studio_catalog set price='5990' where article='103-0097-01'");
	$GLOBALS['DB_CONNECTION']->query("update studio_catalog set price='5990' where article='103-0092-07'");
	$GLOBALS['DB_CONNECTION']->query("update studio_catalog set price='5990' where article='103-0092-08'");
	$GLOBALS['DB_CONNECTION']->query("update studio_catalog set price='5990' where article='103-0092-09'");


function addToLog($message) {
	$handle = fopen('products.txt', "a+");
	fwrite($handle, $message . PHP_EOL);
	fclose($handle);			
}

function GetBetween($content,$start,$end){
    $r = explode($start, $content);
    if (isset($r[1])){
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
}
?>