<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

require_once "{$_SERVER['DOCUMENT_ROOT']}/new_admin/functions.php";
require_once "importer/excel_reader/reader.php";
require_once "importer/import_impl_carslberg.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/new_admin/translit.php";

require_once "header.php";

$pcontent = $pcontent2 = '';

$action = null;
@$action = $_REQUEST['action'];

$SITE_INTRASETI_ROOT = $_SERVER['DOCUMENT_ROOT'].'/';

if($action == 'upload_catalog') 
{
	$res = '';
	$name_of_uploaded_file = basename($_FILES['catalog']['name']);
	if(isset($_FILES['catalog']) && 
	   $_FILES['catalog']['tmp_name'] != '' && 
	   $_FILES['catalog']['size'] != 0 &&
	   strpos($name_of_uploaded_file, '.xls'))
	{
		// ! Изменить обратно
		$folder = $SITE_INTRASETI_ROOT . 'carlsberg/admin/importer/';
		$filename = $folder . 'site_data.xls';		
		copy($filename, $folder . 'site_data_' . time() . '.xls');
		$rename_result = rename($_FILES['catalog']['tmp_name'], $filename);		
		chmod($filename, 0644); 
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('CP1251');
		$data->read($filename);
		$id = '23';
		dbconnect();
		$error = import_data($id, $data);
		$res =  "<font style='color: green;'>Файл успешно загружен</font>".$error;
	}
	else		
	{
		echo "<font style='color: red;'>Файл с каталогом пустой или имеет недопустимое имя/расширение</font>";
        }
} 
else if($action == 'upload_images') 
{
	if(isset($_FILES['images']) && $_FILES['images']['tmp_name'] != '' && $_FILES['images']['size'] != 0) 
	{
		$name_of_uploaded_file = basename($_FILES['images']['name']);
		$type_of_uploaded_file = substr($name_of_uploaded_file, strrpos($name_of_uploaded_file, '.') + 1);

		if(!is_allowed_filetype($type_of_uploaded_file))
		{	
			echo "Недопустимое имя файла $name_of_uploaded_file";
			return;
		}
		$folder = $SITE_INTRASETI_ROOT . 'images/items/';
		$filename = $folder .'middle/'. $_FILES['images']['name'];
		if(move_uploaded_file($_FILES['images']['tmp_name'], $filename)) 
		{		
			$zip = zip_open($filename);
			if ($zip&&strpos($filename,'.zip')!==false) {
				while ($zip_entry = zip_read($zip)) {
					$filename = $folder .'middle/'. zip_entry_name($zip_entry);
					$fp = fopen($filename, "w");
						if (zip_entry_open($zip, $zip_entry, "r")) {
						  $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
						  fwrite($fp,"$buf");
						  zip_entry_close($zip_entry);
						  fclose($fp);
						  createThumbs($filename);
						  $basename = basename($filename);
						  $pcontent .= "
					<TR><TD>{$basename}&nbsp;&nbsp;(<a href='/images/items/middle/{$basename}' target='_blank'>посмотреть</a>)</td>
					<td>" . filesize($SITE_INTRASETI_ROOT . 'images/items/middle/' . $basename) . "</td>
					</TR>
				";
						} else {
							echo "zip entry" . zip_entry_name($zip_entry) . " cannot be open";
						}
				}
				$ret_str = "<font style='color: green;'>Данные успешно загружены.</font>";
				zip_close($zip);
			} 
			else
			{
					createThumbs($filename);	
					 $basename = basename($filename);
				$pcontent .= "
					<TR><TD>{$basename}&nbsp;&nbsp;(<a href='/images/items/middle/{$basename}' target='_blank'>посмотреть</a>)</td>
					<td>" . filesize($SITE_INTRASETI_ROOT . 'images/items/middle/' . $basename) . "</td>
					</TR>
				";
			}
		} 
		else 
		{
			echo $filename . " не может быть сохранен";
		}	

		$pcontent = "<p style='margin: 0; padding-top: 20px;'>Новые фото:<p style='margin: 0; padding-top: 10px;'><TABLE border=1 cellpadding=5 cellspacing=0 class=whitelinks><TR><TH>Имя</TH><th>Размер (байт)</th></TR>{$pcontent}</TABLE>\n";
	}
	else
	{	
		echo "Размер загружаемого файла превышает допустимое значение";
		return;
	}
} 
else if($action == 'show_images') 
{
	$myDirectory = opendir($SITE_INTRASETI_ROOT . 'images/catalog/');
	while($entryName = readdir($myDirectory)) {
		if(strpos($entryName, 'origImage_') !== 0 || strpos($entryName, '.zip'))
			continue;
		$dirArray[] = substr($entryName, 10);
	}       		
	closedir($myDirectory);
	if($dirArray && count($dirArray) > 0)
	{
		sort($dirArray);
		foreach($dirArray as $entry) 
		{
	       		if ($entry[0] == ".") continue;
			$pcontent .= "
				<TR><TD>{$entry}&nbsp;&nbsp;(<a href='/images/catalog/middle/{$entry}' target='_blank'>посмотреть</a>)</td>
				<td>" . filesize($SITE_INTRASETI_ROOT .'images/catalog/middle/' . $entry) . "</td>
				</TR>
			";
		}
		$pcontent = "<p style='margin: 0; padding-top: 20px;'><TABLE border=1 cellpadding=5 cellspacing=0 class=whitelinks><TR><TH>Имя</TH><th>Размер (байт)</th></TR>{$pcontent}</TABLE>\n";
	}
}
else if($action == 'show_catalog_backup') 
{
	$myDirectory = opendir($SITE_INTRASETI_ROOT . '/carlsberg/admin/importer/');
	while($entryName = readdir($myDirectory)) {
		if(strpos($entryName, 'site_data_') !== false)
			$dirArray[] = $entryName;
	}       		
	closedir($myDirectory);
	sort($dirArray);
	foreach($dirArray as $entry) 
	{
       		if ($entry[0] == ".") continue;
		$pcontent2 .= "
			<TR><TD><a href='/admin/importer/{$entry}'>{$entry}</a></td></TR>
		";
	}
	$pcontent2 = "<p style='margin: 0; padding-top: 20px;'><TABLE border=1 cellpadding=5 cellspacing=0 class=whitelinks><TR><TH>Имя</TH></TR>{$pcontent2}</TABLE>\n";
}
else if($action == 'upload_price_list') {
	if(isset($_FILES['prices']) && $_FILES['prices']['tmp_name'] != '' && $_FILES['prices']['size'] != 0) {		
		$filename =  '/home/r/ruiispb/public_html/files/catalog.xls';
		if(!move_uploaded_file($_FILES['prices']['tmp_name'], $filename)) {	
			echo "price list upload failed";
		}
	}
} 

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Загрузка каталога</title>	
	<?php echo $common_links; ?>	
	<?php echo $after_ext_links; ?>		
</head>
<body onLoad="setSelectedMenu(2);">
		<?php echo $common_top; ?>
		<div id="container_main2" style="top: 0;">	
		<div id="container_3">
			<div id="login-form" style="width:670px;font-size:12px; padding-top: 330px;">
				<p style="text-align:center;font-size:14px;font-weight:bold;margin-bottom:20px">Импорт данных каталога и фотографий</p>
				<form method="post" enctype="multipart/form-data" action='catalog_carlsberg.php?action=upload_catalog'>
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr>
					<td width="240">Выберите Excel файл каталог:</td><td><input type="file" size="40" name="catalog"></td>
					<td><input type="submit" value="Загрузить"></td> 
					</tr>			
					</table>				
				</form>				
				<form method="post" enctype="multipart/form-data" action='catalog_carlsberg.php?action=upload_images' style="margin-top:10px">
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr>
					<td width="240">Выберите файл с фотографиями:</td> <td><input type="file" size="40" name="images"></td>
					
					<td><input type="submit" value="Загрузить"></td>
					</tr>
					</table>					
				</form>	
				<div style="margin-top:20px">
					<a  href="../admin/importer/site_data.xls<?php echo '?'.time(); ?>">Последняя версия каталога</a>
				</div>
				<div style="margin-top:20px">
					<?php echo $res;?>
				</div>
				<div style="margin-top:20px">
					<form method="post" enctype="multipart/form-data" action='catalog_carlsberg.php?action=show_catalog_backup' style="margin-top:10px">
						<input type="submit" value="Показать старые версии каталога">
					</form>	
					<?php echo $pcontent2; ?>
				</div>
				<div style="margin-top:20px">
					<form method="post" enctype="multipart/form-data" action='catalog_carlsberg.php?action=show_images' style="margin-top:10px">
						<input type="submit" value="Показать список изображений">
					</form>	
					<?php echo $pcontent; ?>
				</div>
			</div>
		</div>
		</div>	
	
</body>
</html>

<?php
function createThumbs($fname)
{
//	echo "Creating thumbnails for {$fname} <br />";

  	list($width, $height, $type) = getimagesize($fname);

  	if($type == 1)
		$img = imagecreatefromgif($fname);
  	else if($type == 2)
		$img = imagecreatefromjpeg($fname);
  	else if($type == 3)
		$img = imagecreatefrompng($fname);
	else
	{ 
		echo "Unable to open image $fname"; 
		return;
	}

	createThumb($fname, $img, $width, $height, $type, '/small/', 80, 0);
	createThumb($fname, $img, $width, $height, $type, '/460x530/', 460, 0);
}

function createThumb( $fname, $img, $width, $height, $type, $prefixdest, $new_width, $new_height)
{
	ini_set('memory_limit', '128M'); 

	if($new_width)	
		$new_height = floor( $height * ( $new_width / $width ) );
	else
		$new_width = floor( $width * ( $new_height / $height ) );

	$tmp_img = imagecreatetruecolor( $new_width, $new_height );

	imagecopyresampled( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

	$nname = str_replace('/middle/', $prefixdest, $fname);
  	if($type == 1)
		imagegif($tmp_img, $nname);
  	else if($type == 2)
		imagejpeg($tmp_img, $nname, 100);
  	else if($type == 3)
		imagepng($tmp_img, $nname, 0);

	imagedestroy($tmp_img);
}

function is_allowed_filetype($type_of_uploaded_file)
{
	$allowed_extensions = array("ZIP", "JPG", "GIF", "PNG");
	for($i=0; $i < sizeof($allowed_extensions); $i++)
	{
		if(strcasecmp($allowed_extensions[$i], $type_of_uploaded_file) == 0)
			return true;
	}
	return false;
}

?>
