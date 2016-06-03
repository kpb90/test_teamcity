<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors','On');


function pscript_execute() 
{
	$ptext = '';

	if ($_POST['step'] == 3) 
	{
		if(strpos($_POST['content'], 'href=') !== false || strpos($_POST['content'], '@') !== false || strpos($_POST['content'], 'Тел') !== false)
		{
			echo 'Сообщение заблокировано как спам, позвоните нам 318-05-50 и мы постараемся Вам ответить.';
			exit;
		}

		//Make order
		$mail_text="
		Сообщение отправлено с сайта vostok.spb.ru:

		Имя: {$_POST['person2']} {$_POST['person']} {$_POST['person3']}

		Телефон: {$_POST['telefon']}

		Организация: {$_POST['organiz']}

		E-mail: {$_POST['email']}

		Тип сообщения: {$_POST['content_type']};

		Сообщение: {$_POST['content']}";
				
		$header	= "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/plain; charset=utf-8\r\n";
	$header .= 'From: quality@vostok.spb.ru' . "\r\n" .
	    'Reply-To: quality@vostok.spb.ru' . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();

		@mail('intraseti@mail.ru', 'Обратная связь (' . $_POST['content_type'] . ')', $mail_text, $header);
		@mail('v.maksymiv@vostok.spb.ru', 'Обратная связь (' . $_POST['content_type'] . ')', $mail_text, $header);
		@mail('quality@vostok.spb.ru', 'Обратная связь (' . $_POST['content_type'] . ')', $mail_text, $header);

		$ptext = "<h2 style='color: green;'><u>Ваше сообщение было успешно отправлено!</h2></u><p><b>Благодарим за Ваше участие!</b><p>";
	}

	$r = $GLOBALS['DB_CONNECTION']->query("select title as text_small, content as text from cms2_pages where id=31");
	if($r)
	{
		$row = $r->fetch_assoc();
		if($row)
		{
			$GLOBALS['SCRIPT_SET_DATA_HPTITLE'] = $row['text_small'];
			return $ptext . $row['text'];
		}
	}



}
?>