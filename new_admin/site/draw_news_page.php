<?php

$news_id=$_GET['full'];

$x=strlen($page['title'])*13;

$x=$x.'px';

$y=top_menu($page_id);

$menu_2=menu_2($page_id);





$news=afetchrowset(mysql_query("SELECT * FROM `cms2_news` WHERE `new_id` = '".$news_id."'"));

$news=$news[0];

$template=$news['template_type_for_long'];

$select_template=mysql_query("select * from cms2_templates where template_id='$template'");

$a_s_t=mysql_fetch_array($select_template);

$content=$a_s_t['content'];





$content=str_replace('#menu#',$y,$content);

$content=str_replace('#menu_2#',$menu_2,$content);

$content=str_replace('#title',$page['title'],$content);



$content=draw_blocks($content,$page_id);








$news['date']=date("d/m/Y",$news['date']);

$content=str_replace('#news_date#',$news['date'],$content);

$content=str_replace('#news_header#',$news['title'],$content);

$content=str_replace('#news_long_content#',$news['content_long'],$content);













?>