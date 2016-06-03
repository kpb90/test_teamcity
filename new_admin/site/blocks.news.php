<?php
//Настройки новостного блока
$b_options=$block['content'];
$b_options=unserialize($b_options);
//Заголовок блока
$b_title=$block['title'];

//Шаблон одной новости:
$short_template=$templates['short_news'];
$short_template=afetchrowset(mysql_query("SELECT * FROM cms2_templates WHERE template_id = '".$short_template."'"));
$short_marker=$short_template[0]['marker'];
$short_template=$short_template[0]['content'];
$all_news=afetchrowset(mysql_query("SELECT * FROM cms2_news WHERE news_block_id = '".$b_options['type']."' ORDER BY `date` ".($b_options['order']=='up'?'DESC':'ASC')));
$news_content='';

for($a=0;$a<sizeof($all_news) && $a<$b_options['count_in_block'];$a++)
{
$news=$all_news[$a];
$s=$short_template;

$block_id=$news['news_block_id'];
$page=afetchrowset(mysql_query("SELECT * FROM `cms2_pages` WHERE `id` = '".$block_id."'"));
$page=$page[0]['file_name'];

  $news['date']=date("d.m.Y",$news['date']);

$s=str_replace('#news_link',$page.'.php?full='.$news['new_id'],$s);
$s=str_replace('#news_date',$news['date'],$s);

if (strlen($news['content_short'])>$b_options['short_len'])
  $news['content_short']=substr($news['content_short'],0,$b_options['short_len']).'...';


$s=str_replace('#news_short_content',$news['content_short'],$s);
$s=str_replace('#news_header',$news['title'],$s);

$news_content.=$s;

}



$block_template=str_replace('#block_title',$b_title,$block_template);
$block_template=str_replace($short_marker,$news_content,$block_template);

$news_pages=afetchrowset(mysql_query("SELECT * FROM cms2_page WHERE id = '".$b_options['type']."'"));
if(count($news_pages) > 0)
{
	$news_pages=$news_pages[0];
	$block_template=str_replace('#block_archive_link',$news_pages['file_name'].'.php',$block_template);
}
?>