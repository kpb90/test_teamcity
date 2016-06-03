<?php

$GLOBALS['IS_MAIN_PAGE'] = $_SERVER["REQUEST_URI"] == "/";

$PAGE_TEMPLATE = '<!DOCTYPE html>
<!--[if IE 7 ]><html class="ie7"><![endif]-->
<!--[if IE 8 ]><html class="ie8"><![endif]-->
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html xmlns="http://www.w3.org/1999/html"><!--<![endif]-->
<head>
<title>#headtitle - Vodopoint.ru</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META http-equiv="Content-Language" content="ru">
<META name="keywords" content="#keyw">
<META name="description" content="#desc" >
<link rel="shortcut icon" href="/favicon.ico">

<meta http-equiv="X-Ua-Compatible" content="ie=edge" />

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="robots" content="noyaca" />

<link rel="stylesheet" type="text/css" media="screen" href="/css/reset.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/fonts.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/layout.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/header-line.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/main-menu.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/footer.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/ikSelect.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/ikSelectOSX.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/icheck/minimal/blue_vostok.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/common.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/elements.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/slider.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/catalog-promo.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/plugins/jquery.jscrollpane.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/prettyPhoto.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/compareblock.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/catalog-menu.css" />

<script type="text/javascript" src="/js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/js/modernizr.custom.js"></script>
<script type="text/javascript" src="/js/adaptive/main.js"></script>
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

</head>

<body class="body_container">

<div id="fb-root"></div>

<div id="compare-slide-block" class="dn">
	<div id="compare-slide-button">
		<a href="http://sankt-peterburg.vostok.ru/compare/">Сравнить</a>
	</div>
</div>

<div id="layout" >
	<header id="header">
		<div class="header-line">
			<div class="layout-limiter">
				<div class="header-cart"><a href="/cart/index.html">Корзина<span>0</span></a></div>
				<div class="header-userbox" id="header-userbox">
					<a class="logout dn" href="/"><img src="/images/layout/ico_logout.png"></a><a href="/" class="">Войти</a>
				</div>
				
				<div class="header-langs">
					<a href="http://vostok.ru" class="active">RU</a>
					<a href="http://en.vostok.ru">EN</a>
				</div>

				<div class="header-region" id="choose-region">
					<a href="/#"><span>Санкт-Петербург</span></a>
					<div class="header-region-choose">
						<ul class="sections">
							<li class="active" data-country="1">Россия</li>
							<li data-country="2">СНГ</li>
							<li class="disabled">Европа</li>
							<li class="disabled">Азия</li>
						</ul>
						<ul class="regions">
						</ul>
						<a class="map" href="/inworld/index.html"><img src="/images/layout/region-choose-map.png" alt="Восток-Сервис в мире"></a>
						<div id="map-vostok-inworld-title"><a class="" href="/inworld/index.html"><i></i> Восток-Сервис<br>в мире</a></div>
					</div>
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
		</div>

		<nav id="menu">
			<div class="menu">
				<div class="layout-limiter">
					<ul class="level0">
						<li>
							<a href="/about/index.html">О компании</a>
							<ul class="level1">
								<li><a href="/inworld/index.html">Восток-сервис в мире</a></li>
								<li><a href="/mission/index.html">Миссия</a></li>
								<li><a href="/awards/index.html">Награды и достижения</a></li>
								<li><a href="/production/index.html">Производство</a></li>
								<li><a href="/partners/index.html">Партнеры</a></li>
								<li><a href="/brands/index.html">Наши бренды</a></li>
								<li>
									<a href="/career/index.html">Карьера</a>
									<ul class="level2">
										<li><a href="/career_politics/index.html">Кадровая политика</a></li>
										<li><a href="/codex/index.html">Кодекс бизнес-этики</a></li>
										<li><a href="/vacancy/index.html">Вакансии</a></li>
									</ul>
								</li>
							</ul>
						</li>
						<li>
							<a href="/novosti/index.html">Пресс-центр</a>
							<ul class="level1">
								<li><a href="/novosti/index.html">Новости</a></li>
								<li><a href="/smi-o-nas/index.html">СМИ о нас</a></li>
							</ul>
						</li>
						<li><a href="/catalog/index.html">Каталог</a></li>
						<li><a href="/services/index.html">Услуги</a></li>
						<li>
							<a href="/stock/index.html">Акции</a>
							<ul class="level1">
								<li><a href="/novelty/index.html">Новинки</a></li>
								<li><a href="/stock/index.html">Акции</a></li>
							</ul>
						</li>
						<li>
							<a href="/customers/index.html">Клиентам</a>
							<ul class="level1">
								<li><a href="/vostok-rf/index.html">Региональное управление</a></li>
								<li><a href="/vostok-sng/index.html">Отдел сбыта в странах СНГ</a></li>
								<li><a href="/catalog-gazprom/index.html">Каталог «Газпром - 2014»</a></li>
								<li><a href="/customers/tehnologii/index.html">Технологии и материалы</a></li>
								<li>
									<a href="/poleznaya-informacia/index.html">Полезная информация</a>
									<ul class="level2">
										<li><a href="/pravila-uhoda/index.html">Правила ухода за спецодеждой</a></li>
										<li><a href="/tablica-razmerov/index.html">Таблица соответствий размерных рядов</a></li>
										<li><a href="/simvoli-po-uhodu/index.html">Символы по уходу</a></li>
										<li><a href="/piktogrammi-zashiti/index.html">Пиктограммы защиты</a></li>
										<li><a href="/pravila_obuv/index.html">Правила ухода за обувью</a></li>
										<li><a href="/rules/index.html">Правила сайта</a></li>
									</ul>
								</li>
								<li><a href="/obmen-i-vozvrat/index.html">Обмен и возврат</a></li>
							</ul>
						</li>
						<li><a href="/contacts/index.html">Контакты</a></li>
					</ul>
				</div>
			</div>
			<div class="submenu">
				<div class="layout-limiter"></div>
			</div>
		</nav>
	</header>
	<div id="logo" class="logopic"><a href="/"></a></div>

	<section id="content">
		<div class="layout-limiter">
			' . get_p_content() . '	
		</div>
	</section>
</div>
<footer id="footer">
	<div class="layout-limiter">
		<div class="footer-line">
			<div class="footer-menu-main menublock">
				<ul>
					<li><a href="/catalog/index.html">Каталог</a></li>
					<li><a href="/about/index.html">О компании</a></li>
					<li><a href="/customers/index.html">Клиентам</a></li>
					<li><a href="/novosti/index.html">Пресс-центр</a></li>
					<li><a href="/services/index.html">Услуги</a></li>
					<li><a href="/contacts/index.html">Контакты</a></li>
					<li><a href="/stock/index.html">Акции</a></li>
					<li><a href="/rules/index.html" class="footer-page-rules">Правила сайта</a></li>
				</ul>
			</div>
                	<div class="footer-menu-corporate">
				<h3>Корпоративным клиентам</h3>
				<ul>
					<li><a href="/services/4/index.html">Специальный заказ</a></li>
					<li><a href="/services/6/index.html">Нанесение логотипа</a></li>
					<li><a href="http://sankt-peterburg.vostok.ru/services/8/">Аренда спецодежды</a></li>
					<li><a href="/poleznaya-informacia/index.html">Полезная информация</a></li>
				</ul>
			</div>

			<div class="footer-menu-private">
				<h3>Частным клиентам</h3>
				<ul>
					<li><a href="/contacts/index.html">Адреса магазинов</a></li>
					<li><a href="/services/7/index.html">Доставка</a></li>
					<li><a href="/pravila-uhoda/index.html">Правила ухода за СО</a></li>
				</ul>
			</div>

			<div class="footer-actions actions">
				<ul>
					<li class="footer-actions-mail"><a href="/#pretty-block-form-write-letter" rel="prettyForm">Написать письмо</a></li>
					<li class="footer-actions-phone"><a href="/#pretty-block-form-request-call" rel="prettyForm">Заказать звонок</a></li>
				</ul>
			</div>
		</div>

		<div class="footer-copyright">
			<div class="footer-site">© 2014 Группа компаний «Восток-Сервис»</div>
			<div class="creative-people">
				<a href="http://cpeople.ru/">Дизайн сайта<span>CreativePeople</span></a>
			</div>
			<div class="kinetica-copyright">
				<a href="http://kinetica.su/">Разработка сайта<span>Kinetica</span></a>
			</div>
		</div>

	</div>

</footer>

<script>
	$(function(){
		$(window).trigger("resize");
	});
</script>

</body>
</html>
';

function get_p_content()
{
	if($GLOBALS['IS_MAIN_PAGE'])
	{
		$GLOBALS['PAGE_IN_DB']['content'] = strreplace('#NEWS_ACTIONS#', '<div class="catalog-menu-slider">' . get_news() . get_2_slider() . '</div>', $GLOBALS['PAGE_IN_DB']['content']);

		return '
			<div id="catalog-promo">
				<div class="container">
					<div class="item">
						<div style="background-image: url(/images/layout/center_bkg.png); height: 471px;" class="mask"><i></i></div>
					</div>
				</div>
			</div>
			<i class="catalog-promo-limiter"></i>
			<i class="catalog-promo-scroller"></i>
			<div class="catalog-menu-slider">
				' . get_l_menu() . '
       	                        ' . get_1_slider() . '
			</div>
			#content
		';
	}
	else
	{
		return '
			<div class="breadcrumbs catalog">
    				<a href="/">Главная</a> → <a href="/catalog/">Каталог</a> → <a href="#">Спецодежда</a> → <a href="/catalog/odezhda/zaschita-ot-obschih-proizvodstvennyh-zagryazneniy/">Защита от общих производственных загрязнений</a>
			</div>
			<header class="calalog-header ">
				<h1>Защита от общих производственных загрязнений</h1>
			</header>
			<div class="catalog-expand-button"><div>Подбор по фильтрам</div></div>
			<div class="catalog-block">
				<div class="left">
					' . get_l_menu() . '
				</div>
				<div class="right">
					#content
				</div>
				<clear></clear>
			</div>
		';
	}
}

function get_l_menu() 
{
	return '
				<div id="catalog-menu">
					<ul class="level0" data-parent="01" data-id="0">
						<li class="group-01_01" data-group="01_01">
							<a href="/#odezhda">Спецодежда</a>
						</li>
						<li class="group-01_02" data-group="01_02">
							<a href="/#obuv">Спецобувь</a>
						</li>
						<li class="group-01_03" data-group="01_03">
							<a href="/#sredstva-zaschity">Средства защиты</a>
						</li>
						<li class="group-01_05" data-group="01_05">
							<a href="/#zaschita-ruk">Защита рук</a>
						</li>
						<li class="group-01_04" data-group="01_04">
							<a href="/#drugoe">Другое</a>
						</li>
					</ul>
				</div>	
	';
}

function get_1_slider() 
{
	return '
				<div class="slider_container slider slider-outer slider-catalog-banner" data-cols="{1000:2, 768:1, 600:2, 480:1}">
					<div>
						<a href="/../shop.vostok.ru/stock/452/index.html">
							<div class="image">
								 <img src="/uploads/global/images/banner/280x155_th3f1a3c21/f1209ab4bd2f20d1dc6dc4d2ebd68f007c3481e4.jpg@1398859317">
							</div>
							<div class="content">
								<div class="content-wrapper">
									<div class="content-limiter">
										<div class="type">Акция</div>
										<div class="title">Снижение цены на футболки КВАНТ: акция продлена!</div>
										<div class="description">С 1 мая по 31 августа на сигнальные футболки КВАНТ скидка — 30%!</div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div>
						<a href="/../i-vs.vostok.ru/stock/542/index.html">
							<div class="image">
								 <img src="/uploads/global/images/banner/280x155_th3f1a3c21/7bf2baf6ab3a130642e715601b6cfcde4c589ecf.jpg@1405415675">
							</div>
							<div class="content">
								<div class="content-wrapper">
									<div class="content-limiter">
										<div class="type">Акция</div>
										<div class="title">Готовься к осени</div>
										<div class="description">С 15 июля по 31 августа, приобретая сандалии в магазинах «Восток-Сервис», вы получите скидку 10% при покупке обуви в сентябре-октябре.</div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div>
						<a href="/../shop.vostok.ru/novosti/557/index.html">
							<div class="image">
								 <img src="/uploads/global/images/banner/280x155_th3f1a3c21/0bd9089d110896e76d3792c5563ddbd8becacc0c.jpg@1406836803">
							</div>
							<div class="content">
								<div class="content-wrapper">
									<div class="content-limiter">
										<div class="type">Новинка</div>
										<div class="title">Защита от клещей</div>
										<div class="description">Группа компаний «Восток-Сервис» представляет новинку — костюм противоэнцефалитный ЭКСПЕДИЦИЯ.</div>
									</div>
								</div>
							</div>
						</a>
					</div>
				</div>
	';
}

function get_2_slider() 
{
	return '
				<div class="slider_container slider slider-outer slider-catalog-banner" data-cols="{1000:2, 768:1, 600:2, 480:1}">
					<div>
						<a href="/../shop.vostok.ru/stock/452/index.html">
							<div class="image">
								 <img src="/uploads/global/images/banner/280x155_th3f1a3c21/f1209ab4bd2f20d1dc6dc4d2ebd68f007c3481e4.jpg@1398859317">
							</div>
							<div class="content">
								<div class="content-wrapper">
									<div class="content-limiter">
										<div class="type">Акция</div>
										<div class="title">Снижение цены на футболки КВАНТ: акция продлена!</div>
										<div class="description">С 1 мая по 31 августа на сигнальные футболки КВАНТ скидка — 30%!</div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div>
						<a href="/../i-vs.vostok.ru/stock/542/index.html">
							<div class="image">
								 <img src="/uploads/global/images/banner/280x155_th3f1a3c21/7bf2baf6ab3a130642e715601b6cfcde4c589ecf.jpg@1405415675">
							</div>
							<div class="content">
								<div class="content-wrapper">
									<div class="content-limiter">
										<div class="type">Акция</div>
										<div class="title">Готовься к осени</div>
										<div class="description">С 15 июля по 31 августа, приобретая сандалии в магазинах «Восток-Сервис», вы получите скидку 10% при покупке обуви в сентябре-октябре.</div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div>
						<a href="/../shop.vostok.ru/novosti/557/index.html">
							<div class="image">
								 <img src="/uploads/global/images/banner/280x155_th3f1a3c21/0bd9089d110896e76d3792c5563ddbd8becacc0c.jpg@1406836803">
							</div>
							<div class="content">
								<div class="content-wrapper">
									<div class="content-limiter">
										<div class="type">Новинка</div>
										<div class="title">Защита от клещей</div>
										<div class="description">Группа компаний «Восток-Сервис» представляет новинку — костюм противоэнцефалитный ЭКСПЕДИЦИЯ.</div>
									</div>
								</div>
							</div>
						</a>
					</div>
				</div>
	';
}

?>