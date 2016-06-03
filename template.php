<?php

$GLOBALS['IS_MAIN_PAGE'] = $_SERVER["REQUEST_URI"] == "/";
$GLOBALS['CARLSBERG_MODE'] = strpos($_SERVER['REQUEST_URI'],'/carlsberg/') !== false;


$PAGE_TEMPLATE = '<!DOCTYPE html>
<!--[if IE 7 ]><html class="ie7"><![endif]-->
<!--[if IE 8 ]><html class="ie8"><![endif]-->
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html xmlns="http://www.w3.org/1999/html"><!--<![endif]-->
<head>
<title>' . ($GLOBALS['IS_MAIN_PAGE'] || $GLOBALS['PAGE_TYPE'] == 'page' ? 'Восток-Сервис Санкт-Петербург #headtitle' : '#headtitle купить в магазине или заказать оптом в Восток-Сервис Санкт-Петербург') . '</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META http-equiv="Content-Language" content="ru">
<META name="keywords" content="#keyw">
<META name="description" content="#desc" >
<link rel="shortcut icon" href="/favicon.ico">

<meta http-equiv="X-Ua-Compatible" content="ie=edge" />

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="robots" content="noyaca" />

<link rel="stylesheet" type="text/css" media="screen" href="/css/reset.css?ver=4" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/fonts.css?ver=4" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/layout.css?ver=7" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/header-line.css?ver=4" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/main-menu.css?ver=4" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/footer.css?ver=4" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/ikSelect.css?ver=4" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/ikSelectOSX.css?ver=4" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/icheck/minimal/blue_vostok.css?ver=4" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/common.css?ver=5" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/elements.css?ver=4" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/slider.css?ver=4" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/catalog-promo.css?v9?ver=4" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/plugins/jquery.jscrollpane.css?ver=4" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/prettyPhoto.css?ver=4" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/catalog-menu.css?ver=4" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/product.css?ver=7" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/news.css?ver=4" />
<link href="http://www.vostok.spb.ru' . $_SERVER["REQUEST_URI"] . '" rel="canonical">
<script type="text/javascript" src="/js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/js/modernizr.custom.js"></script>
<script type="text/javascript" src="/js/adaptive/main.js?ver=2"></script>
<script type="text/javascript" src="/js/jquery/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" src="/js/jquery/jquery.ikSelect.js"></script>
<script type="text/javascript" src="/js/jquery/jquery.icheck.js"></script>
<script type="text/javascript" src="/js/jquery/jquery.mousewheel.js"></script>
<script type="text/javascript" src="/js/jquery/jquery.jscrollpane.min.js"></script>
<script type="text/javascript" src="/js/jquery/jquery.form.js"></script>
<script type="text/javascript" src="/js/jquery/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="/js/elements.js"></script>
<script type="text/javascript" src="/js/scripts.js"></script>
<script type="text/javascript" src="/js/compareblock.js"></script>
<script type="text/javascript" src="/js/raty.js"></script>
<script type="text/javascript" src="/js/cart.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="/css/cart.css?ver=7" />
<link rel="stylesheet" href="/js/jquery.fancybox-1.3.4.css" type="text/css" media="all" />
<script type="text/javascript" src="/js/jquery.fancybox-1.3.4.pack.js"></script>
<meta name=\'yandex-verification\' content=\'43669c102fc3ce8b\' />
</head>

<body class="body_container">

<div id="fb-root"></div>

<div id="compare-slide-block" class="dn">
	<div id="compare-slide-button">
		<a href="http://sankt-peterburg.vostok.ru/compare/">Сравнить</a>
	</div>
</div>

<div id="layout"' . get_bkg_img() . '>
	<header id="header">
		'.get_header_line().'
		'.get_top_grey_menu ().'
	</header>
	<section id="content">
		<div class="layout-limiter">
			' . get_p_content() . '	
		</div>
	</section>
</div>
<clear class=""></clear>
<footer id="footer">
	<div class="layout-limiter">

		<div class="footer-copyright">
			<div class="footer-site">© ' . Date('Y') . ' Группа компаний «Восток-Сервис»</div>
			<div class="kinetica-copyright">
				<a href="http://intraseti.ru/">Сопровождение сайта<span>Интрасети</span></a>
			</div>
		</div>

	</div>

</footer>

<script>
	$(function(){
		$(window).trigger("resize");
	});
</script>

<noindex>
<!--begin of Top100 logo-->
<a href="http://top100.rambler.ru/top100/">
<img src="http://top100-images.rambler.ru/top100/banner-88x31-rambler-blue.gif" alt="Rambler\'s Top100" width=88 height=31 border=0></a>
<!--end of Top100 logo -->
<!--begin of Rambler\'s Top100 code -->
<a href="http://top100.rambler.ru/top100/">
<img src="http://counter.rambler.ru/top100.cnt?1260298" alt="" width=1 height=1 border=0></a>
<!--end of Top100 code-->
<!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href=\'http://www.liveinternet.ru/click\' "+
"target=_blank><img src=\'http://counter.yadro.ru/hit?t45.1;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"\' alt=\'\' title=\'LiveInternet\' "+
"border=0 width=31 height=31><\/a>")//--></script><!--/LiveInternet-->
'.($GLOBALS['CARLSBERG_MODE'] ? '' : '
<script type="text/javascript"><!-- /* build:::5 */ -->
	var liveTex = true,
		liveTexID = 33032,
		liveTex_object = true;
	(function() {
		var lt = document.createElement(\'script\');
		lt.type =\'text/javascript\';
		lt.async = true;
		lt.src = \'http://cs15.livetex.ru/js/client.js\';
		var sc = document.getElementsByTagName(\'script\')[0];
		sc.parentNode.insertBefore(lt, sc);
	})();
</script>').'

<!-- Yandex.Metrika informer -->
<a href="http://metrika.yandex.ru/stat/?id=22471051&amp;from=informer"
target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/22471051/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" onclick="try{Ya.Metrika.informer({i:this,id:22471051,lang:\'ru\'});return false}catch(e){}"/></a>
<!-- /Yandex.Metrika informer -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter22471051 = new Ya.Metrika({id:22471051,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/22471051" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<script>
(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new
Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a
,m)
})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');
  ga(\'create\', \'UA-68161356-1\', \'auto\');
  ga(\'require\', \'displayfeatures\');
  ga(\'send\', \'pageview\');
</script>

</noindex>

</body>
</html>
';

function get_factories () {
	if ($_SESSION['auto_user']['level']==3) 
	{
		$url_factory = explode('/',$_SESSION['auto_user']['g_latin']);
		$url_factory = '/'.$url_factory[1].'/';
	} 
	else  
	{
		$url_factory =$_SESSION['auto_user']['g_latin'];
	} 

	$query_factory = "SELECT `id`, `code`, `gtitle`, `subgtitle`, `g1_latin`, `g2_latin`, `level`, `nested`, `breadcrumbs` 
			  FROM `cms2_factories_carslberg` 
			  WHERE g1_latin like '{$url_factory}%' and level = 1;";

	$query_department = '';
	$all_factories = false;
	if ($_SERVER['REQUEST_URI'] == '/carlsberg/factories/'
		||
		($_SESSION['auto_user']['level']==1&&strpos($_SERVER['REQUEST_URI'],'/carlsberg/factories/')===false)) 
	{
		$all_factories = true;
	} else {
		if ($_SESSION['auto_user']['level']==1) {
			$url_factory = explode('/',$_SERVER['REQUEST_URI']);
			$url_factory = '/'.$url_factory[3].'/';
		}	
		$query_department = "SELECT `id`, `code`, `gtitle`, `subgtitle`, `g1_latin`, `g2_latin`, `level`, `nested`, `breadcrumbs` 
					  FROM `cms2_factories_carslberg` 
					  WHERE g1_latin like '{$url_factory}%' and g2_latin like '{$_SESSION['auto_user']['g_latin']}%' and level = 2";	
	}
	//echo '!'.$query_factory.'!';
	
	$data_factory = array ();
	$data_department = array ();
	$query = $query_factory.$query_department;
	
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
				$data_factory[]=$row;
		   break;
		   case 1: 
				$data_department[]=$row;
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

	$select_factories = '';
	$ret_factories = '';

	if (count($data_factory)==1) {
		$row = $data_factory[0];
		if($_SESSION['auto_user']['level']==3) {
			$select_factories = "<span>{$row['gtitle']}</span>";	
		} else {
			$select_factories = "<a href='/carlsberg/factories{$row['g1_latin']}'>{$row['gtitle']}</a>";	
		}
	}
	foreach ($data_factory as $row) {
		if (!$select_factories&&($all_factories==false&&strpos($_SERVER['REQUEST_URI'],$row['g1_latin'])!==false)){
			$select_factories = "<a href='/carlsberg/factories{$row['g1_latin']}'>{$row['gtitle']}</a>";	
		} else {
			$ret_factories .= "<li><a href='/carlsberg/factories{$row['g1_latin']}'>{$row['gtitle']}</a></li>";	
		}
	}

	$ret_department = "";
	$select_department = '';

	if (count($data_department)==1) {
		$row = $data_department[0];
		$select_department = "<a href='/carlsberg/factories{$row['g2_latin']}'>{$row['subgtitle']}</a>";	
	}

	foreach ($data_department as $row) {
		if(!$select_department&&strpos($_SERVER['REQUEST_URI'],$row['g2_latin'])!==false) {
				$select_department = "<a href='/carlsberg/factories{$row['g2_latin']}'>{$row['subgtitle']}</a>";	
			} else {
				$ret_department .= "<li><a href='/carlsberg/factories{$row['g2_latin']}'>{$row['subgtitle']}</a></li>";
			}
	}

	if (!$select_department) {
		$select_department = "<a href='javascript:;'>Выберите цех</a>";		
	} 
	if (!$select_factories) {
		$select_factories = "<a href='javascript:;'>Выберите завод</a>";	
	}
	
	return array('factories'=>$ret_factories, 'select_factories' => $select_factories,  'department' => $ret_department, 'select_department' => $select_department);
}

function get_top_grey_menu () 
{
	if ($GLOBALS['CARLSBERG_MODE'] && $_SESSION['auto_user']['type']=='carlsberg') 
	{
		$factories = get_factories ();
		return '<nav id="carlsberg_menu" class = "carlsberg">
				<div class="menu">
						<div class="layout-limiter">
							<ul class="level0">
								<li class = "spec_after">
									'.$factories['select_factories'].'
									<ul class="level1">
										'.$factories['factories'].'
									</ul>
								</li>
								<li>
									'.$factories['select_department'].'
									<ul class="level1">
										'.$factories['department'].'
									</ul>
								</li>
								<!--li>
									<a href="/carlsberg/normi.html">НОРМЫ СО И СИЗ компании</a>
								</li-->
								<li class = "wh">
									<a class = "header-cart-carlsberg" href="/carlsberg/zakaz_i_dostavka.html">Корзина<span>'.intval($GLOBALS['common_count_carlsberg']).'</span></a>
								</li>
								<li>
									<a href="/carlsberg/instrukciya.html">Помощь</a>
								</li>
								<li>
									<a href="/carlsberg/contact.html">Контакты</a>
								</li>
								<li>
									<form method="post" action="/carlsberg_catalog_src.php" name="logout_form">
									'.($_SESSION['auto_user']['name'] ? "<div class = 'name_autoriz'>{$_SESSION['auto_user']['name']}</div>" : '').'
										<button class="logout" type = "submit" name = "logout">выход</button>
						 			</form>
								</li>
							</ul>
						</div>
				</div>
				<div class="submenu">
					<div class="layout-limiter"></div>
				</div>
			</nav>
		';
	}

	return '
	<nav id="menu">
		<div class="menu">
						<div class="layout-limiter">
							<ul class="level0">
								<li>
									<a href="http://sankt-peterburg.vostok.ru/about/">О компании</a>
									<ul class="level1">
										<li><a href="http://sankt-peterburg.vostok.ru/inworld/">Восток-сервис в мире</a></li>
										<li><a href="/novosti/">Новости</a></li>
										<li><a href="http://sankt-peterburg.vostok.ru/smi-o-nas/">СМИ о нас</a></li>
										<li><a href="http://sankt-peterburg.vostok.ru/mission/">Миссия</a></li>
										<li><a href="http://sankt-peterburg.vostok.ru/awards/">Награды и достижения</a></li>
										<li><a href="http://sankt-peterburg.vostok.ru/production/">Производство</a></li>
										<li><a href="http://sankt-peterburg.vostok.ru/partners/">Партнеры</a></li>
										<li><a href="http://sankt-peterburg.vostok.ru/brands/">Наши бренды</a></li>
										<li>
											<a href="http://sankt-peterburg.vostok.ru/career/">Карьера</a>
											<ul class="level2">
												<li><a href="http://sankt-peterburg.vostok.ru/career_politics/">Кадровая политика</a></li>
												<li><a href="http://sankt-peterburg.vostok.ru/codex/">Кодекс бизнес-этики</a></li>
												<li><a href="http://sankt-peterburg.vostok.ru/vacancy/">Вакансии</a></li>
											</ul>
										</li>
									</ul>
								</li>
								<li>
									<a href="/services/services.php">Услуги</a>
									<ul class="level1">
										<li><a href="/services/logo.php">Изготовление и нанесение логотипов</a></li>
										<li><a href="/services/cloth-ord.php">Пошив спецодежды на заказ</a></li>
										<li><a href="/services/corporate.php">Разработка корпоративного стиля</a></li>
										<li><a href="/dostavka.php">Доставка</a></li>
									</ul>
								</li>
								<li><a href="/speccena.php">Акции</a></li>
								<li><a href="/tradedep.php">Отдел оптовых продаж</a></li>
								<li>
									<a href="/coords_store.php">Магазины «Cпецодежда»</a>
									<ul class="level1">
										<li><a href="/shops/obvodny_kanal.php">м. Пушкинская</a><i></i></nobr></li>
										<li><a href="/shops/veteranov.php">м. Проспект Ветеранов</a></li>
										<li><a href="/shops/ozerki.php">м. Озерки</a></li>
										<li><a href="/shops/vaska.php">м. Василеостровская</a></li>
										<li><a href="/shops/akademka.php">м. Академическая</a></li>
										<li><a href="/shops/narvskaja.php">м. Нарвская</a></li>
										<li><a href="/shops/elizarovskaja.php">м. Елизаровская</a></li>
										<li><a href="/shops/ligovka.php">м. Лиговский проспект</a></li>
										<li><a href="/shops/savushkina.php">м. Старая деревня</a></li>
										<li><a href="/shops/elektrosila.php">м. Электросила</a></li><br />
										<li><a href="/shops/kolpino.php">г. Колпино</a></li>
										<li><a href="/shops/pskov.php">г. Псков</a></li>
										<li><nobr><span style="float: left; color: yellow; border: 1px solid yellow; line-height: 15px; padding: 0px 3px; font-size: 9px; margin: 11px 5px 0px 0px;">новый</span><a href="/shops/velikij_novgorod.php">г. Великий Новгород</a><i></i></nobr></li>
									</ul>
								</li>
								<li><a href="/katalogi_i_buklety.php">Каталоги и буклеты</a></li>
								<li><a href="/coords.php">Контакты</a></li>
							</ul>
						</div>
					</div>
					<div class="submenu">
				<div class="layout-limiter"></div>
			</div>
		</nav>';
}

function get_header_line () 
{
	if (!$GLOBALS['CARLSBERG_MODE'] || $_SERVER['REQUEST_URI'] == '/carlsberg/') 
	{
		return 
	'
			<div class="header-line">
				<div class="layout-limiter">
					<div class="header-cart"><a href="/gendir.php">Написать директору</a></div>
					<div class="header-cart"><a href="http://sankt-peterburg.vostok.ru/cart/">Корзина<span>0</span></a></div>
					<div class="header-userbox" id="header-userbox">
						<a class="logout dn" href="/"><img src="/images/layout/ico_logout.png"></a>
						<ul>
							<li class = "hard_code_append" style = "position:relative;">
								<a href="javascript:;" class="enter_vostok">Войти</a>
								<div class = "hard_code_append_child">
									<a href="/" class="">Войти в Восток-Сервис </a>
	                               <a href="'.($_SESSION['auto_user']['g_latin'] ? ($_SESSION['auto_user']['g_latin']=='/' ? '/carlsberg/factories/' : '/carlsberg/factories'.$_SESSION['auto_user']['g_latin']) : '/carlsberg/').'" class="">Войти в CARLSBERG</a>
	                            </div>
							</li>
						</ul>
					</div>
					
					<!--div class="header-langs">
						<a href="/" class="active">RU</a>
						<a href="http://en.vostok.ru">EN</a>
					</div-->

					<div class="header-region">
						<a href="http://sankt-peterburg.vostok.ru/inworld/"><span>Санкт-Петербург</span></a>
					</div>
				
					<div class="header-phone">+7 (812) 318–05–50</div>
					<div class="header-search" id="header-search">
						<a href="/#"></a>
						<div class="header-search-box">
							<div class="choose">
								Поиск <i data-type="catalog">по каталогу</i> / <i data-type="site">по сайту</i>
							</div>
							<form action="http://sankt-peterburg.vostok.ru/search/">
								<input type="text" name="query">
								<div class="notice">
									<span data-type="catalog">введите наименование, или код по каталогу (более 3 символов)</span>
									<span data-type="site">введите поисковый запрос (более 3 символов)</span>
								</div>
								<button type="submit">Искать</button>
							</form>
						</div>
					</div>
				</div>
			</div>';
	}
}
function get_bkg_img()
{	
	if($GLOBALS['IS_MAIN_PAGE'])
		return '';
	else if($GLOBALS['PAGE_TYPE'] == 'page')
		return " style='background: url(/images/layout/bkg/logo-backgound.jpg) no-repeat center 80px;'";
		//''return '';
		//logo-backgound.jpg
	return " style='background: url(/images/layout/bkg/" . ($GLOBALS['CATALOG_INFO'] ? substr($GLOBALS['CATALOG_INFO']['g1_latin'], 1, -1) : 'default') . ".jpg) no-repeat center 80px;'";
}

function get_p_content()
{
	if($GLOBALS['IS_MAIN_PAGE'])
	{
		$GLOBALS['PAGE_IN_DB']['content'] = str_replace('#NEWS_ACTIONS#', '<div class="catalog-menu-slider news-actions-slider">' . get_news() . get_2_slider() . '</div><clear></clear>', $GLOBALS['PAGE_IN_DB']['content']);

		return '
			<div id="catalog-promo">
				<div id="logo" class="logopic"><a href="/"><img src="/images/layout/logo.png" border=0/></a></div>
			</div>
			<div class="catalog-menu-slider main-top-slider">
				' . get_l_menu() . get_1_slider() . '
			</div>
			<clear></clear>
			#content
		';
	}
	else if($GLOBALS['PAGE_TYPE'] == 'page' && $_SERVER['REQUEST_URI'] != '/katalogi_i_buklety.php')
	{   
                $this_is_news_page = $GLOBALS['PAGE_IN_DB']['page_type']==='script'&&$GLOBALS['PAGE_IN_DB']['outer_script']==='new_src';
                $catalog_block = $this_is_news_page === false ? '<div class="left">
                                                                     ' . get_l_menu() . '
                                                                </div>
                                                                <div class="right' . ($_SERVER["REQUEST_URI"] == '/coords_store.php' ? ' simplepage' : ' stpage') . '">
                                                                        #content
                                                                </div>
                                                                <clear></clear>':'#content';
		return '
			<div id="logo" class="logopic"><a href="/"><img src="/images/layout/logo.png" border=0/></a></div>
			<div class="breadcrumbs catalog">
	  			' . $scr_text . '
			</div>
			<header class="calalog-header">#title</header>
			<div class="catalog-block">
				'.$catalog_block.'
			</div>
		';
	}
	else
	{
		return '
			<div id="logo" class="logopic">' . 
				($GLOBALS['CARLSBERG_MODE'] ? '<a href="/" id="vostoklogo"><img src="/images/layout/logo.png" border=0/></a><a href="http://carlsberggroup.com" id="carlsberglogo" target="_blank"><img src="/carlsberg/carlsberglogo.png" border=0/></a>' : '<a href="/"><img src="/images/layout/logo.png" border=0/></a>') . '
			</div>
			#content
		';
	}
}

function get_news() 
{
	$news_str = '';
	$tnews = afetchrowset(mysql_query("select news.id, news.date, news.text_small from news where main=1 and news.archive=0 and news.add2archive=0 order by news.date desc, news.id desc limit 3"));
	foreach($tnews as $row)
 	{
		if (strlen($row[text_small]) > 264)
			$row[text_small] = str_replace('Внимание', '<b>Внимание</b>', smarty_modifier_mb_truncate ($news_items['text_small'], 264,'...'));
		$date = new DateTime($row['date']);
		$timestamp = $date->getTimestamp();
		$date = rus_date('j F Y', $timestamp);
		$news_str .= "
			<div class='news_block' style='margin: 0; clear: both;'>
                            <a  href='/novosti/?id={$row['id']}' style = 'display:block;text-decoration:none;'>
				<span style='color: #898989;'>{$date} г.</span><br>
                                {$row['text_small']} <span style='display: block; color: #ff6f02;text-decoration:underline;'>Подробнее</span>
                            </a>
			</div>
		";
	}

	return '
				<div id="news-block">
					<a href="/novosti/">Новости</a>
					' . $news_str . '
				</div>	
	';
}

function get_l_menu() 
{
	if ($GLOBALS['CARLSBERG_MODE']) 
	{
		include_once "carlsberg_function.php";
		return get_l_menu_carlsberg ();
	} 
	else 
	{
		$extrawhere = $GLOBALS['PAGE_TYPE'] == 'page' || $GLOBALS['PAGE_TYPE'] == 'tovar' ? 'tlevel=1' : '1'; 	
	}

	$cat_enties = afetchrowset(mysql_query("SELECT * from studio_catalog_groups where $extrawhere order by id ASC"));
	$cur_seltd = $cur2_seltd = $cur3_seltd = FALSE;
	$i = 1;
	$lmenu_str = '';
	$ir = array(0,1,2,3,5,4,5);
	foreach($cat_enties as $row)
 	{
		if($row['tlevel'] == 1)
		{
			$cur_seltd = $GLOBALS['PAGE_TYPE'] != 'tovar' && $row['g1title'] == $GLOBALS['CATALOG_INFO']['g1title'];
			$lmenu_str .= '
						<li class="group-01_0' . $ir[$i] . ($cur_seltd ? ' seltd' : '') .'" data-group="01_0' . $ir[$i] . '">
							<a href="' . $row['g1_latin'] . '" title="' . $row['g1title'] . ' - товары с ценами и адреса магазинов">' . $row['g1title'] . '</a>
						</li>
			';
			$i++;
		}
		else if($cur_seltd)
		{
			if($row['tlevel'] == 2)
			{
				$cur2_seltd = $row['g2title'] == $GLOBALS['CATALOG_INFO']['g2title'];
				$lmenu_str .= '
						<li class="lmenu_lev2' . ' seltd' . ($ir[$i] - 1) .  ($cur2_seltd ? ' seltd' : '') . '">
							<a href="' . $row['g2_latin'] . '" title="' . $row['g2title'] . ' - информация где купить и цены">' . $row['g2title'] . '</a>
						</li>
				';
			}
			else if($cur2_seltd && $row['tlevel'] == 3)
			{
				$cur3_seltd = $row['g3title'] == $GLOBALS['CATALOG_INFO']['g3title'];
				$lmenu_str .= '
						<li class="lmenu_lev3' . ' seltd' . ($ir[$i] - 1) . ($cur3_seltd ? ' seltd' : '') . '">
							<a href="' . $row['g3_latin'] . '"' . (strlen($row['g3title']) > 40 ? ' style="line-height: 15px;"' : '') . ' title="' . $row['g3title'] . ' - цены и режим работы магазинов">' . $row['g3title'] . '</a>
						</li>
				';
			}
		}
	}

	return '
				<div id="catalog-menu">
					<ul class="level0" data-parent="01" data-id="0">
						' . $lmenu_str . '
					</ul>
				</div>	
	';
}

function get_1_slider() 
{
	$sliders_str = '';
	$tsliders = afetchrowset(mysql_query("select * from actions where onmain=1 and active=0 and type=1 order by id desc limit 5"));
	foreach($tsliders as $row)
 	{
		$sliders_str .= "
					<div>
						<a href='{$row['url']}'>
							<div class='image'>
								 <img src='{$row['logo']}'>
							</div>
							<div class='content'>
								<div class='content-wrapper'>
									<div class='content-limiter'>
										<div class='title'>{$row['name']}</div>
										<div class='description'>{$row['descr']}</div>
									</div>
								</div>
							</div>
						</a>
					</div>
		";
	}


	return '
				<div class="slider_container slider slider-outer slider-catalog-banner" data-cols="{1000:1, 768:1, 600:1, 480:1}">
					' . $sliders_str . '
				</div>
	';
}

function get_2_slider() 
{
	$sliders_str = '';
	$tsliders = afetchrowset(mysql_query("select * from actions where onmain=1 and active=0 and type<>1 order by id desc limit 5"));
	foreach($tsliders as $row)
 	{
		$sliders_str .= "
					<div>
						<a href='{$row['url']}'>
							<div class='image'>
								 <img src='{$row['logo']}'>
							</div>
							<div class='content'>
								<div class='content-wrapper'>
									<div class='content-limiter'>
										<div class='type'>" . ($row['type'] == 2 ? 'Акция' : ($row['type'] == 3 ? 'Новинка' : '')) . "</div>
										<div class='title'>{$row['name']}</div>
										<div class='description'>{$row['descr']}</div>
									</div>
								</div>
							</div>
						</a>
					</div>
		";
	}


	return '
				<div class="slider_container slider slider-outer slider-catalog-banner" data-cols="{1000:2, 768:1, 600:2, 480:1}">
					' . $sliders_str . '
				</div>
	';
}

?>