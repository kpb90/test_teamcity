<? session_start(); 

include"functions.php";
dbconnect();

/*phpinfo();
@$action = $_REQUEST['action'] ;
@$login = $_REQUEST['login'] ;
@$password = $_REQUEST['password'] ;

var_dump($_SESSION);
*/

if (!isset($logged_user_id)) {$_SESSION['logged_user_id']="";}
if (!isset($error_message)) {$_SESSION['error_message']="";}
if  (@$action=="login") 
	{
	if ((@$login!="") and (@$password!="")) {
	$select_logged_user=mysql_query("select * from studio_users where login='".$login."' and password='".$password."'");
	$a_s_l_u=mysql_fetch_array($select_logged_user);
	$logged_user_id=$a_s_l_u['user_id'];
		if ($logged_user_id=="") {$err_mes="Неверный логин\пароль. Воспользуйтесь <a onClick=\"document.all.pass_div.style.display='block';\" href=\"#\" class=\"text_links\">формой напоминания пароля</a>
		<div style=\"display:none;height:20px;\" id=\"pass_div\" name=\"pass_div\"><br><br><nobr><form action=\"index.php?action=forgot_password\" style=\"height:20px;margin-bottom:0px;margin-top:0px;\" method=\"post\" id=\"edit_form\" name=\"pass_form_$id\"><div class=\"black_names\">Ваш логин:&nbsp;<input type=\"text\" class=\"normal\" name=\"login\" value=\"$login\">&nbsp;&nbsp;&nbsp;<input type=\"submit\" class=\"submit_button\" value=\"Получить на email\" style=\"width:120px;\"></div></form></nobr></div>";
		}
	}
	else
	{$err_mes="Логин или пароль пуст. Если вы не ваш пароль - воспользуйтесь <a onClick=\"document.all.pass_div.style.display='block';\" href=\"#\" class=\"text_links\">формой напоминания пароля</a><div style=\"display:none;height:20px;\" id=\"pass_div\" name=\"pass_div\"><br><br><nobr><form action=\"index.php?action=forgot_password\" style=\"height:20px;margin-bottom:0px;margin-top:0px;\" method=\"post\" id=\"edit_form\" name=\"pass_form_$id\"><div class=\"black_names\">Ваш логин:&nbsp;<input type=\"text\" class=\"normal\" name=\"login\" value=\"$login\">&nbsp;&nbsp;&nbsp;<input type=\"submit\" class=\"submit_button\" value=\"Получить на email\" style=\"width:120px;\"></div></form></nobr></div>";}
	
	}

if (@$action=="logout") {$logged_user_id="";$module_selected="";}
if (!isset($module_selected)) {$_SESSION['module_selected']="";}
if (isset($m_s) && $m_s!="") {$module_selected=$m_s;}




?>

<html>
<head>
<Title>Система Управления Сайтом &#151; DNK Control</Title>
<Meta Http-equiv="Content-Type" Content="text/html; charset=Windows-1251">
<Meta name="author" Content="DNK">
<Meta name="description" Content="">
<Meta name="keywords" Content="">
<link rel="stylesheet" href="style.css" type="text/css">
<script language="javascript" src="vvv_calendar.js"></script>
</head>
<body bgcolor="#FFFFFF">
<TABLE cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF" height="100%" align="center"> 
<tr valign="top"><td width="100%" height="100%">


<?php
if ($logged_user_id=="") {
print"
<TABLE cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" bgcolor=\"#FFFFFF\" height=\"100%\" align=\"center\"> 
	<tr valign=\"middle\">
		<td width=\"100%\" height=\"100%\" valign=\"middle\" align=\"center\">

			<TABLE cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"670\" height=\"217\" align=\"center\"> 
				<tr valign=\"top\">
					<TD align=\"center\"><center><div class=\"error\" style=\"width:300px;\">$err_mes</div></center></TD>
				</tr>
				<tr valign=\"top\">

					<td width=\"100%\" height=\"100%\" background=\"images/auth.jpg\" style=\"padding-left:300px;padding-top:35px;height:117px;\" align=\"right\">
						<form action=\"index.php?action=login\" method=\"post\" id=\"authform\">
						<table width=\"300\" height=\"40\" cellpadding=\"0\" cellspacing=\"0\">
							<tr>
								<td><div class=\"white_names\" style=\"margin-left:0px;\"><nobr>Логин:</div></td><td style=\"padding-left:20px;\" colspan=\"2\"><div class=\"white_names\" style=\"margin-left:0px;\"><nobr>Пароль:</div></td>
							</tr>
							<tr>
								<td><input type=\"text\" class=\"normal\" style=\"border:0px;width:140px;\" name=\"login\"></td><td style=\"padding-left:20px;\"><input type=\"password\" class=\"normal\" style=\"border:0px;width:140px;\" name=\"password\"></td><td><a href=\"#\" onClick=\"document.all.authform.submit();\"><img src=\"images/px.gif\" width=\"80\" height=\"20\" border=\"0\"></a></td>
							</tr>
						</table>
						</form>
					</td>
				</tr>
				<tr>
					<td width=\"100%\" height=\"100\">&nbsp;
					</td>
				</tr>
			</TABLE>
		</td>
	</tr>
</TABLE>
";
}





if ($logged_user_id!="") {
print"<script language=\"javascript\">
	function confirmDelete(url){
var agree = confirm('Вы уверены что хотите удалить элемент?');
if (agree){
document.location=url;
}
}
function confirmClear(url){
var agree = confirm('Вы уверены что хотите очистить сообщения?');
if (agree){
document.location=url;
}
}
</script>";


print"
<TABLE cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" bgcolor=\"#FFFFFF\" height=\"100%\" align=\"center\"> 
	<tr valign=\"top\">
		<td width=\"233\" bgcolor=\"#E08418\" height=\"100%\"> 
			<TABLE cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"233\" height=\"100%\" align=\"center\"> 
<tr valign=\"middle\"><td height=\"20\" colspan=\"2\" style=\"padding-bottom:14px;\"><img src=\"images/logo.jpg\" border=\"0\"></td></tr>
				
";

$select_menu=mysql_query("select * from studio_modules where include_style='1' order by position");
if ($logged_user_id==1) {$select_menu=mysql_query("select * from studio_modules order by position");}


while ($line_menu=mysql_fetch_array($select_menu)) 
	{
	extract($line_menu);
	if ($directory_title=="start") {$start=$id;}
	if ($id==$module_selected) {$class=" class=left_menu_selected ";} else {$class=" class=left_menu ";}
	print"<tr valign=\"middle\"><td height=\"20\" width=\"20\" style=\"padding-top:7px;padding-bottom:7px;padding-left:20px;\"><img src=\"images/menu_arrow.jpg\"></td><td style=\"padding-top:7px;padding-bottom:7px;padding-left:5px;\" width=\"213\"><a href=\"index.php?m_s=$id\" $class>$menu_title</a></td></tr>";
	}
print"
				<tr>
					<td height=\"100%\" bgcolor=\"#E08418\" colspan=\"2\">&nbsp;</td> 
				</tr>
			</table>
		</td>
		<td width=\"19\" bgcolor=\"#FFFFFF\"><img src=\"images/divider.jpg\" border=\"0\"></td>

		<td width=\"100%\">
			<TABLE cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" bgcolor=\"#FFFFFF\" height=\"100%\" align=\"center\"> 
				<tr valign=\"bottom\">
					<td height=\"78\" width=\"173\" bgcolor=\"#E0E0E0\"><img src=\"images/top_img.jpg\" border=\"0\"></td>
					<td height=\"78\" width=\"*\" bgcolor=\"#E0E0E0\" style=\"padding-bottom:10px;padding-right:25px;\" align=\"right\"><div class=\"top_menu\"><a href=\"../index.php\" class=\"top_menu\">Перейти на сайт</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?m_s=$start\" class=\"top_menu\">В начало</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?action=logout\" class=\"top_menu\">Выход</a></div></td>
				</tr>
				<tr valign=\"top\">
					<td colspan=\"2\" height=\"100%\" style=\"padding-top:30px;padding-left:10px;padding-right:30px;padding-bottom:30px;\">

";

if (!isset($module_selected) or (@$module_selected=="")) 
{	
	$action="";
	include"modules/start/index.php";
}


if ($module_selected!="") 
	{
	$select_module=mysql_query("select * from studio_modules where id='$module_selected'");
	$a_s_m=mysql_fetch_array($select_module);
	$module_directory=$a_s_m['directory_title'];
	
	include"modules/$module_directory/index.php";
	}
print"
					</td>
				</tr>
			</TABLE>
		</td>
	</tr>
</TABLE>
";
}
?>
</td></tr></table>
</BODY>
</HTML>
