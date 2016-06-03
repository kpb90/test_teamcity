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

<? 


$file_name="new_version_".date('j_m_Y_h_m_s').".zip";
$fileName = "../new_versions_temp/".$file_name;
require_once('pclzip.lib.php');
$archive = new PclZip($fileName);
$a_modules=explode(";",$modules_line);
for ($x=0;$x<count($a_modules);$x++) 
	{
	$cur_dir="modules/".$a_modules[$x]."/";
	$v_list = $archive->add($cur_dir);
	}
$v_list = $archive->add("cur_version.txt");
$v_list = $archive->add("check_version.php");
$v_list = $archive->add("functions.php");
$v_list = $archive->add("vvv_calendar.js");
$v_list = $archive->add("get_new_version.php");
$v_list = $archive->add("pclzip.lib.php");
$v_list = $archive->add("style.css");
$v_list = $archive->add("index.php");
$v_list = $archive->add("images/");


print"$modules_line";
print"$source_site";

$a_source_site=explode("admin",$source_site);
$back=$a_source_site[0]."/admin/check_version.php";



print"


<div class=\"orange_names\"><br><b>Обновление CMS:</b><br></div>
";
print"<script language=\"javascript\">document.location='$back?sub_action=get_update&update_file=$file_name';</script>";
?>

</BODY>
</HTML>

