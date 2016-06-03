<?php
  //error_reporting(E_ALL);
  //ini_set('display_errors','On');
	$DOC_ROOT = substr($_SERVER['DOCUMENT_ROOT'], -1) == '/' ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['DOCUMENT_ROOT'].'/';
	include_once "{$DOC_ROOT}carlsberg/admin/dbaccessor.php";
	include_once "const.php";
	$GLOBALS['db_for_log'] = new DBAccessor(false);

	function get_price ($row) {
		if ($_SESSION['auto_user']['currency']==1) {
			return $row['bel_price'];
		}
		return $row['price'];
	}
        
	function get_type_currency($currency=false) {
		$currency = $currency === false ? $_SESSION['auto_user']['currency'] : $currency;
		if ($currency==1) {
			return 'BYR';
		}
		return 'росс.руб.';	
	}

	function compile_and_send_letter_carlsberg ($state) {
		switch ($state) {
			case STATE_FIRST_SEND_LETTER_TO_USER_AND_MANAGER:
				$_POST = $GLOBALS['POST'];
				$query_insert_goods_for_orders = '';
				
				$id_order = get_id_order ();
				$tr_str = '';
				$sch_ff = 0;
				foreach($_POST['basket'] as $row) {
					$GLOBALS['ZAKAZ_PAGE'][ITEMS_MAIL] .= "<br/><br/><b><a href = 'http://vostok.spb.ru/carlsberg{$row['title_latin']}'>{$row['title']}</a></b><br/>";
					for ($i=0; $i<count($row['quantity']); $i++) {

						if (!array_key_exists($i, $row['quantity']) || !$row['quantity'][$i] )
							continue;

						$sch_ff++;
						$row_quantity_w = $row['quantity'][$i];
						if (array_key_exists($i, $row['select_size']) !== false&&$row['select_size'][$i] ) {
							$GLOBALS['ZAKAZ_PAGE'][ITEMS_MAIL] .= " Размер: {$row['select_size'][$i]} ";
						}

						$row['quantity'][$i] = intval($row['quantity'][$i]);
						$GLOBALS['ZAKAZ_PAGE'][ITEMS_MAIL] .= " Количество: {$row['quantity'][$i]} шт.";

						if (array_key_exists($i, $row['common_row_price']) !== false&&isset($row['common_row_price'][$i]) ) {
							$GLOBALS['ZAKAZ_PAGE'][ITEMS_MAIL] .= " Итого: ".number_format($row['common_row_price'][$i], 2, ',', ' ')." ".get_type_currency()."<br/>";
						}
						if (!$row['price']) {
							$row['price'] = 0;
						}
						$tr_str .= "<tr>
							<td style = 'border: 1px solid #d2d2d4;padding: 1px; text-align:center'>".($sch_ff)."</td>
							<td style = 'border: 1px solid #d2d2d4;padding: 1px; text-align:center'><a href = 'http://vostok.spb.ru/carlsberg{$row['title_latin']}'>{$row['title']}</a></td>
							<td style = 'border: 1px solid #d2d2d4;padding: 1px; text-align:center'>{$row['article']}</td>
							<td style = 'border: 1px solid #d2d2d4;padding: 1px; text-align:center'>{$row['select_size'][$i]}</td>
							<td style = 'border: 1px solid #d2d2d4;padding: 1px; text-align:center'>шт.</td>
							<td style = 'border: 1px solid #d2d2d4;padding: 1px; text-align:center'>{$row['quantity'][$i]}</td>
							<td style = 'border: 1px solid #d2d2d4;padding: 1px; text-align:center'>{$_SESSION['auto_user']['factory']}</td>
							<td style = 'border: 1px solid #d2d2d4;padding: 1px; text-align:center'>".number_format($row['price'], 2, ',', ' ')." ".get_type_currency()."</td>
							<td style = 'border: 1px solid #d2d2d4;padding: 1px; text-align:center'>".number_format($row['common_row_price'][$i], 2, ',', ' ')." ".get_type_currency()."</td>
						</tr>";
						$query_insert_goods_for_orders .= "('{$row['cart_item_id']}','{$row['select_size'][$i]}','','{$row['quantity'][$i]}','{$id_order}','{$row['price']}','{$row['common_row_price'][$i]}'),";
					}
				}

				$GLOBALS['ZAKAZ_PAGE'][ITEMS_MAIL] = '
												<table style = "border-collapse: collapse;border-spacing: 0;border: 1px solid #D2D2D4;margin:10px 0">
													<tr>
														<td style = "border: 1px solid #d2d2d4;padding: 1px; text-align:center" width="30"><br/><br/>№<br/></td>
														<td style = "border: 1px solid #d2d2d4;padding: 1px; text-align:center" width="125"><br/><br/>Позиция (наименование)<br/></td>
														<td style = "border: 1px solid #d2d2d4;padding: 1px; text-align:center" width="125"><br/><br/>Артикул<br/></td>
														<td style = "border: 1px solid #d2d2d4;padding: 1px; text-align:center" width="90"><br/><br/>Размер<br/></td>
														<td style = "border: 1px solid #d2d2d4;padding: 1px; text-align:center" width="70"><br/><br/>Ед. измерения<br/></td>
														<td style = "border: 1px solid #d2d2d4;padding: 1px; text-align:center" width="70"><br/><br/>Кол-во<br/></td>
														<td style = "border: 1px solid #d2d2d4;padding: 1px; text-align:center" width="200"><br/><br/>Подразделение<br/></td>
														<td style = "border: 1px solid #d2d2d4;padding: 1px; text-align:center" width="95"><br/><br/>Цена за единицу Без НДС<br/></td>
														<td style = "border: 1px solid #d2d2d4;padding: 1px; text-align:center" width="95"><br/><br/>Итого<br/></td>
													</tr>
													'.$tr_str.'
												</table>';

				if ($query_insert_goods_for_orders) {
					$query_insert_goods_for_orders = substr ($query_insert_goods_for_orders, 0, -1);
					$query_insert_goods_for_orders = "INSERT INTO `cms2_orders_goods`(`item_id`, `size`, `measure`, `quantity`, `order_id`, `price`, `common_price`) 
													VALUES 
													{$query_insert_goods_for_orders}";
					$GLOBALS['db_for_log']->wrp_log_history(array('type_query'=>'createRecord', 'query'=> $query_insert_goods_for_orders,  'descr_query' => "Вставка товаров заявки"));
				}
				
				$body2 .= "<br/>Общее количество товаров: " .$_POST['common_count']. " шт.<br/>
						  Общая сумма заявки: " . number_format($_POST['common_price'], 2, ',', ' ') . " ".get_type_currency()."<br/>";		

				$body2 .= "	{$GLOBALS['ZAKAZ_PAGE'][ITEMS_MAIL]}<br/><br/><br/>
							Имя: {$_SESSION['auto_user']['name']}<br/>
							Телефон: {$_SESSION['auto_user']['phone']}<br/>
							Email: {$_SESSION['auto_user']['email']}<br/>
							".($_POST['comment'] ? "Комментарии: {$_POST['comment']}<br/>":'').
							($_POST['cost_center'] ? "Центр затрат: {$_POST['cost_center']}<br/>":'').
							($_POST['type_of_expenditure'] ? "Вид расходов: {$_POST['type_of_expenditure']}<br/>":'');

				$body2 .= $_POST['form_with_private_data']['addr'] ? "Адрес: {$_POST['form_with_private_data']['addr']}<br/>":'';
				$body2 .= $_POST['form_with_private_data']['index'] ? "Индекс: {$_POST['form_with_private_data']['index']}<br/>" : '';
				$body2 .= $_POST['form_with_private_data']['other'] ? "Примечение: {$_POST['form_with_private_data']['other']}<br/>" : '';
				$body2 .= $_POST['form_with_private_data']['other'] ? "Примечение: {$_POST['form_with_private_data']['other']}<br/>" : '';
				$body2 .= "<hr><b>1 файл</b><br/><a href = 'http://vostok.spb.ru/carlsberg/admin/orders/PDF_FILES/{$id_order}.pdf'>Заказ №{$id_order}.pdf</a><hr>";

				$body3 = "Ваша заявка №{$id_order} поступил в обработку<br/>
						  Вы заказали следующие товары:
						  {$GLOBALS['ZAKAZ_PAGE'][ITEMS_MAIL]}<br/><br/>
						  Общее количество товаров: " .$_POST['common_count']. " шт.<br/>
						  Общая сумма заявки: " . number_format($_POST['common_price'], 2, ',', ' ') . " ".get_type_currency()."<br/><br/>
						 <b>Менеджер:</b> {$_SESSION['auto_user']['manager_name']} (<a href = 'mailto:{$_SESSION['auto_user']['manager_email']}'>{$_SESSION['auto_user']['manager_email']}</a>)<br/><br/><br/>";
			
				$header	= "MIME-Version: 1.0\r\n";
				$header .= "Content-type:  text/html; charset=utf-8\r\n";
				$header .= 'From: info@vostok.spb.ru' . "\r\n" .
				    'Reply-To: info@vostok.spb.ru' . "\r\n" .
				    'X-Mailer: PHP/' . phpversion();
				
				$user_hash = md5(SALT.$_SESSION['auto_user']['id']);
				$manager_hash = md5(SALT.$_SESSION['auto_user']['manager']);
				$order_hash = md5(SALT.$id_order);
				$href_reject_confirm = "<br/><a href = 'http://vostok.spb.ru/carlsberg/admin/orders.php?user_hash={$user_hash}&manager_hash={$manager_hash}&order_hash={$order_hash}&approve=1'>Одобрить</a>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href = 'http://vostok.spb.ru/carlsberg/admin/orders.php?user_hash={$user_hash}&manager_hash={$manager_hash}&order_hash={$order_hash}'>Отклонить</a><br/>";
				$subj = "Заявка с сайта Восток Сервис - №" . $id_order;
				$GLOBALS['db_for_log']->wrp_log_history (array ('action_history' => 'insert', 
											  'callback' => 'send_letter_carlsberg', 
											  'subj'=>$subj,
											  'header'=>$header,	
											  'email'=>$_SESSION['auto_user']['manager_email'],
											  'email_text'=>$href_reject_confirm.$body2,
											  'price' => $_POST['common_price'],
											  'body2'=>$body2,
											  'id_order'=>$id_order,
											  'currency'=>$_SESSION['auto_user']['currency']));
				$subj_user = "Подтверждение заявки №{$id_order} в Восток-Сервис";
				$GLOBALS['db_for_log']->wrp_log_history (array ('callback' => 'send_letter_carlsberg', 
											  'subj'=>$subj_user,
											  'header'=>$header,
											  'email'=>$_SESSION['auto_user']['email'],
											  'email_text'=>$body3,
											  'body2'=>$body3,
											  'id_order'=>$id_order));
				file_get_contents("http://vostok.spb.ru/carlsberg/admin/orders/controller.php?task=generatePDF&id={$id_order}");
			break;
			
			default:
				# code...
			break;
		}

	}

	function get_id_order () {
		$query = "INSERT INTO `cms2_orders_carslberg_id`(`id`) VALUES (DEFAULT)";
		$id_order = $GLOBALS['db_for_log']->wrp_log_history(array('type_query'=>'createRecord', 'query'=> $query,  'descr_query' => "Получение id заявки"));
		if ($id_order) {
			return $id_order;
		}
		$GLOBALS['db_for_log']->mail_to_admin_big_problem ("Не возможно вставить id заявки".print_r($_SESSION['auto_user'], true).print_r($opts, true));
	}

	function send_letter_carlsberg ($opts) {
		$body2 = "Здравствуйте!<br>".$opts['email_text']."<br/> <a href = 'http://vostok.spb.ru/carlsberg/'>Система приёма заявок Carlsberg на сайте Восток-Сервис</a><br/><a href = 'http://vostok.spb.ru/carlsberg/admin/'>Система управления заявками</a><br/><br/><br/>";
		$log_str = '';
		$ret = true;
		if (!$opts['email']||(isset($opts['email_manager'])&&!$opts['email_manager'])) {
			$GLOBALS['db_for_log']->mail_to_admin_big_problem ("Письма не отправляются".print_r($_SESSION['auto_user'], true).print_r($opts, true));
			$ret = false;
		}
		
		if($opts['email'] != 'tikhomirov_va@baltika.com')
		{	
			@mail($opts['email'], $opts['subj'], $body2, $opts['header']);
			$log_str.= 'email ='. $opts['email'].';';
		}
		if ($opts['email_manager'] && $opts['email_manager'] != 'tikhomirov_va@baltika.com') {
			@mail($opts['email_manager'], $opts['subj'], $body2, $opts['header']);
			$log_str.= 'email_manager ='. $opts['email_manager'].';';
		}
		
		$mvs_emails = get_mvs_emails ($opts);
		if (count($mvs_emails)>0) {
			if ($mvs_emails) {
				foreach ($mvs_emails as $mvs_emails_v) {
					if ($mvs_emails_v['email']) {
						if($mvs_emails_v['email'] != 'tikhomirov_va@baltika.com')
						{
							@mail($mvs_emails_v['email'], $opts['subj'], $body2, $opts['header']);
							$log_str.= '$mvs ='. $mvs_emails_v['email'].';';
						}
					} else {
						$GLOBALS['db_for_log']->mail_to_admin_big_problem ("Письма не отправляются".print_r($_SESSION['auto_user'], true).print_r($opts, true).print_r($mvs_emails, true));						
						$ret = false;
					}
				}
			}
		}

		$GLOBALS['db_for_log']->wrp_log_history(array('action_history' => 'letters_fly', 'log_str'=> $log_str));
		//@mail('kpb90@mail.ru', $opts['subj'], $body2, $opts['header']);
		return $ret;
	}

	function get_mvs_emails ($opts) 
	{
		$condition = '';
		if ($opts['send_copy_letter_to_super_admin_and_MVS']==true) {
			$condition .= ($condition ? " or " : ' '). " role = ".MVS. " or role = ".SUPER_ADMIN;
		} 
		
		if ($opts['send_copy_letter_to_carlsberg']==true) {
			$condition .= ($condition ? " or " : ' '). " role = ".MANAGER_CARSLBERG;
		}

		if ($condition) {
			$condition = " where ({$condition}) and 
				Username <> 'andreichuk_se1' and 
				Username <> 'yorkhova' and 
				Username <> 'demo' and 
				Username <> 'm.d.garmony' and 
				Username <> 'tokko' and 
				Username <> 'talyar'";
		}

		if ($condition) {
			$query  = "select email from users_enc {$condition}";
			$mvs_emails = $GLOBALS['db_for_log']->wrp_log_history(array('type_query'=>'getAssocList', 'query'=> $query,  'descr_query' => "Получение email МВС ".print_r($opts, true)));
			if($opts['send_copy_letter_to_extra_MVS'] == true && $opts['email'])
			{
				$querycf = "SELECT cf.extramails from `cms2_factories_carslberg` as cf inner join `users_enc` as u on cf.g2_latin=u.g_latin where u.email='{$opts['email']}' limit 1";
				$extramails = mysql_result(mysql_query($querycf), 0);
				if($extramails)
				{
					$memails = explode(";", str_replace(' ', '', $extramails));
					foreach($memails as $e)
						if(strpos($e, '@'))
							$mvs_emails[]['email'] = $e;		
				}
			}
			return $mvs_emails;	
		} 
	}

	/*================================================*/
	function autorization_user ($login, $pswd) {
		//'manager_email'
	  $query = "SELECT u.*, 
				  if (u.g_latin<>'/' , 
			   	    							(select f.id from cms2_factories_carslberg as f where f.g2_latin = u.g_latin limit 1),
			   	    							id_factory) as factory,
	  	        (SELECT uu.`email` FROM `users_enc` as uu  WHERE u.`manager` = uu.`id` limit 1) as manager_email,
	  	        (SELECT uu.`name` FROM `users_enc` as uu  WHERE u.`manager` = uu.`id` limit 1) as manager_name,
	  	        (select f.currency from cms2_factories_carslberg as f where f.g2_latin = u.g_latin limit 1) as currency
	   		    FROM users_enc as u
	   		    WHERE Username = '$login' AND password = '$pswd' limit 1";

	  $r = $GLOBALS['DB_CONNECTION']->query($query);

	  if ($r&&$row=$r->fetch_assoc ()) {
	  	if ($row['factory']==ALL_FACTORY) {
			$row['factory'] = 'Восток-Сервис';
		} else if ($row['factory']==HEADQUARTERS) {
			$row['factory'] = 'Штаб квартира Carlsberg';
		} else {
			$query  = " SELECT * FROM `cms2_factories_carslberg` where id = {$row['factory']}";
			$factoryInfo = $GLOBALS['db_for_log']->wrp_log_history(array('type_query'=>'getAssoc', 'query'=> $query,  'descr_query' => "Получение фабрик из основного сайта "));
			$row['factory'] = $factoryInfo ['gtitle'].($factoryInfo ['subgtitle'] ? " / {$factoryInfo ['subgtitle']}" : '');
		}
	  	$_SESSION['auto_user'] = $row;
	  	return true;
	  }
	  return false;
	}

	function check_low () {
	  return strpos($_SERVER['REQUEST_URI'],'/carlsberg/factories'. $_SESSION['auto_user']['g_latin'])!==false;
	}

	function get_url_on_catalog_for_auto_user () {
	  $user_url = str_replace ('carlsberg/factories'. $_SESSION['auto_user']['g_latin'],'',$_SERVER['REQUEST_URI']);
	  // если выбрана категория
	  if (($pos_catalog=strpos ($_SERVER['REQUEST_URI'],'/catalog/'))!==FALSE) {
	    return substr($_SERVER['REQUEST_URI'], $pos_catalog+strlen('/catalog/')-1);
	  } else {
	    return '';
	  }
	}

	function get_url_on_factory_for_auto_user ($url_on_catalog_for_auto_user) {
	  $url_on_catalog_for_auto_user = $url_on_catalog_for_auto_user ? $url_on_catalog_for_auto_user : get_url_on_catalog_for_auto_user ();
	  $pos_factory = strpos ($_SERVER['REQUEST_URI'], $_SESSION['auto_user']['g_latin']);
	  if (strpos($_SERVER['REQUEST_URI'],'/carlsberg/factories')!==false) {
	    $url_on_factory_for_auto_user = str_replace (array('catalog'.$url_on_catalog_for_auto_user,'/carlsberg/factories'),array('',''), $_SERVER['REQUEST_URI']);  
	  } else {
	  	$url_on_factory_for_auto_user = $_SESSION['auto_user']['g_latin'];
	  	/*
	      if ( $_SESSION['auto_user']['level']!=1) {
	        $url_on_factory_for_auto_user = $_SESSION['auto_user']['g_latin'];
	      } else {
	        $url_on_factory_for_auto_user = '/carlsberg/factories/';
	      }
	      */
	  }
	  return $url_on_factory_for_auto_user;
	}

	/*================================================*/

	function get_l_menu_carlsberg () {
		//if ($GLOBALS['PAGE_KEY'] != 'catalog_carlsberg') {
		//	return '';
		//}
		$url_on_catalog_for_auto_user = get_url_on_catalog_for_auto_user ();
		$url_on_factory_for_auto_user = get_url_on_factory_for_auto_user ($url_on_catalog_for_auto_user);
		$condition_for_get_code_of_factory = get_condition_for_get_code_of_factory ($url_on_factory_for_auto_user);
		$query = "SELECT * from studio_catalog_groups_carslberg where {$condition_for_get_code_of_factory} group by g1title  order by id ASC";
		$cat_enties = afetchrowset(mysql_query($query));
		$begin_url_for_left_menu = '/carlsberg/factories/'.$url_on_factory_for_auto_user.'/catalog/';
		foreach($cat_enties as $row) {
	 		$url_for_left_menu = preg_replace("/\/\/+/","/", $begin_url_for_left_menu.$row['g1_latin']); 
			$cur_seltd =strpos ($_SERVER['REQUEST_URI'], $row['g1_latin']) !== FALSE;
			$lmenu_str .= '
						<li class="group-01_0' . $ir[$i] . ($cur_seltd ? ' seltd' : '') .'" data-group="01_0' . $ir[$i] . '">
							<a  '.(substr_count($row['g1title'], ' ') > 3 ? "style = 'line-height:30px'":'').' href="' .$url_for_left_menu . '" title="' . $row['g1title'] . ' - товары с ценами и адреса магазинов">' . $row['g1title'] . '</a>
						</li>
				';
				$i++;
		}

		return '
					<div id="catalog-menu" class = "carlsberg">
'.($_SESSION['auto_user'] ? '
						<ul class="level0" data-parent="01" data-id="0">
							' . $lmenu_str . '
							<li class="group-01_0 ' .($_SERVER['REQUEST_URI']=='/carlsberg/factories'.$_SESSION['auto_user']['g_latin'] ? ' seltd' : '') .'" data-group="01_0">
								<a href="/carlsberg/factories'.$_SESSION['auto_user']['g_latin'].'" title="Показать все">Показать все</a>
							</li>
						</ul>':'').'
					</div>	
		';

	}

	function get_condition_for_get_code_of_factory ($url_on_factory_for_auto_user) {
			if ($url_on_factory_for_auto_user=='/') {
					// Все заводы 
					$url_on_factory_for_auto_user = '/%';
			}
			$subquery_for_code_factory_for_auto_user = "(select f.code from `cms2_factories_carslberg` as f where g2_latin like '{$url_on_factory_for_auto_user}' limit 1)";
			// Для получения товаров привязанных к родителю
			$subquery_for_code_factory_for_auto_user2 = "(select SUBSTRING( f.code, 1, 1 ) from `cms2_factories_carslberg` as f where g2_latin like '{$url_on_factory_for_auto_user}' limit 1)";

			return "
				(carlsberg = '' OR (	
		  			INSTR(carlsberg,concat(',',{$subquery_for_code_factory_for_auto_user})) > 0 
		  			or
		  			INSTR(carlsberg,concat(',',{$subquery_for_code_factory_for_auto_user2},',')) > 0 
		  		))";
	}

	function addToLog_carlsberg($message,$file='log_order_carlsberg.txt') {
		$message = "\r\n======================================Дата логирования: ".date("Y-m-d H:i:s"). "\r\n".$message."\r\n======================================";
		$handle = fopen($file, "a+");
		fwrite($handle, $message . PHP_EOL);
		fclose($handle);
	}

	function get_button_buy ($opts) {

		if (  $_SESSION['auto_user']['Username'] == 'andreichuk_se1' || 
			$_SESSION['auto_user']['Username'] == 'yorkhova' || 
			$_SESSION['auto_user']['Username'] == 'demo' || 
			$_SESSION['auto_user']['Username'] == 'm.d.garmony' || 
			$_SESSION['auto_user']['Username'] == 'tokko' || 
			$_SESSION['auto_user']['Username'] == 'zaytceva_mi' || 
			$_SESSION['auto_user']['Username'] == 'talyar')
			return '';

	    $data_type = "";
	    $type = "";
	    if ( $_SESSION['auto_user']['type'] && strpos($_SERVER['REQUEST_URI'],'/carlsberg/')!==false) {
	      $data_type = " data-type = '{$_SESSION['auto_user']['type']}'";
	      $type = 'carlsberg';
	    }
	    $title = 'Добавить в корзину';
	    if (array_key_exists($opts['data']['id'], $GLOBALS['IDS'])!==false)  {
	     return "<div style = 'clear:both'><a data-type='carlsberg' href='/carlsberg/zakaz_i_dostavka.html' class='readmore carlsberg'>Корзина</a></div>";
	    }
	     return "<div style = 'clear:both'><A {$data_type} data-price = '{$opts['data']['price']}' data-item = '{$opts['data']['id']}' href='javascript:;' class='readmore {$type} buy_this_item'>{$title}</A></div>";
  }
?>