<?php

if (@$action=="save_auth")
{

SetOption('auth','table_width',$new_table_width);
SetOption('auth','table_height',$new_table_height);
SetOption('auth','anchor',$new_anchor);
SetOption('auth','antispam',$new_antispam);
SetOption('auth','antispam_time_limit',$new_antispam_time_limit);
SetOption('auth','antispam_attempts',$new_antispam_attempts);
SetOption('auth','remember_login',$new_remember_login);
SetOption('auth','email_enter',$new_email_enter);
SetOption('auth','email_anchor',$new_email_anchor);
SetOption('auth','email_text',$new_email_text);
//debug($_POST);
//SetTemplate('auth',$new_temp_auth_auth);
print"<script language=\"javascript\">document.location='index.php';</script>";
}

if (@$action=="save_reg_form_settings")
{
//$field_opt;
$login_id=-1; //1
$password_id=-1; //2
$email_id=-1; //3

$error_login=0;
$error_password=0;
$error_email=0;

$email_needed=GetOption('auth','email_enter');

foreach($field_opt as $key => $value)
{
if ($value==1)
{
if ($login_id==-1)
  $login_id=$key;
else
  $error_login=1;
}

if ($value==2)
{
if ($password_id==-1)
  $password_id=$key;
else
  $error_password=1;
}

if ($value==3)
{
if ($email_id==-1)
  $email_id=$key;
else
  $error_email=1;
}
} //end foreach

$error=0;

if ($login_id==-1)
{
echo '<font color=red>ОШИБКА: Вы должны указать поле логина</font><br>';
$error=1;
}

if ($password_id==-1)
{
echo '<font color=red>ОШИБКА: Вы должны указать поле пароля</font><br>';
$error=1;
}

if ($error_login==1)
{
echo '<font color=red>ОШИБКА: Поле логина должно быть только одно</font><br>';
$error=1;
}

if ($error_password==1)
{
echo '<font color=red>ОШИБКА: Поле логина должно быть только одно</font><br>';
$error=1;
}

if ($email_needed==1 && $email_id==-1)
{
echo '<font color=red>ОШИБКА: Вы должны указать поле EMAIL</font><br>';
$error=1;
}

if ($email_needed==1 && $error_email==1)
{
echo '<font color=red>ОШИБКА: Поле EMAIL должно быть только одно</font><br>';
$error=1;
}



if ($error==1)
{
print "<br><br><a class=\"text_links\" href=index.php?action=reg_form_settings>Вернуться назад</a>";
}
else
{
SetOption('reg','field_login_id',$login_id);
SetOption('reg','field_password_id',$password_id);
SetOption('reg','field_email_id',$email_id);
print"<script language=\"javascript\">document.location='index.php?action=reg_form_settings';</script>";
}



}

if (@$action=="save_reg")
{
//SetOption('reg','table_width',$new_table_width);
//SetOption('reg','table_height',$new_table_height);
//SetOption('reg','antispam',$new_antispam);
SetOption('reg','form_id',$new_form);
//SetTemplate('reg',$new_temp_auth_reg);
print"<script language=\"javascript\">document.location='index.php';</script>";
}

if (@$action=="reg_form_settings")
{
$form_id=GetOption('reg','form_id');
$data=fetchrowset(mysql_query("SELECT * FROM cms_forms WHERE `form_id` = $form_id;"));
$form=$data[0];

$form_fields=fetchrowset(mysql_query("SELECT * FROM  cms_forms_fields WHERE `form_id` = $form_id ORDER BY `position` ASC"));

echo '<form method=POST action="index.php?action=save_reg_form_settings">';

PrintJavaScript();

echo '
<table cellpadding=0 cellspacing=0 border=0>
<tr>
<td><a href="index.php"><img src="images/back_icon.jpg" border="0"></a></td>
<td><a href="index.php"><div class="orange_names"><u><nobr>Вернуться к настройкам</nobr></u></div></a></td>
</tr>
</table><br>';


//Выводим заголовок таблицы
print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\"><tr>";
print "<td bgcolor=\"#434343\" style=\"padding-right:20px;\" width=\"100px\"><div class=\"razdelz_headers\" style=\"width:100px\">Название поля</div></td>";
print "<td bgcolor=\"#434343\" style=\"padding-right:20px;\" width=\"100px\"><div class=\"razdelz_headers\" style=\"width:100px\">Значение</div></td>";
print "<td bgcolor=\"#434343\" style=\"padding-right:20px;\" width=\"100px\"><div class=\"razdelz_headers\" style=\"width:100px\">Свойства</div></td>";
print "</tr>";

for($i=0;$i<sizeof($form_fields);$i++) PrintField($form_fields[$i]);
echo '</table>';

print "<br><input type=submit class=submit_button value=\"Сохранить настройки формы регистрации\"></form>";


}

if (@$action=="refresh_user_table")
{
$temp=nfetchrowset(mysql_query("SHOW COLUMNS FROM cms_auth_users"));

$user_fields=array();

for($i=0;$i<sizeof($temp);$i++)
{
if ($temp[$i][0]=='id' || $temp[$i][0]=='confirmed') continue;
$user_fields[]=$temp[$i][0];
}

$form_id=GetOption('reg','form_id');
$form_fields=fetchrowset(mysql_query("SELECT `id`,`type` FROM  cms_forms_fields WHERE `form_id` = $form_id ORDER BY `id` ASC"));

$temp=array();
for($i=0;$i<sizeof($form_fields);$i++)
{
$type=$form_fields[$i]['type'];
if ($type==0 || $type==1 || $type==2 || $type==3 || $type==8) $temp[]=$form_fields[$i][0];
}
$form_fields=$temp;

for($i=0;$i<sizeof($form_fields);$i++)
{
if (!in_array($form_fields[$i],$user_fields))
mysql_query("ALTER TABLE `cms_auth_users` ADD `".$form_fields[$i]."` TINYTEXT NOT NULL ;");
}

for($i=0;$i<sizeof($user_fields);$i++)
{
if (!in_array($user_fields[$i],$form_fields))
mysql_query("ALTER TABLE `cms_auth_users` DROP `".$user_fields[$i]."`;");
}

print"<script language=\"javascript\">document.location='index.php';</script>";
}

if (@$action=="") 
{

echo '<form method=POST action="index.php?action=save_auth">';

PrintJavaScript();

print "
<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" height=\"50\">
<tr>
<td width=\"100%\">

<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" height=\"50\">
<tr>
<td height=\"24\" bgcolor=\"#434343\" width=\"100%\"><div class=\"razdelz_headers\">Настройки авторизации</div></td>
<td height=\"24\" bgcolor=\"#434343\" width=\"250\"><div class=\"razdelz_headers\" style=\"margin-left:0px;margin-right:0px;width:250px;text-align:center;\">Значения</div></td>
</tr>
<tr valign=\"top\">
<td height=\"100%\" width=\"100%\" bgcolor=\"#FFFFFF\" colspan=\"2\">
<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" height=\"100%\">";

PrintOption('auth','Ширина','table_width');
PrintOption('auth','Высота','table_height');
PrintOption('auth','Точка привязки','anchor');
PrintOption('auth','Антиспам::включен','antispam','checkbox');
PrintOption('auth','Антиспам::период времени','antispam_time_limit');
PrintOption('auth','Антиспам::кол-во попыток','antispam_attempts');
PrintOption('auth','Ставить галочку &quot;Запомнить&quot;','remember_login','checkbox');
PrintOption('auth','Подтверждение по EMAIL','email_enter','checkbox');
PrintOption('auth','Точка привязки для email в письме','email_anchor');
PrintOption('auth','Текст письма','email_text','textarea');
//Show_Template('auth_auth');





	print"<tr><td height=\"15\" bgcolor=\"#FFFFFF\" width=\"100%\" colspan=\"6\"><img src=\"images/px.gif\" height=15 border=\"0\"></td>
</tr></table></td></tr></table></td></tr></table>";


print "<input type=submit class=submit_button value=\"Сохранить настройки авторизации\">&nbsp;";

echo '<input type=button class=submit_button onclick="javascript:location=\'index.php?action=refresh_user_table\'" value="Обновить таблицу пользователей"></form>';



////////////////////////////////Настройки регистрации


echo '<form method=POST action="index.php?action=save_reg">';

print "
<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" height=\"50\">
<tr>
<td width=\"100%\">

<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" height=\"50\">
<tr>
<td height=\"24\" bgcolor=\"#434343\" width=\"100%\"><div class=\"razdelz_headers\">Настройки регистрации</div></td>
<td height=\"24\" bgcolor=\"#434343\" width=\"250\"><div class=\"razdelz_headers\" style=\"margin-left:0px;margin-right:0px;width:250px;text-align:center;\">Значения</div></td>
</tr>
<tr valign=\"top\">
<td height=\"100%\" width=\"100%\" bgcolor=\"#FFFFFF\" colspan=\"2\">
<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" height=\"100%\">";

//PrintOption('reg','Ширина','table_width');
//PrintOption('reg','Высота','table_height');
//PrintOption('reg','Антиспам','antispam');
Show_Forms();
//Show_Template('auth_reg');

	print"<tr><td height=\"15\" bgcolor=\"#FFFFFF\" width=\"100%\" colspan=\"6\"><img src=\"images/px.gif\" height=15 border=\"0\"></td>
</tr></table></td></tr></table></td></tr></table>";

print "<input type=submit class=submit_button value=\"Сохранить настройки регистрации\"></form>";

}

function PrintOption($table,$text,$name,$misc='')
{
if ($table=='auth')
  $s=mysql_query("select * from cms_auth_settings where name = '$name'");
else
  $s=mysql_query("select * from cms_auth_reg_settings where name = '$name'");
$s=mysql_fetch_row($s);
$value=$s[2];
  
print "
<tr valign=\"middle\">
<td width=\"50%\" style=\"padding-top:5px;padding-bottom:5px;padding-left:10px;\">
<div class=\"orange_names\"><b>".$text.":</b></div>
</td>
<td style=\"padding-right:10px;\"></td>
<td width=\"1\" bgcolor=\"#CCCCCC\"><img src=\"images/px.gif\" border=\"0\" width=\"1\"></td>
<td width=\"50%\">
<div style=\"display:none;width:100%;text-align:center;\" id=\"div_".$table."_$name\" name=\"div_".$table."_$name\">
<table width=\"100%\" height=\"20\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
<tr nowrap style=\"text-align:center;\">
<td style=\"padding-left:5px;padding-right:5px\">";

if ($misc=='')
  print "<input type=\"text\" class=\"normal\" name=\"new_$name\" value=\"$value\" style=\"text-align:center;width:90%\">";
if ($misc=='textarea')
  print "<textarea class=\"normal\" name=\"new_$name\" style=\"text-align:center;width:90%\" cols=50 rows=10>$value</textarea>";
if ($misc=='checkbox')
{
  print "
<input type=hidden name=\"new_$name\" value=0>
<div class=\"black_names\" style=\"margin-left:0px;margin-right:0px;width:250px;text-align:center\"><input type=checkbox name=\"new_$name\" value=\"1\" ";
if ($value==1) echo " checked=checked";
print ">&nbsp;Да</div>";
}

print "</td>
</tr>
</table>
</div>
<div class=\"black_names\" style=\"margin-left:0px;margin-right:0px;width:250px;text-align:center\" id=\"div2_".$table."_$name\" name=\"div2_".$table."_$name\">";

if ($misc!='checkbox')
  echo nl2br($value);
else
  echo ($value==0?'Нет':'Да');

print "</div>
</td>
<td width=\"1\" bgcolor=\"#CCCCCC\"><img src=\"images/px.gif\" border=\"0\" width=\"1\"></td>
</td>
<td width=\"50\">
<div style=\"width:60px;\" class=\"gray_names\">
<a href=\"#\" onClick=\"show('div_".$table."_$name');hide('div2_".$table."_$name');return false;\" class=\"text_links\"><img src=\"images/edit_icon.jpg\" border=\"0\"></a>
</div>
</td>
</tr>
";

print"<tr valign=\"middle\"><td height=\"1\" bgcolor=\"#FFFFFF\" colspan=\"6\"><img src=\"images/px.gif\" height=\"1\"></td></tr>";
print"<tr valign=\"middle\"><td height=\"1\" bgcolor=\"#CCCCCC\" colspan=\"6\"><img src=\"images/px.gif\" height=\"1\"></td></tr>";
print"<tr valign=\"middle\"><td height=\"1\" bgcolor=\"#FFFFFF\" colspan=\"6\"><img src=\"images/px.gif\" height=\"1\"></td></tr>";
}

function Show_Forms()
{
print "<tr valign=\"middle\">
<td width=\"50%\" style=\"padding-top:5px;padding-bottom:5px;padding-left:10px;\">
<div class=\"orange_names\"><b>Шаблон:</b></div>
</td>
<td style=\"padding-right:10px;\"></td>
<td width=\"1\" bgcolor=\"#CCCCCC\"><img src=\"images/px.gif\" border=\"0\" width=\"1\"></td>
<td width=\"50%\">
<table width=\"100%\" height=\"20\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
<tr nowrap style=\"text-align:center;\">
<td style=\"padding-left:5px;padding-right:5px\">";
print "<select name=\"new_form\" class=normal style=\"width:150px;\">";
$sql="SELECT * FROM cms_forms";
$a=mysql_query($sql);
$a=fetchrowset($a);

$fid=GetOption('reg','form_id');

for($i=0;$i<sizeof($a);$i++)
{
echo '<option value='.$a[$i]['form_id'];
if ($fid==$a[$i]['form_id']) echo ' selected';
echo '>'.$a[$i]['name'].'</option>';
}

print"</select>";
print "</td></tr></table></td>
<td width=\"1\" bgcolor=\"#CCCCCC\"><img src=\"images/px.gif\" border=\"0\" width=\"1\"></td>
</td><td width=\"50\">
<div style=\"width:60px;\" class=\"gray_names\">
<a href=\"index.php?action=reg_form_settings\" class=\"text_links\"><img src=\"images/edit_icon.jpg\" border=\"0\"></a>
</div>

</td></tr>";
print"<tr valign=\"middle\"><td height=\"1\" bgcolor=\"#FFFFFF\" colspan=\"6\"><img src=\"images/px.gif\" height=\"1\"></td></tr>";
print"<tr valign=\"middle\"><td height=\"1\" bgcolor=\"#CCCCCC\" colspan=\"6\"><img src=\"images/px.gif\" height=\"1\"></td></tr>";
print"<tr valign=\"middle\"><td height=\"1\" bgcolor=\"#FFFFFF\" colspan=\"6\"><img src=\"images/px.gif\" height=\"1\"></td></tr>";
}


function GetOption($table,$name)
{
if ($table=='auth')
  $s=mysql_query("select * from cms_auth_settings where name = '$name'");
else
  $s=mysql_query("select * from cms_auth_reg_settings where name = '$name'");
$s=mysql_fetch_row($s);
return $s[2];
};

function SetOption($table,$name,$value)
{
  $sql="UPDATE cms_auth_";
  if ($table=='reg') $sql.="reg_";
  $sql.="settings SET value='$value' WHERE name='$name' LIMIT 1";
  mysql_query($sql);
}

function SetTemplate($type,$new_template)
{
  $sql="UPDATE cms_auth_common SET template_$type = '$new_template' WHERE id='1' LIMIT 1";
  mysql_query($sql);  
}


function PrintField($f)
{
if ($f['type']==7 || $f['type']==4) $f['description']=$f['misc'];

echo '<tr valign=middle>';

print "<td style=\"height:20px;width:100px;border-right:1px solid #CCCCCC;\"><div class=\"orange_names\" style=\"width:100px;overflow:hidden\">".$f['description']."</div></td>";

print "<td style=\"height:20px;width:100px;border-right:1px solid #CCCCCC;\">";
print "<div style=\"display:none;height:20px;width:100%;text-align:center;\" id=\"div_reg_".$f['id']."\" name=\"div_reg_".$f['id']."\">
<table width=\"100%\" height=\"20\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
<tr nowrap style=\"text-align:center;\">
<td style=\"padding-left:5px;padding-right:5px\">";
PrintSelect($f['id']);
print "</td>
</tr>
</table>
</div>
<div class=\"black_names\" style=\"margin-left:0px;margin-right:0px;width:100%;text-align:center\" id=\"div2_reg_".$f['id']."\" name=\"div2_reg_".$f['id']."\">".PrintSelectValue($f['id'])."</div>";
print "</td>";

print "<td style=\"height:20px;width:100px;\"><div class=\"black_names\" style=\"width:100px;overflow:hidden\">";
if ($f['type']==0)
  print "<a href=\"#\" title=\"Редактировать\" onClick=\"show('div_reg_".$f['id']."');hide('div2_reg_".$f['id']."');return false;\" class=\"text_links\"><img src=\"images/edit_icon.jpg\" border=\"0\"></a>";
else
  echo '&nbsp;';
print "</div></td>";
echo '</tr>';

$N=3;
print"<tr valign=\"middle\"><td colspan=$N height=\"1\" bgcolor=\"#FFFFFF\"><img src=\"images/px.gif\" height=\"1\"></td></tr>";
print"<tr valign=\"middle\"><td colspan=$N height=\"1\" bgcolor=\"#CCCCCC\"><img src=\"images/px.gif\" height=\"1\"></td></tr>";
print"<tr valign=\"middle\"><td colspan=$N height=\"1\" bgcolor=\"#FFFFFF\"><img src=\"images/px.gif\" height=\"1\"></td></tr>";
}


function PrintSelect($id)
{
$login_id=GetOption('reg','field_login_id');
$password_id=GetOption('reg','field_password_id');
$email_id=GetOption('reg','field_email_id');

echo '<select name=field_opt['.$id.']>';
echo '<option value=0 ';
echo '></option>';
echo '<option value=1 ';
if ($login_id==$id) echo 'selected';
echo '>Поле логина</option>';
echo '<option value=2 ';
if ($password_id==$id) echo 'selected';
echo '>Поле пароля</option>';
echo '<option value=3 ';
if ($email_id==$id) echo 'selected';
echo '>Поле EMAIL</option>';
echo '</select>';
}

function PrintSelectValue($id)
{
$login_id=GetOption('reg','field_login_id');
$password_id=GetOption('reg','field_password_id');
$email_id=GetOption('reg','field_email_id');
if ($login_id==$id) return 'Поле логина';
if ($password_id==$id) return 'Поле пароля';
if ($email_id==$id) return 'Поле EMAIL';
}






?>
