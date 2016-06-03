<?php

function pscript_execute() 
{

	$shops_rows = afetchrowset(mysql_query("select content from cms2_pages where id=140"));

	$GLOBALS['SCRIPT_SET_DATA_HPTITLE'] = $GLOBALS['PAGE_IN_DB']['title'];

	return "{$GLOBALS['PAGE_IN_DB']['content']}
		{$shops_rows[0]['content']}
		<br><br><A name='mmap'>
		<img src='/catalog/upload/images/map42.jpg' alt='Филиалы Восток-Сервис' ISMAP usemap='#IHIP_NEW' border='0'>
<map name='IHIP_NEW'>
   <area href='/shops/savushkina.php' coords='125,151,35' shape='circle'>
   <area href='/shops/obvodny_kanal.php' coords='237,440,35' shape='circle'>
   <area href='/shops/akademka.php' coords='340,95,35' shape='circle'>
   <area href='/shops/vaska.php' coords='117,275,35' shape='circle'>
   <area href='/shops/ligovka.php' coords='375,340,35' shape='circle'>
   <area href='/shops/narvskaja.php' coords='150,500,35' shape='circle'>
   <area href='/shops/elektrosila.php' coords='220,540,35' shape='circle'>
   <area href='/shops/elizarovskaja.php' coords='420,510,35' shape='circle'>
   <area href='/shops/ozerki.php' coords='190,100,35' shape='circle'>
   <area href='/shops/veteranov.php' coords='140,620,35' shape='circle'>
   <area nohref='' shape='default'>
  </map>		
	";
}
?>