<?php
session_start();
include_once "{$_SERVER['DOCUMENT_ROOT']}/const.php";
include_once "{$_SERVER['DOCUMENT_ROOT']}/new_admin/dbconnect.php";
class DBAccessor {
	
	protected $resource = '';
	
	function __construct() {
		$this->resource = dbconnect();	
	}			
		
	function __destruct() {	
		return true;
	}	

	function get_header_for_letter ($from) {
			$from = "info@vostok.spb.ru";
			$header	= "MIME-Version: 1.0\r\n";
			$header .= "Content-type:  text/html; charset=utf-8\r\n";
			$header .= "From: {$from}" . "\r\n" .
				    "Reply-To: {$from}" . "\r\n" .
				    'X-Mailer: PHP/' . phpversion();
			return $header;
	}

	function update_avg_rating_catalog ($id_item) {
		if ($id_item) {
			$query = "SELECT avg(rating) as avg_rating  FROM `rating_carslberg` WHERE id_item = {$id_item} and access = 1";
		 	$info_rating = $this->wrp_log_history(array('type_query'=>'getAssoc', 'query'=> $query,  'descr_query' => "Среднее значение оценки для товара"));
		 	if ($info_rating) {
		 		$query = "UPDATE `studio_catalog_carslberg` SET `rating`= '{$info_rating['avg_rating']}' where id = '{$id_item}'";
				$result = $this->wrp_log_history (array ('type_query'=>'execute', 'query' => $query, 'descr_query' => 'Обновление общей оценки у товара'));	
				return $result;
		 	}
		}
	}

	public function wrp_log_history ($opts) {
		$ret = '';
		$add_field = '';

		// Логирование для отладки
		switch ($opts['type_query']) {
			case 'createRecord':
				$ret = $this->createRecord($opts['query']);
				$add_field = "Создается новая запись:".print_r($ret,true)."\r\n";
			break;
			case 'execute':
				$ret = $this->execute($opts['query']);
				$add_field = "Выполняется запрос обновления:".print_r($ret,true)."\r\n";
			break;

			case 'executeListQuery':
				$this->executeListQuery($opts['query']);
				$add_field = "Выполняется запрос executeListQuery:".print_r($ret,true)."\r\n";
			break;
			
			case 'getAssoc':
				$ret = $this->getAssoc($opts['query']);
				$add_field = "Выполняется запрос getAssoc:".print_r($ret,true)."\r\n";
			break;

			case 'getAssocList':
				$ret = $this->getAssocList($opts['query']);
				$add_field = "Выполняется запрос getAssocList:\r\n";
			break;

			case 'none':
				$add_field = $opts['message'];
			break;

			default:
				# code...
			break;
		}
		if ($add_field) {
			$add_field .= ' '.$opts['descr_query']."\r\n";
		}
		
		$mysql_error = mysql_error();
		if ($mysql_error) {
			$add_field .= $mysql_error.$opts['query'];
			$this->mail_to_admin_big_problem (print_r($_SESSION['auto_user'], true).$add_field);
		}

		// Логирование истории заявки
		$query = '';
		$str_change_status = "";
		$str_change_status_for_letter = "";
		if (array_key_exists('action_history', $opts)) {
			$history_log = "";
			$id_order = $opts['id_order'];
			switch ($opts['action_history']) {
				case 'insert':
						$date_order = date("Y-m-d H:i:s");
						$email_text = mysql_escape_string($opts['email_text']);
						$query = "INSERT INTO `cms2_letter_for_repeat_send_om_carlsberg`(`id_order`, `text`) VALUES ('{$id_order}','{$email_text}')";
						$this->wrp_log_history (array ('type_query'=>'createRecord', 'query' => $query, 'descr_query' => 'Сохраняем письмо для отправки второму менеджеру'));
						$query = "INSERT INTO `cms2_orders_carslberg_text`(`text`,`date`) VALUES ('".addslashes($opts['body2'])."','{$date_order}')";
						$text_id = $this->wrp_log_history (array ('type_query'=>'createRecord', 'query' => $query, 'descr_query' => 'Добавления текста'));
						$history_log = "<b>{$_SESSION['auto_user']['name']} <a href = \"mailto:{$_SESSION['auto_user']['email']}\">{$_SESSION['auto_user']['email']}</a> ({$_SESSION['auto_user']['factory']}) </b> оформил заявку <br> Дата заявки: {$date_order} <br/>". $opts['body2'];
						$add_field .= "Пользователь {$_SESSION['auto_user']['Username']} оформил заявку \r\n Дата заявки: {$date_order}";
						$history_log = addslashes($history_log).'<hr/>';
						$query = "INSERT INTO `cms2_orders_carslberg`(`id`,`user_id`, `date`, `text_id`, `history_log`, `price`,`currency`) 
																	VALUES 
																	('{$opts['id_order']}',{$_SESSION['auto_user']['id']},'{$date_order}',$text_id, '{$history_log}','{$opts['price']}','{$opts['currency']}')";
						$this->wrp_log_history (array ('type_query'=>'createRecord', 'query' => $query, 'descr_query' => 'Добавляется заявка'));
				break;

				case 'approve_order':
						$query = $this->getQueryOfOrderOnTheHash();
						//$result = $this->wrp_log_history (array ('type_query'=>'execute', 'query' => $query , 'action_history' => 'user_change_status', 'prev_info_order' => $prev_info_order, 'status_MVS_id' => $status_MVS_id, 'status_OM_id' => $status_OM_id, 'price' => $price, 'date_change_order' => $date_change_order, 'id_order' => $id));
						$ret = $this->wrp_log_history(array('type_query'=>'getAssoc', 'query'=> $query,  'descr_query' => "(Одобрение заявки)Проверка есть ли бд заявка: "));
						if ($ret) {
							$result = $this->wrp_log_history (array ('type_query'=>'execute', 'query' => $query , 'action_history' => 'user_change_status', 'status_OM_id' => ORDER_APPROVED,  'date_change_order' => date("Y-m-d H:i:s"), 'id_order' => $id_order));
							$history_log = "Заявка {$row['id']} поменяла статус на одобрен";
							addToLog_carlsberg ($history_log."\r\n Менеджер: {$row['manager_email']} \r\n  Покупатель: {$row['user_email']} \r\n");
						} else {
							$add_field .= "Ошибка. Не найдена заявка для которого необходимо поменять статус.".$query;
							$this->mail_to_admin_big_problem (print_r($_SESSION['auto_user'], true).$add_field);
						}
				break;

				case 'user_change_text':
					$old_id_text = $opts['old_id_text'];
					$new_id_text = $ret;
					$date_change_order = $opts['date_change_order'];
					$history_log = "<br> {$_SESSION['auto_user']['name']} <a href = \"mailto:{$_SESSION['auto_user']['email']}\">{$_SESSION['auto_user']['email']}</a> ({$_SESSION['auto_user']['factory']}) изменил текст заявки №{$id_order} 
									<br> Дата изменения: {$date_change_order} <br>
									<a target = '_blank' href = 'see_text.php?id=$old_id_text'>Предыдущая версия текста заявки</a><br/>
									<a target = '_blank' href = 'see_text.php?id=$new_id_text'>Текущая версия текста заявки</a><br/>";
				break;
				case 'user_add_comment':
					$date_change_order = $opts['date_change_order'];
					$str_change_status_for_letter = $str_change_status = $opts['comment_to_status'] ? "<b>Комментарии: </b> {$opts['comment_to_status']}<br/>":'';
					$str_change_status_for_letter .=  "<b>Менеджер: </b> {$_SESSION['auto_user']['name']} (<a href = \"mailto:{$_SESSION['auto_user']['email']}\">{$_SESSION['auto_user']['email']}</a>)<br/>";
					$str_change_status_for_letter .= "<hr>{$opts['text_order']}";
					$history_log = "<br> {$_SESSION['auto_user']['name']} <a href = \"mailto:{$_SESSION['auto_user']['email']}\">{$_SESSION['auto_user']['email']}</a> ({$_SESSION['auto_user']['factory']}) изменил данные заявки №{$id_order}:
										<br> Дата изменения: {$date_change_order} <br>
										{$str_change_status}";	

				break;
				case 'user_change_status':
					$data_MVS_store = array (ORDER_RECEIVED_IN_VOSTOK=>'Получен в Восток Сервис', ORDER_COMPILED => 'Скомплентован', ORDER_SEND => 'Отправлен', PARTIALLY_SENT => 'Отправлен частично');
					$data_OM_store = array (ORDER_REJECTED => 'Отклонен', ORDER_APPROVED =>'Одобрен', ORDER_GOODS_RECEIVED =>'Товар получен', ORDER_GOODS_RECEIVED_NOT_FULL => 'Товар получен не в полном объеме',ORDER_SENT_REQUEST_TO_SPARE_MANAGER => 'Запрос отправлен запасному менеджеру');

					$date_change_order = $opts['date_change_order'];

					if ($opts['prev_info_order']['status_MVS_id']!=$opts['status_MVS_id']&&isset($opts['status_MVS_id'])) {
						$str_change_status .= "Статус заявки обновился ".($opts['prev_info_order']['status_MVS_id'] ? " c {$data_MVS_store[$opts['prev_info_order']['status_MVS_id']]} " : "")." на <b>".$data_MVS_store[$opts['status_MVS_id']]."</b><br/>";
						$str_change_status_for_letter .= "Статус заявки №{$opts['id_order']} обновился на <b>{$data_MVS_store[$opts['status_MVS_id']]}</b><br/>";
					}

					if ($opts['prev_info_order']['status_OM_id']!=$opts['status_OM_id']&&isset($opts['status_OM_id'])) {
						$str_change_status .= "Статус заявки обновился ".($opts['prev_info_order']['status_OM_id'] ? " c {$data_OM_store[$opts['prev_info_order']['status_OM_id']]} " : ""). " на <b>".$data_OM_store[$opts['status_OM_id']]."</b><br/>";
						$str_change_status_for_letter .= "Статус заявки №{$opts['id_order']} обновился на <b>{$data_OM_store[$opts['status_OM_id']]}</b><br/>";
					}
					/*
					if ($opts['prev_info_order']['price']!=$opts['price']&&isset($opts['price'])) {
						$str_change_status .= "Цена заявки изменена c {$opts['prev_info_order']['price']} на <b>{$opts['price']}</b><br/>";
						$str_change_status_for_letter .= "Цена заявки №{$opts['id_order']} изменена на <b>{$opts['price']}</b><br/>";
					}
					*/
					if ($str_change_status_for_letter) {
						$str_change_status_for_letter .= $opts['comment_to_status'] ? "<b>Комментарии: </b> {$opts['comment_to_status']}<br/>":'';
						$str_change_status_for_letter .=  "<b>Менеджер: </b> {$_SESSION['auto_user']['name']} (<a href = \"mailto:{$_SESSION['auto_user']['email']}\">{$_SESSION['auto_user']['email']}</a>)<br/>";
						$str_change_status_for_letter .= "<hr>{$opts['text_order']}";
					}

					if (isset($opts['comment_reject'])) {
						$str_change_status .= "Заявка отменена<br/>".($opts['comment_reject'] ? "<b>Причина отмены заявки: </b> {$opts['comment_reject']}":'');
					}

					// менеджером: {$_SESSION['auto_user']['name']} (<a href = \"mailto:{$_SESSION['auto_user']['email']}\">{$_SESSION['auto_user']['email']}</a>)
					$opts['subj_change_status'] = $str_change_status;					
					if ($opts['comment_to_status']&&$str_change_status) {
						$str_change_status .= "<b>Комментарии к изменённому статусу заявки:</b> {$opts['comment_to_status']}";
					}

					if ($str_change_status) {
						$history_log = "<br> {$_SESSION['auto_user']['name']} <a href = \"mailto:{$_SESSION['auto_user']['email']}\">{$_SESSION['auto_user']['email']}</a> ({$_SESSION['auto_user']['factory']}) изменил данные заявки №{$id_order}:
										<br> Дата изменения: {$date_change_order} <br>
										{$str_change_status}";	
					}
				break;
				case 'letters_fly':
					$add_field .= "Летят письма: ".$opts['log_str'];
				break;
			}

			if ($opts['action_history'] != 'insert'&&$history_log) {
				$history_log = addslashes($history_log).'<hr/>';

				if (!$opts['id_order']) {
					$this->mail_to_admin_big_problem ('Невозможно обновить заявку: '. print_r($_SESSION['auto_user'], true).print_r($opts, true).$add_field);					
				}

				$query = "UPDATE `cms2_orders_carslberg` SET `history_log`= concat (`history_log`,'{$history_log}') where id = {$opts['id_order']}";
				if ($query) {
					$r = $this->wrp_log_history (array ('type_query'=>'execute', 'query' => $query));
					if ($r['result'] != 'success') {
						$add_field .= "Запрос {$query} закончился ошибкой";
					}
				}
			}
		}

		if (array_key_exists('update_rating', $opts)) {
			$id_user = $this->getInt ('id_user');
			$protect_rating = $this->getInt ('protect_rating');
			$reliability_rating = $this->getInt ('reliability_rating');
			$comfort_rating = $this->getInt ('comfort_rating');
			$exploitation_rating = $this->getInt ('exploitation_rating');
			$design_rating = $this->getInt ('design_rating');
			$text_rating = $this->getString ('text_otz');
			$rating = ($protect_rating + $reliability_rating + $comfort_rating + $exploitation_rating + $design_rating) / 5;
			$id_item_rating = $this->getInt ('id_item');
			$date_rating = date("Y-m-d H:i:s");
			$query = "INSERT INTO `rating_carslberg`(`id_user`,`protect_rating`, `reliability_rating`, `comfort_rating`, `exploitation_rating`, `design_rating`, `rating`, `text`, `id_item`, `date`) 
				VALUES 
				('{$id_user}','{$protect_rating}','{$reliability_rating}','{$comfort_rating}','{$exploitation_rating}','{$design_rating}','{$rating}','{$text_rating}', '{$id_item_rating}', '{$date_rating}')";
			$this->wrp_log_history (array ('type_query'=>'createRecord', 'query' => $query, 'descr_query' => 'Добавление новой оценки'));				
		}

		//$str_change_status
		if (function_exists($opts['callback'])) {
			 call_user_func($opts['callback'], $opts);
		} else if (function_exists($opts['callback_if_change_status'])&&$str_change_status) {
			$opts['subj'] .= '. '. strip_tags($opts['subj_change_status']);
			 if (!$opts['email_text']) {
			 	$opts['email_text'] .= $str_change_status_for_letter;
			 }
			 call_user_func($opts['callback_if_change_status'], $opts);
		}

		$str_log = "Пользователь:".print_r($_SESSION['auto_user']['Username'],true)."\r\n".$add_field."\r\n".($opts['query'] ? "Запрос к БД:".substr($opts['query'],0)."\r\n":'');
		$this->addToLog2 ($str_log);

		return $ret;
	}

	function getQueryOfOrderOnTheHash () {
		$user_hash = $this->getString ('user_hash');
 		$manager_hash = $this->getString ('manager_hash');
 		$order_hash = $this->getString ('order_hash');
		$query=	"SELECT  o.`id`, o.`user_id`, o.`status_MVS_id`, o.`status_OM_id`, o.`date`, o.`text_id`, o.`price`, o.`history_log`,
									(SELECT u.`email` FROM `users_enc` as u  WHERE md5(CONCAT ('".SALT."',u.`id`)) = '{$user_hash}' limit 1) as user_email,		
									(SELECT u.`role` FROM `users_enc` as u  WHERE md5(CONCAT ('".SALT."',u.`id`)) = '{$user_hash}' limit 1) as user_role,		
									(SELECT u.`email` FROM `users_enc` as u  WHERE md5(CONCAT ('".SALT."',u.`id`)) = '{$manager_hash}' limit 1) as manager_email,
									(SELECT u.`name` FROM `users_enc` as u  WHERE md5(CONCAT ('".SALT."',u.`id`)) = '{$manager_hash}' limit 1) as manager_name,
									ot.text as text_order
								  FROM `cms2_orders_carslberg` as o left join cms2_orders_carslberg_text as ot on o.text_id = ot.id
								  WHERE  md5(CONCAT ('".SALT."',o.id)) = '{$order_hash}' and md5(CONCAT ('".SALT."',user_id)) = '{$user_hash}' limit 1";
		return $query;								  
	}

	function getAssocList($query, $convert = false) {
		if($convert) {
			$query = iconv("UTF-8", "windows-1251", $query);
		}
		$cursor = mysql_query( $query);		
		if($cursor) {			
			$array = array();
			while ($row = mysql_fetch_assoc($cursor)) {			
				if($convert) {
					$array[] = $this->convertRow($row);		
				} else {
					$array[] = $row;		
				}			
			}			
			mysql_free_result($cursor);
			return $array;
		} else {			
			$errorMsg = mysql_error();
			$this->addToLog("mysql error: $errorMsg");
			return false;
		}										
	}
	
	function mail_to_admin_big_problem ($message) {
				$header	= "MIME-Version: 1.0\r\n";
			$header .= "Content-type:  text/html; charset=utf-8\r\n";
			$header .= 'From: info@vostok.spb.ru' . "\r\n" .
			    'Reply-To: info@vostok.spb.ru' . "\r\n" .
			    'X-Mailer: PHP/' . phpversion();
			@mail('kpb90@mail.ru', "Ошибка в запросе на vostok/carlsberg", $message, $header);	
	}	

	function getDataList($query, $convert = false) {
		if($convert) {
			$query = iconv("UTF-8", "windows-1251", $query);
		}
		$cursor = mysql_query( $query);	
		if($cursor) {			
			$array = array();
			while ($row = mysql_fetch_row($cursor)) {			
				if($convert) {
					$array[] = $this->convertRow($row);		
				} else {
					$array[] = $row;		
				}			
			}			
			mysql_free_result($cursor);
			return $array;
		} else {			
			$errorMsg = mysql_error();
			addToLog("mysql error: $errorMsg");
			return false;
		}	
	}	
		
	function getAssoc($query, $convert =false) {
		if($convert) {
			$query = iconv("UTF-8", "windows-1251", $query);
		}
		$res = $this->getAssocList($query, $convert);		
		if(is_array($res)) {
			$result = $res[0];			
			return $result; 
		} else {
			return false;
		}		
	}
		
		
	function getNumberOfRows() {
		$query = "SELECT FOUND_ROWS();";
		$res = $this->getResult($query);
		return $res;
	}
		
	function getResult($query) {
		$cursor = mysql_query( $query);
						
		if(!$cursor) {
			return false;			
		}
		$ret = null;
		if ($row = mysql_fetch_row($cursor)) {
			$ret = $row[0];
		}		
		mysql_free_result($cursor);
		return $ret; 		
	}
		
		
	function execute($query) {	
		$res = mysql_query($query);
		if($res) {
			$result['result'] = 'success';
		} else {
			$result['result'] = 'failure';
			$result['code'] = 1;
		}		
		return $result;
	}
		
	function executeListQuery($query) {
	
		$start = $this->getInt('start');
	    $end = $this->getInt('limit');   
	        
	    $field = $this->getString('sort');
	    $dir = $this->getString('dir');  
	        
	    if($field && $dir) {
	        $sql = $query . ' ORDER BY ' . $field . ' ' . $dir; 
	    } else if($dir && !$field) {
	    	$sql = $query . "ORDER BY id $dir";	    	
	    } else {
	       	$sql = $query . "ORDER BY id";
	    }	    	
	   	$sql = $sql . ' LIMIT ' . $start . ', '. $end;      

	    $list = $this->getAssocList($sql);
	   
	    $rows = $this->getNumberOfRows($sql);
	    	
		$res = json_encode($list);
		$cb = isset($_GET['callback']) ? $_GET['callback'] : '';
	       
	     echo $cb . '({"isize":"' . count($list) . '","total":"' . $rows . '","results":' . $res . '})';				
	}
		
	function createRecord($query) {	
		$res = mysql_query($query);
		if($res) {
			return mysql_insert_id();
		}
		return 0;
	}
		
	function getInt($param) {				
		if(array_key_exists($param, $_REQUEST)) {
			$value = $_REQUEST[$param];
			return intval($value);
		} else {
			return 0;
		}
	}
		
	function getString($param) {					
		if(array_key_exists($param, $_REQUEST)) {			
			$value = $_REQUEST[$param];
			$value = stripslashes($value); 
			return mysql_real_escape_string($value);
		} else {
			return "";
		}
	}
		
	function  getFloat($param) { 
		if(array_key_exists($param, $_REQUEST)) {
			$value = $_REQUEST[$param];
			return floatval($value);
		} else {
			return 0;
		}
	}	
	
	
	function concatProps($prop, $allProps) {
		if($prop) {
			if($allProps) {
				$allProps .= ',' . $prop;
			} else {
				$allProps = $prop;
			}
		}
		return $allProps;
	}
	
		
	function formWhere($name, $value, $sign, &$where) {
		if($value) {
			if($where) {
				$where = $where . ' AND ' . $name . $sign . $value;
			} else {
				$where = ' WHERE ' . $name . $sign . $value; 
			}
		}		
	}
		
	function addToLog($message) {
		$filename = "log.txt";		
		$handle = fopen($filename, "a+");
		fwrite($handle, $message . PHP_EOL);
		fclose($handle);			
	}

	function addToLog2 ($message, $file='log_order_carlsberg.txt') {
		if ($file=='log_order_carlsberg.txt') {
			$file= $_SERVER['DOCUMENT_ROOT'].'/carlsberg/admin/logs/'.$_SESSION['auto_user']['id'].'_'.$_SESSION['auto_user']['name'].'_log_order_carlsberg.txt';
		}
		$message = "\r\n======================================Дата логирования: ".date("Y-m-d H:i:s"). "=================\r\n".$message;
		$handle = fopen($file, "a+");
		fwrite($handle, $message . PHP_EOL);
		fclose($handle);		
	}

	function convertRow($row) {
		$correctArray = array();
		foreach($row as $key => $value) {
			$correctArray[$key] = $value;
		}
		return $correctArray;
	}



function string_begins_with($string, $search) {
    return (strncmp($string, $search, strlen($search)) == 0);
}

function getImageName($folder, $filename) {
	$id = 1;
	$handler = opendir($folder);
		 		
	$path_parts = pathinfo($folder . '/' . $filename);
	 do {
	 	$filename = $path_parts['filename'] . '_' . $id . '.' . $path_parts['extension'];
	 	$id++;
	 } while(file_exists($folder . '/' . $filename)); 
	 	
	 return $filename;	 	 
}




function uploadSingleFile($folder, $url_path, $width) {
	$logo = '';
	if(isset($_FILES['uploadfile']) && $_FILES['uploadfile']['tmp_name'] != '' && $_FILES['uploadfile']['size'] != 0) {
		$file_upload = true;
		$real_name = basename($_FILES['uploadfile']['name']);
		$tmp_name = basename( $_FILES['uploadfile']['tmp_name']);

		$filename = $this->getCorrectFileName($real_name, $tmp_name);
		
		$upload_name = $folder . $tmp_name;
		$correct_name = $this->getImageName($folder, $filename);
		
		if(rename($_FILES['uploadfile']['tmp_name'], $upload_name)) {
			if($width != -1) {
				$this->makeThumbnail($folder, basename($upload_name), $width, -1, $correct_name);
			}				
		} 	
		$logo = $url_path . $correct_name;
		unlink($upload_name);							
	}		
	return $logo;
}

function getCorrectFileName($real_name, $tmp_name) {
	$sanitized_name = preg_replace('/[^0-9a-z\.\_\-]/i','',$real_name);
	
	$filename = "";
	if($sanitized_name == $real_name) {
		$filename = $real_name;
	} else {
		$filename = $tmp_name;
	}
	return $filename;
}

function uploadFileGroup($folder, $url_path, $width)  {
	$result = array();
	if(isset($_FILES['uploadfile']) ) {		
		for($i = 0; $i < count($_FILES['uploadfile']['name']); $i++) {			
			$real_name = $_FILES['uploadfile']['name'][$i];
			$tmp_name = $_FILES['uploadfile']['tmp_name'][$i];			
			$size = $_FILES['uploadfile']['size'][$i];
			if($size > 0) {
				$file = $this->moveUploadedFile($real_name, $tmp_name, $folder, $url_path, $width);	
				$result[] = $file;
			}				
		}		
	} 
	return $result;
}

function moveUploadedFile($real, $tmp, $folder, $path, $width) {
		
		$result = '';
		$real_name = basename($real);
		$tmp_name = basename($tmp);
			
		$filename = $this->getCorrectFileName($real_name, $tmp_name);
			
		$path_parts = pathinfo($filename);			
		$file_location =  $folder . $filename;
			
		rename($tmp, $file_location); 
				
		if($path_parts['extension'] != 'flv') {								
			$correct_name = $this->getImageName($folder, $filename);
			$file = $this->makeThumbnail($folder, basename($file_location), $width, -1, $correct_name);
			$result =  $correct_name; 
			unlink($file_location);	
		} else {
			$result =  $filename;
		}
		return $result;
	
}

function makeThumbnail($folder, $fileName, $dest_width, $dest_height, $thumb_name) { 

	$thumbnailPath = $folder . '/' . $thumb_name;
	$imagePath = $folder . '/' . $fileName;
	
	$imageType = array( 1 => 'GIF', 2 => 'JPG', 3 => 'PNG', 4 => 'SWF', 5 => 'PSD', 6 => 'BMP', 7 => 'TIFF', 8 => 'TIFF', 9 => 'JPC', 10 => 'JP2', 11 => 'JPX', 12 => 'JB2', 13 => 'SWC', 14 => 'IFF');
	$imgInfo = getimagesize($imagePath);

	if ( $imageType[$imgInfo[2]] == 'JPG' ) {
		$sourceImage = imagecreatefromjpeg($imagePath);
	} elseif ($imageType[$imgInfo[2]] == 'PNG'){
		$sourceImage = imagecreatefrompng($imagePath);
	} elseif ($imageType[$imgInfo[2]] == 'BMP'){
		$sourceImage = $this->imageCreateFromBMP($imagePath);
	} else {
		$sourceImage = imagecreatefromgif($imagePath);
	}
	if(!$sourceImage) {
		return false;
	}

	$size = getimagesize($imagePath);
	$src_width = $size[0];
	$src_height = $size[1];

	$x = 0; // shift top
	$y = 0; // shift left
	$calc_height = ceil($src_height * $dest_width / $src_width);

	if($dest_height == -1) {
		// just resize height proportionally
		$dest_height = $calc_height;
	} else if($calc_height > $dest_height) {
		// have to cut top and bottom
		$y = $src_height / 2 / $calc_height * ($calc_height - $dest_height);
	} else {
		// have to cut left and right
		$calc_width = ceil($src_width * $dest_height / $src_height);
		$x = $src_width / 2 / $calc_width * ($calc_width - $dest_width);
	}
	$new_im = ImageCreatetruecolor($dest_width, $dest_height);
	imagecopyresampled($new_im, $sourceImage, 0, 0, $x, $y, 
		$dest_width, $dest_height, $src_width - $x * 2, $src_height - $y * 2);
	imagejpeg($new_im,$thumbnailPath, 70);			
	return true;
}

function imageCreateFromBMP($filename) {

	//Ouverture du fichier en mode binaire
	if (! $f1 = fopen($filename,"rb")) return FALSE;

	//1 : Chargement des ent?tes FICHIER
	$FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1,14));
	if ($FILE['file_type']	!= 19778) return FALSE;

	//2 : Chargement des ent?tes BMP
	$BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel'.
			'/Vcompression/Vsize_bitmap/Vhoriz_resolution'.
			'/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1,40));
	$BMP['colors']	= pow(2,$BMP['bits_per_pixel']);
	if ($BMP['size_bitmap']	== 0) $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];
	$BMP['bytes_per_pixel']	= $BMP['bits_per_pixel']/8;
	$BMP['bytes_per_pixel2']= ceil($BMP['bytes_per_pixel']);
	$BMP['decal']	= ($BMP['width']*$BMP['bytes_per_pixel']/4);
	$BMP['decal']	-= floor($BMP['width']*$BMP['bytes_per_pixel']/4);
	$BMP['decal']	= 4-(4*$BMP['decal']);
	if ($BMP['decal'] == 4) $BMP['decal']	= 0;

	//3 : Chargement des couleurs de la palette
	$PALETTE = array();
	if ($BMP['colors'] < 16777216)
	{
		$PALETTE = unpack('V'.$BMP['colors'], fread($f1,$BMP['colors']*4));
	}

	//4 : Cr?ation de l'image
	$IMG = fread($f1,$BMP['size_bitmap']);
	$VIDE = chr(0);

	$res = imagecreatetruecolor($BMP['width'],$BMP['height']);
	$P = 0;
	$Y = $BMP['height']-1;
	while ($Y >= 0)
	{
		$X=0;
		while ($X < $BMP['width'])
		{
			if ($BMP['bits_per_pixel']== 24)
				$COLOR = unpack("V",substr($IMG,$P,3).$VIDE);
			elseif ($BMP['bits_per_pixel']== 16)
			{		
				$COLOR = unpack("n",substr($IMG,$P,2));
				$COLOR[1]= $PALETTE[$COLOR[1]+1];
			}
			elseif ($BMP['bits_per_pixel']== 8)
			{		
				$COLOR = unpack("n",$VIDE.substr($IMG,$P,1));
				$COLOR[1]= $PALETTE[$COLOR[1]+1];
			}
			elseif ($BMP['bits_per_pixel']== 4)
			{
				$COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
				if (($P*2)%2 == 0) 
					$COLOR[1]=($COLOR[1] >> 4); 
				else 
					$COLOR[1]=($COLOR[1] & 0x0F);
				$COLOR[1]= $PALETTE[$COLOR[1]+1];
			}
			elseif ($BMP['bits_per_pixel']	== 1)
			{
				$COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
				if(($P*8)%8 == 0) $COLOR[1]= $COLOR[1]				>>7;
				elseif (($P*8)%8 == 1) $COLOR[1]=($COLOR[1]& 0x40)>>6;
				elseif (($P*8)%8 == 2) $COLOR[1]=($COLOR[1]& 0x20)>>5;
				elseif (($P*8)%8 == 3) $COLOR[1]=($COLOR[1]& 0x10)>>4;
				elseif (($P*8)%8 == 4) $COLOR[1]=($COLOR[1]& 0x8)>>3;
				elseif (($P*8)%8 == 5) $COLOR[1]=($COLOR[1]& 0x4)>>2;
				elseif (($P*8)%8 == 6) $COLOR[1]=($COLOR[1]& 0x2)>>1;
				elseif (($P*8)%8 == 7) $COLOR[1]=($COLOR[1]& 0x1);
				$COLOR[1]= $PALETTE[$COLOR[1]+1];
			}
			else
				return FALSE;
			imagesetpixel($res,$X,$Y,$COLOR[1]);
			$X++;
			$P += $BMP['bytes_per_pixel'];
		}
		$Y--;
		$P+=$BMP['decal'];
	}

	//Fermeture du fichier
	fclose($f1);

	return $res;
}



}


?>
