<?php



define('EMAIL_SUBJECT','Подтверждение регистрации');



$REG_ERRORS[1]='<font class=error_reg_message><b class=error_reg>Ошибка:</b> Не все необходимые поля заполнены</font>';

$REG_ERRORS[2]='<font class=error_reg_message><b class=error_reg>Ошибка:</b> Неверный формат файла</font>';

$REG_ERRORS[3]='<font class=error_reg_message><b class=error_reg>Ошибка:</b> Файл слишком большой</font>';

$REG_ERRORS[4]='<font class=error_reg_message><b class=error_reg>Ошибка:</b> Пользователь с таким логином уже существует</font>';

$REG_ERRORS[5]='<font class=error_reg_message><b class=error_reg>Ошибка:</b> Неверно введет код антиспам</font>';



define('ACTIVATION_SUCCESS','Активация успешна!<br>Можете войти под своим логином');

define('ACTIVATION_FAILED','Неверный код активации');



define('REGISTRATION_BUTTON_TITLE','Зарегистироваться');



define('REMIND_BUTTON_TITLE','Выслать пароль');

define('BAD_EMAIL','В базе нет такого EMAIL. Проверьте правильность ввода');

define('REMIND_LETTER',"Вы запросили восстановление пароля\nВаш логин - #login\nВаш пароль - #pass");

define('REMIND_SUBJECT','Восстановление пароля');

define('REMIND_SEND','Письмо с паролем выслано, проверьте почту');

















$reg_content='';



if ($_GET['reg']==1)

{

$form_id=afetchrowset(mysql_query("SELECT * FROM `cms_auth_reg_settings` WHERE `name` = 'form_id'"));

$form_id=$form_id[0]['value'];



$form=afetchrowset(mysql_query("SELECT * FROM `cms_forms` WHERE `form_id` = '".$form_id."'"));

$form=$form[0];



$fields=afetchrowset(mysql_query("SELECT * FROM `cms_forms_fields` WHERE `form_id` = '".$form_id."' ORDER BY `id` ASC"));



//debug($fields);

//die();



$error=0;



$login_id=afetchrowset(mysql_query("SELECT * FROM `cms_auth_reg_settings` WHERE `name` = 'field_login_id'"));

$login_id=$login_id[0]['value'];



$e=afetchrowset(mysql_query("SELECT * FROM `cms_auth_settings` WHERE `name` = 'email_enter'"));

$email['needed']=$e[0]['value'];

$e=afetchrowset(mysql_query("SELECT * FROM `cms_auth_settings` WHERE `name` = 'email_anchor'"));

$email['marker']=$e[0]['value'];

$e=afetchrowset(mysql_query("SELECT * FROM `cms_auth_settings` WHERE `name` = 'email_text'"));

$email['text']=$e[0]['value'];



$email_id=afetchrowset(mysql_query("SELECT * FROM `cms_auth_reg_settings` WHERE `name` = 'field_email_id'"));

$email_id=$email_id[0]['value'];



$repeat=afetchrowset(mysql_query("SELECT * FROM `cms_auth_users` WHERE `".$login_id."` = '".$_POST['field_'.$login_id]."'"));

if ($repeat!=false) $error=4;



$_SESSION['error_message']='';





$sql="insert into cms_auth_users values ('','".($email['needed']==0?'1':'0')."',";



//debug($fields);

//debug($_POST);



foreach($fields as $field)

{

if ($error) break;

$fid=$field['id'];

$type=$field['type'];

$misc=$field['misc'];

$nec=$field['necessary'];



if ($type!=8 && $type!=6)

{

  if(!isset($_POST['field_'.$fid])) continue;

  if($_POST['field_'.$fid]=="" && $nec==1)

  {

    $error=1;

    break;

  }

  $sql.='\''.mysql_escape_string($_POST['field_'.$fid]).'\',';

}

/////////

if ($type==6)

{

  if(!isset($_POST['field_'.$fid]) || $_POST['field_'.$fid]=='' || $_SESSION['captcha_code']=='')

  {

    $error=5;

    break;

  }

  if ($_POST['field_'.$fid]!=$_SESSION['captcha_code'])

  {

    $error=5;

    break;

  }

}

/////////

if ($type==8)

{

    $misc=unserialize($misc);

    $misc[0]=explode(";",$misc[0]);

    $misc[1]=explode("x",$misc[1]);



    $file=$_FILES['field_'.$fid];



    if ($file['name']!="")

    {

      if ($file['size']>$misc[2])

      {

        $error=3;

        break;

      }

      $new_name="";

      $extension = addslashes($file['name']);

      $start=0;

      for ($x=strlen($extension)-1;$x>0; $x=$x-1)

      {

        $start=$start+1;

        if ($extension[$x]==".") {break;}

      }

      $extension=substr($extension,-$start+1);

      $flag=0;

      for($j=0;$j<sizeof($misc[0]);$j++)$flag+=(strtolower($misc[0][$j])==strtolower($extension));

      if ($flag==0)

      {

        $error=2;

        break;

      }

      $new_name=md5($id.'_'.time().'_'.mt_rand()).'.'.strtolower($extension);

      if(move_uploaded_file($file['tmp_name'],"../cms_uploads/users/$new_name"))

      {

        imgresize("../cms_uploads/users/$new_name", "../cms_uploads/users/$new_name",$misc[1][0],$misc[1][1],100,0xFF5800);

        $sql.='\''.$new_name.'\',';

      }

    }

    else

    {

      if ($nec==1)

      {

        $error=1;

        break;

      }

      else

      {

        $sql.='\'\',';

      }

    }

}

}





$sql=substr($sql,0,strlen($sql)-1);

$sql.=');';



//debug($error);

//debug($sql);

//die();



if ($error==0)

{

  mysql_query($sql);

  $user_id=mysql_insert_id();

  if ($email['needed']==1)

  {

    $code='';

    $auth_table=nfetchrowset(mysql_query("SHOW COLUMNS FROM cms_auth_users")); 

    foreach($auth_table as $item)$code.=$item[0].$user_id;

    $code=md5($code);

    $link='http://'.$_SERVER['HTTP_HOST'].'/'.$page['file_name'].'.php?reg=2&user_id='.$user_id.'&code='.$code;

    $email['text']=str_replace($email['marker'],$link,$email['text']);

    $to=$_POST['field_'.$email_id];

    mail($to,EMAIL_SUBJECT,$email['text']);

  }

  $reg_content=$form['success_message'];

}

else

{

  $_SESSION['error_message']=$REG_ERRORS[$error];

}



}

///////////////////////////////////////////////////////

if ($_GET['reg']==2)

{ //Подтверждение регистрации

  $_code='';

  $user_id=(int)$_GET['user_id'];

  $auth_table=nfetchrowset(mysql_query("SHOW COLUMNS FROM cms_auth_users")); 

  foreach($auth_table as $item)$_code.=$item[0].$user_id;

  $_code=md5($_code);



  if ($_code==$_GET['code'])

  {

    $sql="UPDATE cms_auth_users SET `confirmed` = 1 WHERE `id` = '".$user_id."'";

    mysql_query($sql);

    $reg_content=ACTIVATION_SUCCESS;

  }

  else

  {

    $reg_content=ACTIVATION_FAILED;

  }

}

///////////////////////////////////////////////////////

if ($_GET['reg']==3)

{ //Напоминание пароля

@$mode=(int)$_GET['remind_mode'];



if ($mode==0)

{

  $reg_content.='<table cellpadding=0 cellspacing=5 border=0 width=10%>

  <form action="'.$page['file_name'].'.php?reg=3&remind_mode=1" method=POST>';

  $reg_content.="<tr><td><div class=\"reg_description\"><nobr>Введите EMAIL</nobr></div></td><td width=100% class=reg_input><input class=form_element type=text name=\"email\"></td></tr>"; 

  $reg_content.='<tr>

  <td></td>

  <td class=reg_submit colspan=2><input type="submit" value="'.REMIND_BUTTON_TITLE.'"></td>

  </tr>

  </form>

  </table>';

}

else

{

  $email=mysql_escape_string($_POST['email']);

  $email_id=afetchrowset(mysql_query("SELECT * FROM `cms_auth_reg_settings` WHERE `name` = 'field_email_id'"));

  $email_id=$email_id[0]['value'];



  $user=afetchrowset(mysql_query("SELECT * FROM cms_auth_users WHERE `".$email_id."` = '".$email."'"));



  if ($user==false)

  {

    $reg_content=BAD_EMAIL;

  }

  else

  {

    $user=$user[0];

    $login_id=afetchrowset(mysql_query("SELECT * FROM `cms_auth_reg_settings` WHERE `name` = 'field_login_id'"));

    $login_id=$login_id[0]['value'];

    $pass_id=afetchrowset(mysql_query("SELECT * FROM `cms_auth_reg_settings` WHERE `name` = 'field_password_id'"));

    $pass_id=$pass_id[0]['value'];

    $login=$user[$login_id];

    $pass=$user[$pass_id];

    $text=REMIND_LETTER;

    $text=str_replace("#login",$login,$text);

    $text=str_replace("#pass",$pass,$text);

    mail($email,REMIND_SUBJECT,$text);

    $reg_content=REMIND_SEND;

  }

}



}

////////////////////////////////////////////////

$x=strlen($page['title'])*13;

$x=$x.'px';



$y=top_menu($page_id);



$content=str_replace('#menu#',$y,$content);

$content=str_replace('#menu_2#',$menu_2,$content);

$content=str_replace('#title',$page['title'],$content);



$content=draw_blocks($content,$page_id);

$content=draw_forms($content, $page_id);

//$content=draw_vote($content, $page_id);







if ($page['page_status']==1) 

  $reg_content='В данный момент содержание страницы недоступно. Ведутся технические работы.';	



if ($page['group_visible']==1 && !isset($_SESSION['authorized'])) 

  $reg_content='Содержание страницы доступно только зарегистрированным пользователям.';	





if ($reg_content=='')

{

$form_id=afetchrowset(mysql_query("SELECT * FROM `cms_auth_reg_settings` WHERE `name` = 'form_id'"));

$form_id=$form_id[0]['value'];



$form=afetchrowset(mysql_query("SELECT * FROM `cms_forms` WHERE `form_id` = '".$form_id."'"));

$form=$form[0];



$fields=afetchrowset(mysql_query("SELECT * FROM `cms_forms_fields` WHERE `form_id` = '".$form_id."' ORDER BY `position` ASC"));





$reg_content.=$_SESSION['error_message'].'<br>';



$reg_content.='<table cellpadding=0 cellspacing=5 border=0 style="width:'.$form['form_width'].'px;height:'.$form['form_height'].'px">

<form action="'.$page['file_name'].'.php?reg=1" method=POST enctype="multipart/form-data">';

if($form['title']!="")

  $reg_content.="<tr><td colspan=2><div class=\"reg_title\"><nobr>".$form['title']."</nobr></div></td></tr>";



foreach($fields as $field)

{

$name='field_'.$field['id'];

$description=$field['description'];

$description.= $field['necessary']==1?'&nbsp;<font color=red>*</font>':'';

$type=$field['type'];

$misc=$field['misc'];



if ($type==0)

{

$reg_content.="<tr><td><div class=\"reg_description\"><nobr>$description</nobr></div></td><td width=100% class=reg_input><input class=form_element style=\"width:100%\" type=text name=\"".$name."\"></td></tr>"; 

}

if ($type==1)

{

$reg_content.="<tr><td><div class=\"reg_description\"><nobr>$description</nobr></div></td><td width=100%><textarea \"width:100%\" class=form_element type=text name=\"$name\"></textarea></td></tr>"; 

}

if ($type==2)

{

$reg_content.="<tr><td><div class=\"reg_description\"><nobr>$description</nobr></div></td><td width=100% class=reg_input><input class=form_element type=hidden name=\"$name\" value=\"off\"><input type=checkbox name=\"$name\"></td></tr>";

}

if ($type==3)

{

$items=explode("\r\n",$misc);

$reg_content.="<tr><td><div class=\"reg_description\"><nobr>$description</nobr></div></td><td><select \"width:100%\" class=form_element name=\"$name\" class=\"select_form\">";

for($j=0;$j<sizeof($items);$j++)

  $reg_content.="<option>".$items[$j]."</option>"; 

$reg_content.="</select></td></tr>";

}

if ($type==4)

{

$reg_content.="<tr><td colspan=\"2\"><div class=\"reg_text_marker\"><nobr>$misc</nobr></div></td></tr>";   

}

if ($type==5)

{

$reg_content.="<tr><td colspan=\"2\"><div class=\"reg_text_image\"><img src=\"$misc\"></div></td></tr>";   

}

if ($type==6)

{

$reg_content.="<tr><td colspan=\"2\" align=right><table cellpadding=0 cellspacing=0 border=0><tr><td colspan=2 align=right><div class=\"reg_description\"><br>$description<br></div></td></tr><tr><td align=right><img src=\"admin/modules/forms/captcha.php\"></td><td style=\"padding-left:10px;width:100%\"><div class=\"reg_description\"><input style=\"width:100%\" class=form_element type=text name=\"$name\" value=\"\"></div></td></table></td></tr>";   

}

if ($type==7)

{

$reg_content.="<tr><td colspan=\"2\"><div class=\"reg_input\"><input type=submit class=submit value=\"$misc\"></div></td></tr>";   

}

if ($type==8)

{

$reg_content.="<tr><td><div class=\"reg_description\"><nobr>$description</nobr></div></td><td width=100% align=right><div class=\"reg_description\"><input type=file style=\"width:100%\" name=\"".$name."\"></div></td></tr>";   

}

if ($type==9)

{

$reg_content.="<tr><td colspan=2 width=100%><div class=\"reg_input_image\"><input type=image style=\"border:0px\" src=\"$misc\"></div></td></tr>";   

}





}



$reg_content.='

</form>

</table>';

}



$content=str_replace('#reg',$reg_content,$content);



?>