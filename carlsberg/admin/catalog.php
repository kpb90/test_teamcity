<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
require_once "header.php";
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

error_reporting(E_ALL);
ini_set('display_errors','Off');

require_once "../admin/functions.php";
require_once "../admin/importer/excel_reader/reader.php";
require_once "../admin/importer/import_impl.php";
require_once "../admin/translit.php";

//$GLOBALS['origImage_'] = 'origImage_';
$GLOBALS['origImage_'] = '';

$pcontent = '';
$action = null;
@$action = $_REQUEST['action'];
$SITE_INTRASETI_ROOT = $_SERVER['DOCUMENT_ROOT'].'/';

if($action == 'upload_catalog') {
	$name_of_uploaded_file = basename($_FILES['catalog']['name']);
	if(isset($_FILES['catalog']) && 
	   $_FILES['catalog']['tmp_name'] != '' && 
	   $_FILES['catalog']['size'] != 0 &&
	   strpos($name_of_uploaded_file, '.xls'))
	{
		$folder = $SITE_INTRASETI_ROOT . 'admin/importer/';
		$filename = $folder . 'site_data.xls';		
		copy($filename, $folder . 'site_data_' . time() . '.xls');
		$rename_result = rename($_FILES['catalog']['tmp_name'], $filename);		
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('CP1251');
		$data->read($filename);
		$ret_str = '';
		if(is_array($data->sheets[0]['cells']))
		{
			$id = '13';
			dbconnect();
			$result=import_data($id, $data);
			if (!$result)
			{
				$ret_str="<font style='color:red;'>Не удалось импортировать данные категорий.</font>";
			}
			else
			{
				$not_found_files = check_files();

				if ($not_found_files)
				{
					$ret_str.="<br/><br/><font style='color: red;'>Внимание! Следующие файлы не найдены на сервере:</font><br/><br/>{$not_found_files}";
				}
				echo "<div style='position: absolute; top: 550px; left: 0px; width: 100%;'><div style=' margin: 0 auto; width: 665px;'><span style = 'color:green'>Данные категорий успешно загружены!</span><br/>{$ret_str}</div></div>";
			}
		}
		else
			$ret_str = "<font style='color: red;'>Не удалось прочитать Excel файл.</font>";

		echo "<div style='position: absolute; top: 500px; left: 0px; width: 100%;'><div style=' margin: 0 auto; width: 665px;'>{$ret_str}</div></div>";
	}
	else		
	{
		echo "<font style='color: red;'>Файл с категориями пустой или имеет недопустимое имя/расширение.</font>";
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
		
		$folder = $SITE_INTRASETI_ROOT . 'images/';
		$filename = $folder .$GLOBALS['origImage_'] . $_FILES['images']['name'];
		
		if(move_uploaded_file($_FILES['images']['tmp_name'], $filename)) 
		{			
			if(strcasecmp("ZIP", $type_of_uploaded_file) == 0)
			{
				$zip = zip_open($filename);
				if ($zip) 
				{
					$pcontent = '';
					while ($zip_entry = zip_read($zip)) 
					{
						if(zip_entry_filesize($zip_entry) <= 0)
							continue;
						$ffname = zip_entry_name($zip_entry);	
						if(strpos($ffname, 'MACOSX/') !== FALSE)
							continue;

					    if(!is_allowed_filetype(substr($ffname, strrpos($ffname, '.') + 1)))
					    {
							echo "Недопустимое имя файла $ffname в архиве";
							continue;
	                    }
	
					    $unpacked_name = $folder . $GLOBALS['origImage_'] . $ffname;	
					    $fp = fopen($unpacked_name, "w");
					    if (zip_entry_open($zip, $zip_entry, "r")) 
					    {
					      fwrite($fp, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));
					      zip_entry_close($zip_entry);
					      fclose($fp);
					      //createThumbs($unpacked_name);
					        //resize_with_bachground ($folder,$ffname,'','/brand/');
							$pcontent .= "
								<TR><TD>{$ffname}&nbsp;&nbsp;(<a href='/images/{$GLOBALS['origImage_']}{$ffname}' target='_blank'>посмотреть</a>)</td>
								<td>" . filesize($folder.$GLOBALS['origImage_'] . $ffname) . "</td>
								</TR>
							";
					    } 
					    else 
							echo "$ffname в архиве не может быть открыт";
					 }
					 zip_close($zip);
				
				} 
				else 
					echo $filename . " не может быть открыт";
			}
			
			else
			{
			    //createThumbs($filename);	
				//resize_with_bachground ($folder,$_FILES['images']['name'],'','/brand/');
				$pcontent = "
					<TR><TD>{$_FILES['images']['name']}&nbsp;&nbsp;(<a href='/images/{$GLOBALS['origImage_']}{$_FILES['images']['name']}' target='_blank'>посмотреть</a>)</td>
					<td>" . filesize($SITE_INTRASETI_ROOT . "images/{$GLOBALS['origImage_']}" . $_FILES['images']['name']) . "</td>
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

else if($action == 'show_not_found_files')
{
	$pcontent = check_files ();
	if (!$pcontent)
		$pcontent = "<span style = 'color:green;'>Все файлы найдены</span>";
}
else if($action == 'show_images')
{
	$path = $SITE_INTRASETI_ROOT.'images/';
	$myDirectory = opendir($path);
	while($entryName = readdir($myDirectory)) {
		$dirArray[] = $entryName;
	}

	closedir($myDirectory);
	sort($dirArray);
	foreach($dirArray as $entry)
	{
		if ($entry[0] == ".") continue;
		$pcontent .= "
		<TR><TD><a href='/images/{$entry}' target='_blank'>{$entry}</a></td>
		<td>" . filetype($path . $entry) . "</td>
			<td>" . filesize($path . $entry) . "</td>
			</TR>
		";
	}
	$pcontent = "<p style='margin: 0; padding-top: 20px;'><TABLE border=1 cellpadding=5 cellspacing=0 class=whitelinks><TR><TH>Filename</TH><th>Filetype</th><th>Filesize</th></TR>{$pcontent}</TABLE>\n";
}

function resize_with_bachground ($folder,$ffname,$prefix = '',$where_output = '')
{
	$fname = str_replace ('//','/',$folder.$ffname);

	$maxWidth = 134;
	$maxHeight = 100;
	$bgColor = array(255, 255, 255);
	
	list($width, $height, $type) = getimagesize($fname);

	if($type == 1)
	{
		$img = imagecreatefromgif($fname);
	}
	else
		if($type == 2)
		{
			$img = imagecreatefromjpeg($fname);
		}
		else
			if ($type == 3)
			{
				$img = imagecreatefrompng($fname);
			}
		
	$width = imagesx($img);
	$height = imagesy($img);

	$kw = $width / $maxWidth;
	$kh = $height / $maxHeight;
	$k = $kw > $kh ? $kw : $kh;
	$newImg = imagecreatetruecolor($maxWidth, $maxHeight);
	$bg = imagecolorallocate($newImg, $bgColor[0], $bgColor[1], $bgColor[2]);
	imagefill($newImg, 0, 0, $bg);
	if($k > 1) {
		$newWidth = (int) ($width / $k);
		$newHeight = (int) ($height / $k);
	} else {
		$newWidth = $width;
		$newHeight = $height;
	}
	$left = (int) (($maxWidth - $newWidth) / 2);
	$top = (int) (($maxHeight - $newHeight) / 2);
	imagecopyresampled($newImg, $img, $left, $top, 0, 0, $newWidth, $newHeight, $width, $height);
	
	$fname = str_replace ('//','/',$folder.$where_output.$prefix.$ffname);
	if($type == 1)
	{
		$flag = imagegif($newImg, $fname);
	}
	else if($type == 2)
	{
		$flag = imagejpeg($newImg, $fname, 100);
	}
	else if($type == 3)
	{
		$flag = imagepng($newImg, $fname, 0);
	}
}

function createThumbs($fname)
{

	list($width, $height, $type) = getimagesize($fname);

	if($type == 1)
	{
		$img = imagecreatefromgif($fname);
		$background = imagecolorallocate($img, 0, 0, 0);
		imagecolortransparent($img, $background);
	}
	else if($type == 2)
		$img = imagecreatefromjpeg($fname);
	else if($type == 3)
		$img = imagecreatefrompng($fname);
	else
	{
		echo "Unable to open image $fname";
		return;
	}

	createThumb($fname, $img, $width, $height, $type, 'bigImage', 435, 246);
	//createThumb($fname, $img, $width, $height, $type, 'middleImage', 320, 270);
	//createThumb($fname, $img, $width, $height, $type, 'smallImage', 200, 142);
}

function createThumb( $fname, $img, $width, $height, $type, $prefixdest, $new_width, $new_height)
{
	ini_set('memory_limit', '128M');

	$new_height = floor( $height * ( $new_width / $width ) );

	$tmp_img = imagecreatetruecolor( $new_width, $new_height );

	imagecopyresampled( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

	$nname = str_replace('origImage', $prefixdest, $fname);
	if($type == 1)
		imagegif($tmp_img, $nname);
	else if($type == 2)
		imagejpeg($tmp_img, $nname, 100);
	else if($type == 3)
		imagepng($tmp_img, $nname, 0);
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

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Загрузка категорий</title>	
	<?php echo $common_links; ?>	
	<?php echo $after_ext_links; ?>		
</head>
<body onLoad="setSelectedMenu(1);">
		<?php echo $common_top; ?>
		<div id="container_main2" style="height:400px;top:40%;">	
		<div id="container_3">
			<div id="login-form" style="width:670px;font-size:12px">
				<p style="text-align:center;font-size:14px;font-weight:bold;margin-bottom:20px">Импорт данных категорий</p>
				<table cellpadding="0" cellspacing="3" border="0" width="100%" style="position:relative;">
					<tr>
						<td>
							<form method="post" enctype="multipart/form-data" action='catalog.php?action=upload_catalog'>
								<table cellpadding="0" cellspacing="3" border="0" width="100%">
									<tr>
										<td width="240">Выберите Excel файл категорий:</td>
										<td><input type="file" size="40" name="catalog"></td>
										<td><input type="submit" value="Загрузить"></td> 
									</tr>			
								</table>				
							</form>		
						</td>		
						<td>
							<a  href="../admin/importer/site_data.xls">Последняя версия excel категорий</a>
						</td>
					</tr>
				</table>
				<?php echo $pcontent;?>
			</div>
		</div>
		</div>	
	
</body>
</html>
