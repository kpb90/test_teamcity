<?php 

	$GLOBALS['TRANSLITER']['alfavitlower'] = explode(',', '., ,ё,й,ц,у,к,е,н,г,ш,щ,з,х,ъ,ф,ы,в,а,п,р,о,л,д,ж,э,я,ч,с,м,и,т,ь,б,ю');
	$GLOBALS['TRANSLITER']['alfavitupper'] = explode(',', '., ,Ё,Й,Ц,У,К,Е,Н,Г,Ш,Щ,З,Х,Ъ,Ф,Ы,В,А,П,Р,О,Л,Д,Ж,Э,Я,Ч,С,М,И,Т,Ь,Б,Ю');
	$GLOBALS['TRANSLITER']['alfavit_trans'] = explode(',', '_,_,e,y,c,u,k,e,n,g,sh,shh,z,h,,f,y,v,a,p,r,o,l,d,j,e,ya,ch,s,m,i,t,,b,u');

	function get_translit_singleline($source_str)
	{
		$ret = strtotranslit(trim($source_str));
		return $ret;
	}

	function get_translit_multiline($source_str)
	{
		$ret = array();
		foreach(preg_split("/(\r?\n)/", $source_str) as $line)
		{
			$ret[] = strtotranslit(trim($line));
		}
		return $ret;
	}

	function strtotranslit($word) 
	{
		$ret = str_replace($GLOBALS['TRANSLITER']['alfavitlower'], 
			$GLOBALS['TRANSLITER']['alfavit_trans'], 
			strtolower_cyr($word));
		return preg_replace("/[^A-Za-z0-9 _]/","",$ret);
	}

	function strtolower_cyr($word) 
	{
		return str_replace($GLOBALS['TRANSLITER']['alfavitupper'], 
			$GLOBALS['TRANSLITER']['alfavitlower'], 
			$word);
	}

	function strtoupper_cyr($word) 
	{
		return str_replace($GLOBALS['TRANSLITER']['alfavitlower'], 
			$GLOBALS['TRANSLITER']['alfavitupper'], 
			$word);
	}


	if(isset($_GET['transl_source']))
	{
		echo get_translit_singleline($_GET['transl_source']);
	}

?>