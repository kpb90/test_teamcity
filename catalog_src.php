<?php

include"./new_admin/importer/translit.php";

//require('admin/paging.php');

function pscript_execute() 
{
	$is_tov_page = $GLOBALS['PAGE_TYPE'] == 'tovar';
	$GLOBALS['PAGE_MADEBY_MODE'] = false;
	$GLOBALS['PAGE_BREND'] = array();
	$brend_tovs = false;
	$brend_cat_row = array();

	if($is_tov_page)
	{

		$GLOBALS['II_PAGE_PARAMS']['TOVDATA'][] = $GLOBALS['CATALOG_INFO'];
		$GLOBALS['SCRIPT_SET_DATA_HPTITLE'] = $GLOBALS['II_PAGE_PARAMS']['TOVDATA'][0]['title'];
		$first_item = $GLOBALS['II_PAGE_PARAMS']['TOVDATA'][0];
		$rtext = $GLOBALS['PAGE_TOP_BLOCK'] = '';
	}
	else if($GLOBALS['PAGE_TYPE'] == 'ishop')
	{
		$ishop_url = substr($_SERVER["REQUEST_URI"], strlen('/internet_magazin/'));			
		//echo "SELECT * from studio_catalog where title_latin like '/{$ishop_url}%' order by ID ASC";
		$r = $GLOBALS['DB_CONNECTION']->query("SELECT * from studio_catalog where title_latin like '/{$ishop_url}%' order by ID ASC");
		if($r)
		while($row = $r->fetch_assoc())
			$rtext .= "<tr><td>{$row['title']}</td><td>{$row['article']}</td><td>{$row['price']}</td></tr>";
		$rtext = "<table>{$rtext}</table>";

	}
	else if($GLOBALS['PAGE_TYPE'] == 'madeby')
	{
		$GLOBALS['PAGE_MADEBY_MODE'] = true;
		$brend_url = GetBetween($_SERVER["REQUEST_URI"], '/madeby/', '/');			
		
		$r = $GLOBALS['DB_CONNECTION']->query("select * from studio_catalog_madeby where title_latin='{$brend_url}' limit 1");
		if($r)
		{
			$GLOBALS['PAGE_BREND'] = $r->fetch_assoc();
			if(!$GLOBALS['PAGE_BREND'])
				return "Производитель не найден";
			$rimg = $GLOBALS['PAGE_BREND']['img'] ? "<img src='/images/brand/{$GLOBALS['PAGE_BREND']['img']}' width=140 alt='Логотип {$GLOBALS['PAGE_BREND']['name']}' style='float: left; margin: 0 10px 10px 0;'>" : '';
			$rtext = "<div id='cat_full_descr'>{$rimg}{$GLOBALS['PAGE_BREND']['text_small']}</div>";

		}
		else
			return "Производитель не найден";

		$brend_tovs = substr_count($_SERVER["REQUEST_URI"], '/') > 3;
		if($brend_tovs)
		{	
			$brend_cat = substr($_SERVER["REQUEST_URI"], strlen($GLOBALS['PAGE_BREND']['title_latin']) + 8);
			$r = $GLOBALS['DB_CONNECTION']->query("SELECT * from studio_catalog where title_latin like '%{$brend_cat}%' and brend_latin='{$GLOBALS['PAGE_BREND']['title_latin']}' order by if(pict = 'no_photo.png' or pict = 'no_photo' or pict is null,1,0), ID ASC");
			if($r)
			while($row = $r->fetch_assoc())
				$GLOBALS['II_PAGE_PARAMS']['TOVDATA'][] = $row;

			$r = $GLOBALS['DB_CONNECTION']->query("SELECT * from studio_catalog_groups where g3_latin like '%{$brend_cat}' limit 1");
			if($r && $row = $r->fetch_assoc())
				$brend_cat_row = $row;

			$GLOBALS['SCRIPT_SET_DATA_HPTITLE'] = $brend_cat_row["g{$brend_cat_row['tlevel']}title"] . ' ' . $GLOBALS['PAGE_BREND']['name']; 
		}
		else
		{
			$r = $GLOBALS['DB_CONNECTION']->query("select g.* from studio_catalog_groups as g inner join (SELECT gid from studio_catalog where brend_latin='{$GLOBALS['PAGE_BREND']['title_latin']}' group by gid) as m on g.code=m.gid order by g.code asc");
			if($r)
			while($row = $r->fetch_assoc())
				$GLOBALS['II_PAGE_PARAMS']['DATA'][] = $row;
			$first_item = $GLOBALS['II_PAGE_PARAMS']['DATA'][0];
			$GLOBALS['SCRIPT_SET_DATA_HPTITLE'] = 'Спецодежда и СИЗ ' . $GLOBALS['PAGE_BREND']['name']; 
		}	
	}
	else
	{
		$first_item = $GLOBALS['II_PAGE_PARAMS']['DATA'][] = $GLOBALS['CATALOG_INFO'];
		if($first_item)
		{
			$GLOBALS['SCRIPT_SET_DATA_HPTITLE'] = $first_item["g{$first_item['tlevel']}title"];


			if($first_item['hassubdirs'])
			{
				$r = $GLOBALS['DB_CONNECTION']->query("SELECT * from studio_catalog_groups where `g{$first_item['tlevel']}_latin`='{$first_item['g3_latin']}' order by ID ASC");
				if($r)
				while($row = $r->fetch_assoc())
					$GLOBALS['II_PAGE_PARAMS']['DATA'][] = $row;
                        }
                        else
			{
				$r = $GLOBALS['DB_CONNECTION']->query("SELECT * from studio_catalog where gid='{$first_item['code']}' order by if(pict = 'no_photo.png' or pict = '' or pict is null,1,0), ID ASC");
				if($r)
				while($row = $r->fetch_assoc())
					$GLOBALS['II_PAGE_PARAMS']['TOVDATA'][] = $row;
			}

			$rtext = "<div id='cat_full_descr'>{$first_item['descr']}</div>";
		}
	}

	//var_dump($first_item);

	if(!$GLOBALS['PAGE_MADEBY_MODE'] && ($first_item['g2title'] || $first_item['g3title']))
	{
		$scr_text = '<a href="' . $first_item['g1_latin'] . '" title="' . $first_item['g1title'] . '" alt="' . $first_item['g1title'] . '">' . $first_item['g1title'] . '</a>';
		if($first_item['g2title'])
			$scr_text .= ' → <a href="' . $first_item['g2_latin'] . '" title="' . $first_item['g2title'] . '" alt="' . $first_item['g2title'] . '">' . $first_item['g2title'] . '</a>';
		if($first_item['g3title'])
			$scr_text .= ' → <a href="' . $first_item['g3_latin'] . '" title="' . $first_item['g3title'] . '" alt="' . $first_item['g3title'] . '">' . $first_item['g3title'] . '</a>';
	}
	else if($brend_tovs)
	{
		$scr_text = "<a href='/madeby/{$GLOBALS['PAGE_BREND']['title_latin']}/' title='Спецодежда и СИЗ {$GLOBALS['PAGE_BREND']['name']}'>{$GLOBALS['PAGE_BREND']['name']}</a>
			 → <a href='{$_SERVER["REQUEST_URI"]}' title='{$GLOBALS['SCRIPT_SET_DATA_HPTITLE']}' alt='{$GLOBALS['SCRIPT_SET_DATA_HPTITLE']}'>{$GLOBALS['SCRIPT_SET_DATA_HPTITLE']}</a>";
	}

	$GLOBALS['SCRIPT_SET_DATA_SCRUMB'] = '
		<div id="crumbs">'
			 . $scr_text . '
		</div>
	';


	if(count($GLOBALS['II_PAGE_PARAMS']['DATA']) > 0)
	foreach($GLOBALS['II_PAGE_PARAMS']['DATA'] as $row)
	{
		if(!$GLOBALS['PAGE_MADEBY_MODE'] && ($row['tlevel'] - 1) != $first_item['tlevel'] )
			continue;
		$rtext .=  drawFolder($row);
	}

	if(count($GLOBALS['II_PAGE_PARAMS']['TOVDATA']) > 0)
	foreach($GLOBALS['II_PAGE_PARAMS']['TOVDATA'] as $row)
	{
		$rtext .= $is_tov_page ? drawProduct($row) : drawProductSimple($row);
	}									 


	$GLOBALS['SCRIPT_SET_DATA_TITLE'] = $GLOBALS['SCRIPT_SET_DATA_HPTITLE'] . ($GLOBALS['PAGE_BREND']['name'] =='3M' ? ' (3М - ЗМ)' : '') . 'Низкие цены в интернет-магазине и информация где купить оптом.';

	if($is_tov_page)
	{
		$GLOBALS['PAGE_TOP_BLOCK'] = "<div class='product-pager'>{$GLOBALS['PAGE_TOP_BLOCK']}</div>";
	}
	else
	{
		$GLOBALS['PAGE_TOP_BLOCK'] = "<header class='calalog-header'><h1>{$GLOBALS['SCRIPT_SET_DATA_HPTITLE']}</h1></header>";
		$rtext = $rtext . get_seo_name($GLOBALS['SCRIPT_SET_DATA_HPTITLE']);
	}

	return '
		<div class="breadcrumbs catalog">
  			' . $scr_text . '
		</div>
		' . $GLOBALS['PAGE_TOP_BLOCK'] . '
		<div class="catalog-block"' . ($is_tov_page ? ' style="margin-top: 58px;"' : '') . '>
                    	<div class="right">
				' . $rtext . '
			</div>
			<div class="left">
				' . get_product_info_top($first_item) . get_l_menu() . get_madeby_menu() . '
			</div>
			<clear></clear>
		</div>
	';
}

$GLOBALS['II_PAGE_DESCR']['CNTR'] = 0;

function drawProductSimple($row)
{	
	$rname_branded = $row[title];
	$branded_block = '';
	if($row['brend'])
	{
		$kkey = $row[brend_latin] == 'nord' || $row[brend_latin] == 'MONBLAN' || $row[brend_latin] == 'spec' || $row[brend_latin] == 'rang' ? 'Коллекция' : 'Производитель';
		$branded_block = $row['brend'] ? "\n<div class='brend_link'>{$kkey}: " . ($row[brend_latin] ? "<a href='/madeby/{$row[brend_latin]}/' title='Спецодежда и СИЗ {$row[brend]}'>{$row[brend]}</a></div>" : $row[brend]) : '';
		$rname_branded = $row[title] . ', ' .  $row['brend'];
	}

	$img_txt = $row[pict] ? "<A href='{$row[title_latin]}' title='{$rname_branded}'><IMG SRC='/images/items/small/{$row[pict]}' WIDTH=80  BORDER=0 HSPACE=1 VSPACE=1 alt='$active_keyword, {$rname_branded}' style='padding-bottom: 10px;'></a>" : '&nbsp;';

	$mbylogo = '';
	if($row[img])
		$mbylogo = "<img src='/img/products/middle/{$row[img]}' alt='Логотип {$row[madeby]}' style='position: absolute; top: 0px; right: 30px;'>";


	return "
			<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 VALIGN='TOP' width='100%' style='border-bottom: 1px solid #afafaf; position: relative; margin: 5px 0;'>
				<TR><TD VALIGN='TOP' WIDTH=80 style='padding: 4px 10px 0px 0px;'>
					{$img_txt}
				</TD><TD VALIGN='TOP'>
					<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 VALIGN='TOP' WIDTH='100%'>
						<TR><TD><div class='scaptext' style='margin: 4px 0;'><A href='{$row[title_latin]}' title='{$rname_branded}'>{$row[title]}</a></div>
							<div class='text'>" . $row[text_small] . "</div>
						</TD></TR><TR><td>
							<A href='{$row[title_latin]}' title='{$rname_branded}' class='readmore'>Подробнее</A>
							<div class='pricetext' style='margin-left: 10px;'>" . 
								($row[article] ? "<div class='code'><p>Код по каталогу</p><p>{$row[article]}</p></div>" : '') . "
							</div>
							{$branded_block}
						</td></TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	";

}

function drawProduct($row)
{	
	$rname_branded = $row[title] . ($row[madeby] && !strpos($row[title], $row[madeby]) && !strpos($grow[title], $row[madeby]) ? ' ' . $row[madeby] : '');
	$title = "$rname_branded ($grow[title]): цена, где купить, фото, продажа мужских и женских.";
	$pagedescription="Восток-Сервис Санкт-Петербург - $grow[title] - $rname_branded: цена, купить, фото.";

	$p_name = 'Каталог';
	$tov_name = $row[title];

	#проверка картинки
	if ($row['pict'])
	{
		$img_big ="
			<a id='single_image' href='/$img[title]' title='{$rname_branded}'><IMG id='main_image' SRC='/images/items/460x530/{$row[pict]}' ALIGN='RIGHT' HSPACE=10 alt='$active_keyword, {$rname_branded}'></a>
		";
	}

	//<div class='text' style='margin-right: 10px;'>". $row[text] . $row[article] . ($row[madeby] ? "<br>Производитель: <a href='/madeby/{$row[madebyeng]}/' title='Спецодежда и СИЗ {$row[madeby]}" . ($row[madeby] =='3M' ? ' (3М - ЗМ)' : '') . "'><b>{$row[madeby]}</b>{$mbylogo}" : '') . "</div>

	if($row['prot_props'])
	{
		$a = $row['prot_props'];
		$row['prot_props'] = '';

		if($a[strlen($a) - 1] == ',')
			$a= substr($a, 0, -1);

		$r = $GLOBALS['DB_CONNECTION']->query("SELECT * from studio_prot_props where id in ({$a}) order by id ASC");
		if($r)
		{
			while($pprow = $r->fetch_assoc())
				$row['prot_props'] .= "<div class='block iTooltip' title='{$pprow['title']}' data-description='{$pprow['descr']}'><a href='#'><img src='/images/care_props/{$pprow['pict']}'></a></div>\n";
			$row['prot_props'] = "
				<article class='care-props'>
					<header class='active'>Защитные свойства</header>
					<div>
						{$row['prot_props']}
						<clear class=''></clear>
					</div>
				</article>
			";
		}
	}

	if($row['techs'])
	{
		$a = $row['techs'];
		$row['techs'] = '';

		if($a[strlen($a) - 1] == ',')
			$a= substr($a, 0, -1);

		$r = $GLOBALS['DB_CONNECTION']->query("SELECT * from studio_techs where id in ({$a}) order by id ASC");
		if($r)
		{
			while($pprow = $r->fetch_assoc())
				$row['techs'] .= "<div><a href='http://sankt-peterburg.vostok.ru{$pprow['descr']}' title='{$pprow['title']}'>{$pprow['title']}</a></div>\n";
			$row['techs'] = "
				<div class='technologies'>
					<header class='active'>Используемые технологии<i></i></header>
					<div style='display: block;'>
						{$row['techs']}
					</div>
				</div>
			";
		}
	}

	if($row['advices'])
	{
		$a = $row['advices'];
		$row['advices'] = '';

		if($a[strlen($a) - 1] == ',')
			$a= substr($a, 0, -1);

		$r = $GLOBALS['DB_CONNECTION']->query("SELECT * from studio_advices where id in ({$a}) order by id ASC");
		if($r)
		{
			while($pprow = $r->fetch_assoc())
				$row['advices'] .= "<div class='block iTooltip' data-description='{$pprow['descr']}' title='{$pprow['title']}'><a href='#' title='{$pprow['title']}'><img src='/images/recomend/{$pprow['pict']}'></a></div>\n";
			$row['advices'] = "
				<div class='recomendation block'>
					<header class='active'>Рекомендации по уходу<i></i></header>
					<div>
						{$row['advices']}
					</div>
				</div>
			";
		}
	}

	if($row['extra_props'])
	{
		$a = $row['extra_props'];
		$row['extra_props'] = '';

		if($a[strlen($a) - 1] == ',')
			$a= substr($a, 0, -1);

		$r = $GLOBALS['DB_CONNECTION']->query("SELECT * from studio_extra_props where id in ({$a}) order by id ASC");
		if($r)
		{
			while($pprow = $r->fetch_assoc())
				$row['extra_props'] .= "<div><strong>{$pprow['title']}</strong>: {$pprow['value']}</div>\n";
			$row['extra_props'] = "
				<div class='charact block'>
					<header class='active'>Характеристики единицы товара<i></i></header>
					<div><div class='about'>
						{$row['extra_props']}
					</div></div>
				</div>
			";
		}
	}

	if($row['gost'])
	{
		$ginfo = explode(';', $row['gost']);
		$row['gost'] = isset($ginfo[1]) ? "<div class='gost'><div><a href='http://cdn.vostok.ru/uploads/global/ghost/{$ginfo[1]}' target='_blank'>{$ginfo[0]}</a></div></div>" : "<div class='gost'><div>{$ginfo[0]}</div></div>";
	}

	if($row['morepict'])
	{
		$a = $row['morepict'];
		$row['morepict'] = '';
	
		$ginfo = explode(';', $a);
		$i = $row['id'] * 10;
		foreach($ginfo as $pprow)
			$row['morepict'] .= "<a num='" . (++$i) . "' data-title='{$row['title']}' href='/images/items/middle/{$pprow}' data-preview='/images/items/460x530/{$pprow}'><img src='/images/items/small/{$pprow}' alt='{$row['title']}'></a>\n";

		$row['morepict'] = "
			<div id='product-status-container'></div>
					<div class='pslider'>
						<div class='display'><div class='dots'></div></div>
						<div class='slide'>
							<div class='container'>
								<div class='track'>
									{$row['morepict']}									
								</div>
							</div>
						</div>
					</div>
		";
	}
	else
		$row['morepict'] = "<div class='no-photo'><img src='/images/items/middle/{$row[pict]}' alt='{$row['title']}'" . ($row[pict] == 'no_photo.png' ? ' style="padding: 40px 0;"' : '') . "></div>";


	$mbylogo = '';
	if($row[brend_img])
		$mbylogo = "
			<div class='production'>
	        	    <a href='/madeby/{$row['brend_latin']}/'><img src='/images/brand/{$row['brend_img']}'></a>
	        	</div>
		";

	$infolink = '/razmeri_odezhdi.php';
	$infotitle = 'Таблицы размеров одежды и обуви';
	if(0 && strpos($_SERVER["REQUEST_URI"], '/zashhita_ruk/') === 0)
	{
		$infolink = '/services/perchatki.pptx';
		$infotitle = 'Инструкция по работе с перчатками, определение размера перчаток';
	}

	if($row['descr'])
		$row['descr'] = '<header class="active">Подробное описание<i></i></header>' . $row['descr'] . '<br />';

	return "
		<div class='inner-body'>
			<div id='product-production'>
				{$mbylogo}
				{$row['prot_props']}
				{$row['techs']}
				<clear class=''></clear>
				<div style='text-align: center; margin-top: 10px; background-color: #257bc8; padding: 3px 5px;'><a href='{$infolink}' title='{$infotitle}' style='color: white; display: block; font-weight: bold; text-decoration: none;'>{$infotitle}</a></div>
				
			</div>

			<div id='product-pictures'>
				<div class='product product-pictures-small'>
                                        {$row['morepict']}
					<a href='##' class='prev disabled'></a>
					<a href='##' class='next'></a>
				</div>
			</div>

			<div id='production-charact-comments'>
				<div class='charact block'>
					{$row['gost']}
				</div>
				<div class='fulldescr block'>
					{$row['descr']}
				</div>
				{$row['extra_props']}<br>
				{$row['advices']}
				<clear class=''></clear>
		 	  	" . get_seo_name($row['title']) . show_neighbour_products($row[gid], $row[id]) . "
			</div>
			<clear class='safely'></clear>
		</div>
	";
	
}

function drawFolder($row)
{
	$urla =  $row["g{$row['tlevel']}_latin"];
	$row_title = $row["g{$row['tlevel']}title"];

	if($GLOBALS['PAGE_MADEBY_MODE'])
	{
		$urla = '/madeby/' . $GLOBALS['PAGE_BREND']['title_latin'] . '/' . get_translit_singleline($row_title) . '/';
		$row_title .= ' ' . $GLOBALS['PAGE_BREND']['name'];
	}
	
	$img_txt = $row[pict] ? "<A href='{$row['g3_latin']}' style='color: #FC7D44; text-decoration: none'><IMG SRC='/images/items/small/{$row[pict]}' WIDTH=76 BORDER=0 HSPACE=1 VSPACE=1 alt='{$active_keyword}, {$row_title}' style='padding-bottom: 10px;'></A>" : '&nbsp;';
		
	return "
			<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 VALIGN='TOP' width='100%' style='border-bottom: 1px solid #afafaf; position: relative;'>
				<TR><TD VALIGN='TOP' WIDTH=80 style='padding: 4px 10px 0px 0px;'>
					{$img_txt}
				</TD><TD VALIGN='TOP'>
					<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 VALIGN='TOP' WIDTH='100%'>
						<TR><TD><div class='scaptext' style='margin-bottom: 4px;'><A href='{$urla}' title='{$row_title}'>{$row_title}</a></div>
							" . ($row[descr] ? "<div class='text'>{$row[descr]}</div>" : '') . "
						</TD></TR><TR><td>
							<A href='{$urla}' title='{$rname_branded}' class='readmore'>" . ($row[hassubdirs] ? 'Подгруппы' : 'Каталог товаров') . "</A>
						</td></TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
		<BR>
	";

}

function get_tov_price($row)
{
	if(!$row['price'])
		return "<div class='price_div'>Цену уточняйте у менеджера</div>";
	
	if($row['oldprice'])
		$row['price'] = "<nobr><del>{$row['oldprice']}</del>&nbsp;&nbsp;<ins>{$row['price']}</ins></nobr>";


	return "<div class='price_div'>Цена:&nbsp;<span>{$row['price']}</span></div>";
}

function get_seo_name($ttle_in)
{
	$shops_rows=afetchrowset(mysql_query("select content from cms2_pages where id=140"));
	$shops_row = $shops_rows[0];
	$seo2text_low = get_seo_low($ttle_in);
	return "<div style='clear: both; padding-top: 10px;'>Приобрести {$seo2text_low} можно также и в розницу в одном из наших магазинов (<b>обязательно заранее уточните наличие по телефону</b>):<br>{$shops_row['content']}<div class='clear'></div></div>";
}

function get_seo_low($ttle_in)
{
	return str_replace(explode(',', 'Ё,Й,Ц,У,К,Е,Н,Г,Ш,Щ,З,Х,Ъ,Ф,Ы,В,А,П,Р,О,Л,Д,Ж,Э,Я,Ч,С,М,И,Т,Ь,Б,Ю,одежда,защита,футболка,куртка,кепка,каска,сигнальная'), 
		explode(',', 'ё,й,ц,у,к,е,н,г,ш,щ,з,х,ъ,ф,ы,в,а,п,р,о,л,д,ж,э,я,ч,с,м,и,т,ь,б,ю,одежду,защиту,футболку,куртку,кепку,каску,сигнальную'), $ttle_in);
}

function show_neighbour_products($gr_id, $cur_item = '')
{
	$cnt = 0;
	$r = $GLOBALS['DB_CONNECTION']->query("select * from studio_catalog where gid='{$gr_id}' order by if(pict = 'no_photo.png' or pict = 'no_photo' or pict is null,1,0), id asc");
	if($r)
	while($row = $r->fetch_assoc())
		$item_arr[$cnt++] = $row;


	if(!$item_arr || count($item_arr) == 0)
		return '';

	$ret = '';
	$cnt = 1;
	foreach($item_arr as $i => $item_row)
	{
		if ($cur_item && $item_row['id'] == $cur_item)
		{
			if($i > 0)
				$GLOBALS['PAGE_TOP_BLOCK'] .= "<a href='" . $item_arr[$i - 1][title_latin] . "'><span>предыдущий</span>товар</a>";
			if($i < $cnt)
				$GLOBALS['PAGE_TOP_BLOCK'] .= "<a href='" . $item_arr[$i + 1][title_latin] . "'><span>следующий</span>товар</a>";	
			continue;
	         }


		$smallimg = '';
		if($item_row[pict] != '')
		{
			//$im_prop = !$cur_item || $img['width'] * 1.3 > $img['height'] ? 'WIDTH=60' : 'height=78';
			$smallimg = "<div style='height: 140px; display: table-cell; vertical-align: middle;'><IMG SRC='/images/items/small/{$item_row[pict]}' style='max-width: 80px; max-height: 140px;' alt='{$item_row[title]}'></div>";
		}

		$cor_articul = '';
		if ($item_row[article] != '') 
			$cor_articul = "{$item_row[article]}";
			$cor_price = '';
		if ($item_row[price] > 0 && ($cor_price = get_tov_price($item_row)) > 0) 
			$cor_price = "<br>Цена: $cor_price";
		$separ = $cnt++ % 4 ? '' : '<div style="clear: both;"></div>';
		$ret .= "
				<div class='samegrovs'>
					<a href='{$item_row[title_latin]}'>
						{$smallimg}<br>
						<div class='ttle'><b>{$item_row[title]}</b></div>
						<div class='code2'><p>Код по каталогу</p>{$cor_articul}</div>
						<p class='readmore'>Подробнее</p>
					</a>
				</div>{$separ}
		";
	}

	return "<div class = 'wrp-samegrovs'>{$ret}</div>";
}

function get_product_info_top($first_item) 
{                                         
	if($GLOBALS['PAGE_TYPE'] != 'tovar')
		return '';

        $scr_text = '';
	if($first_item['tlevel'] == 2)
		$scr_text = "<a href='{$first_item['g2_latin']}' style='line-height: 16px; padding-top: 5px; height: 72px;'><div style='padding-top: 14px;'>{$first_item['g1title']}</div><p>{$first_item['g2title']}</p></a>";
	else if($first_item['tlevel'] == 3)
		$scr_text = "<a href='{$first_item['g3_latin']}' style='line-height: 16px; padding-top: 5px; height: 72px;'>{$first_item['g1title']}<p>{$first_item['g2title']}</p><p>{$first_item['g3title']}</p></a>";


	$gr_code = $first_item['g1title'] == 'Спецодежда' ? 1 : ($first_item['g1title'] == 'Спецобувь' ? 2 : ($first_item['g1title'] == 'Средства защиты' ? 3 : ($first_item['g1title'] == 'Защита рук' ? 4 : 5)));

	if($GLOBALS['CATALOG_INFO']['price'])
		$pricebl = "
					<div class='price'><span class='current'>{$GLOBALS['CATALOG_INFO']['price']}</span></div>
					<div class='price-notice'>Цена указана с учетом НДС</div>
		";
	else
		$pricebl = "<div class='price' style='font-size: 14px;'>Цену уточняйте у менеджера</div>";

	if($GLOBALS['CATALOG_INFO']['external_link'])
		$pricebl .= "<a href='{$GLOBALS['CATALOG_INFO']['external_link']}'  onclick=\"yaCounter22471051.reachGoal('MAGAZIN'); return true;\"><img src='/images/234857.png'></a>";

	$GLOBALS['CATALOG_INFO']['title'] = str_replace('&nbsp;', ' ', $GLOBALS['CATALOG_INFO']['title']);
	$fprops = '';	
	$words = explode(' ', $GLOBALS['CATALOG_INFO']['title']);
//echo '<!--';	var_dump($words); echo '-->';
	foreach($words as $w)
		if(mb_strlen($w) > 15)
		{
			$fprops = ' style="font-size: 20px;"';	
			break;
		}	
	
	return "
			<div id='catalog-menu'>
				<ul data-id='0' data-parent='01' class='level0' style='width: 320px;'>
					<li data-group='01_01' class='group-01_0{$gr_code} seltd'>
						{$scr_text}
					</li>
				</ul>
			</div>
			<div id='product-info'>
				<div data-id='{$GLOBALS['CATALOG_INFO']['id']}' class='product-view'>
					<header class='curproduct title'>
						<h1{$fprops}>{$GLOBALS['CATALOG_INFO']['title']}</h1>
						<div class='code'>Код по каталогу: <span>{$GLOBALS['CATALOG_INFO']['article']}</span></div>
					</header>
					{$pricebl}
				</div>
			</div>
	";
}

function get_madeby_menu() 
{                                         
	$madeby_arr = array('CERVA' => array('CERVA', ''), '3M' => array('3M', ''), '3M_PELTOR' => array('3M PELTOR', ''), '3M_SPEEDGLAS' => array('3M SPEEDGLAS', ''),'ANSELL' => array('ANSELL', ''),
				'UVEX' => array('UVEX', ''), 'JSP' => array('JSP', ''), 'MILLER' => array('MILLER', ''), 'HECKEL' => array('HECKEL', ''), 'DuPont' => array('DuPont', ''), 'MG' => array('M&G', ''),
				'ARX' => array('ARX', ''), 'SPIROTEK' => array('SPIROTEK', ''), 'OPTEX' => array('OPTEX', ''), 'rosomz' => array('РОСОМЗ', ''), 'PLUM' => array('PLUM', ''), 'EVONIK' => array('EVONIK', ''));


	$i = 0;
	$lmenu_str = '';
	foreach($madeby_arr as $k => $v)
 	{
		$cur_seltd = $k == $GLOBALS['PAGE_BREND']['title_latin'];
		$lmenu_str .= "
					<div class='group-01_0999{$i}" . ($cur_seltd ? ' seltd' : '') . "' data-group='01_0999{$i}'>
						<a href='/madeby/{$k}/' title='Спецодежда и СИЗ {$v[0]}" . ($v[0] =='3M' ? ' (3М - ЗМ)' : '') . "'{$v[1]}>{$v[0]}</a>
					</div>
		";
		$i++;
	}
	
	$name_low = $GLOBALS['PAGE_BREND']['name'] ? get_seo_low(str_replace(' ' . $GLOBALS['PAGE_BREND']['name'], '', $GLOBALS['SCRIPT_SET_DATA_HPTITLE'])) : get_seo_low($GLOBALS['SCRIPT_SET_DATA_HPTITLE']);
	
	return "
		<div id='opt_sales'>
			<b>{$GLOBALS['SCRIPT_SET_DATA_HPTITLE']}</b> от Восток-Сервис это прямые поставки от производителя.<p>Для того, чтобы купить {$name_low} оптом с нашего склада в Санкт-Петербурге, позвоните в <span>отдел оптовых продаж: <b>318-08-05</b></span></p>
		</div>	
		<div id='madeby_menu'>
			{$lmenu_str}
		</div>
	";
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
