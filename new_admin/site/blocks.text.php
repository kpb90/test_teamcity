<?php

//Основной текст блока

$b_text=$block['content'];

$b_text=unserialize($b_text);

$b_text=stripslashes($b_text['content']);



//Заголовок блока

$b_title=$block['title'];



$block_template=str_replace('#block_title',$b_title,$block_template);

$block_template=str_replace('#text',$b_text,$block_template);



?>