<?php

$templates_d['news']['block']='������ �����';
$templates_d['news']['short_news']='������ ������� �������';

$params_d['news']['count_in_block']='���-�� �������� ��� ������';
$params_d['news']['type']='���� ��������';
$params_d['news']['order']='������� ������';
$params_d['news']['short_len']='������ �������� �������';

function print_block_special_news($params='')
{
  global $params_d;
  if ($params=='') $params=array();

  echo $params_d['news']['count_in_block'].':<br><br>';
  echo '<input type=text name="new_block_special[count_in_block]" class=normal style="width:250px;" value="'.@$params['count_in_block'].'"><br><br>';

  $news_types=afetchrowset(mysql_query("SELECT * FROM cms2_pages WHERE `page_type` = 'news_page' ORDER BY id"));
  echo '��� ��������� ��������:<br><br>';
  echo '<select class=normal style="width:250px;" name="new_block_special[type]">';
  foreach($news_types as $type)
    echo '<option value="'.$type['id'].'" '.(@$params['type']==$type['id']?'selected':'').'>'.$type['title'].'</option>';
  echo '</select>';
  echo '<br><br>';

  echo $params_d['news']['order'].':<br><br>';
  echo '<select class=normal style="width:250px;" name="new_block_special[order]">';
  echo '<option value="up" '.(@$params['order']=='up'?'selected':'').'>����� - ������</option>';
  echo '<option value="down" '.(@$params['order']=='down'?'selected':'').'>����� - �����</option>';
  echo '</select>';
  echo '<br><br>';
  
  echo $params_d['news']['short_len'].':<br><br>';
  echo '<input type=text name="new_block_special[short_len]" class=normal style="width:250px;" value="'.@$params['short_len'].'"><br><br>'; 
}

function show_news_order($value){return($value=='up'?'����� - ������':'����� �����');}

function show_news_type($value){$n=afetchrowset(mysql_query("SELECT * FROM cms2_pages WHERE `id` = '".$value."'"));return $n[0]['title'];}

?>