<?php

define("DATE_TIME_FORMAT","d.m.Y H:i:s");





$x=strlen($page['title'])*13;

$x=$x.'px';

$y=top_menu($page_id);

$menu_2="";



$content=str_replace('#menu#',$y,$content);

$content=str_replace('#menu_2#',$menu_2,$content);

$content=str_replace('#title',$page['title'],$content);



$content=draw_blocks($content,$page_id);

$content=draw_forms($content, $page_id);



$forum='';



if ($page['page_status']==1) 

  $forum='В данный момент содержание страницы недоступно. Ведутся технические работы.';	



if ($page['group_visible']==1 && !isset($_SESSION['authorized'])) 

  $forum='Просмотр форума доступен только зарегистрированным пользователям.';	



if ($forum=='')

{

  include('forum/template.class.php');



  $forum_action=(string)$_GET['forum_action'];



  if (strlen($forum_action)==0)

  {

    if (isset($_GET['topic']))

    {

      $forum=PrintTopic($page,(int)$_GET['topic'],(int)$_GET['topic_page']);

    }

    else

    {

      $sub=(int)$_GET['sub'];

      if ($sub==0)

      {

        $forum=PrintMain($page);

      }

      else

      {

        $forum=PrintSub($page,$sub,(int)$_GET['sub_page']);

      }

    }

  }

  else

  {

    if ($forum_action=='new_post')

    {

      AddPost();

      $topic_id=(int)$_POST['topic_id'];

      GoTo2($page['file_name'].'.php?topic='.$topic_id);

    }

    if ($forum_action=='new_topic')

    {

      $topic_id=AddTopic();

      GoTo2($page['file_name'].'.php?topic='.$topic_id);

    }

  }

}



$content=str_replace('#forum',$forum,$content);



////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////

function PrintMain($page)

{

  $top_pages=afetchrowset(mysql_query("SELECT * FROM cms_forum WHERE `parent` = 0"));

  $top_pages_content='';

  foreach($top_pages as $top_page)

  {

    $top_page_template=new class_template;

    $top_page_template->LoadTemplate($top_page['template_type_for_top_pages']);

    $top_page_template->Replace('#top_page_title',$top_page['title']);

    $sub_pages_content='';

    

    //ORDER BY `stick` desc,`position`

    $sub_pages=afetchrowset(mysql_query("SELECT * FROM cms_forum WHERE `parent` = '".$top_page['id']."' ORDER BY `stick` desc, `position`"));

    //$sub_pages[0]=afetchrowset(mysql_query("SELECT * FROM cms_forum WHERE `parent` = '".$top_page['id']."' AND `stick` = 1 ORDER BY `position`"));    

    //$sub_pages[1]=afetchrowset(mysql_query("SELECT * FROM cms_forum WHERE `parent` = '".$top_page['id']."' AND `stick` = 0 ORDER BY `position`"));

    //$sub_pages=array_merge($sub_pages[0],$sub_pages[1]);

 

    foreach($sub_pages as $sub_page)

    {

      $sub_page_list_template=new class_template;

      $sub_page_list_template->LoadTemplate($top_page['template_type_for_sub_pages_list']);

      $markers=array(

        '#sub_page_list_title',

        '#sub_page_list_num_of_topics',

        '#sub_page_list_num_of_messages',

        '#sub_page_list_num_of_last_date',

        '#sub_page_list_num_of_last_author',

        '#sub_page_link'

      );



      $last_post=GetLastPost($sub_page['id']);



      $replace=array(

        $sub_page['title'],

        GetNumOfTopics($sub_page['id']),

        GetNumOfPosts($sub_page['id']),

        

        

        $last_post==false?'':

        

        DateFormat($last_post['date'])

        

        ,

        $last_post==false?'Сообщений еще не было':

        'Оставил: '.GetAuthor($last_post['author_id']),

        $page['file_name'].'.php?sub='.$sub_page['id']

      );

      

      $sub_page_list_template->Replace($markers,$replace);

      $sub_page_list_template->content=ShowAtts($sub_page['add_atr_type'],$sub_page['id'],$sub_page_list_template->content);

      $sub_pages_content.=$sub_page_list_template->content;

    } 

    $top_page_template->Replace('#sub_pages',$sub_pages_content);

    $top_page_template->content=ShowAtts($top_page['add_atr_type'],$top_page['id'],$top_page_template->content);

    $top_pages_content.=$top_page_template->content;

  }

  return $top_pages_content;

}

////////////////////////////////////////////////////////////////////////////////////////////////////

function GetNumOfTopics($id)

{

  $a=afetchrowset(mysql_query("SELECT * FROM cms_forum WHERE `parent` = '".$id."'"));

  return sizeof($a);

}

////////////////////////////////////////////////////////////////////////////////////////////////////

function GetNumOfPosts($id)

{

  $ids=array();

  $ids[]=$id;

  $a=afetchrowset(mysql_query("SELECT id FROM cms_forum WHERE `parent` = '".$id."'"));

  for($i=0;$i<sizeof($a);$i++)$ids[]=$a[$i]['id'];

  $count=0;

  for($i=0;$i<sizeof($ids);$i++)

  {

    $a=afetchrowset(mysql_query("SELECT id FROM cms_forum_messages WHERE `parent` = '".$ids[$i]."'"));

    $count+=sizeof($a);

  }

  return $count;

}

////////////////////////////////////////////////////////////////////////////////////////////////////

function GetLastPost($id)

{

  $ids=array();

  $ids[]=$id;

  $a=afetchrowset(mysql_query("SELECT id FROM cms_forum WHERE `parent` = '".$id."'"));

  for($i=0;$i<sizeof($a);$i++)$ids[]=$a[$i]['id'];

  $last_post=null;

  for($i=0;$i<sizeof($ids);$i++)

  {

    $a=afetchrowset(mysql_query("SELECT * FROM cms_forum_messages WHERE `parent` = '".$ids[$i]."' ORDER BY date DESC"));

    $post=$a[0];

    if ($post==null) continue;

    if ($last_post==null)

      $last_post=$post;

    else

      if ($last_post['date']<$post['date']) $last_post=$post;

  }

  return $last_post;

}

////////////////////////////////////////////////////////////////////////////////////////////////////

function GetAuthor($id)

{

  if ($id[0]=='_')

  {

    $id=substr($id,1);

    $sql='SELECT * FROM cms_auth_users WHERE `id` = \''.$id.'\';';

    $user=afetchrowset(mysql_query($sql));

    $user=$user[0];

    $f=afetchrowset(mysql_query("SELECT * FROM cms_auth_reg_settings WHERE `name` = 'field_login_id'"));

    $f=$f[0]['value'];

    return $user[$f];

  }

  else

  {

    $sql='SELECT * FROM cms2_users WHERE `user_id` = \''.$id.'\';';

    $author=afetchrowset(mysql_query($sql));

    $author=$author[0];

    $author=$author['login'];

    return $author;

  }

}

////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////

function PrintSub($page,$id,$sub_p)

{

  $sub_page=afetchrowset(mysql_query("SELECT * FROM cms_forum WHERE `id` = '".$id."'"));

  $sub_page=$sub_page[0];



  $on_page=GetOptions();

  $on_page=$on_page[1];



  $sub_page_template=new class_template;

  $sub_page_template->LoadTemplate($sub_page['template_type_for_sub_pages']);



  $sql="SELECT * FROM cms_forum WHERE `parent` = '$id' ORDER BY `stick` desc,`position` LIMIT ".($sub_p*$on_page).",".($on_page)."  ";

  $topics=afetchrowset(mysql_query($sql));

  

  //Всего постов

  $count=nfetchrowset(mysql_query("SELECT COUNT(*) FROM cms_forum WHERE `parent` = '".$id."'"));

  $count=(int)$count[0][0];



  //Всего страниц

  $pages=(int)ceil($count/$on_page);



  $topics_content='';

  foreach($topics as $topic)

  {

    $topic_list_template=new class_template;

    $topic_list_template->LoadTemplate($sub_page['template_type_for_topics_list']);



    $markers=array(

      '#topics_list_title',

      '#topics_link',

      '#topics_list_author',

      '#topics_list_messages',

      '#topics_list_last_date',

      '#topics_list_last_author'

    );



    $last_post=GetLastPost($topic['id']);



    $replace=array(

      $topic['title'],

      $page['file_name'].'.php?topic='.$topic['id'],

      GetAuthor(GetTopicAuthor($topic['id'])),

      GetNumOfPosts($topic['id']),

      DateFormat($last_post['date']),

      'Оставил: '.GetAuthor($last_post['author_id'])

    );



    $topic_list_template->Replace($markers,$replace);

    $topic_list_template->content=ShowAtts($topic['add_atr_type'],$topic['id'],$topic_list_template->content);

    $topics_content.=$topic_list_template->content;

  }



  $markers=array(

    '#sub_page_new_topic',

    '#sub_page_path',

    '#sub_page_select',

    '#sub_page_num_of_pages',

    '#sub_page_num_row',

    '#sub_page_form_new_topic',

    '#topics',

  );



  $status=$sub_page['status'];



  if ($status==1)

    $TopicForm='<div style="display:none" id="sub_page_form_new_topic">'.MakeTopicForm($page,$sub_page).'</div>';

  else

    $TopicForm='<div style="display:none" id="sub_page_form_new_topic">Раздел закрыт.</div>';



  $replace=array(

    'document.getElementById(\'sub_page_form_new_topic\').style.display = \'block\'',

    GetPath($page,$sub_page),

    MakeSubPageSelect($page['file_name'],$id),

    $pages==0?1:$pages,

    BuildNumRow($pages,$sub_p,$page['file_name'].'.php?sub='.$id.'&sub_page='),

    $TopicForm,

    $topics_content

  );

  

  $sub_page_template->Replace($markers,$replace);

  $sub_page_template->content=ShowAtts($sub_page['add_atr_type'],$sub_page['id'],$sub_page_template->content);



  return $sub_page_template->content;

}

////////////////////////////////////////////////////////////////////////////////////////////////////

function GetPath($real,$page,$flag=1)

{

  $titles=array();

  if ($flag==1) $titles[]=$page['title'];

  $p=array();

  while($page['parent']!=0)

  {

    $page=afetchrowset(mysql_query("SELECT * FROM cms_forum where `id` = '".$page['parent']."'"));

    $page=$page[0];

    $titles[]=$page['title'];

    $p[]=$page['id'];

  }

  $titles=array_reverse($titles);

  $p=array_reverse($p);

  $title='';

  //debug($p);

  //debug($titles);

  for($i=0;$i<sizeof($titles);$i++)

  {

    $link='';

    if ($p[$i]!=null && $i!=0 && $i!=sizeof($titles)-1)

    {

      //$link='<a href="'.$real['file_name'].'.php?topic='.$p[$i].'">';

      $link='<a href="'.$real['file_name'].'.php?sub='.$p[$i].'" class=forum_sub_page_path>';

    }

    if ($i==0) $link='<a href="'.$real['file_name'].'.php" class=forum_sub_page_path>';

    if ($i==sizeof($titles)-1) $link='';

    $title.=$link.$titles[$i].($link==''?'':'</a>').'&nbsp;&gt;&gt;&nbsp;';

  }

  $title=substr($title,0,strlen($title)-20);

  return $title;

}

////////////////////////////////////////////////////////////////////////////////////////////////////

function GetTopicAuthor($id)

{

  $a=afetchrowset(mysql_query("SELECT * FROM cms_forum_messages WHERE `parent` = '$id' ORDER BY date ASC"));

  return $a[0]['author_id'];

}

////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////

function PrintTopic($page,$id,$topic_page)

{

  $on_page=GetOptions();

  $on_page=$on_page[0];



  $topic=afetchrowset(mysql_query("SELECT * FROM cms_forum WHERE `id` = $id "));

  $topic=$topic[0];



  $topic_template=new class_template;

  $topic_template->LoadTemplate($topic['template_type_for_topics']);



  $sql="SELECT * FROM cms_forum_messages WHERE `parent` = '$id' ORDER BY `date` ASC LIMIT ".($topic_page*$on_page).",".($on_page)." ";

  $messages=afetchrowset(mysql_query($sql));



  //Всего постов

  $count=nfetchrowset(mysql_query("SELECT COUNT(*) FROM cms_forum_messages WHERE `parent` = '".$id."'"));

  $count=(int)$count[0][0];



  //Всего страниц

  $pages=(int)ceil($count/$on_page);



  //debug($pages);



  $messages_content='';

  foreach($messages as $message)

  {

    $message_template=new class_template;

    $message_template->LoadTemplate($topic['template_type_for_messages']);

    $markers=array(

      '#post_content',

      '#post_author',

      '#post_date'

    );

    $replace=array(

      ParsePost($message['content']),

      GetAuthor($message['author_id']),

      DateFormat($message['date'])

    );

    $message_template->Replace($markers,$replace);

    $message_template->content=ShowAtts($message['add_atr_type'],$message['id'],$message_template->content);

    $messages_content.=$message_template->content;

  }

  $num_row=BuildNumRow($pages,$topic_page,$page['file_name'].'.php?topic='.$id.'&topic_page=');

  $markers=array(

    '#topics_path',

    '#posts',

    '#topics_num_of_pages',

    '#topics_num_row',

    '#topics_reply_form'

  );



  $status=$topic['status'];

  if ($status==1)

    $Form='<div>'.MakeReplyForm($page,$topic).'</div>';

  else

    $Form='<div class=item_close>Тема закрыта.</div>';



  $replace=array(

    GetPath($page,$topic),

    $messages_content,

    $pages,

    $num_row,

    $Form

  );



  $topic_template->Replace($markers,$replace);

  $topic_template->content=ShowAtts($topic['add_atr_type'],$topic['id'],$topic_template->content);

  return $topic_template->content;

}

////////////////////////////////////////////////////////////////////////////////////////////////////

function DateFormat($date){  return date(DATE_TIME_FORMAT,$date);}

////////////////////////////////////////////////////////////////////////////////////////////////////

function MakeReplyForm($page,$topic)

{

$att_set=$topic['atr_messages'];







  $content='

<script language=Javascript>

function pasteN(text)

{

document.getElementById(\'textarea\').focus();

if (text != \'\') document.getElementById(\'textarea\').value = document.getElementById(\'textarea\').value + "[b]" + text + "[/b]\n";

}



function pasteS(text)

{

document.getElementById(\'textarea\').focus();

if (text != \'\') document.getElementById(\'textarea\').value = document.getElementById(\'textarea\').value + text;

}

</script>



  <form method=POST action="'.$page['file_name'].'.php?forum_action=new_post">

  <input type=hidden name=topic_id value="'.$topic['id'].'">

	<center>

	<br><h2 class="text" align="center" style="text-align:center;"><nobr>Введите Ваше сообщение:</nobr></h2>

  <br>

  <textarea id=textarea name=message_content class="zakta" style="width:90%;height:150px;"></textarea><br>

<a href="javascript:pasteS(\' :) \')"><img src="images/smilies/smile.gif" width="20" height="20" alt=":)" border="0"></a>

<a href="javascript:pasteS(\' :| \')"><img src="images/smilies/neutral.gif" width="20" height="20" alt=":|" border="0"></a>

<a href="javascript:pasteS(\' :( \')"><img src="images/smilies/sad.gif" width="20" height="20" alt=":(" border="0"></a>

<a href="javascript:pasteS(\' :D \')"><img src="images/smilies/big_smile.gif" width="20" height="20" alt=":D" border="0"></a>

<a href="javascript:pasteS(\' :o \')"><img src="images/smilies/yikes.gif" width="20" height="20" alt=":o" border="0"></a>

<a href="javascript:pasteS(\' ;) \')"><img src="images/smilies/wink.gif" width="20" height="20" alt=";)" border="0"></a>

<a href="javascript:pasteS(\' :/ \')"><img src="images/smilies/hmm.gif" width="20" height="20" alt=":/" border="0"></a>

<a href="javascript:pasteS(\' :P \')"><img src="images/smilies/tongue.gif" width="20" height="20" alt=":P" border="0"></a>

<a href="javascript:pasteS(\' :lol: \')"><img src="images/smilies/lol.gif" width="20" height="20" alt=":lol:" border="0"></a>

<a href="javascript:pasteS(\' :mad: \')"><img src="images/smilies/mad.gif" width="20" height="20" alt=":mad:" border="0"></a>

<a href="javascript:pasteS(\' :rolleyes: \')"><img src="images/smilies/roll.gif" width="20" height="20" alt=":rolleyes:" border="0"></a>

<a href="javascript:pasteS(\' :cool: \')"><img src="images/smilies/cool.gif" width="20" height="20" alt=":cool:" border="0"></a>

'

.

ShowReplyAtts($att_set)

.



'

<br><br>

  <input type=submit name=submit value="Отправить"  class=zakbtn>

  </form>

  ';

  return $content;

}

////////////////////////////////////////////////////////////////////////////////////////////////////

function MakeTopicForm($page,$sub_page)

{

$att_set=$sub_page['atr_topics'];

$att_set_2=$sub_page['atr_messages'];



$content='

<script language=Javascript>

function pasteN(text)

{

document.getElementById(\'textarea\').focus();

if (text != \'\') document.getElementById(\'textarea\').value = document.getElementById(\'textarea\').value + "[b]" + text + "[/b]\n";

}



function pasteS(text)

{

document.getElementById(\'textarea\').focus();

if (text != \'\') document.getElementById(\'textarea\').value = document.getElementById(\'textarea\').value + text;

}

</script>





  <form method=POST action="'.$page['file_name'].'.php?forum_action=new_topic">

<div class="creat_item_forum">Создание темы:</div>

<hr class="line_forum_create_item">



  <input type=hidden name=topic_id value="'.$sub_page['id'].'">



<table class="forum_table_create_item" cellspacing=3 cellpadding=0 border=0>

<tr valign=top><td class=forum_title_input>Название темы</td><td><input type=text name=topic_title value="" class=forum_topic_create_item></td></tr>

<tr valign=top><td class=forum_title_input>Сообщение</td><td><textarea id=textarea name=message_content class=forum_message_create_item></textarea><br>

<a href="javascript:pasteS(\' :) \')"><img src="images/smilies/smile.gif" width="20" height="20" alt=":)" border="0"></a>

<a href="javascript:pasteS(\' :| \')"><img src="images/smilies/neutral.gif" width="20" height="20" alt=":|" border="0"></a>

<a href="javascript:pasteS(\' :( \')"><img src="images/smilies/sad.gif" width="20" height="20" alt=":(" border="0"></a>

<a href="javascript:pasteS(\' :D \')"><img src="images/smilies/big_smile.gif" width="20" height="20" alt=":D" border="0"></a>

<a href="javascript:pasteS(\' :o \')"><img src="images/smilies/yikes.gif" width="20" height="20" alt=":o" border="0"></a>

<a href="javascript:pasteS(\' ;) \')"><img src="images/smilies/wink.gif" width="20" height="20" alt=";)" border="0"></a>

<a href="javascript:pasteS(\' :/ \')"><img src="images/smilies/hmm.gif" width="20" height="20" alt=":/" border="0"></a>

<a href="javascript:pasteS(\' :P \')"><img src="images/smilies/tongue.gif" width="20" height="20" alt=":P" border="0"></a>

<a href="javascript:pasteS(\' :lol: \')"><img src="images/smilies/lol.gif" width="20" height="20" alt=":lol:" border="0"></a>

<a href="javascript:pasteS(\' :mad: \')"><img src="images/smilies/mad.gif" width="20" height="20" alt=":mad:" border="0"></a>

<a href="javascript:pasteS(\' :rolleyes: \')"><img src="images/smilies/roll.gif" width="20" height="20" alt=":rolleyes:" border="0"></a>

<a href="javascript:pasteS(\' :cool: \')"><img src="images/smilies/cool.gif" width="20" height="20" alt=":cool:" border="0"></a><br>





</td></tr>

</table>

'

.

ShowReplyAtts($att_set)

.

'

<br>

'

.

ShowReplyAtts($att_set_2)

.

'

<hr class="line_forum_create_item">

<input type=image name=submit src="images/create_item_forum.jpg" value="Создать" style="border:0px;">

</form>

  ';

  return $content;

}

////////////////////////////////////////////////////////////////////////////////////////////////////

function MakeSubPageSelect($filename,$sub)

{

  $razdels=afetchrowset(mysql_query("SELECT * FROM cms_forum WHERE `parent` = '0' ORDER BY `position`"));

  $result='<select onchange="if (this.value != \'\') window.location=\''.$filename.'.php?sub=\' + this.value;" class="zakaz" style="width:130px;">';

  for($i=0;$i<sizeof($razdels);$i++)

  {

    $subs=afetchrowset(mysql_query("SELECT * FROM cms_forum WHERE `parent` = '".$razdels[$i]['id']."' ORDER BY `position`"));

    $result.='<optgroup label="'.$razdels[$i]['title'].'">';

    for($j=0;$j<sizeof($subs);$j++)

      $result.='<option '.($sub==$subs[$j]['id']?'selected':'').' value="'.$subs[$j]['id'].'">'.$subs[$j]['title'].'</option>';

    $result.='</optgroup>';

  }

  $result.='</select>';

  return $result;

}



////////////////////////////////////////////////////////////////////////////////////////////////////





function GetOptions()

{

  $OPTIONS=nfetchrowset(mysql_query("SELECT `messages_in_topic`,`topics_on_page` FROM `cms_forum_settings` WHERE `id` = '1'"));

  return $OPTIONS[0];

}



////////////////////////////////////////////////////////////////////////////////////////////////////





function BuildNumRow($num_pages,$cur_page,$link)

{

  $result='';

  for($i=0;$i<$num_pages;$i++)

  {

    $num=$i+1;

    $color=$cur_page==$i?'link_forum_page_active':'link_forum_page';

    $span=$num;

    $span='<a href="'.$link.$i.'" class="'.$color.'" >'.$span.'</a>';

    $result.=$span;

    $result.='&nbsp;&nbsp;';

  }

  return $result;

}







////////////////////////////////////////////////////////////////////////////////////////////////////





function ShowAtts($att_set,$id,$content)

{

  if ($att_set!=0)

  {

    $desc=afetchrowset(mysql_query("SELECT * FROM  cms2_attributes_".$att_set."_descriptions"));

    for($q=0;$q<sizeof($desc);$q++)

    {

      $att_d=$desc[$q];

      $att=afetchrowset(mysql_query("SELECT * FROM  cms2_attributes_".$att_set." WHERE `element_id` = '".$id."'"));

      $att=$att[0];

      $value=$att[$att_d['id']];

      $att_marker=$att_d['marker'];

      $content=str_replace($att_marker,$value,$content);

    }

  }

  return $content;

}

////////////////////////////////////////////////////////////////////////////////////////////////////

function ParsePost($text)

{

  //SMILIES

  $text=str_replace(':)','<img src="images/smilies/smile.gif" width="20" height="20" alt=":)" border="0">',$text);

  $text=str_replace(':|','<img src="images/smilies/neutral.gif" width="20" height="20" alt=":|" border="0">',$text);

  $text=str_replace(':(','<img src="images/smilies/sad.gif" width="20" height="20" alt=":(" border="0">',$text);

  $text=str_replace(':D','<img src="images/smilies/big_smile.gif" width="20" height="20" alt=":D" border="0">',$text);

  $text=str_replace(':o','<img src="images/smilies/yikes.gif" width="20" height="20" alt=":o" border="0">',$text);

  $text=str_replace(';)','<img src="images/smilies/wink.gif" width="20" height="20" alt=";)" border="0">',$text);

  $text=str_replace(' :/','<img src="images/smilies/hmm.gif" width="20" height="20" alt=":/" border="0">',$text);

  $text=str_replace(':P','<img src="images/smilies/tongue.gif" width="20" height="20" alt=":P" border="0">',$text);

  $text=str_replace(':lol:','<img src="images/smilies/lol.gif" width="20" height="20" alt=":lol:" border="0">',$text);

  $text=str_replace(':mad:','<img src="images/smilies/mad.gif" width="20" height="20" alt=":mad:" border="0">',$text);

  $text=str_replace(':rolleyes:','<img src="images/smilies/roll.gif" width="20" height="20" alt=":rolleyes:" border="0">',$text);

  $text=str_replace(':cool:','<img src="images/smilies/cool.gif" width="20" height="20" alt=":cool:" border="0">',$text);



  return $text;

}

////////////////////////////////////////////////////////////////////////////////////////////////////

function ShowReplyAtts($set_id)

	{

	$set_id=(int)$set_id;

	if ($set_id==0)return;

	global $HTTP_POST_VARS;

  $result='';

	$select_all_attributes_types_in_set=mysql_query("select * from  cms2_attributes_".$set_id."_descriptions order by id");

	while ($line=mysql_fetch_array($select_all_attributes_types_in_set)) 

	{

	extract($line);

	$sx=$size_x;

	$sy=$size_y;

	$select_attribute_type=mysql_query("select * from  cms2_attributes_types where type_id='".$type_id."'");

	$a_select_attribute_type=mysql_fetch_array($select_attribute_type);

	$attribute_title=$a_select_attribute_type['title'];

		foreach ($HTTP_POST_VARS as $key => $value) 

		{

		$a=explode('_',$key);

		if (($a[0]=="attribute") and ($a[1]==$id)) $attribute_id_value=$value;

		}

		foreach ($HTTP_POST_VARS as $key => $value) 

		{

		$a=explode('_',$key);

		if (($a[0]=="picture") and ($a[1]==$id)) $attribute_id_value=$value;

		}

		foreach ($HTTP_POST_VARS as $key => $value) 

		{

		$a=explode('_',$key);

		if (($a[0]=="file") and ($a[1]==$id)) $attribute_id_value=$value;

		}

	$datetime=date("Y-m-d");$datetime=explode("-",$datetime);$year=$datetime[0];$month=$datetime[1];$day=$datetime[2];



	if ($type_id==1) {$result.="<br><br>$title:<br><br><input type=\"text\" name=\"attribute_$id\" class=normal style=\"width:550px;\" value=\"$attribute_id_value\">";}

	if ($type_id==2) {$result.="<br><br>$title:<br><br><textarea class=normal  name=\"attribute_$id\" id=\"attribute_$id\" style=\"width:550px;\" rows=5>$attribute_id_value</textarea><a href=\"modules/att_editor.php?id=$id\" target=\"_blank\"><img src='images/edit_icon.jpg'></a>";}

	if ($type_id==3) {$result.="<br><br>$title:<br><br><input type=\"text\" name=\"attribute_$id\"  class=normal  value=\"$attribute_id_value\" style=\"width:550px;\">";}

	if ($type_id==4) {$result.="<br><br>$title:<br><br><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"200\" height=\"20\"><tr><td><input type=\"text\" name=\"attribute_$id\" class=normal  style=\"width:250px;\" value=\"$day.$month.$year\"></td><script language='JavaScript'> var attribute_$id = new calendar_create(document.forms['new_thing_form'].elements['attribute_$id']); </script><td class=\"tab\"><a href='javascript:attribute_$id.popup();'><img src='images/vvv_calendar.gif'></a></td></tr></table>";}

	if ($type_id==5) {$result.="<br><br>$title:<br><br><input type=\"text\" name=\"attribute_$id\"  class=normal  value=\"$attribute_id_value\"  style=\"width:550px;\">";}

	if ($type_id==6) {$result.="<br><br>$title:<br><br><input width=\"550\" maxlength=\"30\" size=\"30\" type=\"file\"  value=\"$attribute_id_value\" class=normal name=\"picture_";$result.="$id";$result.="_";$result.="$sx";$result.="_";$result.="$sy"; $result.="\">";}

	if ($type_id==7) {$result.="<br><br>$title:<br><br><input width=\"550\" maxlength=\"30\" size=\"30\" type=\"file\"  value=\"$attribute_id_value\" class=normal name=\"file_";$result.="$id";$result.="\">";}

}





return $result;

}

////////////////////////////////////////////////////////////////////////////////////////////////////



function AddPost()

{

  global $_POST,$_SESSION;

  //debug($_POST);debug($_SESSION);

  $topic_id=(int)$_POST['topic_id'];

  $topic=afetchrowset(mysql_query("SELECT * FROM cms_forum WHERE `id` = '$topic_id'"));

  $topic=$topic[0];

  $new_add_atr=$topic['atr_messages'];

  $message_content=$_POST['message_content'];

  $sql="insert into cms_forum_messages values ('','$topic_id',

  '".mysql_escape_string(nl2br(htmlspecialchars($message_content)))."',

  '_".$_SESSION['authorized']."','".time()."','$new_add_atr')";		

  //debug($sql);

  mysql_query($sql);

  Insert_Att($new_add_atr,mysql_insert_id(),'forum');

}

////////////////////////////////////////////////////////////////////////////////////////////////////

function AddTopic()

{

  global $_POST,$_SESSION;



  $cat_parent=(int)$_POST['topic_id'];

  $select_cat=mysql_query("select * from cms_forum where `id` = '$cat_parent'");

  $cat=mysql_fetch_array($select_cat);

  $cat_level=$cat['level']+1;



  $select_par=mysql_query("select * from cms_forum where `parent` = '$cat_parent' order by position");

  $cat_position=1;

  $lp=0;

  while(@$a=mysql_fetch_array($select_par))$lp=$a['position'];

  $lp++;

  $cat_position=$lp;



  $cat_title=mysql_escape_string(htmlspecialchars($_POST['topic_title']));



  $new_template_messages=$cat['template_type_for_messages'];

  $topic_template=$cat['template_type_for_topics'];



  $parent=afetchrowset(mysql_query("SELECT * FROM cms_forum WHERE `id` = '$cat_parent'"));

  $parent=$parent[0];



  $new_add_atr=$parent['atr_topics'];

  $atr_messages=$parent['atr_messages'];



  $sql="insert into cms_forum values ('','$cat_title','$cat_parent','$cat_position','$cat_level',

  '1','$new_add_atr','0','0','$topic_template',

  '$new_template_messages','0','0','$atr_messages',

  '0','0','0')";

  //debug($sql);

  mysql_query($sql);		

  $_topic_id=mysql_insert_id();

  Insert_Att($new_add_atr,$topic_id,'forum');

  $topic=afetchrowset(mysql_query("SELECT * FROM cms_forum WHERE `id` = '$_topic_id'"));

  $topic=$topic[0];

  $new_add_atr=$topic['atr_messages'];

  $message_content=$_POST['message_content'];

  $sql="insert into cms_forum_messages values ('','$_topic_id',

  '".mysql_escape_string(nl2br(htmlspecialchars($message_content)))."',

  '_".$_SESSION['authorized']."','".time()."','$new_add_atr')";		

  //debug($sql);

  mysql_query($sql);

  Insert_Att($new_add_atr,mysql_insert_id(),'forum');

  return $_topic_id;

}



?>