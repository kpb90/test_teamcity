<?php



function draw_blocks($content, $page_id) 

{


/////////////////////////////////////////







  $positions=afetchrowset(mysql_query("SELECT * FROM  cms2_blocks_positions ORDER BY position_id"));
  for($j=0;$j<sizeof($positions);$j++)
  {
    $block_content='';
    $position_id=$positions[$j]['position_id'];
    $marker=$positions[$j]['marker'];
    $blocks=afetchrowset(mysql_query("select * from  cms2_blocks_on_pages where page_id='".$page_id."' and position='".$position_id."' ORDER BY `position_on_page` ASC"));
    for($i=0;$i<sizeof($blocks);$i++)
    {
      $sql_add='';
      if (!isset($_SESSION['authorized'])) 
      {
        $sql_add='AND `group_visible` = 0';
      }
      $block=afetchrowset(mysql_query("SELECT * FROM  cms2_blocks WHERE `block_id` = '".$blocks[$i]['block_id']."' AND `status` = 0 ".$sql_add));
      $block=$block[0];
      if ($block==false) continue;



      $templates=unserialize($block['templates']);

      //Общий шаблон блока

      $block_template=$templates['block']; 
      $block_template=afetchrowset(mysql_query("SELECT * FROM cms2_templates WHERE template_id = '".$block_template."'"));
      $block_template=$block_template[0]['content'];

      



      include('blocks.'.$block['type'].'.php');



      $att_set=$block['add_atr_type'];



      if ($att_set!=0)

      {

        $desc=afetchrowset(mysql_query("SELECT * FROM  cms2_attributes_".$att_set."_descriptions"));

        for($q=0;$q<sizeof($desc);$q++)

        {

          $att_d=$desc[$q];

          $att=afetchrowset(mysql_query("SELECT * FROM  cms2_attributes_".$att_set." WHERE `element_id` = '".$block['block_id']."'"));

          $att=$att[0];



          $value=$att[$att_d['id']];

          $att_marker=$att_d['marker'];



          $block_template=str_replace($att_marker,$value,$block_template);

        }

      }

      $block_content.=$block_template;

      if ($i!=sizeof($blocks)-1) $block_content.='<br>';

    }

    $content=str_replace($marker,$block_content,$content);

  }

return $content;

}















//////////////////////////////////////////////////////////////////////////////////////////////////



function PrintComment($comment,$template)

{

/*

#comment_author

#comment_date

#comment_text

*/

$comment['time']=date("d.m.Y",$comment['time']);

$comment['user_id']=GetUser($comment['user_id']);

$template=str_replace('#comment_text',PrintSmilies($comment['comment']),$template);

$template=str_replace('#comment_date',$comment['time'],$template);

$template=str_replace('#comment_author',$comment['user_id'],$template);

return $template;

}





function GetUser($id)

{

  $user=afetchrowset(mysql_query("SELECT * FROM cms2_auth_users WHERE `id` = '".$id."'"));

  $user=$user[0];



  $s=mysql_query("select * from cms2_auth_reg_settings where name = 'field_login_id'");

  $s=mysql_fetch_row($s);



  return $user[$s[2]];

}



function PrintSmilies($text)

{

  $text=str_replace(':)','<img src="images/smilies/smile.gif" width="20" height="20" alt=":)" border="0">',$text);

  $text=str_replace(':|','<img src="images/smilies/neutral.gif" width="20" height="20" alt=":|" border="0">',$text);

  $text=str_replace(':(','<img src="images/smilies/sad.gif" width="20" height="20" alt=":(" border="0">',$text);

  $text=str_replace(':D','<img src="images/smilies/big_smile.gif" width="20" height="20" alt=":D" border="0">',$text);

  $text=str_replace(':o','<img src="images/smilies/yikes.gif" width="20" height="20" alt=":o" border="0">',$text);

  $text=str_replace(';)','<img src="images/smilies/wink.gif" width="20" height="20" alt=";)" border="0">',$text);

  $text=str_replace(':/','<img src="images/smilies/hmm.gif" width="20" height="20" alt=":/" border="0">',$text);

  $text=str_replace(':P','<img src="images/smilies/tongue.gif" width="20" height="20" alt=":P" border="0">',$text);

  $text=str_replace(':lol:','<img src="images/smilies/lol.gif" width="20" height="20" alt=":lol:" border="0">',$text);

  $text=str_replace(':mad:','<img src="images/smilies/mad.gif" width="20" height="20" alt=":mad:" border="0">',$text);

  $text=str_replace(':rolleyes:','<img src="images/smilies/roll.gif" width="20" height="20" alt=":rolleyes:" border="0">',$text);

  $text=str_replace(':cool:','<img src="images/smilies/cool.gif" width="20" height="20" alt=":cool:" border="0">',$text);

  return $text;

}



?>