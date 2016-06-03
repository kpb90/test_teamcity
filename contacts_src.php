<?php

function pscript_execute()
{
	$GLOBALS['ZAKAZ_PAGE']['sec_extra'] ='';
	if (array_key_exists('messageFF', $_POST)) {
			$body2 .= "Имя: {$_POST['nameFF']}
			E-mail: {$_POST['contactFF']}
			Сообщение: {$_POST['messageFF']}\n";
			
			
			$header	= "MIME-Version: 1.0\r\nContent-type: text/plain; charset=utf-8\r\n";
			$header .= 'From: info@vostok.spb.ru' . "\r\n" .
			'Reply-To: info@vostok.spb.ru' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

			$subj = "Обратная связь Восток-Сервис";
			$where_mail = '';
			if ($_POST['where']==1) {
				$where_mail = 'kpb90@mail';
			} else if ($_POST['where']==2) {
				$where_mail = 'kpb90@mail';
			} else if ($_POST['where']==3) {
				$where_mail = 'kpb90@mail';
			}
			@mail($where_mail, $subj, $body2, $header);
			//@mail('info@vostok.spb.ru', $subj, $body2, $header);
			$GLOBALS['ZAKAZ_PAGE']['sec_extra'] = "<font style='color: blue;'>Ваше сообщение отправлено, большое спасибо!</font>";
	}
	
	
        $GLOBALS['ZAKAZ_PAGE']['sec_extra'] = '
<style>
		#feedback-form {
    padding: 2%;
  border-radius: 3px;
  background: #f1f1f1;
}
#feedback-form [required] {
  width: 100%;
  box-sizing: border-box;
  margin: 2px 0 2% 0;
  padding: 2%;
  border: 1px solid rgba(0,0,0,.1);
  border-radius: 3px;
  box-shadow: 0 1px 2px -1px rgba(0,0,0,.2) inset, 0 0 transparent;
}
#feedback-form [required]:hover {
  border-color: #7eb4ea;
  box-shadow: 0 1px 2px -1px rgba(0,0,0,.2) inset, 0 0 transparent;
}
#feedback-form [required]:focus {
  outline: none;
  border-color: #7eb4ea;
  box-shadow: 0 1px 2px -1px rgba(0,0,0,.2) inset, 0 0 4px rgba(35,146,243,.5);
  transition: .2s linear;
}
#feedback-form [type="submit"] {
  padding: 2%;
  border: none;
  border-radius: 3px;
  box-shadow: 0 0 0 1px rgba(0,0,0,.2) inset;
  background: #669acc;
  color: #fff;
}
#feedback-form [type="submit"]:hover {
  background: #5c90c2;
}
#feedback-form [type="submit"]:focus {
  box-shadow: 0 1px 1px #fff, inset 0 1px 2px rgba(0,0,0,.8), inset 0 -1px 0 rgba(0,0,0,.05);
}</style>
					<header class="calalog-header"><h1>Обратная связь</h1></header>
					<div>'.$GLOBALS['ZAKAZ_PAGE']['sec_extra'].'</div>
					<form method="POST" id="feedback-form">
					Как к Вам обращаться:
					<input type="text" name="nameFF" required placeholder="фамилия имя отчество" x-autocompletetype="name">
					Email для связи:
					<input type="email" name="contactFF" required placeholder="адрес электронной почты" x-autocompletetype="email">
					Ваше сообщение:
					<textarea name="messageFF" required rows="5"></textarea>
					<select multiple name="where[]" required>
						<option disabled>Выберите адресат письма</option>
						<option value="1">Техническая поддержка</option>
						<option value="2">Заказ продукции</option>
						<option value="3">Руководству</option>
					 </select>
					 <input type="submit" value="отправить">
					</form>
					';

	return $GLOBALS['PAGE_IN_DB']['content'].$GLOBALS['ZAKAZ_PAGE']['sec_extra'];
}
?>