<?php
include_once "site/site.php";
include_once "dbconnect.php";
include_once "my_func.php";
function get_margin($price, $marg)
{
  if ($marg < 1)
    return $price * $marg;
  return $marg; 
}

function checkmail($str)
{
       $badchars = "[ ]+| |\+|=|[|]|{|}|`|\(|\)|,|;|:|!|<|>|%|\*|/|'|\"|~|\?|#|\\$|\\&|\\^|www[.]|@|[.]";
       return (eregi($badchars,$str));
}


function date_to_date_string($date) 
	{
	$date=explode("-",$date);
	$result=(int)$date[2]." ".month_name($date[1])." ".$date[0];
	return $result;
	}


function datetime_to_normal($date) 
	{
	$a_date=explode(" ",$date);
	$a_date_2=explode("-",$a_date[0]);
	$result=$a_date_2[2].".".$a_date_2[1].".".$a_date_2[0];
	return $result;
	}

function datetime_from_normal($date) 
	{
	$a_date=explode(".",$date);
	$result=$a_date[2]."-".$a_date[1]."-".$a_date[0]." 00:00:01";
	return $result;
	}


// РЕСАЙЗ ИЗОБРАЖЕНИЙ//РЕСАЙЗ ИЗОБРАЖЕНИЙ//РЕСАЙЗ ИЗОБРАЖЕНИЙ//РЕСАЙЗ ИЗОБРАЖЕНИЙ//РЕСАЙЗ ИЗОБРАЖЕНИЙ//РЕСАЙЗ ИЗОБРАЖЕНИЙ
// РЕСАЙЗ ИЗОБРАЖЕНИЙ//РЕСАЙЗ ИЗОБРАЖЕНИЙ//РЕСАЙЗ ИЗОБРАЖЕНИЙ//РЕСАЙЗ ИЗОБРАЖЕНИЙ//РЕСАЙЗ ИЗОБРАЖЕНИЙ//РЕСАЙЗ ИЗОБРАЖЕНИЙ

	function imgresize($src, $dest, $width, $height, $quality=100, $rgb=0xFFFFFF)
	{
	if (!file_exists($src)) return false;
	$size = getimagesize($src);
	if ($size === false) return false;
	$format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
	$icfunc = "imagecreatefrom" . $format;
	if (!function_exists($icfunc)) return false;
	$x_ratio = $width / $size[0];
	$y_ratio = $height / $size[1];
	$ratio = min($x_ratio, $y_ratio);
	$use_x_ratio = ($x_ratio == $ratio);
	$new_width = $use_x_ratio ? $width : floor($size[0] * $ratio);
	$new_height = !$use_x_ratio ? $height : floor($size[1] * $ratio);
	$isrc = $icfunc($src);
	$idest = imagecreatetruecolor($new_width, $new_height);
	imagefill($idest, 0, 0, $rgb);
	imagecopyresampled($idest, $isrc, 0, 0, 0, 0, $new_width, $new_height, $size[0], $size[1]);
	for($i=strlen($dest)-1;$i>=0;$i--)
	if($dest[$i]=='.')
	break;
	$i++;
	$ftypeg="";
	while($i<strlen($dest))
	{ 
	$ftypeg.=$dest[$i];
	$i++;
	}
	if(strtolower($ftypeg)=="jpg")
	$ftypeg="jpeg";
	$ftypeg="image".$ftypeg;
	if (!function_exists($ftypeg)) return false;
	$ftypeg($idest, $dest, $quality);
	imagedestroy($isrc);
	imagedestroy($idest);
	return true;
	}

function show_possible_atr_set_purposes()
{
include('atr.inc.php');
$purposes=afetchrowset(mysql_query('select * from cms2_modules where include_style=\'1\''));
foreach($purposes as $purpose)
  if (isset($ATR_PURPOSES[$purpose['directory_title']]))
  {
    echo '<optgroup label="">';
    foreach($ATR_PURPOSES[$purpose['directory_title']] as $element)
      echo '<option value="'.$element[0].'">'.$element[1].'</option>';
    echo '</optgroup>';
  }
}

function show_possible_templates_purposes()
{
include('templates.inc.php');
$purposes=afetchrowset(mysql_query('select * from cms2_modules where include_style=\'1\''));
foreach($purposes as $purpose)
{
  if (isset($TEMPLATES_PURPOSES[$purpose['directory_title']]))
  {
    echo '<optgroup label="">';
    foreach($TEMPLATES_PURPOSES[$purpose['directory_title']] as $element)
      echo '<option value="'.$element[0].'">'.$element[1].'</option>';
    echo '</optgroup>';
  }
}
}

function show_possible_page_purposes()
{
include('pages.inc.php');
$purposes=afetchrowset(mysql_query('select * from cms2_modules where include_style=\'1\''));
foreach($purposes as $purpose)
  if (isset($PAGES_PURPOSES[$purpose['directory_title']]))
    foreach($PAGES_PURPOSES[$purpose['directory_title']] as $element)
      echo '<option value="'.$element[0].'">'.$element[1].'</option>';
echo '<option value="script">Скрипт-страница</option>';
}


function show_possible_templates($purpose) {
$select_possible_modules=mysql_query("select * from cms2_templates where purpose='$purpose'");
while ($line_modules=mysql_fetch_array($select_possible_modules)) 
{
extract($line_modules);
print"<option value=\"$template_id\">$title</option>";
}
}

function count_possible_templates($purpose) {
$result=0;
$select_possible_modules=mysql_query("select * from cms2_templates where purpose='$purpose'");
$result=mysql_num_rows($select_possible_modules);
return $result;
}


function show_possible_atr_sets($purpose) {
	$select_modules=mysql_query("select * from  cms2_attributes_sets where purpose='$purpose' order by set_id");
	while ($line_modules=mysql_fetch_array($select_modules)) 
		{
		extract($line_modules);
		print"<option value=\"$set_id\">$set_title</option>";
		}
}

function count_possible_atr_sets($purpose) {
$result=0;
$select_possible_modules=mysql_query("select * from  cms2_attributes_sets where purpose='$purpose' order by set_id");
$result=mysql_num_rows($select_possible_modules);
return $result;
}


function show_possible_blocks() {
$select_possible_modules=mysql_query("select * from  cms2_blocks");
while ($line_modules=mysql_fetch_array($select_possible_modules)) 
{
extract($line_modules);
print"<option value=\"$block_id\">$name</option>";
}
}

function show_possible_forms() {
$select_possible_modules=mysql_query("select * from cms_forms");
while ($line_modules=mysql_fetch_array($select_possible_modules)) 
{
extract($line_modules);
print"<option value=\"$form_id\">$name</option>";
}
}


function show_possible_blocks_positions() {
$select_possible_modules=mysql_query("select * from  cms2_blocks_positions");
while ($line_modules=mysql_fetch_array($select_possible_modules)) 
{
extract($line_modules);
print"<option value=\"$position_id\">$title</option>";
}
}

function show_possible_forms_positions() {
$select_possible_modules=mysql_query("select * from cms_forms_positions");
while ($line_modules=mysql_fetch_array($select_possible_modules)) 
{
extract($line_modules);
print"<option value=\"$position_id\">$title</option>";
}
}




function generate_password($number)

  {

    $arr = array('a','b','c','d','e','f',

                 'g','h','i','j','k','l',

                 'm','n','o','p','r','s',

                 't','u','v','x','y','z',

                 'A','B','C','D','E','F',

                 'G','H','I','J','K','L',

                 'M','N','O','P','R','S',

                 'T','U','V','X','Y','Z',

                 '1','2','3','4','5','6',

                 '7','8','9','0');

    // Генерируем пароль

    $pass = "";

    for($i = 0; $i < $number; $i++)

    {

      // Вычисляем случайный индекс массива

      $index = rand(0, count($arr) - 1);

      $pass .= $arr[$index];

    }

    return $pass;

  }





function send_email($client_id, $text)
{
$select_reg_email=mysql_query("select * from client_names where client_id='".$client_id."'");
$s_r_e=mysql_fetch_array($select_reg_email);
$client_reg_email=$s_r_e['reg_email'];

$sendtheme='Письмо из электронного офиса компании ДНК';
$sendchar='windows-1251';
$lettype='html';
$my_name='Электронный офис ДНК';
$my_email='info@webdnk.ru';

		$body = "$text";
		$headers ="From: ".$my_name."<".$my_email.">\n";
		$headers.="Content-Type: text/$lettype; charset=$sendchar";
		mail($client_reg_email,$sendtheme,stripslashes($body),$headers);
}



function GetSpace($dir)
{
$result=0;
$d = dir($dir);
while (false !== ($entry = $d->read()))
{
  if($entry=="." or $entry=="..") continue;
  if(is_dir($dir."/".$entry))
    $result+=GetSpace($dir."/".$entry);
  else
    $result+=filesize($dir."/".$entry);
}
$d->close();
return $result;
}

function ToBytes($val)
{
$val = trim($val);
$last = strtolower($val{strlen($val)-1});
switch($last)
{
case 'g':
  $val *= 1024;
case 'm':
  $val *= 1024;
case 'k':
  $val *= 1024;
}
return $val;
}

function FromBytes($val)
{
$l='';
if ($val>1024)
{
  $l=' kb';
  $val/=1024;
}
if ($val>1024)
{
  $l=' mb';
  $val/=1024;
}

if ($val>1024)
{
  $l=' Gb';
  $val/=1024;
}
$val=sprintf("%.3f",$val);
return $val.$l;
}








function month_name($m) {
if ($m==1) {$m="января";}
if ($m==2) {$m="февраля";}
if ($m==3) {$m="марта";}
if ($m==4) {$m="апреля";}
if ($m==5) {$m="мая";}
if ($m==6) {$m="июня";}
if ($m==7) {$m="июля";}
if ($m==8) {$m="августа";}
if ($m==9) {$m="сентября";}
if ($m==10) {$m="октября";}
if ($m==11) {$m="ноября";}
if ($m==12) {$m="декабря";}
return $m;
}

function check_errors($value, $value_name, $process_name, $result_type) {
global $last_action_result;
global $result_image;
global $cur_errors;
global $cur_successes;
global $error_flags;
$error=0;
$error_type="";
for ($y=3;$y<func_num_args();$y++) {
$x=func_get_arg($y);

if (($x=='rus_only') and ($error!=1))
	{
		$error=!preg_match("/^[а-яА-Я]+$/",$value);
		if ($error==1) {$error_type="Значение должно содержать только русские буквы";}
	}

if (($x=='rus_and_spaces') and ($error!=1))
	{
		$error=!preg_match("/^[а-яА-Я ]+$/",$value);
		if ($error==1) {$error_type="Значение должно содержать только русские буквы и пробелы";}
	}

if (($x=='rus_and_numbers') and ($error!=1))
	{
		$error=!preg_match("/^[а-яА-Я0-9]+$/",$value);
		if ($error==1) {$error_type="Значение должно содержать только русские буквы и цифры";}
	}

if (($x=='rus_and_numbers_and_spaces') and ($error!=1))
	{
		$error=!preg_match("/^[а-яА-Я0-9 ]+$/",$value);
		if ($error==1) {$error_type="Значение должно содержать только русские буквы и цифры и пробелы";}
	}


if (($x=='latin_only') and ($error!=1))
	{
		$error=!preg_match("/^[a-zA-Z]{1,15}$/",$value);
		if ($error==1) {$error_type="Значение должно содержать только латинские буквы";}
	}

if (($x=='latin_and_numbers') and ($error!=1))
	{
		$error=!preg_match("/^[a-zA-Z0-9]{1,15}$/",$value);
		if ($error==1) {$error_type="Значение должно содержать только латинские буквы и цифры";}
	}


if (($x=='filenames') and ($error!=1))
	{
		$error=!preg_match("/^[a-zA-Z0-9_.]{1,15}$/",$value);
		if ($error==1) {$error_type="Значение должно содержать только латинские буквы, цифры и нижние подчеркивания";}
	}

if (($x=='letters_and_numbers') and ($error!=1))
	{
		$error=!preg_match("/^[0-9a-zA-Zа-яА-Я -]+$/",$value);
		if ($error==1) {$error_type="Значение должно содержать только буквы, цифры и тире";}
	}



if (($x=='email') and ($error!=1))
	{
		$error=!preg_match("/^[a-zA-Z0-9_.-]+[@]{1}+[a-zA-Z0-9_-]+[\.]{1}[a-zA-Z0-9]+$/",$value);
		if ($error==1) {$error_type="Значение должно быть вида адрес@хост.зона латинскими буквами и цифрами";}
	}

if (($x=='numbers') and ($error!=1))
	{
		$error=!preg_match("/^[0-9]+$/",$value);
		if ($error==1) {$error_type="Значение должно содержать только цифры";}
	}

if (($x=='phone') and ($error!=1))
	{
		$error=!preg_match("/^[0-9-]+$/",$value);
		if ($error==1) {$error_type="Значение должно содержать только цифры и тире";}
	}



if ($x=='small')
	{
		$error_length=!preg_match("/^.{1,15}$/",$value);
		if ($error_length==1) {$error=1;$error_type=$error_type." Длина не должна превышать 15 символов";}
	}


if ($x=='big')
	{
		$error_length=!preg_match("/^.{1,255}$/",$value);
		if ($error_length==1) {$error=1;$error_type=$error_type." Длина не должна превышать 255 символов";}
	}
}


if ($error==1) {$error_flags=1;$last_action_result="$value_name: $error_type";if ($cur_errors!="") {$cur_errors=$cur_errors."<br>".$last_action_result;} else {$cur_errors=$last_action_result;}}

if ($result_type=="all") 
{
if ($error==0) {$last_action_result="$value_name: $process_name прошло успешно";if ($cur_successes!="") {$cur_successes=$cur_successes."<br>".$last_action_result;} else {$cur_successes=$last_action_result;}}
}

if ($result_type=="summary") 
{
if ($error_flags==0) {$cur_successes="Все действия выполнены успешно";}
}


if ($error_flags==1) {$result_image="result_arrow_red";}
if ($error_flags==0) {$result_image="result_arrow_green";}
return $error;
}



function refresh_errors() {
global $cur_errors;
global $cur_successes;
global $error_flags;
$cur_errors="";
$cur_successes="";
$error_flags=0;
}

function critical_base_error() {
global $cur_errors;
global $cur_successes;
global $error_flags;
if ($cur_errors!="") {$cur_errors=$cur_errors."<br>"."Произошла критическая ошибка при работе с базой данных";}
if ($cur_errors=="") {$cur_errors="Произошла критическая ошибка при работе с базой данных";}
$error_flags=1;
}






// создает новый набор атрибутов// создает новый набор атрибутов// создает новый набор атрибутов
// создает новый набор атрибутов// создает новый набор атрибутов// создает новый набор атрибутов

	function create_new_attributes_set($new_set_title,$set_purpose) //создает новый набор аттрибутов
	{
	mysql_query("insert into  cms2_attributes_sets values ('', '".$new_set_title."','$set_purpose')");
	$a=mysql_insert_id();
	mysql_query("CREATE TABLE `cms_attributes_".$a."_descriptions` (
  `id` int(3) NOT NULL auto_increment,
  `title` varchar(20) NOT NULL default '',
  `type_id` int(2) NOT NULL default '0',
  `marker` varchar(50) NOT NULL default '0',
  `size_x` int(3) NOT NULL default '0',
  `size_y` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=24 ;
	");
	if (@mysql_query("CREATE TABLE `cms_attributes_".$a."` (`element_id` int(5))")) {}		
	}


// выводит в форму все атрибуты набора в виде элементов формы, с возможностью редактирования
// выводит в форму все атрибуты набора в виде элементов формы, с возможностью редактирования

	function show_edit_attributes_sets_form($set_id)
	{
	$select_all_attributes_types_in_set=mysql_query("select * from  cms2_attributes_".$set_id."_descriptions order by id");

print"<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" height=\"50\">
<tr><td style=\"padding-right:15px;\"><div class=\"black_names\">название атрибута</div></td><td style=\"padding-right:15px;\"><div class=\"black_names\">тип атрибута</div></td><td style=\"padding-right:15px;\"><div class=\"black_names\">маркер</div><td style=\"padding-right:15px;\"><div class=\"black_names\">размер_х</div></td><td style=\"padding-right:15px;\"><div class=\"black_names\">размер_у</div></td><td style=\"padding-right:15px;\"><div class=\"black_names\">действия</div></td></td></tr>";
	while ($line=mysql_fetch_array($select_all_attributes_types_in_set)) 
	{
	extract($line);
	$select_attribute_type=mysql_query("select * from  cms2_attributes_types where type_id='".$type_id."'");
	$a_select_attribute_type=mysql_fetch_array($select_attribute_type);
	$attribute_title=$a_select_attribute_type['title'];
print"<tr><td height=3></td></tr>";
	print"<tr><td><div class=\"black_names\"><input type=\"text\" name=\"$id#title\" value=\"$title\" style=\"width:90px;\" class=\"normal\"></div></td><td class=\"tab\"><div class=\"black_names\"><b style=\"width:100px\">$attribute_title</b></div></td>";

	print"<td><div class=\"black_names\"><input type=\"text\" name=\"$id#new_marker\" value=\"$marker\" style=\"width:90px;\" class=\"normal\"></div></td>";
	if ($type_id==6) {print"<td><div class=\"black_names\"><input type=\"text\" name=\"$id#size_x\" value=\"$size_x\" style=\"width:50px;\" class=\"normal\"></div></td><td><input type=\"text\" name=\"$id#size_y\" value=\"$size_y\" style=\"width:50px;\" class=\"normal\"></div></td>";} else {print"<td>&nbsp;</td><td>&nbsp;</td>";}
	print"<td class=\"tab\"<div class=\"black_names\"><a class=\"text_links\" href=\"index.php?action=delete_attribute_from_set&attribute_id=$id&set_id=$set_id\">удалить</a></div></td></tr>";
print"<tr><td height=3></td></tr>";
	}
print"</table>";
	}



// выводит возможные наборы атрибутов в виде select'a// выводит возможные наборы атрибутов в виде select'a
// выводит возможные наборы атрибутов в виде select'a// выводит возможные наборы атрибутов в виде select'a


	function show_attributes_sets($select_name, $selected_id) 
	{
	print"<select name=\"$select_name\"><option selected value=\"none\">Не выбран";
	$select_all_things_attributes_sets=mysql_query("select * from  cms2_attributes_sets order by set_id");
	while ($line=mysql_fetch_array($select_all_things_attributes_sets)) 
	{
	extract($line);
	print"<option value=\"$set_id\""; if ($set_id==$selected_id) {print" selected";} print">Набор № $set_id $set_title";
	}
	print"</select>";
	}






// выводит возможные типы атрибутов в виде select'a// выводит возможные типы атрибутов в виде select'a//
// выводит возможные типы атрибутов в виде select'a// выводит возможные типы атрибутов в виде select'a//

	function show_attributes_types($select_name, $selected) 
	{
	print"<select name=\"$select_name\" class=\"normal\"><option";
	if ($selected=='none') {print" selected ";}  print" value=\"none\">Не выбран";
	$select_all_things_attributes_types=mysql_query("select * from  cms2_attributes_types order by type_id");
	while ($line=mysql_fetch_array($select_all_things_attributes_types)) 
	{
	extract($line);
	print"<option value=\"$type_id\""; if (@$selected==$type_id) {print" selected ";}  print">$title";
	}
	print"</select>";
	}






// добавляет новый атрибут к набору// добавляет новый атрибут к набору// добавляет новый атрибут к набору
// добавляет новый атрибут к набору// добавляет новый атрибут к набору// добавляет новый атрибут к набору

	function add_new_attribute_to_set($set_id, $new_attribute_title, $new_attribute_type_id, $new_attribute_marker, $new_size_x, $new_size_y) //добавляет новый атрибут к выбранному набору
	{
	mysql_query("insert into  cms2_attributes_".$set_id."_descriptions values ('', '".$new_attribute_title."', '".$new_attribute_type_id."', '".$new_attribute_marker."','$new_size_x','$new_size_y')");
	$max_attribute_id_in_set=mysql_insert_id();
	$inserting_type="int(1)";
	if ($new_attribute_type_id=='1') {$inserting_type="varchar(200)";}
	if ($new_attribute_type_id=='2') {$inserting_type="text";}
	if ($new_attribute_type_id=='3') {$inserting_type="int(10)";}
	if ($new_attribute_type_id=='4') {$inserting_type="varchar(20)";}
	if ($new_attribute_type_id=='5') {$inserting_type="decimal(10,2)";}
	if ($new_attribute_type_id=='6') {$inserting_type="varchar(30)";}
	if ($new_attribute_type_id=='7') {$inserting_type="varchar(30)";}
	mysql_query("ALTER TABLE `cms_attributes_".$set_id."` add `".$max_attribute_id_in_set."` ".$inserting_type." NOT NULL");
	}


// стирает атрибут из набора//стирает атрибут из набора//стирает атрибут из набора
// стирает атрибут из набора//стирает атрибут из набора//стирает атрибут из набора

	function delete_attribute_from_set($set_id, $attribute_id) //стирает атрибут из набора
	{
	mysql_query("delete from  cms2_attributes_".$set_id."_descriptions where id='".$attribute_id."'");
	mysql_query("ALTER TABLE `cms_attributes_".$set_id."` DROP `".$attribute_id."`");
	}



// выводит аттрибуты набора для внесения в них значений для конкретной вещи
// выводит аттрибуты набора для внесения в них значений для конкретной вещи

	function show_attributes_from_set_for_insert($set_id,$table=1)
	{
	global $HTTP_POST_VARS;
	$select_all_attributes_types_in_set=mysql_query("select * from  cms2_attributes_".$set_id."_descriptions order by id");
	while ($line=mysql_fetch_array($select_all_attributes_types_in_set)) 
	{
	extract($line);
	$sx=$size_x;
	$sy=$size_y;
	$select_attribute_type=mysql_query("select * from  cms2_attributes_types where type_id='".$type_id."'");
	$a_select_attribute_type=mysql_fetch_array($select_attribute_type);
	$attribute_title=$a_select_attribute_type['title'];
		foreach ($HTTP_POST_VARS as $key => $value) 
		{
		$a=explode('_',$key);
		if (($a[0]=="attribute") and ($a[1]==$id)) $attribute_id_value=$value;
		}
		foreach ($HTTP_POST_VARS as $key => $value) 
		{
		$a=explode('_',$key);
		if (($a[0]=="picture") and ($a[1]==$id)) $attribute_id_value=$value;
		}
		foreach ($HTTP_POST_VARS as $key => $value) 
		{
		$a=explode('_',$key);
		if (($a[0]=="file") and ($a[1]==$id)) $attribute_id_value=$value;
		}
	$datetime=date("Y-m-d");$datetime=explode("-",$datetime);$year=$datetime[0];$month=$datetime[1];$day=$datetime[2];

if ($table==1)
{
	if ($type_id==1) {print"<tr><td align=\"right\"><div class=\"black_names\"><br><br>$title:<br><br><input type=\"text\" name=\"attribute_$id\" class=normal style=\"width:550px;\" value=\"$attribute_id_value\"></td></tr>";}
	if ($type_id==2) {print"<tr><td align=\"right\"><div class=\"black_names\"><br><br>$title:<br><br><textarea class=normal id=\"attribute_$id\" name=\"attribute_$id\" style=\"width:550px;\" rows=5>$attribute_id_value</textarea><a href=\"modules/att_editor.php?id=$id\" target=\"_blank\"><img src='images/edit_icon.jpg'></a></td></tr>";}
	if ($type_id==3) {print"<tr><td align=\"right\"><div class=\"black_names\"><br><br>$title:<br><br><input type=\"text\" name=\"attribute_$id\"  class=normal  value=\"$attribute_id_value\" style=\"width:550px;\"></td></tr>";}
	if ($type_id==4) {print"<tr><td align=\"right\"><div class=\"black_names\"><br><br>$title:<br><br><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"200\" height=\"20\"><tr><td><input type=\"text\" name=\"attribute_$id\" class=normal  style=\"width:250px;\" value=\"$day.$month.$year\"></td><script language='JavaScript'> var attribute_$id = new calendar_create(document.forms['new_thing_form'].elements['attribute_$id']); </script><td class=\"tab\"><a href='javascript:attribute_$id.popup();'><img src='images/vvv_calendar.gif'></a></td></tr></table></td></tr>";}
	if ($type_id==5) {print"<tr><td align=\"right\"><div class=\"black_names\"><br><br>$title:<br><br><input type=\"text\" name=\"attribute_$id\"  class=normal  value=\"$attribute_id_value\"  style=\"width:550px;\"></td></tr>";}
	if ($type_id==6) {print"<tr><td align=\"right\"><div class=\"black_names\"><br><br>$title:<br><br><input width=\"550\" maxlength=\"30\" size=\"30\" type=\"file\"  value=\"$attribute_id_value\" class=normal name=\"picture_";print"$id";print"_";print"$sx";print"_";print"$sy"; print"\"></td></tr>";}
	if ($type_id==7) {print"<tr><td align=\"right\"><div class=\"black_names\"><br><br>$title:<br><br><input width=\"550\" maxlength=\"30\" size=\"30\" type=\"file\"  value=\"$attribute_id_value\" class=normal name=\"file_";print"$id";print"\"></td></tr>";}
}
else
{
	if ($type_id==1) {print"<br><br>$title:<br><br><input type=\"text\" name=\"attribute_$id\" class=normal style=\"width:550px;\" value=\"$attribute_id_value\">";}
	if ($type_id==2) {print"<br><br>$title:<br><br><textarea class=normal  name=\"attribute_$id\" id=\"attribute_$id\" style=\"width:550px;\" rows=5>$attribute_id_value</textarea><a href=\"modules/att_editor.php?id=$id\" target=\"_blank\"><img src='images/edit_icon.jpg'></a>";}
	if ($type_id==3) {print"<br><br>$title:<br><br><input type=\"text\" name=\"attribute_$id\"  class=normal  value=\"$attribute_id_value\" style=\"width:550px;\">";}
	if ($type_id==4) {print"<br><br>$title:<br><br><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"200\" height=\"20\"><tr><td><input type=\"text\" name=\"attribute_$id\" class=normal  style=\"width:250px;\" value=\"$day.$month.$year\"></td><script language='JavaScript'> var attribute_$id = new calendar_create(document.forms['new_thing_form'].elements['attribute_$id']); </script><td class=\"tab\"><a href='javascript:attribute_$id.popup();'><img src='images/vvv_calendar.gif'></a></td></tr></table>";}
	if ($type_id==5) {print"<br><br>$title:<br><br><input type=\"text\" name=\"attribute_$id\"  class=normal  value=\"$attribute_id_value\"  style=\"width:550px;\">";}
	if ($type_id==6) {print"<br><br>$title:<br><br><input width=\"550\" maxlength=\"30\" size=\"30\" type=\"file\"  value=\"$attribute_id_value\" class=normal name=\"picture_";print"$id";print"_";print"$sx";print"_";print"$sy"; print"\">";}
	if ($type_id==7) {print"<br><br>$title:<br><br><input width=\"550\" maxlength=\"30\" size=\"30\" type=\"file\"  value=\"$attribute_id_value\" class=normal name=\"file_";print"$id";print"\">";}
}
}
}


// выводит аттрибуты набора для внесения в них значений для конкретной вещи
// выводит аттрибуты набора для внесения в них значений для конкретной вещи

	function show_attributes_from_set_for_edit($set_id, $page_id,$table=1)
	{
	$select_all_attributes_types_in_set=mysql_query("select * from  cms2_attributes_".$set_id."_descriptions order by id");
	while ($line=mysql_fetch_array($select_all_attributes_types_in_set)) 
	{
	extract($line);
	$sx=$size_x;
	$sy=$size_y;
	$cur_attribute_id=$id;
	$cur_value="";
	$select_value=mysql_query("select * from  cms2_attributes_".$set_id." where element_id='".$page_id."'");
	$cur_value="";
	if (mysql_num_rows($select_value)>0) {
	$a_value=mysql_fetch_array($select_value);
	foreach ($a_value as $key => $value) {
	if ($key==$cur_attribute_id) {$cur_value=$value;}
	}
	}
	$select_attribute_type=mysql_query("select * from  cms2_attributes_types where type_id='".$type_id."'");
	$a_select_attribute_type=mysql_fetch_array($select_attribute_type);
	$attribute_title=$a_select_attribute_type['title'];
	$datetime=date("Y-m-d");$datetime=explode("-",$datetime);$year=$datetime[0];$month=$datetime[1];$day=$datetime[2];
if ($table==1)
{
	if ($type_id==1) {print"<tr><td align=\"right\"><div class=\"black_names\"><br><br>$title:<br><br><input type=\"text\" name=\"attribute_$id\" class=normal style=\"width:550px;\" value=\"$cur_value\"></td></tr>";}
	if ($type_id==2) {print"<tr><td align=\"right\"><div class=\"black_names\"><br><br>$title:<br><br><textarea class=normal id=\"attribute_$id\" name=\"attribute_$id\" style=\"width:550px;\" rows=5>$cur_value</textarea><a href=\"modules/att_editor.php?id=$id\" target=\"_blank\"><img src='images/edit_icon.jpg'></a></td></tr>";}
	if ($type_id==3) {print"<tr><td align=\"right\"><div class=\"black_names\"><br><br>$title:<br><br><input type=\"text\" name=\"attribute_$id\"  class=normal  value=\"$cur_value\" style=\"width:550px;\"></td></tr>";}
	if ($type_id==4) {print"<tr><td align=\"right\"><div class=\"black_names\"><br><br>$title:<br><br><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"200\" height=\"20\"><tr><td><input type=\"text\" name=\"attribute_$id\" value=\"$cur_value\"  class=normal  style=\"width:250px;\" value=\"$day.$month.$year\"></td><script language='JavaScript'> var attribute_$id = new calendar_create(document.forms['new_thing_form'].elements['attribute_$id']); </script><td class=\"tab\"><a href='javascript:attribute_$id.popup();'><img src='images/vvv_calendar.gif'></a></td></tr></table></td></tr>";}
	if ($type_id==5) {print"<tr><td align=\"right\"><div class=\"black_names\"><br><br>$title:<br><br><input type=\"text\" name=\"attribute_$id\"  class=normal  value=\"$cur_value\"  style=\"width:550px;\"></td></tr>";}
	if ($type_id==6) {print"<tr><td align=\"right\"><div class=\"black_names\"><br><br>$title:<br><br><input width=\"550\" maxlength=\"30\" size=\"30\" type=\"file\"  value=\"$cur_value\" class=normal name=\"picture_";print"$id";print"_";print"$sx";print"_";print"$sy"; print"\"></td></tr>";}
	if ($type_id==7) {print"<tr><td align=\"right\"><div class=\"black_names\"><br><br>$title:<br><br><input width=\"550\" maxlength=\"30\" size=\"30\" type=\"file\"  value=\"$cur_value\" class=normal name=\"file_";print"$id";print"\"></td></tr>";}
}
else
{
	if ($type_id==1) {print"<br><br>$title:<br><br><input type=\"text\" name=\"attribute_$id\" class=normal style=\"width:550px;\" value=\"$cur_value\">";}
	if ($type_id==2) {print"<br><br>$title:<br><br><textarea class=normal  name=\"attribute_$id\" id=\"attribute_$id\" style=\"width:550px;\" rows=5>$cur_value</textarea><a href=\"modules/att_editor.php?id=$id\" target=\"_blank\"><img src='images/edit_icon.jpg'></a>";}
	if ($type_id==3) {print"<br><br>$title:<br><br><input type=\"text\" name=\"attribute_$id\"  class=normal  value=\"$cur_value\" style=\"width:550px;\">";}
	if ($type_id==4) {print"<br><br>$title:<br><br><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"200\" height=\"20\"><tr><td><input type=\"text\" name=\"attribute_$id\" value=\"$cur_value\"  class=normal  style=\"width:250px;\" value=\"$day.$month.$year\"></td><script language='JavaScript'> var attribute_$id = new calendar_create(document.forms['new_thing_form'].elements['attribute_$id']); </script><td class=\"tab\"><a href='javascript:attribute_$id.popup();'><img src='images/vvv_calendar.gif'></a></td></tr></table>";}
	if ($type_id==5) {print"<br><br>$title:<br><br><input type=\"text\" name=\"attribute_$id\"  class=normal  value=\"$cur_value\"  style=\"width:550px;\">";}
	if ($type_id==6) {print"<br><br>$title:<br><br><input width=\"550\" maxlength=\"30\" size=\"30\" type=\"file\"  value=\"$cur_value\" class=normal name=\"picture_";print"$id";print"_";print"$sx";print"_";print"$sy"; print"\">";}
	if ($type_id==7) {print"<br><br>$title:<br><br><input width=\"550\" maxlength=\"30\" size=\"30\" type=\"file\"  value=\"$cur_value\" class=normal name=\"file_";print"$id";print"\">";}



}
	}
	}





// Функция расчета вложенности категории (сколько от нее шагов до самых верхних категорий) // Функция расчета вложенности категории (сколько от нее шагов до самых верхних категорий)



	function steps_up_from_current($page_id) {
	$current_page_id=$page_id;
	$counter=0;
	while (1<2) {
	$select_category=mysql_query("select * from cms2_pages where id='".$current_page_id."'");
	$a_select_category=mysql_fetch_array($select_category);
	$parent_id=$a_select_category['parent'];
	$current_page_id=$parent_id;
	if ($parent_id==0) {break;}
	$counter=$counter+1;
	}
	return $counter;
	}



// Проверяет, есть ли у страницы вложенные страницы


	function exists_sub_pages($page_id) {
	$select_sub_pages=mysql_query("select * from cms2_pages where parent='".$page_id."'");
	if (mysql_num_rows($select_sub_pages)>0) {$result=1;} else {$result=0;}
	return $result;
	}








// Строит список страниц

	function build_list_from_pages($parent_id) {
	global $cur_top_menu;
	global $cur_show_string;
	global $all_show_string;
	$select_all_childs=mysql_query("select * from cms2_pages where parent='".$parent_id."' order by position");
	while ($line=mysql_fetch_array($select_all_childs)) 
	{
	extract($line);
	if ($parent=="0")
	{
	$cur_top_menu=$id;$cur_show_string="";
	$x=build_view($id, 1, $cur_top_menu);
//debug($x);
	print"$x";
	build_list_from_pages($id);
	print"<script ## language=\"javascript\">function show_hide_$id() { $cur_show_string }</script>";
	}
	else
	{
	$x=build_view($id, 0, $cur_top_menu);
	print"$x";
	build_list_from_pages($id);
	}
	}
	}


// Рисует позицию-страницу

	function build_view($id, $visible, $cur_top_menu) {
	global $logged_user_id;
	global $cur_top_menu;
	global $cur_show_string;
	global $all_show_string;
	global $all_hide_string;
	$cur_page=$id;
	$select_pages=mysql_query("select * from cms2_pages where id='$id'");
	$counter=0;
	while ($line_pages=mysql_fetch_array($select_pages)) 
		{
		extract($line_pages);
		if ($menu_status==0) {$menu_status_str="включена";}
		if ($menu_status==1) {$menu_status_str="отключена";}
		if ($page_status==0) {$page_status_str="включена";}
		if ($page_status==1) {$page_status_str="отключена";}
		$check_max_position=mysql_query("select * from cms2_pages where position>'$position' and parent=$parent");
		if (mysql_num_rows($check_max_position)>0) {$max=0;} else {$max=1;}
		$check_min_position=mysql_query("select * from cms2_pages where position<'$position' and parent=$parent");
		if (mysql_num_rows($check_min_position)>0) {$min=0;} else {$min=1;}
		if ($min==0) {$move_up="<a href=\"index.php?action=move_page_up&page_id=$id\" class=\"text_links\" title=\"Сдвинуть наверх\"><img alt=\"Сдвинуть наверх\" src=\"images/move_up_icon.jpg\" border=\"0\"></a>";} else {$move_up="<img src=\"images/move_up_disabled_icon.jpg\" border=\"0\" alt=\"Сдвинуть наверх нельзя\">";}
		if ($max==0) {$move_down="<a href=\"index.php?action=move_page_down&page_id=$id\" class=\"text_links\" title=\"Сдвинуть вниз\"><img alt=\"Сдвинуть вниз\" src=\"images/move_down_icon.jpg\" border=\"0\"></a>";} else {$move_down="<img src=\"images/move_down_disabled_icon.jpg\" border=\"0\" alt=\"Сдвинуть вниз нельзя\">";}
	if ($can_be_deleted=="1") {$delete="<a class=\"text_links\" href=\"javascript:confirmDelete('index.php?action=delete_page&page_id=$id')\" title=\"Удалить\"><img alt=\"Удалить\" src=\"images/delete_icon.jpg\" border=\"0\"></a>";}
	if ($can_be_deleted=="0") {$delete="<img alt=\"Удаление невозможно\" title=\"Удаление невозможно\" src=\"images/delete_disabled_icon.jpg\" border=\"0\">";}
	if ($logged_user_id=="1") {$stop_delete="<a class=\"text_links\" href=\"index.php?action=delete_page_stop&page_id=$id&cur_page_can_be_deleted=$can_be_deleted\" title=\"Запретить удаление\"><img alt=\"Запретить удаление\" img src=\"images/delete_stop_icon.jpg\" border=\"0\"></a>";} else {$stop_delete="";}
		$x=0;$arrow="";
		$x=steps_up_from_current($id)*25;

    include('pages.inc.php');
    if ($page_type!='script') 
    {
      foreach($PAGES_PURPOSES as $purpose)
        foreach($purpose as $p)
          if ($p[0]==$page_type)$page_type=$p[1];
    }
    else $page_type="скрипт-страница";



//$group_vis=$group_visible==0?'Всем':'Только зарегистрированным';



$select_existing_blocks_module=mysql_query("select * from cms2_modules where directory_title='blocks'");
$select_existing_forms_module=mysql_query("select * from cms2_modules where directory_title='forms'");
if ((mysql_num_rows($select_existing_blocks_module)>0) or (mysql_num_rows($select_existing_forms_module)>0)) {$edit_blocks="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index.php?action=edit_blocks_on_page&page_id=$id\" class=\"text_links\" title=\"Редактировать блоки и формы на странице\"><img alt=\"Редактировать блоки и формы на странице\" src=\"images/edit_blocks_icon.jpg\" border=\"0\"></a>";} else {$edit_blocks="";}

if ($visible==0) {$vis="style=\"display:none;\"";
$cur_show_string.="if (document.getElementById(\"row_".$id."_1_".$cur_top_menu."\").style.display=='none') {document.all.img_".$cur_top_menu.".src='images/minus_arrow.jpg';document.getElementById(\"row_".$id."_1_".$cur_top_menu."\").style.display='';document.getElementById(\"row_".$id."_2_".$cur_top_menu."\").style.display='';document.getElementById(\"row_".$id."_3_".$cur_top_menu."\").style.display='';document.getElementById(\"row_".$id."_4_".$cur_top_menu."\").style.display='';} else {document.all.row_".$id."_1_".$cur_top_menu.".style.display='none';document.all.row_".$id."_2_".$cur_top_menu.".style.display='none';document.all.row_".$id."_3_".$cur_top_menu.".style.display='none';document.all.row_".$id."_4_".$cur_top_menu.".style.display='none';document.all.img_".$cur_top_menu.".src='images/plus_arrow.jpg';}";
$all_show_string.="document.all.img_".$cur_top_menu.".src='images/minus_arrow.jpg';document.all.row_".$id."_1_".$cur_top_menu.".style.display='';document.all.row_".$id."_2_".$cur_top_menu.".style.display='';document.all.row_".$id."_3_".$cur_top_menu.".style.display='';document.all.row_".$id."_4_".$cur_top_menu.".style.display='';";
$all_hide_string.="document.all.row_".$id."_1_".$cur_top_menu.".style.display='none';document.all.row_".$id."_2_".$cur_top_menu.".style.display='none';document.all.row_".$id."_3_".$cur_top_menu.".style.display='none';document.all.row_".$id."_4_".$cur_top_menu.".style.display='none';document.all.img_".$cur_top_menu.".src='images/plus_arrow.jpg';";

}


PrintJavaScript();

$perm[0]='Всем';
$perm[1]='Зарегистрированным';

$permissions='
<a class="text_links" href="javascript:toggle(\'perm_'.$id.'\');" title="Права - '.$perm[$group_visible].'">
<img alt="Права" src="images/permissions'.$group_visible.'.jpg" border="0">
</a>';

$perm[$group_visible]='<b><i>'.$perm[$group_visible].'</i></b>';

$permissions.='<div id=perm_'.$id.' style="display:none">
<table cellspacing=0 cellpadding=0 border=0 align=right valign=top>
<tr><td align=right><a class="text_links" href="?action=change_page_group_visible&page_id='.$id.'&new_status=0">'.$perm[0].'</a></td></tr>
<tr><td align=right><a class="text_links" href="?action=change_page_group_visible&page_id='.$id.'&new_status=1">'.$perm[1].'</a></td></tr>
</table>
</div>
';


if (($visible==1) and ($parent=="0"))  {$onclick=""; if (exists_sub_pages($id)) {$onclick="onClick='show_hide_$id();'";$arrow="<img src=\"images/plus_arrow.jpg\" $onclick id=\"img_".$cur_top_menu."\" style=\"cursor:pointer;\" alt=\"Раскрыть вложенные страницы\">";} else {$arrow="<img src=\"images/px.gif\" width=18 height=18 border=\"0\">";}}
		if ($x>0) $arrow="<img src=\"images/sub_arrow.jpg\" align=\"left\" alt=\"Вложенная страница\">";
				$result="
					<tr valign=\"middle\" id=\"row_".$id."_1_".$cur_top_menu."\" $vis>
						<td width=\"100%\" style=\"padding-top:0px;padding-bottom:0px;padding-left:$x\">
							<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" height=\"30\">
								<tr valign=\"middle\">
									<td width=\"18\" style=\"padding-left:10px;\">$arrow</td>
									<td width=\"100%\"><div class=\"orange_names\" style=\"margin-left:5px;\"><b>$menu_title</b></div></td>
								</tr>
							</table>
						</td>
						<td align=\"left\">
							<div class=\"black_names\" align=\"left\">
							$page_type
							</div>
						</td>
						<td width=\"1\" bgcolor=\"#CCCCCC\"><img src=\"images/px.gif\" border=\"0\" width=\"1\"></td>
						<td align=\"center\"><a href=\"index.php?action=change_menu_status&page_id=$id&cur_status=$menu_status\" class=\"text_links\">$menu_status_str</a></td>
						<td width=\"1\" bgcolor=\"#CCCCCC\"><img src=\"images/px.gif\" border=\"0\" width=\"1\"></td>
						<td align=\"center\"><a href=\"index.php?action=change_page_status&page_id=$id&cur_status=$page_status\" class=\"text_links\">$page_status_str</a></td>
						<td width=\"1\" bgcolor=\"#CCCCCC\"><img src=\"images/px.gif\" border=\"0\" width=\"1\"></td>

						<td valign=\"middle\" height=\"30\">
							<div style=\"width:250px;\" class=\"gray_names\"><nobr><a href=\"index.php?action=edit_page&page_id=$id\"  class=\"text_links\" title=\"Редактировать\"><img alt=\"Редактировать\" src=\"images/edit_icon.jpg\" border=\"0\"></a>$edit_blocks&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$move_up&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$move_down&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$delete&nbsp;&nbsp;&nbsp;&nbsp;$stop_delete&nbsp;&nbsp;&nbsp;&nbsp;$permissions</nobr>
							</div>
						</td>

					</tr>
					";
				$result.="<tr id=\"row_".$id."_2_".$cur_top_menu."\" $vis valign=\"middle\"><td height=\"1\" bgcolor=\"#FFFFFF\" colspan=\"10\"><img src=\"images/px.gif\" height=\"1\"></td></tr>";
				$result.="<tr id=\"row_".$id."_3_".$cur_top_menu."\" $vis valign=\"middle\"><td height=\"1\" bgcolor=\"#CCCCCC\" colspan=\"10\"><img src=\"images/px.gif\" height=\"1\"></td></tr>";
				$result.="<tr id=\"row_".$id."_4_".$cur_top_menu."\" $vis valign=\"middle\"><td height=\"1\" bgcolor=\"#FFFFFF\" colspan=\"10\"><img src=\"images/px.gif\" height=\"1\"></td></tr>";
		}	



//debug($result);
	return $result;
}






// Строит селект из страниц

	function build_select_from_pages($parent_id, $selected) {
	$offset=0;
	global $offset_multiplier;
	$select_all_childs=mysql_query("select * from cms2_pages where parent='".$parent_id."' order by position");
	while ($line=mysql_fetch_array($select_all_childs)) 
	{
	extract($line);
	$x=build_option_view($id, $menu_title,$selected);
	print"$x";
	build_select_from_pages($id, $selected);
	}
	}

// Выводит страницу в виде опшиона 

	function build_option_view($id, $title,$selected) {
	global $cur_page_id;
	$offset=steps_up_from_current($id);
	if ($id!=$cur_page_id) $result="<option value=\"$id\""; if ($selected==$id) {$result.=" selected ";} $result.=">"; for ($x=0;$x<$offset;$x++) {$result.="--";} $result.="$title </option>";
	return $result;
	}

// Выводит селект из категорий каталога 

	function build_catalog_category_select($parent_id, $selected) {
	$offset=0;
	global $offset_multiplier;
	$select_all_childs=mysql_query("select * from cms2_pages where parent='".$parent_id."' order by position");
	while ($line=mysql_fetch_array($select_all_childs)) 
	{
	extract($line);
	if ($page_type=="catalog") {
	$x=build_option_view($id, $menu_title,$selected);
	print"$x";}
	build_catalog_category_select($id, $selected);
	}
	}
		function smarty_modifier_mb_truncate(
            $string, 
	            $length = 80,
	            $etc = '...',
	            $charset='UTF-8',
	            $break_words = false,
	            $middle = false) {
	
	    if ($length == 0) return '';
	 
	    if (strlen($string) > $length) {
	        $length -= min($length, strlen($etc));
	        if (!$break_words && !$middle) {
	            $string = preg_replace('/\s+?(\S+)?$/', '', 
	                             mb_substr($string, 0, $length+1, $charset));
	        }
	        if(!$middle) {
	            return mb_substr($string, 0, $length, $charset) . $etc;
	        } else {
	            return mb_substr($string, 0, $length/2, $charset) . 
	                             $etc . 
	                             mb_substr($string, -$length/2, $charset);
	        }
	    } else {
	        return $string;
	    }
	}
	
	function rus_date() 
{
     $translate = array(
     "am" => "дп",
     "pm" => "пп",
     "AM" => "ДП",
     "PM" => "ПП",
     "Monday" => "Понедельник",
     "Mon" => "Пн",
     "Tuesday" => "Вторник",
     "Tue" => "Вт",
     "Wednesday" => "Среда",
     "Wed" => "Ср",
     "Thursday" => "Четверг",
     "Thu" => "Чт",
     "Friday" => "Пятница",
     "Fri" => "Пт",
     "Saturday" => "Суббота",
     "Sat" => "Сб",
     "Sunday" => "Воскресенье",
     "Sun" => "Вс",
     "January" => "Января",
     "Jan" => "Янв",
     "February" => "Февраля",
     "Feb" => "Фев",
     "March" => "Марта",
     "Mar" => "Мар",
     "April" => "Апреля",
     "Apr" => "Апр",
     "May" => "Мая",
     "May" => "Мая",
     "June" => "Июня",
     "Jun" => "Июн",
     "July" => "Июля",
     "Jul" => "Июл",
     "August" => "Августа",
     "Aug" => "Авг",
     "September" => "Сентября",
     "Sep" => "Сен",
     "October" => "Октября",
     "Oct" => "Окт",
     "November" => "Ноября",
     "Nov" => "Ноя",
     "December" => "Декабря",
     "Dec" => "Дек",
     "st" => "ое",
     "nd" => "ое",
     "rd" => "е",
     "th" => "ое"
     );
     
     if (func_num_args() > 1) {
         $timestamp = func_get_arg(1);
         return strtr(date(func_get_arg(0), $timestamp), $translate);
     } else {
         return strtr(date(func_get_arg(0)), $translate);
    }
}
function month_name2($m) {
if ($m==1) $m="январь";
if ($m==2) $m="февраль";
if ($m==3) $m="март";
if ($m==4) $m="апрель";
if ($m==5) $m="май";
if ($m==6) $m="июнь";
if ($m==7) $m="июль";
if ($m==8) $m="август";
if ($m==9) $m="сентябрь";
if ($m==10) $m="октябрь";
if ($m==11) $m="ноябрь";
if ($m==12) $m="декабрь";
return $m;
}

function get_order_message($type='')
	{
		$url_type = $type ? '/'.$type.'/zakaz_i_dostavka.html' : '/zakaz_i_dostavka.html';
		return
		'<div style="display:none;">
				 <div id="submittedDiv" style=" padding: 10px 10px 17px; width: 360px;">
					<b>Изделие добавлено в заказ.</b>
				    <p style="margin: 0; padding-top: 10px;">
				    Вы можете оформить заявку на выбранную продукцию прямо сейчас или продолжить просмотр сайта.<br>
					<p style="margin: 0; padding-top: 10px; text-align: left;">
					<button style = "float:none;" class = "issue_order readmore '.$type.'" onclick=\'document.location.href="'.$url_type.'";\'>Оформить заявку</button>&nbsp;&nbsp;&nbsp;
					<button class = "continue_view readmore '.$type.'" onclick=\'parent.jQuery.fancybox.close();\'>Продолжить просмотр</button>
				</div>
			</div>
			<a href="#submittedDiv" id="hidden_link"></a>
			<div style="display:none;">
				 <div id="submittedDiv2" style=" padding: 10px 10px 17px; width: 200px;">
					<b>Изделие удалено.</b>
				    <p style="margin: 0; padding-top: 10px;">
					<p style="margin: 0; padding-top: 10px; text-align: left;">
					<button class = "continue_view readmore '.$type.'" onclick=\'parent.jQuery.fancybox.close();\'>Продолжить просмотр</button>
				</div>
			</div>
			<a href="#submittedDiv2" id="hidden_link2"></a>';
	}
?>