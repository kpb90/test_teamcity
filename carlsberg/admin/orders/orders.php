<?php
/*
Created by Intraseti (http://www.intraseti.ru)
 */
require_once "../dbaccessor.php";
include_once "{$_SERVER['DOCUMENT_ROOT']}/const.php";
include_once "{$_SERVER['DOCUMENT_ROOT']}/carlsberg_function.php";
class OrderManager extends DBAccessor {
	 
	function __construct() {	
		parent::__construct();				
	}
	
	function __destruct() {		
		parent::__destruct();	
	}	
	 
	function getOrders() {
		$dir = $this->getString('dir');
		$sort = $this->getString('sort');
		 if(!$dir) {
		 	$_REQUEST['dir'] = 'ASC';
		 }
		 if(!$sort) {
		 	$_REQUEST['sort'] = 'id';
		 }

		 $condition = '';

		 if ($_SESSION['auto_user']['role']==OM) {
			$condition .= " and (u.manager like '{$_SESSION['auto_user']['id']}' or user_id like '{$_SESSION['auto_user']['id']}')";
		 } else if ($_SESSION['auto_user']['role']==PS) {
			if ($_SESSION['auto_user']['Username']=='zaytceva_mi')
				$condition .= " and o.currency=1";
			else
				$condition .= " and user_id like '{$_SESSION['auto_user']['id']}'";

		 } else if ($_SESSION['auto_user']['role']==MANAGER_CARSLBERG) {
			$condition .= " and (u.role <> ".SUPER_ADMIN." and u.role <> ".MVS.")";
		}

		$number = $this->getInt('number_filter');
		$start = $this->getString('start_filter');
		$end = $this->getString('end_filter');
		$name = $this->getString('name_filter');
		$phone = $this->getString('phone_filter');
		$email = $this->getString('email_filter');		

		if ($number) {
		 	$condition .= " and o.`id` = '{$number}'";
		}

	 	if ($start) {
			$start = preg_replace("/(\d\d\d\d)-(\d\d)-(\d\d)/","$1$2$3",substr ($start,0,10));
			$condition .= " and  DATEDIFF (o.`date`,'{$start}')>=0";
		}
	   
	    if ($end) {
			$end = preg_replace("/(\d\d\d\d)-(\d\d)-(\d\d)/","$1$2$3",substr ($end,0,10));
			$condition .= " and  DATEDIFF (o.`date`,'{$end}')<=0";
		}

	 	if ($name) {
			$condition .= " and u.name like '%{$name}%'";
		}
	   
	    if ($phone) {
			$condition .= " and u.phone like '%{$phone}%'";
		}

		if ($email)	{
			$condition .= " and u.email like '%{$email}%'";
		}

		$query = "SELECT SQL_CALC_FOUND_ROWS o.*, 
		if (o.currency='','руб.','BYR') as currency,
		 				  u.name as customer_name, u.phone as  customer_phone, concat ('<a target = \"_blank\" href = \"mailto:',u.email,'\">',u.email,'</a>') as customer_email,
		 				  ot.text as text_order,
		 				  uu.name as manager_name, concat ('<a target = \"_blank\" href = \"mailto:',uu.email,'\">',uu.email,'</a>') as manager_email,
		 				  if (u.g_latin<>'/' , 
   	    							(select f.id from cms2_factories_carslberg as f where f.g2_latin = u.g_latin limit 1),
   	    							u.id_factory) as factory
		 		   FROM cms2_orders_carslberg as o inner join  `users_enc` as u on o.user_id = u.id
		 		   left join  `users_enc` as uu on u.manager = uu.id
		 		   						left join cms2_orders_carslberg_text as ot on o.text_id = ot.id
		 		   	where 1 {$condition} ";
		//echo '<!--' . $query . '-->';	
		 $this->wrp_log_history (array ('type_query'=>'executeListQuery', 'query' => $query));
	}
	
	
	function deleteOrders() {
		$ids = $this->getString('ids');
		$query = "DELETE FROM cms2_orders_carslberg  WHERE id IN ($ids)";
		$result = $this->wrp_log_history (array ('type_query'=>'execute', 'query' => $query));
	
		if($result['result'] == 'success') {
			echo '1';
		} else {
			echo '0';
		}
	}

	function saveOrders() {

		if ($_SESSION['auto_user']['Username']=='zaytceva_mi')
		{
			$status_OM_id = $this->getInt('status_OM_id');
			if($status_OM_id != ORDER_GOODS_RECEIVED && $status_OM_id != ORDER_GOODS_RECEIVED_NOT_FULL)
			{
				echo '0';	
				return;
			}
		}

		$id_order = $this->getInt('id');
		$price = $this->getString ('price');
		$text_order = $_REQUEST['text_order'];
		$status_MVS_id = false;
		$status_OM_id = false;
		$new_id_text = false;

		if (isset($_REQUEST['status_MVS_id'])) {
			$status_MVS_id = $this->getInt('status_MVS_id');
		}

		if (isset($_REQUEST['status_OM_id'])) {
			$status_OM_id = $this->getInt('status_OM_id');
		}

		if($id_order) {
			$query_prev_text = "SELECT ot.`text`, ot.`id` FROM `cms2_orders_carslberg_text` as ot
					 WHERE ot.id like 
					(select o.text_id from  `cms2_orders_carslberg` as o where o.id = {$id_order} limit 1)";
			$prev_text_order = $this->getAssoc($query_prev_text);
			$old_id_text = $prev_text_order['id'];
			$prev_text_order = $prev_text_order['text'];
			$date_change_order = date("Y-m-d H:i:s");
			if ($text_order!=$prev_text_order) {
				$t_text_order = trim(strip_tags(str_replace(array("\n","\r","\t",' '), array('','','',''),$text_order)));
				$t_prev_text_order = trim(strip_tags(str_replace(array("\n","\r","\t",' '), array('','','',''),$prev_text_order)));
				if ($t_text_order!=$t_prev_text_order) {
					$query_insert_text = "INSERT INTO `cms2_orders_carslberg_text`(`text`, `date`) VALUES ('{$text_order}','{$date_change_order}')";
					$new_id_text = $this->wrp_log_history (array ('type_query'=>'createRecord', 'query' => $query_insert_text , 'action_history' => 'user_change_text', 'date_change_order' => $date_change_order, 'id_order' => $id_order, 'old_id_text' => $old_id_text));
				}
			} 

			$query_prev_info_of_orders = "SELECT `id`, `user_id`, `status_MVS_id`, `status_OM_id`, `date`, `text_id`, `price`, `history_log`,
											(select u.email from `users_enc` as u where u.id = `user_id` limit 1) as user_email,
											(select u.role from `users_enc` as u where u.id = `user_id` limit 1) as user_role,
											(select uu.email from `users_enc` as uu where uu.id = (select u.manager from `users_enc` as u where u.id = `user_id` limit 1)) as manager_email
										 FROM `cms2_orders_carslberg` WHERE id = {$id_order}";
			$prev_info_order = $this->getAssoc($query_prev_info_of_orders);
			$query = "UPDATE `cms2_orders_carslberg` SET `price` = '$price'".($status_MVS_id === false ? '' : " , `status_MVS_id` = '$status_MVS_id'").($status_OM_id === false ? '' : " , `status_OM_id` = '$status_OM_id'").($new_id_text === false ? '' : " , `text_id` = '$new_id_text'"). 
						"WHERE id=$id_order";


			$email_manager = $prev_info_order ['manager_email'];
			$email = $prev_info_order ['user_email'];
			$comment = $this->getString ('comment_to_status');
			$subj = ($comment ? 'Обратите внимание, есть комментарий! ' : '') . "Изменение статуса заявки №{$id_order}";

			$opt = array ('type_query'=>'execute', 
						 'query' => $query , 
						 'action_history' => 'user_change_status', 
						 'comment_to_status' => $comment,
						 'prev_info_order' => $prev_info_order, 
						 'price' => $price, 
						 'date_change_order' => $date_change_order, 
						 'id_order' => $id_order,
						 'text_order' => $text_order,
						 'header'=> $this->get_header_for_letter ($email_manager),	
						 'subj' => $subj,
						 'email' => $email,
						 'email_manager'=> $email_manager,
						 'email_text'=>'',
						 'send_copy_letter_to_super_admin_and_MVS' => true,
						 'send_copy_letter_to_carlsberg' => $prev_info_order ['user_role'] == MVS ? false : true,
						 'callback_if_change_status' => 'send_letter_carlsberg');
			
			if ($status_MVS_id!==false) {
				$opt['status_MVS_id'] = $status_MVS_id;
			} 

			if ($status_OM_id!==false) {
				$opt['status_OM_id'] = $status_OM_id;
			} 

			$result = $this->wrp_log_history ($opt);
			//$result = $this->execute($query);
			if($result['result'] == 'success') {
				echo '1';
			} else {
				echo '0';
			}
		}	
	}
	
	function editOrders() {
		$id_order = $this->getInt('id');

		 $query = "SELECT SQL_CALC_FOUND_ROWS o.*, u.name as customer_name, u.phone as  customer_phone, u.email as customer_email,
		  		   ot.text as text_order, '' as comment_to_status
		 		   FROM cms2_orders_carslberg as o inner join  `users_enc` as u on o.user_id = u.id
		 		   left join cms2_orders_carslberg_text as ot on o.text_id = ot.id
		 		   where o.id = $id_order";
		$result = $this->getAssoc($query);
		echo json_encode($result);		
	}

	function get_data_for_reject_dialog  ()  {
		return $this->get_data_for_reject_and_approve_dialog ("Отмена заявки");
	}

	function get_data_for_approve_dialog  ()  {
		return $this->get_data_for_reject_and_approve_dialog ("Одобрение заявки");
	}

	function get_data_for_reject_and_approve_dialog  ($text_for_log, $no_json_output=false)  {
	 	if (isset($_REQUEST['user_hash'])&&isset($_REQUEST['manager_hash'])&&isset($_REQUEST['order_hash'])) {
	 		$query = $this->getQueryOfOrderOnTheHash();
	 	} else {
	 		$id = $this->getInt('id');
	 		$query = "SELECT o.`id`, o.`user_id`, o.`status_MVS_id`, o.`status_OM_id`, o.`date`, o.`text_id`, o.`price`, o.`history_log`,
		  		   ot.text as text_order, u.`email` as user_email, u.`role` as user_role,
				   (SELECT uu.`email` FROM `users_enc` as uu  WHERE u.`manager` = uu.`id` limit 1) as manager_email,
				   (SELECT uu.`name` FROM `users_enc` as uu  WHERE u.`manager` = uu.`id` limit 1) as manager_name	  		   		  		   
		 		   FROM cms2_orders_carslberg as o inner join  `users_enc` as u on o.user_id = u.id
		 		   left join cms2_orders_carslberg_text as ot on o.text_id = ot.id
		 		   where o.id = $id";
	 	}

	 	$info_about_order = $this->wrp_log_history(array('type_query'=>'getAssoc', 'query'=> $query,  'descr_query' => "{$text_for_log}: "));
		
		if (!$info_about_order['user_email']) {
			$this->mail_to_admin_big_problem ("Ошибка невозможно определить покупателя. {$text_for_log} не работает".print_r($_SESSION['auto_user'], true).$query);
			echo json_encode(array('text_order' => "Ошибка невозможно определить покупателя!"));
			return 0;
		} 

		if (!$info_about_order['manager_email']) {
			$this->mail_to_admin_big_problem ("Ошибка невозможно определить менеджера. {$text_for_log} не работает".print_r($_SESSION['auto_user'], true).$query);
			echo json_encode(array('text_order' => "Ошибка невозможно определить менеджера! Только менеджер может одобрить заявку!"));
			return 0;
		} 
		
		if ($no_json_output===false) {
			echo json_encode($info_about_order);		
		}
		return $info_about_order;
	}

	function reject_this_order () {
		if (($info_about_order =  $this->get_data_for_reject_and_approve_dialog ("Отмена заявки", true))) {
			$id_order = $this->getInt ('id');
			$comment = $this->getString ('comment');
			$email = $this->getString ('email_user');
			$email_manager = $this->getString ('email_manager');
			$query = "UPDATE `cms2_orders_carslberg` SET `status_OM_id` = ".ORDER_REJECTED." WHERE id=$id_order";
			$subj = "Заявка №{$id_order} отменена";
			$date_change_order = date("Y-m-d H:i:s");
			$email_text = "Заявка № {$id_order} была отменена<br/>
						   ".($comment ? "<b>Комментарий: </b>".$comment:'')."
						   <br><b>Менеджер: </b> {$info_about_order['manager_name']} (<a href = 'mailto:{$info_about_order['manager_email']}'>{$info_about_order['manager_email']}</a>)<hr>{$info_about_order['text_order']}";
			$result = $this->wrp_log_history (array ('type_query'=>'execute', 
													 'query' => $query, 
													 'action_history' => 'user_change_status', 
													 'id_order'=>$id_order, 
													 'comment_reject' => $comment,
													 'header'=> $this->get_header_for_letter ($email_manager),	
													 'subj'=>$subj,
													 'email' => $email,
													 'email_manager' => $email_manager,
													 'email_text'=>$email_text,
													 'send_copy_letter_to_super_admin_and_MVS' => false,
													 'send_copy_letter_to_carlsberg' => $info_about_order ['user_role'] == MVS ? false : true,
													 'callback' => 'send_letter_carlsberg',
													 'date_change_order' => $date_change_order));

			if($result['result'] == 'success') {
				echo '1';
			} else {
				echo '0';
			}
		}
	}

	function set_this_order_approve() {
		if (($info_about_order = $this->get_data_for_approve_dialog())) {
				$id_order = $info_about_order['id'];
				$email =  $info_about_order['user_email'];
				$email_manager = $info_about_order['manager_email'];
				$query = "UPDATE `cms2_orders_carslberg` SET `status_OM_id` = ".ORDER_APPROVED.",apprdate=NOW() WHERE id=$id_order";
				$subj = "Заявка №{$id_order} одобрена";
				$date_change_order = date("Y-m-d H:i:s");
				$email_text = "Заявка № {$id_order} была одобрена<br/> 
							   <b>Менеджер: </b> {$info_about_order['manager_name']} (<a href = 'mailto:{$info_about_order['manager_email']}'>{$info_about_order['manager_email']}</a>)<hr>{$info_about_order['text_order']}";
				
				$result = $this->wrp_log_history (array ('type_query'=>'execute', 
														 'query' => $query, 
														 'action_history' => 'user_change_status',
														 'prev_info_order' => $info_about_order,
														 'status_OM_id' => ORDER_APPROVED, 
														 'id_order'=>$id_order, 
														 'header'=> $this->get_header_for_letter ($email_manager),	
														 'subj'=>$subj,
														 'email' => $email,
														 'email_manager'=> $email_manager,
														 'send_copy_letter_to_extra_MVS' => true,
														 'send_copy_letter_to_super_admin_and_MVS' => true,
														 'send_copy_letter_to_carlsberg' => $info_about_order ['user_role'] == MVS ? false : true,
														 'callback' => 'send_letter_carlsberg',
														 'date_change_order' => $date_change_order,
														 'email_text'=>$email_text));
		}
	}

	function generatePDF() { 
		include_once("orders_pdf.php");
		$id_order = $this->getInt ('id');
		$query = "SELECT SQL_CALC_FOUND_ROWS o.*, u.name as customer_name, u.phone as  customer_phone, u.email as customer_email, u.id_factory as customer_id_factory,
						   u.g_latin, f.gtitle as f_gtitle, f.subgtitle as f_subgtitle, 
						   uu.name as manager_name, uu.id as uu_id,
				  		   ot.text as text_order
				 		   FROM cms2_orders_carslberg as o 
				 		   left join  `users_enc` as u on o.user_id = u.id
				 		   left join  `users_enc` as uu on u.manager = uu.id
				 		   left join cms2_orders_carslberg_text as ot on o.text_id = ot.id
				 		   left join cms2_factories_carslberg as f on f.g2_latin = u.g_latin 
				 		   where o.id = $id_order";
		$info_about_order = $this->wrp_log_history(array('type_query'=>'getAssoc', 'query'=> $query,  'descr_query' => "Получение данных о заявке для PDF: "));
	 	$pdf = new OrderPdf($info_about_order, 'L', 'pt', 'LETTER' );
		$g_pdf = $pdf->create ();
		//print_r($info_about_order);
		echo $info_about_order['id'];
	}

}
?>
