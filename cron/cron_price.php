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
	$GLOBALS['DB_CONNECTION']->query("update studio_catalog set price='0' where 1");


	$in_arr = array(
		'http://sankt-peterburg.vostok.ru/catalog/odezhda/?prop',
		'http://sankt-peterburg.vostok.ru/catalog/obuv/?prop',
		'http://sankt-peterburg.vostok.ru/catalog/sredstva-zaschity/?prop',
		'http://sankt-peterburg.vostok.ru/catalog/zaschita-ruk/?prop',
		'http://sankt-peterburg.vostok.ru/catalog/drugoe/?prop'
	);

	foreach($in_arr as $e)
	{
		$ret = parseit($e);
		if($ret != 'OK')
		{
			echo $ret;	
			break;	
		}
	}

	function parseit($e)
	{
			echo "\n";
		        $file = curl_download($e);
			if($file)
			{
				$psize = GetBetween(substr($file, strrpos($file, '?page')), '=', '"');
				if(!$psize)
					return 'Failed to get size';
				$ret = readit($file);
				if($ret != 'OK')
					return $ret . ' ' . $e;	
 
				if($psize > 1)
				for($i = 2; $i <= $psize; $i++)
				{
					$nname = $e . "=&page={$i}&prev_page=1";
					$ret = readit(curl_download($nname));
					if($ret != 'OK')
						return $ret . ' ' . $nname;	
				}
	
				return 'OK';

			}

			return 'Failed to get file ' . $e; 
	}
      	
	function readit($cnt)
	{
		$prods = explode('/article', $cnt);
echo count($prods);
		if(count($prods) < 2)
			return 'no products';
		
		$ttl = 0;
		foreach($prods as $p)
		{
			$art = GetBetween($p, '<div class="type">', '</div>');
			$price = GetBetween($p, '<div class="price"><span>', '</span></div>');
			if($art && $price)
			{
				$GLOBALS['DB_CONNECTION']->query("update studio_catalog set price='{$price}' where article='{$art}'");
				$ttl++;
			}
		}
	
		if(!$ttl)
			return 'no products';

		return 'OK';
	}



function curl_download($Url){
 
    // is cURL installed yet?
    if (!function_exists('curl_init')){
        die('Sorry cURL is not installed!');
    }
 
    // OK cool - then let's create a new cURL resource handle
    $ch = curl_init();
 
    // Now set some options (most are optional)
 
    // Set URL to download
    curl_setopt($ch, CURLOPT_URL, $Url);
 
curl_setopt($ch, CURLOPT_ENCODING , 'gzip, deflate');
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:16.0) Gecko/20100101 Firefox/16.0');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Host' => 'sankt-peterburg.vostok.ru',
	'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Encoding' => 'gzip, deflate',
	'Cookie' => '_ga=GA1.2.1211310356.1447849683; _ym_uid=1447849684515679628; _vwo_uuid_v2=E376F864F06CC9858D029297FD355048
|8c15b53ebf960605d493b6a901567e72; _ga=GA1.3.1211310356.1447849683; _ym_isad=0; __utnz=024flj6vgqnbd75722taoi58p1
; _ym_visorc_13362410=w; _ym_visorc_32477420=w; _ym_visorc_24288136=w; _ym_mp2_track_24288136=258204
; _ym_mp2_substs_24288136=%5B%7B%22selector%22%3A%22.ya-phone%22%2C%22text%22%3A%22%2B7%20(495)%20363-90-88
%22%7D%5D; _dc_gtm_UA-31754949-1=1'
    ));


	




    // Set a referer
    curl_setopt($ch, CURLOPT_REFERER, "http://www.example.org/yay.htm");
 
    // Include header in result? (0 = yes, 1 = no)
    curl_setopt($ch, CURLOPT_HEADER, 0);
 
    // Should cURL return or print out the data? (true = return, false = print)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
    // Timeout in seconds
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
 
    // Download the given URL, and return output
    $output = curl_exec($ch);
 
    // Close the cURL resource, and free system resources
    curl_close($ch);
 
    return $output;
}



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