<html>
<head>
<Title>
</Title>
<Meta Http-equiv="Content-Type" Content="text/html; charset=Windows-1251">
<Meta name="author" Content="DNK">
<Meta name="description" Content="">
<Meta name="keywords" Content="">
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body bgcolor="#FFFFFF">

<?php


  function myPreExtractCallBack($p_event, &$p_header)
  {
      if (!is_dir($p_header['filename'])) {@unlink($p_header['filename']);}
	 return 1; 
    
  }






include"new_versions_cfg.php";

if (@$sub_action=="get_update")
	{
	print"
	<div class=\"orange_names\"><br><b>Обновление CMS:</b><br></div>
	";
	print"<div class=\"black_names\">Шаг 2: Проводится установка пакета обновлений, ждите...</div>";
	$update_file=str_replace("..","",$update_file);
	$u_f=$new_versions_download_container."/".$update_file;
	if (file_exists("../new_versions_temp/update.zip")) {unlink("../new_versions_temp/update.zip");}
	copy($u_f, "../new_versions_temp/update.zip");
	print"<script language=\"javascript\">window.location='check_version.php?sub_action=extract_update';</script>";
	}


if (@$sub_action=="extract_update")
	{
	require_once('pclzip.lib.php');
	$archive = new PclZip("../new_versions_temp/update.zip");
	$list = $archive->extract(PCLZIP_OPT_PATH, "",PCLZIP_CB_PRE_EXTRACT, 'myPreExtractCallBack');
	print"<script language=\"javascript\">window.location='check_version.php?sub_action=success';</script>";
	}


if (@$sub_action=="success") {$success_message="Обновление проведено успешно.";} else {$success_message="";}

$file = "cur_version.txt";
$fp = fopen("$file", "r");
$version=fgets($fp);
fclose($fp); 

;

$new_version_file = $new_versions_location."/cur_version.txt";
$get_new_version_script = $new_versions_location."/get_new_version.php";
$fp = fopen("$new_version_file", "r");
$possible_version=fgets($fp);
fclose($fp); 


if ($version==$possible_version) {$upload_message="<div class=\"black_names\">Текущая версия CMS: DNK Control $version. Новых версий на данный момент нет.</div>";}
if ($version!=$possible_version) 
{
include"dbconnect.php";
dbconnect();
$select_modules=mysql_query("select * from cms2_modules");
while ($line_modules=mysql_fetch_array($select_modules)) 
{
extract($line_modules);
$modules_line.="$directory_title".";";
}
$modules_line=substr($modules_line,0,strlen($modules_line)-1);

$source_site=$_SERVER['HTTP_REFERER'];

$upload_message="
<div style=\"display:none\">
<form action=\"$get_new_version_script\" method=\"post\" id=\"get_new_version_form\">
<input type=\"hidden\" name=\"modules_line\" value=\"$modules_line\">
<input type=\"hidden\" name=\"source_site\" value=\"$source_site\">
</form></div>

<div class=\"black_names\" name=\"get_new_version_div\">Текущая версия CMS: DNK Control $version. <br>
<b>Внимание!</b> Возможно обновление до: DNK Control $possible_version. Вы можете <a class=\"text_links\" href=\"#\" onClick=\"document.all.get_new_version_div.innerHTML='Шаг 1: Проводится подготовка пакета обновлений, ждите...';document.all.get_new_version_form.submit();\">запустить обновление</a></div>
";
}
print"
<div class=\"orange_names\"><br><b>Обновление CMS:</b><br></div>
";
if ($success_message!="") {print"<div class=\"black_names\">$success_message</div>";}
print"$upload_message";
?>

</BODY>
</HTML>