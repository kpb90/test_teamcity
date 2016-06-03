<?php


$templates_d['auth']['block']='Шаблон блока';

$params_d['auth']['content']='Страница регистрации';

function print_block_special_auth($params='')
{
  global $params_d;
  if ($params=='') $params=array();
  echo $params_d['auth']['content'].':<br><br>';
  $pages=afetchrowset(mysql_query("SELECT * FROM `cms_pages` WHERE `page_type` = 'auth_reg'"));
  echo '<select class=normal style="width:250px;" name="new_block_special[content]">';
  foreach($pages as $page)
    echo '<option value="'.$page['file_name'].'" '.(@$params['content']==$page['file_name']?'selected':'').'>'.$page['title'].'</option>';
  echo '</select><br><br>';
}

function show_auth_content($value){$n=afetchrowset(mysql_query("SELECT * FROM cms2_pages WHERE `file_name` = '".$value."'"));return $n[0]['title'];}

?>