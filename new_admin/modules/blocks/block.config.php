<?php
$TYPES['text']='Текстовый блок';
$TYPES['news']='Новости';
$TYPES['auth']='Авторизация';

//$TYPES['forum']='Форум';

$templates_d=array();
$params_d=array();

include('block.news.php');
include('block.text.php');
include('block.auth.php');


function print_block_templates($name,$sel='')
{
  global $templates_d;
  $array=$templates_d[$name];
  if ($array=='') return;
  foreach($array as $key=>$value)
  {
    echo $value.':<br><br>';
    echo '<select name="new_block_templates['.$key.']" class=normal style="width:250px;">';
    $select_possible_modules=afetchrowset(mysql_query("select * from cms2_templates"));
    foreach ($select_possible_modules as $a)echo '<option '.($sel[$key]==$a['template_id']?'selected':'').' value="'.$a['template_id'].'">'.$a['title'].'</option>';
    echo '</select><br><br>';
  }
}








function CreateSelect($name,$style,$array,$sel_value='')
{
  echo '<select class="normal" name="'.$name.'" style="'.$style.'">';
  foreach($array as $key => $value)
  {
    echo '<option value="'.$key.'" ';
    if ($sel_value==$key) echo 'selected=selected';
    echo '>'.$value.'</option>';
  }
  echo '</select>';
}


function GetTemplateTitle($id)
{
  $result=afetchrowset(mysql_query('SELECT `title` FROM cms2_templates WHERE `template_id`=\''.$id.'\''));
  return $result[0]['title'];
}



?>