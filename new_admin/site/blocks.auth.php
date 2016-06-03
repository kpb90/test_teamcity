<?php
/*
if (isset($_COOKIE['c_login']) && isset($_COOKIE['c_password']) && !(isset($_SESSION['authorized'])))
{
  $login=mysql_escape_string($_COOKIE['c_login']);
  $password=mysql_escape_string($_COOKIE['c_password']);

  $login_id=afetchrowset(mysql_query("SELECT * FROM `cms_auth_reg_settings` WHERE `name` = 'field_login_id'"));
  $login_id=$login_id[0]['value'];

  $pass_id=afetchrowset(mysql_query("SELECT * FROM `cms_auth_reg_settings` WHERE `name` = 'field_password_id'"));
  $pass_id=$pass_id[0]['value'];

  $user=afetchrowset(mysql_query("SELECT * FROM `cms_auth_users` WHERE `".$login_id."` = '".$login."' AND `confirmed` = 1"));

  if ($user!=false)
  {
    $user=$user[0];
    if(md5($user[$pass_id])==$password)
    {
      $_SESSION['authorized']=$user['id'];
      Cook("c_login",$login);
      Cook("c_password",$password);
    }
    else
    {
      Cook("c_login","");
      Cook("c_password","");
    }
  }
  else
  {
      Cook("c_login","");
      Cook("c_password","");
  }
}
*/

$b_title=$block['title'];
$block_template=str_replace('#block_title',$b_title,$block_template);

$table['width']=GetAuthOption('table_width');
$table['height']=GetAuthOption('table_height');
$antispam['state']=GetAuthOption('antispam');
$antispam['time']=GetAuthOption('antispam_time_limit')*60;
$antispam['max_attempts']=GetAuthOption('antispam_attempts');

$form='';
$antispam_flag=0;

if (isset($_SESSION['auth_first_time'])) 
{
  $delta=time()-$_SESSION['auth_first_time'];
  if ($delta<$antispam['time'])
  {
    $num=(int)$_SESSION['auth_count'];
    if ($num>=$antispam['max_attempts'])
    {
      $antispam_flag=1;
    }
  }
  else
  {
    unset($_SESSION['auth_first_time']);
    unset($_SESSION['auth_count']);
  }
}
/*
if (isset($_GET['block_auth']))
{
  $auth_mode=$_GET['block_auth'];
  $error=0;

  if ($antispam_flag==1)
  {
    $code=$_SESSION['captcha_code'];
    $captcha=(int)$_POST['captcha'];
    if ($code=="" || $captcha=="" || $code!=$captcha)
    {
      $error=2;
    }
  }

  if ($auth_mode==1 && $error==0)
  {
    $login=mysql_escape_string($_POST['login']);
    $password=mysql_escape_string($_POST['password']);
    $remember=$_POST['remember']=='off'?0:1;

    $login_id=afetchrowset(mysql_query("SELECT * FROM `cms_auth_reg_settings` WHERE `name` = 'field_login_id'"));
    $login_id=$login_id[0]['value'];

    $pass_id=afetchrowset(mysql_query("SELECT * FROM `cms_auth_reg_settings` WHERE `name` = 'field_password_id'"));
    $pass_id=$pass_id[0]['value'];

    $user=afetchrowset(mysql_query("SELECT * FROM `cms_auth_users` WHERE `".$login_id."` = '".$login."' AND `".$pass_id."` = '".$password."' AND `confirmed` = 1"));

    if ($user!=false)
    {
      $user=$user[0];
      $_SESSION['authorized']=$user['id'];
      if($remember==1)
      {
        Cook("c_login",$login);
        Cook("c_password",md5($password));
      }
      unset($_SESSION['auth_first_time']);
      unset($_SESSION['auth_count']);
    }
    else
    {
      $error=1;
    }
  }  
  if ($auth_mode==2)
  {
    Cook("c_login","");
    Cook("c_password","");    
    $_SESSION['authorized']=0;
    unset($_SESSION['authorized']);
  }
}

*/

$remember=GetAuthOption('remember_login');

if ($error==1)
{
  $form.='Ошибка: Неверные имя пользователя или пароль<br>';
  if ($antispam['state']==1)
  {
    if (!isset($_SESSION['auth_first_time'])) $_SESSION['auth_first_time']=time();
    $num=(int)$_SESSION['auth_count'];
    $_SESSION['auth_count']=++$num;
  }
}
if ($error==2)
{
  $form.='Ошибка: Неверно введен<br>код подтверждения<br>';
}








$form.='<form action="?block_auth=1" method=POST enctype="multipart/form-data">';

$form.='<table height="115" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td colspan="2" class="auth_text" height="15"><h2 class=text>Авторизация</h2><br></td>
	</tr>
	<tr>
		<td colspan="2" height="20"><input type="text" name=login value="Логин" size="25" class="zakinp" style="width:150px;"></td>
	</tr>
	<tr>
		<td colspan="2" height="20"><input type="password" name=password value="Пароль" size="25" class="zakinp" style="width:150px;"></td>
	</tr>';

if ($remember==1)
{
$form.='<tr><H2 class="text">
		<td colspan="2" height="20" class="auth_remember"><input type=hidden name="remember" value="off">
  <input type=checkbox name="remember" style="height:12px;margin-top:5px;margin-left:0px;">&nbsp;Запомнить меня </H2></td>
	</tr>';
}

if ($antispam_flag==1)
{
$form.='<tr>
		    <td colspan="2" height="20" class="auth_text"><img src="/admin/modules/forms/captcha.php"><br>
        <input type="text" name=password value="Сумма чисел на картинке"></td>
      	</tr>';
}

  $reg_page=unserialize($block['content']);
  $reg_page=$reg_page['content'].'.php';


$recover='<a href="'.$reg_page.'?reg=3" class=intext>Вспомнить пароль?</a><br>';

$form.='
<tr>
<td class="auth_text" height="*">';

if (GetAuthOption('email_enter')==1) $form.=$recover;

$form.='<a href="'.$reg_page.'" class=intext>Зарегистрироваться</a></td>
</tr>
<tr>
<td style="padding-top:5px;"><input type="submit" value="Войти" class=zakbtn></td>
</tr>
</table>
</form>';



if (isset($_SESSION['authorized']))
{
$form='
<form action="?block_auth=2" method=POST enctype="multipart/form-data">
<h2 class=text>Вы прошли авторизацию</h2><br>
<input type="submit" value="Выйти" class=zakbtn>
</form>';
}

$block_template=str_replace('#auth',$form,$block_template);

function GetAuthOption($name)
{
  $s=mysql_query("select * from cms_auth_settings where name = '$name'");
  $s=mysql_fetch_row($s);
  return $s[2];
}


?>