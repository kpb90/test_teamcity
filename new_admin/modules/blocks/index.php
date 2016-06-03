<?php
include('block.config.php');


if (@$action=="delete_block") 
{
	$block=mysql_query("select * from  cms2_blocks where block_id='".$deleted_block_id."'");
	$block=mysql_fetch_array($block);
	$atr_set_id=$block['add_atr_type'];
  if ($atr_set_id!=0) mysql_query("delete from  cms2_attributes_".$atr_set_id." where element_id='".$deleted_block_id."'");
	mysql_query("delete from  cms2_blocks where block_id='$deleted_block_id'");
  GoTo2('index.php');
}
///////////////////////////////////////////////////////////////////////////////////////
if (@$action=="delete_block_position") 
{
	mysql_query("delete from  cms2_blocks_positions where position_id='$deleted_position_id'");
  GoTo2('index.php?sub_action=show_settings');
}
///////////////////////////////////////////////////////////////////////////////////////
if (@$action=="change_block_status") 
{
  mysql_query("update  cms2_blocks set status='".($cur_status==0?'1':'0')."' where block_id='$block_id'");
  GoTo2('index.php');
}
///////////////////////////////////////////////////////////////////////////////////////
if (@$action=="change_block_group_visible") 
{
  mysql_query("update  cms2_blocks set group_visible='".$new_status."' where block_id='$block_id'");
  GoTo2('index.php');
}
///////////////////////////////////////////////////////////////////////////////////////
if (@$action=="add_new_block_position") 
{
  if (($new_position_title!="") and ($new_position_marker!="")) 
  {
    mysql_query("insert into  cms2_blocks_positions values ('','$new_position_title','$new_position_marker')");
    GoTo2('index.php?sub_action=show_settings');
  }
  else
  {
    print"<div class=\"error\">Не удалось добавить точку привязки</div>";$action="";
  }
}
///////////////////////////////////////////////////////////////////////////////////////
if (@$action=="save_block_position") 
{
  if (($new_title!="") and ($new_marker!="")) 
  {
    mysql_query("update  cms2_blocks_positions set title='$new_title', marker='$new_marker' where position_id='$position_id'");
    GoTo2('index.php?sub_action=show_settings');
  }
  else
  {
    print"<div class=\"error\">Не удалось изменить точку привязки</div>";$action="";
  }
}
///////////////////////////////////////////////////////////////////////////////////////
if (@$action=="create_new_block")
{
PrintBack(array(array('index.php','Вернуться к блокам')));

echo '<table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr>
<td height=24 bgcolor="#434343"><div class="razdelz_headers">Добавление нового информационного блока</div></td>
</tr>
<tr valign=top>
<td height=500 bgcolor="#FFFFFF">
<form action="index.php?action=create_new_block_1" method=post>
<div class="black_names">
<br>Введите название блока (для CMS)<br><br>
<input type="text" name="new_block_name" class=normal style="width:250px;" value="'.$new_block_name.'"><br>
<br>
<br>Введите заголовок блока (Для сайта)<br><br>
<input type="text" name="new_block_title" class=normal style="width:250px;" value="'.$new_block_title.'"><br>
<br>
Тип блока:
<br><br>';
CreateSelect('new_block_type','width:250px;',$TYPES);
echo '<br><br>
<input type="submit" class="submit_button" value="Далее"></div></form>
</td></tr></table>';
}
///////////////////////////////////////////////////////////////////////////////////////
if (@$action=="create_new_block_1")
{
PrintBack(array(
array('index.php?action=create_new_block&new_block_name='.$new_block_name.'&new_block_title='.$new_block_title,'Вернуться к предыдущему шагу'),
array('index.php','Вернуться к блокам')));
echo '<table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr>
<td height=24 bgcolor="#434343"><div class="razdelz_headers">Добавление нового информационного блока</div></td>
</tr>
<tr valign=top>
<td height=500 bgcolor="#FFFFFF">
<form action="index.php?action=create_new_block_2" method=post>
<div class="black_names">
<input type=hidden name="new_block_name" value="'.$new_block_name.'">
<input type=hidden name="new_block_title" value="'.$new_block_title.'">
<input type=hidden name="new_block_type" value="'.$new_block_type.'"><br>';

echo 'Выберите набор атрибутов:<br>
<select name="new_block_atr" class=normal style="width:150px;">
<option value="0">Без дополнительных атрибутов</option>';
show_possible_atr_sets($new_block_type.'_block');
echo '</select>';


echo '<br><br>
<input type="submit" class="submit_button" value="Далее"></div></form>
</td></tr></table>';

}
///////////////////////////////////////////////////////////////////////////////////////
if (@$action=="create_new_block_2")
{
PrintBack(array(
array('index.php?action=create_new_block_1&new_block_name='.$new_block_name.'&new_block_title='.$new_block_title,'Вернуться к предыдущему шагу'),
array('index.php','Вернуться к блокам')));


$fname="print_block_special_".$new_block_type;
if (!function_exists($fname))
{
  echo '<div class=\"error\">Произошла ошибка, не найдена необходимая функция</div>';
}
else
{
echo '<table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr>
<td height=24 bgcolor="#434343"><div class="razdelz_headers">Добавление нового информационного блока</div></td>
</tr>
<tr valign=top>
<td height=500 bgcolor="#FFFFFF">
<form action="index.php?action=create_new_block_3" method=post>
<div class="black_names">
<input type=hidden name="new_block_name" value="'.$new_block_name.'">
<input type=hidden name="new_block_title" value="'.$new_block_title.'">
<input type=hidden name="new_block_atr" value="'.$new_block_atr.'">
<input type=hidden name="new_block_type" value="'.$new_block_type.'"><br><br>';
$fname();
if ($new_block_atr!='0') show_attributes_from_set_for_insert($new_block_atr,0);
echo '<br><br>';
print_block_templates($new_block_type);
echo '<br><br>
<input type="submit" class="submit_button" value="Далее"></div></form>
</td></tr></table>';
}
}
///////////////////////////////////////////////////////////////////////////////////////
if (@$action=="create_new_block_3")
{
//debug($_POST);
  $sql="INSERT INTO  cms2_blocks VALUES ('','".mysql_escape_string($new_block_name)."','".mysql_escape_string($new_block_title)."','".mysql_escape_string($new_block_type)."','".mysql_escape_string(stripslashes(serialize($_POST['new_block_special'])))."','".mysql_escape_string(serialize($new_block_templates))."','0','".$new_block_atr."','0');";
  mysql_query($sql);
  Insert_Att($new_block_atr,mysql_insert_id(),'block');
  GoTo2('index.php');
}
///////////////////////////////////////////////////////////////////////////////////////


if (@$action=="edit_block") {

if (@$sub_action=="save_all")
{
//  ["add_atr_type"]=>  string(1) "0"
$sql="UPDATE  cms2_blocks SET `name` ='".mysql_escape_string($new_block_name)."', `title`='".mysql_escape_string($new_block_title)."', `content`='".mysql_escape_string(serialize($new_block_special))."', `templates`='".mysql_escape_string(serialize($new_block_templates))."' WHERE `block_id` = '".$block_id."'";
mysql_query($sql);
Edit_Att($add_atr_type,$block_id,'block');
//debug($sql);

}

$block=afetchrowset(mysql_query("select * from  cms2_blocks where block_id='$block_id'"));
$block=$block[0];
//debug($block);

PrintBack(array(array('index.php','Вернуться назад')));
echo '<div class="black_names">';

echo '<form action="index.php?action=edit_block&sub_action=save_all&block_id='.$block_id.'&add_atr_type='.$block['add_atr_type'].'" method="post">';


echo '<br>Введите название блока (для CMS)<br><br>
<input type="text" name="new_block_name" class=normal style="width:250px;" value="'.$block['name'].'"><br>
<br>
<br>Введите заголовок блока (Для сайта)<br><br>
<input type="text" name="new_block_title" class=normal style="width:250px;" value="'.$block['title'].'"><br>
<br>
Тип блока:&nbsp;'.($TYPES[$block['type']]).'
<br><br>';
$fname="print_block_special_".$block['type'];
$fname(unserialize($block['content']));
print_block_templates($block['type'],unserialize($block['templates']));

if ($block['add_atr_type']!=0)show_attributes_from_set_for_edit($block['add_atr_type'], $block_id,0);

echo '<br><br><input type="submit" class="submit_button" value="Сохранить">';
echo '</form>';
echo '</div>';

}


///////////////////////////////////////////////////////////////////////////////////////
if (@$action=="") 
{
print"
<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" height=\"50\">
	<tr>
		<td height=\"40\"><table cellpadding=\"0\" cellspacing=\"0\" height=\"40\" width=\"160\" border=\"0\"><tr><td width=\"31\" height=\"32\"><a href=\"index.php?action=create_new_block\"><img src=\"images/add_page.jpg\" border=\"0\"></a></td><td><a href=\"index.php?action=create_new_block\"><div class=\"orange_names\"><u><nobr>Создать новый блок</nobr></u></div></a></td><td width=\"31\" height=\"32\" style=\"padding-left:100px;\"><a href=\"#\" onClick=\"if (document.all.settings_div.style.display=='block') {document.all.settings_div.style.display='none';} else {document.all.settings_div.style.display='block';}\"><img src=\"images/settings_icon.jpg\" border=\"0\"></a></td><td><a href=\"#\" onClick=\"if (document.all.settings_div.style.display=='block') {document.all.settings_div.style.display='none';} else {document.all.settings_div.style.display='block';}\"><div class=\"orange_names\"><u><nobr>Показать\скрыть настройки</nobr></u></div></a></td></tr></table></td>
	</tr>
	<tr>
		<td width=\"100%\" height=\"10\"><img src=\"images/px.gif\" height=\"10\" border=\"0\"></td>
	</tr>
	<tr>
		<td width=\"100%\">
			<div style=\"display:none;\" id=\"settings_div\" name=\"settings_div\">
			<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" height=\"50\">
				<tr>
					<td height=\"24\" bgcolor=\"#434343\" width=\"50%\"><div class=\"razdelz_headers\">Точки привязки блоков</div></td>
					<td height=\"24\" bgcolor=\"#434343\" width=\"50%\" align=\"center\"><div class=\"razdelz_headers\" style=\"width:150px;margin-left:0px;\">Маркер</div></td>
					<td height=\"24\" bgcolor=\"#434343\" style=\"padding-right:20px;\" align=\"right\"><div class=\"razdelz_headers\" style=\"width:50px;\">Действия</div></td>
				</tr>
				<tr valign=\"top\">
					<td height=\"100%\" width=\"100%\" bgcolor=\"#FFFFFF\" colspan=\"3\">
						<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" height=\"100%\">
	";

$select_blocks_positions=mysql_query("select * from  cms2_blocks_positions order by title");
while ($line_blocks_positions=mysql_fetch_array($select_blocks_positions)) 
{
extract($line_blocks_positions);

print"

							<tr valign=\"middle\">
								<td width=\"50%\" style=\"padding-top:5px;padding-bottom:5px;padding-left:20px;\">
									<div style=\"display:none;height:20px;width:250px;text-align:left;\" id=\"edit_1_$position_id\" name=\"edit_1_$position_id\">
										<table width=\"250\" height=\"20\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
	<form action=\"index.php?action=save_block_position&position_id=$position_id\" style=\"height:20px;margin-bottom:0px;margin-top:0px;\" method=\"post\" id=\"edit_form_$position_id\" name=\"edit_form_$position_id\">
											<tr nowrap>
												<td align=\"left\">
													<input type=\"text\" class=\"normal\" name=\"new_title\" value=\"$title\" style=\"text-align:center\">
												</td>
											</tr>
										</table>
									</div>
									<div class=\"orange_names\" style=\"margin-left:0px;margin-right:0px;width:250px;text-align:left\" id=\"edit_2_$position_id\" name=\"edit_2_$position_id\"><b>$title</b></div>
								</td>	
								<td style=\"padding-right:10px;\"></td>
								<td width=\"1\" bgcolor=\"#CCCCCC\"><img src=\"images/px.gif\" border=\"0\" width=\"1\"></td>
								<td width=\"50%\" align=\"center\">
									<div style=\"display:none;height:20px;width:250px;text-align:center;\" id=\"edit_3_$position_id\" name=\"edit_3_$position_id\">
										<table width=\"250\" height=\"20\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
											<tr nowrap>
												<td align=\"right\">
													<input type=\"text\" class=\"normal\" name=\"new_marker\" value=\"$marker\" style=\"text-align:center\">
												</td>
												<td align=\"left\">
													<input type=\"submit\" class=\"submit_button\" value=\"Сохранить\" style=\"width:90px;\">
												</td>
											</tr>
										</table>
									</form>
									</div>
									<div class=\"black_names\" style=\"margin-left:0px;margin-right:0px;width:250px;text-align:center\" id=\"edit_4_$position_id\" name=\"edit_4_$position_id\">$marker</div>
								</td>
								<td width=\"1\" bgcolor=\"#CCCCCC\"><img src=\"images/px.gif\" border=\"0\" width=\"1\"></td>
								<td width=\"50\">
									<div style=\"width:60px;\" class=\"gray_names\"><a href=\"#\" onClick=\"document.all.edit_1_$position_id.style.display='block';document.all.edit_2_$position_id.style.display='none';document.all.edit_3_$position_id.style.display='block';document.all.edit_4_$position_id.style.display='none';\" class=\"text_links\" title=\"Редактировать\"><img alt=\"Редактировать\" src=\"images/edit_icon.jpg\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:confirmDelete('index.php?action=delete_block_position&deleted_position_id=$position_id')\" class=\"text_links\" title=\"Удалить\"><img alt=\"Удалить\" src=\"images/delete_icon.jpg\" border=\"0\"></a></div>
								</td>
							</tr>
							
";
print"  
							<tr valign=\"middle\"><td height=\"1\" bgcolor=\"#FFFFFF\" colspan=\"6\"><img src=\"images/px.gif\" height=\"1\"></td></tr>
							<tr valign=\"middle\"><td height=\"1\" bgcolor=\"#CCCCCC\" colspan=\"6\"><img src=\"images/px.gif\" height=\"1\"></td></tr>
							<tr valign=\"middle\"><td height=\"1\" bgcolor=\"#FFFFFF\" colspan=\"6\"><img src=\"images/px.gif\" height=\"1\"></td></tr>
";


}
print"
						</table>
					</td>
				</tr>
				<tr>
					<td colspan=\"3\" style=\"padding-top:20px;\">
						<form action=\"index.php?action=add_new_block_position\" method=\"post\"><div class=\"black_names\"><nobr>Название:&nbsp;<input type=\"text\" class=\"normal\" name=\"new_position_title\">&nbsp;&nbsp;Маркер:&nbsp;<input type=\"text\" class=\"normal\" name=\"new_position_marker\">
						<input type=\"submit\" class=\"submit_button\" value=\