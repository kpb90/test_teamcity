<?php
session_start();
include_once "carlsberg_function.php";

if (isset($_REQUEST['logout'])) {
	unset($_SESSION['auto_user']);
		header('Location:/');
} else if (isset($_REQUEST['autoriz_submit'])) {
	if (autorization_user ($_REQUEST['eid'], $_REQUEST['passwd'])) {
		 header('Location:/carlsberg/factories'.$_SESSION['auto_user']['g_latin']);
	} else {
		$GLOBALS['error_auto_form'] = "<div class = 'error'>Не верно введен логин или пароль</div>";
	}
}

function get_auto_form () {
	if ($_SERVER['REQUEST_URI']==='/carlsberg/' && $_SESSION['auto_user']) {
 		header('Location:/carlsberg/factories'.$_SESSION['auto_user']['g_latin']);
	}

	if (strpos($_SERVER['REQUEST_URI'],'/carlsberg/')!==false &&!$_SESSION['auto_user']) {
		return '
		<!--div style="text-align: center; padding: 10px; margin: 10px; color: #00529c; font-size: 15px; line-height: 20px;">
<b style="color: green; font-weight: bold;">Обратите внимание!</b> С 7-го декабря заявки принимаются только на 2016 год.<br/>До конца 2015 года выполняются только заказы поступившие в
работу ранее.<br/>
С наступающим Новым годом!
		</div-->
		<div id="modal_window">
			  <div id="reg_modal_title">ВХОД в CARLSBERG</div>
			  <div id="place_for_insert"></div>
			  <form action="" id="modal_form" method="POST" enctype="multipart/form-data">
				  <table>
					<tbody><tr>
						<td>
							<input type="text" class="span3" name="eid" id="email" placeholder="Логин" required>
						</td>
					</tr>
					<tr>
						<td>
							<input type="password" class="span3" name="passwd" placeholder="Пароль" required>
						</td>
					</tr>
					<tr>
						<td style="text-align:left;" colspan="2">
							<input id="basket_issue_order3" name="autoriz_submit" type="submit" value="Войти" class = "readmore">
						</td>
					</tr>
				  </tbody></table>
				</form>
		</div>';
	}
}

include"./new_admin/importer/translit.php";

//require('admin/paging.php');
function pscript_execute() 
{
	get_cart_without_size();
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
	else if (check_low ()) 
	{

			if(!isset($_SESSION['always_only']))
				$_SESSION['always_only'] = 0;
			if(isset($_POST['always_only']))
				$_SESSION['always_only'] = $_POST['always_only'];
			
			$rtext = '<form id="formalways" name="formalways" method=post style="padding-bottom: 10px;  text-align: right;border-bottom: 1px solid #afafaf; margin: 5px 0 10px;">
					<input value=0 id="always_only" name="always_only" type="hidden">
					<label><input style="vertical-align:-2px;" value=1 id="always_only" name="always_only" onclick="javascript: formalways.submit();" type="checkbox" ' . 
				($_SESSION['always_only'] == 1 ? 'checked' : '') . '>&nbsp;показывать только основной перечень товаров</label>&nbsp;</form>';

			$h1_carlsberg = '';
			$h1_2_carlsberg = '';
			$h1_3_carlsberg = '';
			if($_SESSION['auto_user']['level']==1&&$_SERVER['REQUEST_URI']=='/carlsberg/factories/') {
				$query = "SELECT c.*  from `studio_catalog_carslberg` as c " . ($_SESSION['always_only'] ? 'where c.promo=0 ' : '') . "
						  order by if(pict = 'no_photo.png' or pict = '' or pict is null,1,0), ID ASC limit 100;";
				$h1_carlsberg = "Все товары CARLSBERG";
			} else {
				$url_on_catalog_for_auto_user = get_url_on_catalog_for_auto_user ();
				//var_dump($url_on_catalog_for_auto_user);
				$url_on_factory_for_auto_user = get_url_on_factory_for_auto_user ($url_on_catalog_for_auto_user);
				// Для пользователя первого уровня, если не выбран ни один завод => мы должны получит все товары
				if ($url_on_factory_for_auto_user=='/') {
					// Все заводы 
					$query_for_h1_2 = '';
					$h1_2_carlsberg = 'CARLSBERG';
				} else {
					$query_for_h1_2 = "select f.subgtitle as h1_3, f.gtitle as h1_2  from `cms2_factories_carslberg` as f where f.g2_latin like '{$url_on_factory_for_auto_user}' limit 1;";	
				}
				//var_dump($url_on_factory_for_auto_user);
				$query_for_h1 = "SELECT (CASE WHEN g.g3title NOT LIKE  ''
							 THEN g.g3title
							 WHEN g.g2title NOT LIKE  ''
							 THEN g.g2title
							 WHEN g.g1title NOT LIKE  ''
							 THEN g.g1title
						END) AS h1 from `studio_catalog_groups_carslberg` as g where g3_latin like '{$url_on_catalog_for_auto_user}' limit 1;";
		
				$condition_for_get_code_of_factory = get_condition_for_get_code_of_factory ($url_on_factory_for_auto_user);

				$query_carlsberg_items = "SELECT c.*  from `studio_catalog_carslberg` as c
						  				  where " . ($_SESSION['always_only'] ? 'c.promo=0 and' : '') . " INSTR(title_latin,'{$url_on_catalog_for_auto_user}') > 0 
						  				  		and 
						  				  		{$condition_for_get_code_of_factory}
											order by gid, if(pict = 'no_photo.png' or pict = '' or pict is null,1,0), ID ASC;";
				$query = $query_carlsberg_items.$query_for_h1.$query_for_h1_2;
			}

			if ($GLOBALS['DB_CONNECTION']->multi_query($query))
			{
			   do
			   {
				if ($r = $GLOBALS['DB_CONNECTION']->store_result())
				{
				 while ($row = $r->fetch_assoc())
				 {
				  switch ($num_q)
				  {
				   case 0: 
						$GLOBALS['II_PAGE_PARAMS']['TOVDATA'][] = $row;
				   break;
				   case 1: 
						$h1_carlsberg = $row['h1'];
				   break;
				   case 2: 
						$h1_2_carlsberg = $row['h1_2'];
						$h1_3_carlsberg = $row['h1_3'];
				   break;
				  }
				 }
				 $r->free();
				}
				if ($GLOBALS['DB_CONNECTION']->more_results())
				{
				 $num_q++;
				}
			   }
			   while ($GLOBALS['DB_CONNECTION']->next_result());
			}

	} 
	else 
		$rtext .= "<div>Нет прав доступа для просмотра данной категории</div>";


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
	} else {
		$rtext .= "В данной категории нет товаров";
	}							 


	$GLOBALS['SCRIPT_SET_DATA_TITLE'] = $GLOBALS['SCRIPT_SET_DATA_HPTITLE'] . ($GLOBALS['PAGE_BREND']['name'] =='3M' ? ' (3М - ЗМ)' : '') . 'Низкие цены в интернет-магазине и информация где купить оптом.';

	if($is_tov_page)
	{
		$GLOBALS['PAGE_TOP_BLOCK'] = "<div class='product-pager' style='top: 132px;'>{$GLOBALS['PAGE_TOP_BLOCK']}</div>";
	}
	else
	{
		$GLOBALS['PAGE_TOP_BLOCK'] = "";
		$rtext = $rtext . get_seo_name($GLOBALS['SCRIPT_SET_DATA_HPTITLE']);
	}

	$auto_form = get_auto_form ();
	return '
		<header class="calalog-header">' . $GLOBALS['PAGE_TOP_BLOCK'] . '</header>
		<div class="catalog-block"' .($auto_form ? 'style="padding:20px;"':''). ($is_tov_page ? ' style="margin-top: 58px;"' : '') . '>
		'.($auto_form ? $auto_form : '
            <div class="right">
				' . $rtext . '
			</div>
			<div class="left">
				' . get_product_info_top($first_item) . get_l_menu() . get_madeby_menu() . '
			</div>').'
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
		$branded_block = "\n{$kkey}: " . $row[brend];
		$rname_branded = $row[title] . ', ' .  $row['brend'];
	}
	$url_item = substr($row[title_latin],1);
	$img_txt = $row[pict] ? "<A href='/carlsberg/{$url_item}' title='{$rname_branded}'><IMG SRC='/images/items/small/{$row[pict]}' WIDTH=80  BORDER=0 HSPACE=1 VSPACE=1 alt='$active_keyword, {$rname_branded}' style='padding-bottom: 10px;'></a>" : '&nbsp;';

	$mbylogo = '';
	if($row[img])
		$mbylogo = "<img src='/img/products/middle/{$row[img]}' alt='Логотип {$row[madeby]}' style='position: absolute; top: 0px; right: 30px;'>";

	$but_add_to_basket =  get_button_buy (array('data'=>array('price'=> get_price($row),'id'=>$row['id'])));
	return "
			<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 VALIGN='TOP' width='100%' style='border-bottom: 1px solid #afafaf; position: relative; margin: 5px 0;'>
				<TR><TD VALIGN='TOP' WIDTH=95 style='padding: 4px 10px 0px 0px;'>
					{$img_txt}
					<a class='wrp-rating-dis' href = '/carlsberg_feedback.php?id={$row['id']}'>
						<div class='rating-dis' data-score='{$row['rating']}'>
						</div>
					</a>
				</TD><TD VALIGN='TOP'>
					<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0 VALIGN='TOP' WIDTH='100%'>
						<TR><TD><div class='scaptext' style='margin: 4px 0;'><A href='/carlsberg/{$url_item}' title='{$rname_branded}'>{$row[title]}</a></div>
							<div class='text'>" . $row[text_small] . "</div>
						</TD></TR><TR><td>
							<A href='/carlsberg/{$url_item}' title='{$rname_branded}' class='readmore'>Подробнее</A>
							<div class='pricetext' style='margin-left: 10px;'>" . 
								($row[article] ? "<div class='code'><p>Код по каталогу</p><p>{$row[article]}</p></div>" : '') . "
							</div>
							<div id='product-info'><div class='price currency{$_SESSION['auto_user']['currency']}' style='margin-top: 0;'><span class='current'>".get_price($row)."</span></div>
							<div class='price-notice'>Цена указана без учета НДС</div></div>
							{$but_add_to_basket}
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

		$r = $GLOBALS['DB_CONNECTION']->query("SELECT * from studio_prot_props_carslberg where id in ({$a}) order by id ASC");
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

		$r = $GLOBALS['DB_CONNECTION']->query("SELECT * from studio_techs_carslberg where id in ({$a}) order by id ASC");
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

		$r = $GLOBALS['DB_CONNECTION']->query("SELECT * from studio_advices_carslberg where id in ({$a}) order by id ASC");
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

		$r = $GLOBALS['DB_CONNECTION']->query("SELECT * from studio_extra_props_carslberg where id in ({$a}) order by id ASC");
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

	if(strpos($_SERVER["REQUEST_URI"], '/carlsberg/specobuv/') === 0 || 
	   strpos($_SERVER["REQUEST_URI"], '/carlsberg/zashhita_ruk/') === 0 || 
	   $row['gost'])
	{
		$ginfo = explode(';', $row['gost']);

		if(strpos($_SERVER["REQUEST_URI"], '/carlsberg/specobuv/') === 0)
			$ginfo[0] .= "
				<a  style='text-decoration: underline; float: left;text-transform: none; margin-top: 12px;display: inline-block; width: 280px;' href='/docs/obuv_kcenova.pptx'>Carlsberg обувь ксенова.pptx</a>
				<a  style='text-decoration: underline; float: left;text-transform: none; margin-top: 12px; display: inline-block; width: 280px;' href='/docs/uhod_hranenie.pptx'>Carlsberg обувь уход и хранение.pptx</a>
				<a  style='text-decoration: underline; float: left;text-transform: none; margin-top: 12px; display: inline-block; width: 280px;' href='/docs/how_to.pptx'>Как правильно ухаживать за обувью.pptx</a>
				<a   style='text-decoration: underline; float: left;text-transform: none; margin-top: 12px; display: inline-block; width: 280px;' href='/docs/excel.pptx'>Экель обувь.pptx</a>
				<a   style='text-decoration: underline; float: left;text-transform: none; margin-top: 12px; display: inline-block; width: 560px;' href='/docs/obuv.pptx'>Защитная рабочая обувь PANDA.pptx</a>
				<div style='clear: both;'></div>
			";
		else if(strpos($_SERVER["REQUEST_URI"], '/carlsberg/zashhita_ruk/') === 0)
			$ginfo[0] .= "
				<a   style='text-decoration: underline; float: left;text-transform: none; margin-top: 0px; display: inline-block; width: 560px;' href='/docs/sizruk.pptx'>СИЗ рук для работников Carlsberg - Baltika.pptx</a>
				<a   style='text-decoration: underline; float: left;text-transform: none; margin-top: 12px; display: inline-block; width: 560px;' href='/services/perchatki.pptx'>Инструкция по работе с перчатками, определение размера перчаток.pptx</a>
				<div style='clear: both;'></div>
			";
     
                                                          

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
	        	    <img src='/images/brand/{$row['brend_img']}'>
	        	</div>
		";

$descr_item = $row['descr'] ? "<div class='charact block'>
									<header class='active'>ПОДРОБНОЕ ОПИСАНИЕ<i></i></header>
									<div><div class='about'>
										{$row['descr']}
									</div></div>
								</div><br>":'';

	$infolink = '/razmeri_odezhdi.php';
	$infotitle = 'Таблицы размеров одежды и обуви';

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
				{$row['extra_props']}<br>
				{$descr_item}
				{$row['advices']}
				<clear class=''></clear>
		 	  	" . get_seo_name($row['title']) . show_neighbour_products($row[gid], $row[id]) . "
			</div>
			<clear class='safely'></clear>
		</div>
	";
}

function get_tov_price($row)
{
	$price = get_price ($row);
	if(!$price)
		return '';
	
	if($row['oldprice'])
		$price = "<nobr><del>{$row['oldprice']}</del>&nbsp;&nbsp;<ins>{$price}</ins></nobr>";

	return "<div class='price_div'>Цена:&nbsp;<span>{$price}</span></div>";
}

function get_seo_name($ttle_in)
{
	return '';
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
	$extrawhere = $_SESSION['always_only'] ? ' and promo=0 ' : '';

	$cnt = 0;
	$r = $GLOBALS['DB_CONNECTION']->query("select * from studio_catalog_carslberg where gid='{$gr_id}' {$extrawhere} order by if(pict = 'no_photo.png' or pict = 'no_photo' or pict is null,1,0), id asc");
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
				$GLOBALS['PAGE_TOP_BLOCK'] .= "<a href='/carlsberg" . $item_arr[$i - 1][title_latin] . "'><span>предыдущий</span>товар</a>";
			if($i < $cnt)
				$GLOBALS['PAGE_TOP_BLOCK'] .= "<a href='/carlsberg" . $item_arr[$i + 1][title_latin] . "'><span>следующий</span>товар</a>";	
			continue;
	         }
	         

		$smallimg = '';
		if($item_row[pict] != '')
		{
			//$im_prop = !$cur_item || $img['width'] * 1.3 > $img['height'] ? 'WIDTH=60' : 'height=78';
			$smallimg = "<IMG style = 'width:85px;' SRC='/images/items/small/{$item_row[pict]}' {$im_prop} alt='{$item_row[title]}'>";
		}

		$cor_articul = '';
		if ($item_row[article] != '') 
			$cor_articul = "{$item_row[article]}";
			$cor_price = '';
		if (get_price ($item_row) > 0 && ($cor_price = get_tov_price($item_row)) > 0) 
			$cor_price = "<br>Цена: $cor_price";
		$separ = $cnt++ % 4 ? '' : '<div style="clear: both;"></div>';
		$ret .= "
				<div class='samegrovs'>
					<a href='/carlsberg{$item_row[title_latin]}'>
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
		$scr_text = "<a href='{$first_item['g2_latin']}' style='line-height: 16px; padding-top: 5px; height: 72px; line-height: 62px;'><div style='padding-top: 14px;'>{$first_item['g1title']}</div></a>";
	else if($first_item['tlevel'] == 3)
		$scr_text = "<a href='{$first_item['g3_latin']}' style='line-height: 16px; padding-top: 5px; height: 72px; line-height: 62px;'>{$first_item['g1title']}</a>";


	$gr_code = $first_item['g1title'] == 'Спецодежда' ? 1 : ($first_item['g1title'] == 'Спецобувь' ? 2 : ($first_item['g1title'] == 'Средства защиты' ? 3 : ($first_item['g1title'] == 'Защита рук' ? 4 : 5)));

	$but_add_to_basket =  get_button_buy (array('data'=>array('price'=> get_price($first_item),'id'=>$first_item['id'])));
	if (!$GLOBALS['CATALOG_INFO']['price']) {
		$GLOBALS['CATALOG_INFO']['price'] = 0;
	}
	return "
			<!--<div id='catalog-menu'>
				<ul data-id='0' data-parent='01' class='level0' style='width: 320px;'>
					<li data-group='01_01' class='group-01_0{$gr_code} seltd'>
						{$scr_text}
					</li>
				</ul>
			</div>-->
			<div id='product-info'>
				<div data-id='{$GLOBALS['CATALOG_INFO']['id']}' class='product-view'>
					<header class='curproduct title'>
						<h1>{$GLOBALS['CATALOG_INFO']['title']}</h1>
						<div class='code'>Код по каталогу: <span>{$GLOBALS['CATALOG_INFO']['article']}</span></div>
					</header>
					<div class='price currency{$_SESSION['auto_user']['currency']}'><span class='current'>".get_price($GLOBALS['CATALOG_INFO'])."</span></div>
					<div class='price-notice'>Цена указана без учета НДС</div>
					<a class='wrp-rating-dis' href = '/carlsberg_feedback.php?id={$first_item['id']}'>
						<div class='rating-dis' data-score='{$first_item['rating']}'>
						</div>
						<div style='margin-bottom: 17px;text-align: left;padding-left: 20px;color: #257AC7;  font-family: \"Helvetica\";'>Оценить</div>
					</a>
					{$but_add_to_basket}
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
						{$v[0]}
					</div>
		";
		$i++;
	}
	
	$name_low = $GLOBALS['PAGE_BREND']['name'] ? get_seo_low(str_replace(' ' . $GLOBALS['PAGE_BREND']['name'], '', $GLOBALS['SCRIPT_SET_DATA_HPTITLE'])) : get_seo_low($GLOBALS['SCRIPT_SET_DATA_HPTITLE']);
	return '';
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
