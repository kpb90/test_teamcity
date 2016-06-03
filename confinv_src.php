<?php

include"./catalog/translit.php";

function pscript_execute() 
{
	$ret = '';

	$fpref = $_GET['c'] ? '2' : '';
	$qnty = $_GET['qnty'] ? intval($_GET['qnty']) : 0;

	$GLOBALS['SCRIPT_SET_DATA_HPTITLE'] = "Заявка на участие в конференции " . ($_GET['c'] == 'pskov' ?  'ПСКОВ (3 апреля)' : '');

	if($qnty)
	{
		$fh = fopen("conf_inv{$fpref}.inc", 'w');
		fwrite($fh, $qnty);
		fclose($fh);

		$mmod = $qnty % 10;

		$fh2 = fopen("conf_inv{$fpref}.inc2", 'w');
		fwrite($fh2, $mmod == 1 && $qnty != 11  ? '' : ($mmod > 1 && $mmod < 5 && floor($qnty / 10) != 1 ? 'а' : 'ов')    );
		fclose($fh2);
	}

	if ($_POST['step'] == 3 && "{$_POST['person']}" != '  ') 
	{
		$doc = '';
		if(strpos($_POST['content'], 'href=') !== false || strpos($_POST['content'], '@') !== false || strpos($_POST['content'], 'Тел') !== false)
		{
			echo 'Сообщение заблокировано как спам, позвоните нам 318-05-50 и мы постараемся Вам ответить.';
			exit;
		}
		if(isset($_FILES['inp_file']) && $_FILES['inp_file']['tmp_name'] != '' && $_FILES['inp_file']['size'] != 0)
		{
			$folder = $_SERVER['DOCUMENT_ROOT'].'/images/documents/';

			$type_of_uploaded_file = substr($_FILES['inp_file']['name'], strrpos($_FILES['inp_file']['name'], '.') + 1);

			$nnname = get_translit_fname($_FILES['inp_file']['name']);	

			if(!is_allowed_filetype($type_of_uploaded_file))
			{	
				$ret .= "<div style='background-color: red; padding: 5px;'>Недопустимое имя файла {$_FILES['doc']['name']}!</div>";
			}
			else
			{
				$filename = $folder . $nnname;
				move_uploaded_file($_FILES['inp_file']['tmp_name'], $filename);
				$doc  = $_FILES['inp_file']['name'] ? "Документ: http://vostok.spb.ru/images/documents/{$nnname}":'';
			}
		}

		$mail_text="
			Сообщение отправлено с сайта vostok.spb.ru, раздел '{$GLOBALS['SCRIPT_SET_DATA_HPTITLE']}':\n
			Имя: {$_POST['person']}
			Телефон: {$_POST['telefon']}
			Организация: {$_POST['organiz']}
			Должность: {$_POST['organiz_pos']}
			E-mail: {$_POST['email']}
			{$doc}
		";

		$header	= "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/plain; charset=utf-8\r\n";

   		//@mail('alexeiespoo@mail.ru', $GLOBALS['SCRIPT_SET_DATA_HPTITLE'], $mail_text, $header);
   		@mail('fedorova@vostok.spb.ru', $GLOBALS['SCRIPT_SET_DATA_HPTITLE'], $mail_text, $header);

		$ret .= "<div style='background-color: yellow; padding: 5px;'>Ваше сообщение было успешно отправлено!<br>Благодарим за Ваше участие!</div>";
	}

	$ptext = '';
	$r = $GLOBALS['DB_CONNECTION']->query("select title as text_small, content as text from cms2_pages where id=" . ($_GET['c'] == 'pskov' ? 169 : 175));
	if($r)
	{
		$row = $r->fetch_assoc();
		if($row)
		{
			$GLOBALS['SCRIPT_SET_DATA_HPTITLE'] = $row['text_small'];
			$ptext = $row['text'];
		}
	}

	$uqty = file_get_contents("conf_inv{$fpref}.inc");
	$upostf = file_get_contents("conf_inv{$fpref}.inc2");

	return $ret . '	<div style="width: 600px; text-align: left; clear: both; padding-top: 20px;">
			Уже зарегистрировались: <b style="color: #003287; font-size: 16px;">' . $uqty . '</b> участник' . $upostf . '
			<p><b><a href="#submitform"><u>Отправить заявку на участие</u></a></b>
			<p>' . $ptext . '
		</div>
		<p style="margin: 0; padding-top: 25px;">
		Отправьте Вашу заявку воспользовавшись данной формой:
		<A name="submitform">&nbsp;</a>
		<div class="form">
		<form method="POST" name="ask_form" id="ask_form" enctype="multipart/form-data"> 
			<input type=hidden name="step" value=3>
			<table border=0>
				<tr><td width=170 nowrap>
					Ф.И.О.:
				</td><td>
					<INPUT TYPE="TEXT" NAME="person" SIZE=66 MAXLENGTH=255>
				</td></tr><tr><td>
					Должность:
				</td><td>
					<INPUT TYPE="TEXT" NAME="organiz_pos" SIZE=66 MAXLENGTH=255>
				</td></tr><tr><td>
					Наименование предприятия:
				</td><td>
					<INPUT TYPE="TEXT" NAME="organiz" SIZE=66 MAXLENGTH=255>
				</td></tr><tr><td>
					Телефон:
				</td><td>
					<INPUT TYPE="TEXT" NAME="telefon" SIZE=66 MAXLENGTH=255>
				</td></tr><tr><td>
					Адрес электронной почты:
				</td><td>
					<INPUT TYPE="TEXT" NAME="email" SIZE=66 MAXLENGTH=255>
				</td></tr><tr><td colspan=2 style="height: 50px;">
					<div style="float: left;">Прикрепить файл (<b>не обязательно</b>)<br>в формате .doc, .docx, .odt, .pdf, .rtf, .xls, .xlsx, .gif, .png, .jpg</div>
					<div class="pretty-file-input" style="width: 100px; float: right;cursor: pointer;"><div class="text">Обзор</div><input type="file" size="1" name="inp_file" id="inp_file"></div>
				</td></tr>
			</table>
			<button id="u-write-catalog-submit-button" type="submit">Отправить</button>
		</FORM>
		</div>
	';

}

function is_allowed_filetype($type_of_uploaded_file)
{
	$allowed_extensions = array("ZIP","7ZIP","DOC","DOCX","ODT","PDF","RTF","XLS","XLSX","GIF","PNG","JPG");
	for($i=0; $i < sizeof($allowed_extensions); $i++)
	{
		if(strcasecmp($allowed_extensions[$i], $type_of_uploaded_file) == 0)
			return true;
	}
	return false;
}


?>
