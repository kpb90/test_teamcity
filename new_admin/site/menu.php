<?php

function find_top_page($page_id)
{
	$select_page = mysql_query("select parent from cms2_pages where id='$page_id'");
	
	if(!$select_page)
		return;

	$p_row = mysql_fetch_assoc($select_page);
	
	if(!$p_row)
		return;

	$parent = $p_row['parent'];

	return (!$parent) ? $page_id : find_top_page($parent);
}


function build_page_menus($page_in_db, $ret_arr)
{
	$page_id = $page_in_db['id'];

	$page_selected = find_top_page($page_id);

	$ret_arr['top'] = top_menu($page_in_db, $page_id, $page_selected);			

	$ret_arr['secondary'] = menu_2($page_in_db, $page_id, $page_selected);			
}


function top_menu($page_in_db, $page_id, $page_selected) 
{
	$result= '';

	$pages=mysql_query("select * from cms2_pages where parent='0' and menu_status='0' order by position");

	$pages_count=mysql_num_rows($pages);

	while ($line_menu=mysql_fetch_array($pages))
	{
		extract($line_menu);

		if($file_name == 'index')
			$file_name = '';			
		else if(strpos($file_name, '.') === FALSE)
			$file_name .= '.html';

		$pact = ($page_selected == $line_menu['id']) ? '_sel' : '';

		$result .= "
			<li class='t_menu{$pact}'>
				<a href='/{$file_name}' target='_self' title='{$menu_title}'" . ($file_name ? " id='{$file_name}'" : '') . ">{$menu_title}</a>
			</li>
		";

	}

	return "<ul>{$result}</ul>";
}


function menu_2($a_page, $page_id, $top_page)
{
	$result = '';
	$pages=mysql_query("select * from cms2_pages where menu_status='0' and parent='$top_page' order by position");
	while ($line=mysql_fetch_array($pages))
	{
		extract($line);
		$pact = ($page_id == $line[id]) ? '_sel' : '';
		$result .= "<div id='menu_sub_top_div{$pact}'><a href=\"{$line['file_name']}.html\">{$line['menu_title']}</a></div>\n";
	}

	return $result;
}
?>

