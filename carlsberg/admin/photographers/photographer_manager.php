<?php
require_once "../dbaccessor.php";
error_reporting(E_ALL);
ini_set('display_errors','off');
class PhotographerManager extends DBAccessor {
	
	function __construct() {	
		parent::__construct();				
	}
	
	function getPhotographers() {		
		$dir = $this->getString('dir');
		 if(!$dir) {
		 	$_REQUEST['dir'] = 'DESC';
		 }
		 $email_photographer = $this->getString('email_photographer');
		 $city_photographer = $this->getString('city_photographer');
		 $login_photographer = $this->getString('login_photographer');
		 $uin_photographer  = $this->getString('uin_photographer');

		 $condition = '';
		 if ($email_photographer)
		 {
		 	$condition .= " and `email` like '%{$email_photographer}%'";
		 }

	 	if ($city_photographer)
		{
			$condition .= " and `city` like '%{$city_photographer}%'";
		}
	   
	    if ($login_photographer)
		{
			$condition .= " and `Username` like '%{$login_photographer}%'";
		}

	   	if ($uin_photographer)
		{
		  	$uin_photographer = str_replace(' ','',$uin_photographer);
		   	$condition .= " and INSTR('{$uin_photographer}',REPLACE(UIN, ' ', '')) > 0";
		}
				    
		 $query = "SELECT SQL_CALC_FOUND_ROWS `id`, `Username`, `Name`, `Surname`, `email`, `Phone`, `city`, `account`,
		  		  IF (`pict` not like '' ,CONCAT ('../', CONCAT(`path`,`pict`)),'') as logo, `UIN` FROM `users_enc` where `id` <> 0 {$condition}";
		 $this->executeListQuery($query);
	}
	
	function savePhotographers() {
		$id = $this->getInt('id');
		
		$Username = $this->getString('Username');
		$UIN = $this->getString('UIN');
		$email = $this->getString('email');
		$Name = $this->getString('Name');
		$Surname = $this->getString('Surname');
		$Phone = $this->getString('Phone');
		$city = $this->getString('city');
		$account = $this->getString('account');

		if($id) 
		{
			$query = "UPDATE users_enc SET Username='$Username', account = '$account', UIN='$UIN', email='$email', Name='$Name', Surname='$Surname', " .
				  	  "Phone='$Phone', city = '$city' WHERE id=$id";
		}
		$result = $this->execute($query);		
		if($result['result'] == 'success') {
			echo '1';
		} else {
			echo '0';
		}
		
	}
	
	function editPhotographers() {
		$id = $this->getInt('id');
		
		$query = "SELECT `id`, `Username`, `UIN`, `email`, `Name`, `Surname`,  `Phone`, `city`,`account`
				FROM `users_enc` WHERE id = $id";
		$result = $this->getAssoc($query);
		echo json_encode($result);		
	}
	
	function deletePhotographers() {
		$ids = $this->getString('ids');
		include_once "./../../operation_with_files.php";
		$image_query = "SELECT path FROM users_enc WHERE id IN ($ids)";
		$images = $this->getAssocList($image_query);
		for($i = 0; $i < count($images); $i++) {
			$images[$i]['path'] = str_replace (array('avatar/','./'),array('',''),$images[$i]['path']);
			if ($images[$i]['path'])
			{
				$logo =  $_SERVER['DOCUMENT_ROOT'].'/'.$images[$i]['path'];
				if(file_exists("{$logo}.htaccess"))
				{
					unlink("{$logo}.htaccess");	
				}
				removeDirectory($logo);
			}
		}		
		$query = "DELETE FROM users_enc WHERE id IN ($ids)";
		$result = $this->execute($query);
		$query = "DELETE FROM `cms2_comment` WHERE id_author IN ($ids)";
		$result = $this->execute($query);
		$query = "DELETE FROM `cms2_photo` WHERE id_author IN ($ids)";
		$result = $this->execute($query);
		$query = "DELETE FROM `cms2_album` WHERE id_autor_album IN ($ids)";
		$result = $this->execute($query);

		if($result['result'] == 'success') {
			echo '1';
		} else {
			echo '0';
		}
	}
	
}

?>
