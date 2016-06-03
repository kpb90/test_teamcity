<?php


$templates_d['text']['block']='Шаблон блока';

$params_d['text']['content']='Текст блока';

function print_block_special_text($params='')
{
  global $params_d;
  if ($params=='') $params=array();

  echo $params_d['text']['content'].':<br><br>';

echo '  <script language="javascript" type="text/javascript" src="modules/pages/dnk_editor_src.js"></script>
  <script language="javascript" type="text/javascript" src="modules/pages/config.js"></script>';
  echo '<textarea id=elm1 name="new_block_special[content]" class=normal style="width:100%;">'.@stripslashes($params['content']).'</textarea><br><br>';
}



//function show_text_content($value){return(stripslashes($value));}



?>