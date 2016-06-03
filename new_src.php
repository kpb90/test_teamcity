<?php
define("COUNT_ITEMS_ON_PAGE", 4);
include_once 'new_admin/paging.php';

function get_pagination ($pager)
{		
    return "<div class = 'pager virtual_pager'>".$pager->get_prev_page_link().$pager->get_page_links().$pager->get_next_page_link()."</div>";
}
function get_news_item ($row)
{
    $date = new DateTime($row['date']);
    $timestamp = $date->getTimestamp();
    $date = rus_date('j F Y', $timestamp);
    $title = $row['name'] ? $row['name'] : smarty_modifier_mb_truncate ($row['text_small'], 264,'');
     return ' <article>
         '.($row['img'] ? '
                <div class="pic">
                    <a href="/novosti/?id='.$row['id'].'">
                        <img src = "'.$row['img'].'">
	            </a>
                </div>':'').'
                <div class="content" '.($row['img'] ? '':' style = "margin-left:0;"').'>
                    <div class="title"><a href="/novosti/?id='.$row['id'].'">'.$title.'</a></div>
                    <div class="description">'.$row['text_small'].'</div>
                <div class="date">'.$date.'</div>
                    </div>
              </article>';
}

function pscript_execute() 
{
   $condition = '';

   if ($_REQUEST['id'])
   {
        $condition = ' and id = "'.intval($_REQUEST['id']).'"';    
   }
   else
   {
    $condition = $_REQUEST['year'] ? " and YEAR(n.date) = ".intval($_REQUEST['year']) : '';
    $condition .= $_REQUEST['month'] ? " and month(n.date) = ".intval($_REQUEST['month']) : '';
   }

   $query = "select n.*, MONTH(n.date) as month from news as n where archive=0 and add2archive=0 {$condition} order by date desc, id desc";   
   $pager = new Paging($GLOBALS['DB_CONNECTION'], $query);
   $r = $pager->get_page($query);
   
   if (isset($_REQUEST['s']))
    {
            $pager->set_page_size($_REQUEST['s']);
    }
    else
    {
        $pager->set_page_size(COUNT_ITEMS_ON_PAGE);
    }
   
   $ret_str_items = '';
   $news_items = array ();
   while($r&&$row=$r->fetch_assoc())
   {
     $news_items = $row;
     $ret_str_items .= get_news_item ($row);
   }
   
   $current_year = $_REQUEST['year'] ? $_REQUEST['year'] : date("Y");
   $query = "select count(n.id) as count,MONTH(n.date) as month ,YEAR(n.date) as year  from news as n where archive=0 and add2archive=0 and YEAR(n.date) = {$current_year}  group by year,month";
   $r = $GLOBALS['DB_CONNECTION']->query($query);

   if (!$_REQUEST['id'])
   {
    $fltr_month_str = '';
    $class_act = '';
    while($r&&$row=$r->fetch_assoc())
    {
        $class_act = $row['month'] == $_REQUEST['month']&&$row['year']==$_REQUEST['year'] ? ' class = "active" ' : '';
        $fltr_month_str .= '<div class="month">
                               <a '.$class_act.' rel="'.$row['month'].'" href="/novosti/?year='.$current_year.'&month='.$row['month'].'">'.month_name2($row['month']).' <span>'.$row['count'].' новост' . ($row['count'] == 1 ? 'ь' : ($row['count'] < 5 ? 'и' : 'ей')) . '</span></a>
                            </div>';
    }
    if($fltr_month_str)
    {
       $fltr_month_str = "<div class = 'months'>{$fltr_month_str}</div>"; 
    }
    $prev_year = '<a rel="'.($current_year-1).'" href="/novosti/?year='.($current_year-1).'"><img src="//cdn.vostok.ru/images/layout/arrow-left.png"></a>';
    $next_year = date("Y")!=$current_year ? '<a rel="'.($current_year+1).'" href="/novosti/?year='.($current_year+1).'"><img src="//cdn.vostok.ru/images/layout/arrow-right.png"></a>':'';

    if (!$ret_str_items)
    {
       $ret_str_items = "По данному запросу новостей не найдено";
    }
     return '
         <div class="layout-limiter">
                         <div class="breadcrumbs news ">
                             <a href="/">Главная</a> →
                             <span>Новости</span> 
                        </div>
     <section id="press-list" class="news" style = "padding-top:37px;">
         <section id="press-filter">
                <div class = "year">'.$prev_year.'<span>'.$current_year.' год</span>'.$next_year.'</div>
                 '.$fltr_month_str.'
         </section>
         <section id="press-articles">
                 '.$ret_str_items.'
                 '.get_pagination ($pager).'
         </section>
         <clear></clear>
     </section>';
   }
   
        $title = $news_items['name'] ? $news_items['name'] : smarty_modifier_mb_truncate ($news_items['text_small'], 264,'...');
$date = new DateTime($news_items['date']);
$timestamp = $date->getTimestamp();

        return '    <div class="layout-limiter">
                         <div class="breadcrumbs news ">
                             <a href="/">Главная</a> →
                             <a href="/novosti/">Новости</a> → 
                             <span>'.$title.'</span> 
                        </div>
                     </div>
                     <header  style="padding-top: 36px;">
                         <div class="date">'.rus_date('j F Y', $timestamp).'</div>
                         <h1>'.$title.'</h1>
                         <div class="description pd">'.$news_items['text_small'].'</div>
                     </header>
                     <section id="vstkPageContent" class="user-content">
                         '.$news_items['text'].'
                     </section>
                 <div class="ext-link-block"><a href="/novosti/">← Вернуться к списку новостей</a></div>';
}