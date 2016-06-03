<?php

if (@get_magic_quotes_gpc())
{
  Array_SS($_GET);
  Array_SS($_POST);
  Array_SS($_COOKIE);
  //foreach ($_POST as $k=>$v) if(!is_array($v))$_POST[$k] = stripslashes($v);
  //foreach ($_COOKIE as $k=>$v) if(!is_array($v)) $_COOKIE[$k] = stripslashes($v);
  //foreach ($_GET as $k=>$v) if(!is_array($v)) $_GET[$k] = stripslashes($v);  //?
}

function Array_SS(&$array)
{
  foreach($array as $k=>$v)
  {
    if (is_array($v)) $array[$k]=Array_SS($v);
    if (is_string($v)) $array[$k]=stripslashes($v);
  }
  return $array;
}

function IsUser(){return (isset($_SESSION['authorized']));}

function PrintSeparator($N)
{
echo '<tr valign="middle"><td colspan='.$N.' height=1 bgcolor="#FFFFFF"><img src="images/px.gif" height=1></td></tr>
<tr valign="middle"><td colspan='.$N.' height=1 bgcolor="#CCCCCC"><img src="images/px.gif" height=1></td></tr>
<tr valign="middle"><td colspan='.$N.' height=1 bgcolor="#FFFFFF"><img src="images/px.gif" height=1></td></tr>';
}

function PrintTableHeader($text,$nobr=0,$align='center')
{
if (!is_array($text)) $text=array($text);
echo '<table cellpadding=0 cellspacing=0 border=0 width="100%"><tr>';
for($i=0;$i<sizeof($text);$i++)
echo '<td bgcolor="#434343" style="padding-right:20px;text-align:'.$align.';height:24px;"><div class="razdelz_headers">'.($nobr==1?'<nobr>'.$text[$i].'</nobr>':$text[$i]).'</div></td>';
echo '</tr>';
}

function PrintTableRow($text)
{
if (!is_array($text))$text=array($text);
echo '<tr style="vertical-align:middle">';
for($i=0;$i<sizeof($text);$i++)PrintTableCell(strlen($text[$i])==0?'&nbsp;':$text[$i],$i!=sizeof($text)-1);
echo '</tr>';
PrintSeparator(sizeof($text));
}

function PrintTableCell($text,$border=0)
{
  echo '<td style="padding-top:2px;padding-bottom:2px;padding-right:5px;padding-left:2px;height:20px;'.($border==0?'':'border-right:1px solid #CCCCCC;').'"><div class="black_names">'.$text.'</div></td>';
}

function MakeDelete($link)
{
  return '<a href="javascript:confirmDelete(\''.$link.'\')" class="text_links" title="Удалить"><img alt="Удалить" src="images/delete_icon.jpg" border=0></a>';
}

function MakeEdit($link)
{
  return '<a href="'.$link.'" class="text_links" title="Редактировать"><img alt="Редактировать" src="images/edit_icon.jpg" border=0></a>';
}

function AdminGoTo($a)
{
echo '<script language="Javascript">document.location=\''.$a.'\';</script>';
}

function PrintBack($a)
{
echo '<table cellpadding=0 cellspacing=0 border=0><tr>';
for($i=0;$i<sizeof($a);$i++)
{
echo '<td><a href="'.$a[$i][0].'"><img src="images/back_icon.jpg" border=0></a></td>
<td><a href="'.$a[$i][0].'"><div class="orange_names"><u><nobr>'.$a[$i][1].'</nobr></u></div></a></td>';
echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>';
}
echo '</tr></table><br>';
}

function convert_bytes($result)
{
  if ($result>(1024*1024))
  {
    $result=round(($result/1024/1024)).' Mбайт';
  }
  elseif ($result>1024)
  {
    $result=round(($result/1024)).' Кбайт';
  }
  return $result;
}

function GetVar($var,$method='get',$default='')
{
$result='';if (strtolower($method)=='get')$result=((isset($_GET[$var]))&&($_GET[$var]!=''))?$_GET[$var]:$default;else $result=((isset($_POST[$var]))&&($_POST[$var]!=''))?$_POST[$var]:$default;return $result;
}

function PrintJavaScript()
{
print "<script language=\"JavaScript\">
function GetById(id){if(document.getElementById){return document.getElementById(id);}else if(document.all){return document.all[id];}else if(document.layers){return document.layers[id];};return null;}
function hide(){for(i=0; i<hide.arguments.length; i++) GetById(hide.arguments[i]).style.display = 'none';}
function show(){for(i=0; i<show.arguments.length; i++) GetById(show.arguments[i]).style.display = 'block';}
function toggle(){for(i=0; i<toggle.arguments.length; i++){id=toggle.arguments[i];if (GetById(id).style.display == 'none') show(id);else hide(id);}}
</script>";
}

function PrintTableJavaScript()
{
print "<script language=\"JavaScript\">
function GetById(id){if(document.getElementById){return document.getElementById(id);}else if(document.all){return document.all[id];}else if(document.layers){return document.layers[id];};return null;}
function hide(){for(i=0; i<hide.arguments.length; i++) GetById(hide.arguments[i]).style.display = 'none';}
function show(){for(i=0; i<show.arguments.length; i++) GetById(show.arguments[i]).style.display = '';}
function toggle(){for(i=0; i<toggle.arguments.length; i++){id=toggle.arguments[i];if (GetById(id).style.display == 'none') show(id);else hide(id);}}
</script>";
}

function Debug($var,$text='')
{
ob_start();
var_dump($var);
$str=ob_get_clean();
echo '<table cellspacing=2 cellspacing=2 style="border:2px solid black">';
if ($text!='') echo '<tr><td width=100% align=center><b>'.$text.'</b></td></tr>';
echo '<tr><td bgcolor=lime><pre><b><big>'.htmlspecialchars($str).'</big></b></pre></td></tr></table>';
}

function fetchrowset($q)
{
  $result=array();while($rowset = @mysql_fetch_array($q)) $result[]=$rowset;return $result==''?false:$result;
}

function afetchrowset($q)
{
  $result=array();while($rowset = @mysql_fetch_array($q,MYSQL_ASSOC)) $result[]=$rowset;return $result==''?false:$result;
}

function nfetchrowset($q)
{
  $result=array();while($rowset = @mysql_fetch_array($q,MYSQL_NUM)) $result[]=$rowset;return $result==''?false:$result;
}

function IsAdmin(){return $_SESSION['logged_user_id']==1;}

function Cook($Name,$Value,$time=0)
{
  if ($time==0) $time=31104000;
  SetCookie($Name,$Value,time()+$time);
}

//ATR_SET_INSERTING
function Insert_Att($att_id,$added_id,$folder)
{
global $HTTP_POST_VARS,$_FILES;
$values_array=Array();
for ($cc=0;$cc<1000;$cc++)$values_array[$cc]="###empty###";


		if ($att_id!=0) 
			{
			foreach ($HTTP_POST_VARS as $key => $value) 
				{
				$a=explode('_',$key);
				if ($a[0]=="attribute") 
					{
					$values_array[$a[1]]=$value;$rr=$values_array[$a[1]];;
					}
				}
			foreach ($_FILES as $key => $value) 
				{
				$a=explode('_',$key);
				if ($a[0]=="picture") 
					{
					if ($_FILES[$key]['name']!="")
						{
						$new_name="";
						$extension = addslashes($_FILES[$key]['name']);
						$start=0;
						for ($x=strlen($extension)-1;$x>0; $x=$x-1) 
							{
							$start=$start+1;
							if ($extension[$x]==".") {break;}
							}
						$extension=substr($extension,-$start+1);
						if (($extension!="jpg") and ($extension!="gif") and ($extension!="bmp") and ($extension!="pcx") and ($value!="")) {$pic_ext_err=1;}
						if ($pic_ext_err!="1") 
							{
							$new_name="$added_id"."_"."$a[1]".".$extension";
							if((move_uploaded_file($_FILES[$key]['tmp_name'],"../cms_uploads/".$folder."/$new_name")) and ($pic_ext_err==0)) 
								{
								print"$a[2] $a[3]";
								imgresize("../cms_uploads/".$folder."/$new_name", "../cms_uploads/".$folder."/$new_name", $width=$a[2], $height=$a[3], $quality=100, $rgb=0xFF5800);
								}
							}
						$values_array[$a[1]]=$new_name;
						}
					else {$values_array[$a[1]]='';}
					}
				if ($a[0]=="file") 
					{
					if ($_FILES[$key]['name']!="")
						{
						$new_name="";
						$extension = addslashes($_FILES[$key]['name']);
						$start=0;
						for ($x=strlen($extension)-1;$x>0; $x=$x-1) 
							{
							$start=$start+1;
							if ($extension[$x]==".") {break;}
							}
						$extension=substr($extension,-$start+1);
						if ($extension!="")
							{
							$new_name="$added_id"."_"."$a[1]".".$extension";
							move_uploaded_file($_FILES[$key]['tmp_name'],"../cms_uploads/".$folder."/$new_name");
							}
						$values_array[$a[1]]=$new_name;
						}
						else {$values_array[$a[1]]='';}
					}
					
				}
	
			$query="insert into  cms2_attributes_".$att_id." values('".$added_id."',";
			for ($cc=0;$cc<1000;$cc++)
				{
				$zz=$values_array[$cc];
				if ($zz!="###empty###") {$query=$query."'$zz',";}
				}
			$query=substr($query,0,strlen($query)-1);
			$query=$query.")";
			mysql_query($query);

			for ($cc=0;$cc<1000;$cc++)
				{
				$zz=$values_array[$cc];
				if ($zz!="###empty###") {
				$query="update  cms2_attributes_".$att_id." set `".$cc."`='$zz' where element_id='$added_id'";mysql_query($query);}
				}
			}
}


function Edit_Att($new_add_atr,$cat_id,$folder)
{
global $HTTP_POST_VARS,$_FILES;
		$values_array=Array();
		for ($cc=0;$cc<1000;$cc++)
			{
			$values_array[$cc]="###empty###";
			}


		if ($new_add_atr!=0) 
			{
			foreach ($HTTP_POST_VARS as $key => $value) 
				{
				$a=explode('_',$key);
				if ($a[0]=="attribute") 
					{
					$values_array[$a[1]]=$value;$rr=$values_array[$a[1]];
					}
				}
			foreach ($_FILES as $key => $value) 
				{
				$a=explode('_',$key);
				if ($a[0]=="picture") 
					{
					if ($_FILES[$key]['name']!="")
						{
						$new_name="";
						$extension = addslashes($_FILES[$key]['name']);
						$start=0;
						for ($x=strlen($extension)-1;$x>0; $x=$x-1) 
							{
							$start=$start+1;
							if ($extension[$x]==".") {break;}
							}
						$extension=substr($extension,-$start+1);
						if (($extension!="jpg") and ($extension!="gif") and ($extension!="bmp") and ($extension!="pcx") and ($value!="")) {$pic_ext_err=1;}
						if ($pic_ext_err!="1") 
							{
							$new_name="$cat_id"."_"."$a[1]".".$extension";
							if((move_uploaded_file($_FILES[$key]['tmp_name'],"../cms_uploads/$folder/$new_name")) and ($pic_ext_err==0)) 
								{
								print"$a[2] $a[3]";
								imgresize("../cms_uploads/$folder/$new_name", "../cms_uploads/$folder/$new_name", $width=$a[2], $height=$a[3], $quality=100, $rgb=0xFF5800);
								}
							}
						$values_array[$a[1]]=$new_name;
						}
					}
				if ($a[0]=="file") 
					{
					if ($_FILES[$key]['name']!="")
						{
						$new_name="";
						$extension = addslashes($_FILES[$key]['name']);
						$start=0;
						for ($x=strlen($extension)-1;$x>0; $x=$x-1) 
							{
							$start=$start+1;
							if ($extension[$x]==".") {break;}
							}
						$extension=substr($extension,-$start+1);
						if ($extension!="")
							{
							$new_name="$cat_id"."_"."$a[1]".".$extension";
							move_uploaded_file($_FILES[$key]['tmp_name'],"../cms_uploads/$folder/$new_name");
							}
						$values_array[$a[1]]=$new_name;
						}
					}
				}
	

			for ($cc=0;$cc<1000;$cc++)
				{
				$zz=$values_array[$cc];
				if ($zz!="###empty###") {
				$query="update  cms2_attributes_".$new_add_atr." set `".$cc."`='$zz' where element_id='$cat_id'";mysql_query($query);}
				}
			}
}









//java editor
function PrintJavaEditor($id='elm1')
{
echo '
<script language=javascript type=text/javascript src="modules/pages/dnk_editor_src.js"></script>
<script language=javascript type=text/javascript>
	DNKEditor.init({
		mode : "exact",
		elements : "'.$id.'",
		theme : "advanced",
		russian : {
			title : \'Заголовок\',
			tbl : \'Стиль таблицы\'
		},
		plugins : "style,table,save,advhr,advimage,advlink,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,flash",
		theme_advanced_buttons1_add_before : "save,newdocument,separator",
		theme_advanced_buttons1_add : "fontselect,fontsizeselect",
		theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor,liststyle",
		theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
		theme_advanced_buttons3_add_before : "tablecontrols,separator",
		theme_advanced_buttons3_add : "flash,advhr,separator,print,separator,fullscreen",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		content_css : "style_site.css",
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "hr[class|width|size|noshade]",
		file_browser_callback : "fileBrowserCallBack",
		paste_use_dialog : false,
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,
		theme_advanced_link_targets : "",
		apply_source_formatting : true
	});
	function fileBrowserCallBack(field_name, url, type, win) {
		var connector = "../../filemanager/browser.shtml?Connector=connectors/php/connector.php";
		var enableAutoTypeSelection = true;
		var cType;
		dnkfck_field = field_name;
		dnkfck = win;
		switch (type) {
			case "image":
				cType = "Image";
				break;
			case "flash":
				cType = "Flash";
				break;
			case "file":
				cType = "File";
				break;
		}
		if (enableAutoTypeSelection && cType) {
			connector += "&Type=" + cType;
		}
		window.open(connector, "dnkfck", "modal,width=600,height=400");
	}
</script>';
}



?>