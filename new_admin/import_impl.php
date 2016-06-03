<?php

	ini_set('display_errors','On');

function import_data($id, $data) 
{
	//test_check ($id, $data);
	$parents_arr = array();
	if(strpos($id, '2') !== FALSE)
	{
		importer_query("DROP TABLE IF EXISTS `groups`;");
		importer_query("
			CREATE TABLE `groups` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `name` varchar(250) DEFAULT NULL,
				  `level` int(11) NOT NULL DEFAULT '0',
				  `text_small` text,
				  `parent_id` varchar(80) DEFAULT NULL,
				  `archive` int(11) DEFAULT NULL,
				  `text` text,
				  `img` varchar(100) NOT NULL DEFAULT '',
				  `priority` int(11) NOT NULL,
				  `nameeng` varchar(250) DEFAULT NULL,
				  PRIMARY KEY (`id`),
				  KEY `parent_id` (`parent_id`),
				  KEY `archive` (`archive`)
			) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 PACK_KEYS=0 AUTO_INCREMENT=1 ;
		");
		
		$priority = 0;
		$skip_titles = true;
		foreach($data->sheets[1]['cells'] as $v)
		{
			$priority++;
			if($skip_titles)
			{
				$skip_titles = false;
				continue;
			}
				
	        $v[1] = get_prop($v[1]);
			if($v[2])
			{
				$level1 = $v[1];
				$nameeng = get_translit_singleline($v[2]);
				importer_query("INSERT INTO `groups` (
					`id`, `name`, `level`, `text_small`, `text`, `parent_id`, `archive`, `img`, `priority`,`nameeng`)
					VALUES
					({$v[1]}, '" . get_prop($v[2]) . "', 1, '" . get_prop($v[5]) . "', '" . get_prop($v[6]) . "', 0, " . (get_prop($v[7]) ? 1 : 0) . ", '" . get_prop($v[8]) . "', {$priority},'".$nameeng."');
				");
				$parents_arr[$v[1]] = 0;
				continue;
			}
			if($v[3])
			{
				$level2  = $v[1];
				$nameeng = get_translit_singleline($v[3]);
				importer_query("INSERT INTO `groups` (
					`id`, `name`, `level`, `text_small`, `text`, `parent_id`, `archive`, `img`, `priority`,`nameeng`)
					VALUES
					({$v[1]}, '" . get_prop($v[3]) . "', 2, '" . get_prop($v[5]) . "', '" . get_prop($v[6]) . "', $level1, " . (get_prop($v[7]) ? 1 : 0) . ", '" . get_prop($v[8]) . "', {$priority},'".$nameeng."');
				");
				$parents_arr[$v[1]] = $level1;
				continue;
			}
			if($v[4])
			{
				$nameeng = get_translit_singleline($v[4]);
				importer_query("INSERT INTO `groups` (
					`id`, `name`, `level`, `text_small`, `text`, `parent_id`, `archive`, `img`, `priority`,`nameeng`)
					VALUES
					({$v[1]}, '" . get_prop($v[4]) . "', 3, '" . get_prop($v[5]) . "', '" . get_prop($v[6]) . "', $level2, " . (get_prop($v[7]) ? 1 : 0) . ", '" . get_prop($v[8]) . "', {$priority},'".$nameeng."');
				");
				$parents_arr[$v[1]] = $level2;
			}
		}
		

		importer_query("DROP TABLE IF EXISTS `item`;");
		importer_query("
				CREATE TABLE IF NOT EXISTS `item` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `advflag` tinyint(1) NOT NULL DEFAULT '0',
				  `name` varchar(250) DEFAULT NULL,
				  `text_small` varchar(250) DEFAULT NULL,
				  `text` text,
				  `price` varchar(40) DEFAULT NULL,
				  `archive` int(11) NOT NULL DEFAULT '0',
				  `groups_id` int(11) DEFAULT NULL,
				  `article` varchar(40) DEFAULT NULL,
				  `img` varchar(100) NOT NULL DEFAULT '',
				  `priority` int(11) NOT NULL,
				  `size_co` varchar(250) NOT NULL,
				  `trans_name` varchar(250) NOT NULL,
				  `madeby` varchar(250) NOT NULL, 	
				  `madebyeng` varchar(250) NOT NULL, 	
				  PRIMARY KEY (`id`),
				  KEY `groups_id` (`groups_id`),
				  KEY `archive` (`archive`)
			) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=5000;
		");
		$skip_titles = true;
		$count = 15;
		$used_ids = array();
		foreach($data->sheets[0]['cells'] as $v)
		{
			if($skip_titles)
			{
				$skip_titles = false;
				continue;
			}
			$v[14] = $v[12];
			$v[15] = get_translit_singleline($v[14]);
			$base = $v[1];
			$links = explode (';', $v[1]);
			for ($i=0; $i<count($links); $i++)
			{
				$priority++;
				if (!is_numeric($links[$i]))
					continue;
				$v[1] = trim($links[$i]);
				if($v[11])
					while(isset($used_ids[$v[11]]))
						$v[11] += $v[11] > 10000 ? 1 : 10000;
				else
					$v[11] = 'NULL';
				$v[12] = $priority;
                                $v[13] = "/catalog{$parents_arr[$v[1]]}/models{$v[1]}/" . strtolower(get_translit_singleline($v[3] . '_' . $v[2])) . '.php';

				importer_query("INSERT INTO `item` (
						`groups_id`,`article`, `name`, `archive`, `price`,`size_co`, `text`,`text_small`, `img`, `advflag`,`id`, `priority`,`trans_name`,`madeby`,`madebyeng`)
								VALUES
								(" . get_seq_params($v, $count) . ");
				");
				$used_ids[mysql_insert_id()] = 1;
			}
		}
	}
	else if(strpos($id, 'm') !== FALSE)
	{
		$current = array();
		$skip_titles = true;
		foreach($data->sheets[0]['cells'] as $v)
		{
			if($skip_titles)
			{
				$skip_titles = false;
				continue;
			}
			$current[] = $v;
		}

		$parents = array();
		$skip_titles = true;
		foreach($data->sheets[1]['cells'] as $v)
		{
			if($skip_titles)
			{
				$skip_titles = false;
				continue;
			}
			if($v[2])
			{
				$parents[$v[1]] = 0;
				$level1 = $v[1];
			}
			if($v[3])
			{
				$parents[$v[1]] = $level1;
				$level2  = $v[1];
			}
			if($v[4])
			{
				$parents[$v[1]] = $level2;
			}
		}

		$data2 = new Spreadsheet_Excel_Reader();
		
		$data2->setOutputEncoding('windows-1251');
		
		$data2->read('kristina.xls');
		
		importer_query("DROP TABLE IF EXISTS `article_map`;");
		importer_query("
				CREATE TABLE IF NOT EXISTS `article_map` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `old` varchar(40) DEFAULT NULL,
				  `new` varchar(40) DEFAULT NULL,
				  `cat` int(11) NOT NULL,
				  `mod` int(11) NOT NULL,
				  `prod` int(11) NOT NULL,
				  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1;
		");

		$kristina = array();
		$skip_titles = true;
		foreach($data2->sheets[0]['cells'] as $v)
		{
			if($skip_titles || !$v[1])
			{
				$skip_titles = false;
			}
			else if(is_numeric($v[1]))
			{
				foreach($current as $k => $e)
				{
					if($e[11] == $v[1])
					{
						importer_query("INSERT INTO `article_map` (`old`,`new`,`cat`,`mod`,`prod`) VALUES ('{$e[2]}', '{$v[4]}',{$parents[$e[1]]},{$e[1]},{$e[11]});");
						break;
					}
				}
			}
			else
			{
				foreach($current as $k => $e)
				{
					if($e[2] == $v[4])
					{
						importer_query("INSERT INTO `article_map` (`old`,`new`,`cat`,`mod`,`prod`) VALUES ('{$v[1]}', '{$v[4]}',{$parents[$e[1]]},{$e[1]},{$e[11]});");
						break;
					}
				}
			}
		}	
	}
	else if(strpos($id, 'w') !== FALSE)
	{
		$data2 = new Spreadsheet_Excel_Reader();
		
		$data2->setOutputEncoding('windows-1251');
		
		$data2->read('kristina.xls');
		$count = 12;
		$used_ids = array();
		$priority = 150;
		$skip_titles = true;
		foreach($data2->sheets[0]['cells'] as $v)
		{
			if($skip_titles || !$v[3])
			{
				$skip_titles = false;
			}
			else if(!$v[1])
			{      	
				$a = array('',$v[2],$v[4],$v[5],'',$v[8],$v[8],$v[6],'','','','',$v[7]);

				$base = $a[1];
				$links = explode (';', trim($a[1]));
				for ($i=0; $i<count($links); $i++)
				{
					$priority++;
					if (!is_numeric($links[$i]))
						continue;
					$a[1] = $links[$i];
	
					while($a[10] && isset($used_ids[$a[10]]))
						$a[10] += $a[10] > 10000 ? 1 : 10000;
       	
					$a[11] = $priority;
       	
					importer_query("INSERT INTO `item` (
							`groups_id`,`article`, `name`, `price`,  `text`, `text_small`,  `img`, `advflag`, `archive`, 										`id`,`priority`,`size_co`)
							VALUES
							(" . get_seq_params($a, $count) . ");
					");
					$used_ids[mysql_insert_id()] = 1;
				}
			}
		}	
	}
	else if(strpos($id, 'f') !== FALSE)
	{
		$current = array();
		$skip_titles = true;
		foreach($data->sheets[0]['cells'] as $v)
		{
			if($skip_titles)
			{
				$skip_titles = false;
				continue;
			}
			$current[] = $v;
		}

		$data2 = new Spreadsheet_Excel_Reader();
		
		$data2->setOutputEncoding('windows-1251');
		
		$data2->read('kristina.xls');
		
		$kristina = array();
		$skip_titles = true;
		foreach($data2->sheets[0]['cells'] as $v)
		{
			if($skip_titles || !$v[3])
			{
				$skip_titles = false;
			}
			else if(!$v[1])
			{      	
				continue;
				$current[] = array('',$v[2],$v[4],$v[5],'',$v[8],$v[8],$v[6],'','','','',$v[7]);
			}
			else if(is_numeric($v[1]))
			{
				foreach($current as $k => $e)
				{
					if($e[10] == $v[1])
					{
						if($v[2]) $current[$k][1] = $v[2];
						if($v[4]) $current[$k][2] = $v[4];
						if($v[5]) $current[$k][3] = $v[5];
						if($v[8]) $current[$k][5] = $v[8];
						if($v[6]) $current[$k][7] = $v[6];
						$current[$k][12] = $v[7];
						break;
					}
				}
			}
			else
			{
				foreach($current as $k => $e)
				{
					if($e[2] == $v[1])
					{
						if($v[2]) $current[$k][1] = $v[2];
						if($v[4]) $current[$k][2] = $v[4];
						if($v[5]) $current[$k][3] = $v[5];
						if($v[8]) $current[$k][5] = $v[8];
						if($v[6]) $current[$k][7] = $v[6];
						$current[$k][12] = $v[7];
						break;
					}
				}
			}
		}	

		importer_query("DROP TABLE IF EXISTS `item`;");
		importer_query("
				CREATE TABLE IF NOT EXISTS `item` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `advflag` tinyint(1) NOT NULL DEFAULT '0',
				  `name` varchar(250) DEFAULT NULL,
				  `text_small` varchar(250) DEFAULT NULL,
				  `text` text,
				  `price` varchar(40) DEFAULT NULL,
				  `archive` int(11) NOT NULL DEFAULT '0',
				  `groups_id` int(11) DEFAULT NULL,
				  `article` varchar(40) DEFAULT NULL,
				  `img` varchar(100) NOT NULL DEFAULT '',
				  `priority` int(11) NOT NULL,
				  `size_co` varchar(250) NOT NULL,
				  PRIMARY KEY (`id`),
				  KEY `groups_id` (`groups_id`),
				  KEY `archive` (`archive`)
			) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=5000;
		");

//var_dump(count($current));
		
		$skip_titles = true;
		$count = 12;
		$used_ids = array();
		foreach($current as $v)
		{
			if($skip_titles)
			{
				$skip_titles = false;
				continue;
			}
				
			$base = $v[1];
			$links = explode (';', trim($v[1]));
			for ($i=0; $i<count($links); $i++)
			{
				$priority++;
				if (!is_numeric($links[$i]))
					continue;
				$v[1] = $links[$i];

				while($v[10] && isset($used_ids[$v[10]]))
					$v[10] += $v[10] > 10000 ? 1 : 10000;

				$v[11] = $priority;

				importer_query("INSERT INTO `item` (
						`groups_id`,`article`, `name`, `price`,  `text`, `text_small`,  `img`, `advflag`, `archive`, 										`id`,`priority`,`size_co`)
						VALUES
						(" . get_seq_params($v, $count) . ");
				");
				$used_ids[mysql_insert_id()] = 1;
			}
		}
	}


}

	function importer_query ($q_str)
	{		
		$res = mysql_query($q_str);

		if (mysql_errno()) 
		{ 
			echo "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n{$q_str}\n<br>"; 
		}
		return $res; 
	}
	
	function get_prop($e)
	{
		return trim(str_replace(array("'", "\n"), array("\\'", "<br>\n"), $e));
	}	

	function get_seq_params($data, $count)
	{
		$ret = '';
		for($i = 1; $i <= $count; $i++)
			$ret .= ($ret ? ',' : '') . "'" .  $data[$i] . "'";
		return $ret;
	}
	
	function fix_capitalization($in_str)
	{
		$in_str = strtolower_cyr(trim($in_str)); 
		$in_str[0] = strtoupper_cyr($in_str[0]);
		return $in_str;
	}

	function addToOutput($message) 
	{
		$handle = fopen('output.txt', "a+");
		fwrite($handle, $message . PHP_EOL);
		fclose($handle);			
	}
	
?>