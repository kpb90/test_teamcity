<?php
/*
Created by Intraseti (http://www.intraseti.ru)
 */
include_once "../dbaccessor.php";

class UserManager extends DBAccessor {
	 
	function __construct() {	
		parent::__construct();				
	}
	
	function __destruct() {		
		parent::__destruct();	
	}	
	 
	function login() 
	{
		$login = trim($this->getString('login'));

		if($login == 'yorkhova' || $login == 'andreichuk_se1' || $login == 'demo' || $login == 'm.d.garmony' || $login == 'tokko' || $login == 'talyar')
		{
			echo json_encode(array('result' => 0));
			exit;
		}

		$pwd = trim($this->getString('pwd'));

		$query = "SELECT u.`id`, u.`Username`, u.`name`, u.`phone`, u.`email`, u.`password`, u.`User_hash`, u.`level`,u.`role`, u.`manager`, u.`g_latin`, u.`type`,
					if (u.g_latin<>'/' , 
   	    							(select f.id from cms2_factories_carslberg as f where f.g2_latin = u.g_latin limit 1),
   	    							id_factory) as factory,
 				   (SELECT uu.`email` FROM `users_enc` as uu  WHERE u.`manager` = uu.`id` limit 1) as manager_email,
				   (SELECT uu.`name` FROM `users_enc` as uu  WHERE u.`manager` = uu.`id` limit 1) as manager_name	  
					FROM users_enc as u" .
				" WHERE Username = '$login' AND password = '$pwd' ";

		$userInfo = $this->getAssoc($query);		
		if ($userInfo['factory']==ALL_FACTORY) {
			$userInfo['factory'] = 'Восток-Сервис';
		} else if ($userInfo['factory']==HEADQUARTERS) {
			$userInfo['factory'] = 'Штаб квартира Carlsberg';
		} else {
			$query  = " SELECT * FROM `cms2_factories_carslberg` where id = {$userInfo['factory']}";
			$factoryInfo = $this->getAssoc($query);		
			$userInfo['factory'] = $factoryInfo ['gtitle'].($factoryInfo ['subgtitle'] ? " / {$factoryInfo ['subgtitle']}" : '');
		}

		$result = array(); 
		if($userInfo) {			
			$_SESSION['auto_user'] = $userInfo;
			$result['result'] = 1;	
			$result['level'] = $userInfo['level'];	
			$result['role'] = $userInfo['role'];					
		} else {
			$result['result'] = 0;			
		}
		echo json_encode($result);

	}
	
	function changePassword() {
		$id = $this->getInt('id');
		$pwd = $this->getString('pwd');
		
		$query = "UPDATE users_enc SET password = '$pwd' WHERE id = $id";		
		$result = $this->execute($query);
		echo json_encode($result);	
	}
	
	function getUsers() {
		$condition = " where role <> 1 ";
		if ($_SESSION['auto_user']['role']==OM) {
			$condition .= " and manager like '{$_SESSION['auto_user']['id']}' ";
		} else if ($_SESSION['auto_user']['role']==MANAGER_CARSLBERG) {
			$condition = " where role <> ".SUPER_ADMIN." and role <> ".MVS;
		}
 	
 		$name = $this->getString('name_filter');
		$phone = $this->getString('phone_filter');
		$email = $this->getString('email_filter');		

	 	if ($name)
		{
			$condition .= " and u.name like '%{$name}%'";
		}
	   
	    if ($phone)
		{
			$condition .= " and u.phone like '%{$phone}%'";
		}

		if ($email)
		{
			$condition .= " and u.email like '%{$email}%'";
		}

   	    $query = "SELECT SQL_CALC_FOUND_ROWS u.*, '' as password,
   	    		if (u.g_latin<>'/' , 
   	    							(select f.id from cms2_factories_carslberg as f where f.g2_latin = u.g_latin limit 1),
   	    							id_factory) as factory
		 		  FROM `users_enc` as u
		 		  {$condition}";
		$this->wrp_log_history (array ('type_query'=>'executeListQuery', 'query' => $query));
	}
	
	function saveUsers() {
		$id = $this->getInt('id');
		$name = $this->getString('name');
		$Username = $this->getString('Username');
		$phone = $this->getString('phone');
		$email = $this->getString('email');
		$password = $this->getString('password');
		$date_create_user = date("Y-m-d H:i:s");
		$query = "SELECT  u.id
		 		  FROM `users_enc` as u
		 		  where Username = '{$Username}' and id <> {$id}";

		$exist_user = $this->wrp_log_history (array ('type_query'=>'getAssoc', 'query' => $query, 'descr_query' =>'Проверка есть ли такой логин в бд'));
		if ($exist_user) {
			echo '-121';
			return;
		}
		
		$manager = $manager2 = false;
		$role = false;
		$level = false;

		if (isset($_REQUEST['manager'])) {
			$manager = $this->getInt('manager');
		} else {
			if ($_SESSION['auto_user']['role']==OM) {
				$manager = $_SESSION['auto_user']['id'];
			}
		}

		if (isset($_REQUEST['manager2'])) {
			$manager2 = $this->getInt('manager2');
		}

		if (isset($_REQUEST['role'])) {
			$role = $this->getInt('role');
		}

		if (isset($_REQUEST['factory'])) {
				$factory = $this->getString('factory');
				
				if ($factory == ALL_FACTORY || $factory == HEADQUARTERS) {
					$g_latin = '/';
					$level = 1;
				} else {
					$query = "select * from cms2_factories_carslberg where id = {$factory}";
					$info_factory =  $this->wrp_log_history (array ('type_query'=>'getAssoc', 'query' => $query));
					$g_latin = $info_factory['g2_latin'];
					$level = substr_count($g_latin, '/');
				}
		}

		if ($_SESSION['auto_user']['role']==SUPER_ADMIN || $_SESSION['auto_user']['role']==MVS) {
		// проверяем правильно ли для пользователя назначили завод
			if ($role == PS) {
				 $query_url_manager_factory = "SELECT u.`g_latin`, (select f.`gtitle` from cms2_factories_carslberg as f where INSTR(f.`g2_latin`, u.`g_latin`) > 0 limit 1) as gtitle FROM `users_enc` as u WHERE u.id = {$manager} limit 1";
				 $url_manager_factory = $this->wrp_log_history (array ('type_query'=>'getAssoc', 'query' => $query_url_manager_factory, 'descr_query' =>'Проверяем правильно ли для пользователя назначили завод'));

				 if ( $url_manager_factory) {
		 	 	 	if (strpos ($g_latin, $url_manager_factory['g_latin'])===false) {
						//echo '::error::Для выбранного менеджера можно выбрать только завод и цеха '.$url_manager_factory['gtitle'];
						//return;
		 	 	 	}
				 }

			} else if ($role == OM) {
				// для ответственного менеджера может быть назначен только завод
				if ($level != 2) {
						//echo '::error::Для ответственного менеджера может быть назначен только завод (а не цех завода)';
						//return;
				}
			}
		}

		if($id) {
			$query = "UPDATE users_enc SET id_factory = '$factory', password = '$password', name='$name', Username='$Username', phone='$phone', email = '$email'
				".($manager === false ? '' : " , manager = '$manager'").($manager2 === false ? '' : " , manager2 = '$manager2'").($role === false ? '' : " , role = '$role'").($level === false ? '' : " , level = '$level', g_latin = '$g_latin'")."
			WHERE id=$id";
		} else {

			$query_ins_opt =($manager === false ? '' : ", manager").($manager2 === false ? '' : ", manager2").($role === false ? '' : ", role").($level === false ? '' : ", level, g_latin");
			$query_ins_val =($manager === false ? '' : ", '$manager'").($manager2 === false ? '' : ", '$manager2'").($role === false ? '' : ", '$role'").($level === false ? '' : ", '$level', '$g_latin'");

			$query = "INSERT INTO users_enc(id_factory, password, name, Username, phone, email, `date` {$query_ins_opt}) " .
					 "VALUES('$factory', '$password', '$name', '$Username', '$phone', '$email', '$date_create_user' {$query_ins_val})";
		}
		$result = $this->wrp_log_history (array ('type_query'=>'execute', 'query' => $query));
		if($result['result'] == 'success') {
			echo '1';
		} else {
			echo '0';
		}
	}
	
	function editUsers() {
		$id = $this->getInt('id');

		$query = "SELECT  u.*, u.password as repeat_password,
					if (u.g_latin<>'/' , 
	   	    							(select f.id from cms2_factories_carslberg as f where f.g2_latin = u.g_latin limit 1),
	   	    							if (id_factory = ".ALL_FACTORY.", ".ALL_FACTORY.", ".HEADQUARTERS.")
	   	    			) as factory
				  FROM users_enc as u WHERE id = $id";
		$result = $this->wrp_log_history (array ('type_query'=>'getAssoc', 'query' => $query));
		echo json_encode($result);		
	}
	
	function deleteUsers() {
		$logged_user = $_SESSION['auto_user']['id'];
		$ids = $this->getString('ids');
		$query = "DELETE FROM users_enc WHERE id IN ($ids) and id <> $logged_user";
		$this->addToLog('delete users: ' . $query);
		$result = $this->wrp_log_history (array ('type_query'=>'execute', 'query' => $query));
		if($result['result'] == 'success') {
			echo '1';
		} else {
			echo '0';
		}
	}
}
?>