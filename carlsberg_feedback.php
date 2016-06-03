<?php
include_once "carlsberg_function.php";

if ($_REQUEST['text_otz']) {
	$GLOBALS['db_for_log']->wrp_log_history (array ('update_rating' => '1', 
											  'callback' => 'send_letter_carlsberg', 
											  'subj'=>$subj,
											  'header'=>$header,	
											  'email'=>'kpb90@mail.ru',
											  'email_text'=>"Обновился рейтинг",
											  'id_item'=>$_REQUEST['id_item'],
											  'data'=>$_REQUEST));
	echo 1;
	exit;
}

echo '
<script>
	$("div.rating").raty({
	  score: function() {
	    return $(this).attr("data-score");
	  },
	  path:"/images",
	  click: function(score, evt) {
		  $(this).next().val(score);
	  }
	});
</script>
<div id="modal_window" style = "width:500px;margin-top: 0;">
			  <div id="reg_modal_title">Оцените товар</div>
			  <div id="place_for_insert"></div>
			  <form id="modal_form" method="POST" enctype="multipart/form-data">
				  <table style = "width:97%">
					<tbody>
					<tr>
						<td style="text-align:right; width:10%;">
							Защитные свойства изделия:
						</td>
						<td>
							<div class="rating" data-score="0" style = "margin:11px;">
							</div>
							<input type="hidden" id = "modal_protect_rating" name = "protect_rating" value = "0">
						</td>
					</tr>
					<tr>
						<td style="text-align:right">
							Надежность:
						</td>
						<td>
							<div class="rating" data-score="0" style = "margin:11px;">
							</div>
							<input type="hidden" id = "modal_reliability_rating" name = "reliability_rating" value = "0">
						</td>
					</tr>
					<tr>
						<td style="text-align:right">
							Удобство использования/комфорт:
						</td>
						<td>
							<div class="rating" data-score="0" style = "margin:11px;">
							</div>
							<input type="hidden" id = "modal_comfort_rating" name = "comfort_rating" value = "0">
						</td>
					</tr>
					<tr>
						<td style="text-align:right">
							Соответствие условиям эксплуатации:
						</td>
						<td>
							<div class="rating" data-score="0" style = "margin:11px;">
							</div>
							<input type="hidden" id = "modal_exploitation_rating" name = "exploitation_rating" value = "0">
						</td>
					</tr>
					<tr>
						<td style="text-align:right">
							Дизайн
						</td>
						<td>
							<div class="rating" data-score="0" style = "margin:11px;">
							</div>
							<input type="hidden" id = "modal_design_rating" name = "design_rating" value = "0">
						</td>
					</tr>
					<tr>
						<td style="text-align:right">
							Комментарии:
						</td>
						<td>
							<textarea id = "modal_text_otz" style = "width:90%; height:70px;border: 1px solid #d1d3d4;border-radius: 7px;margin-left: 4px;padding: 10px;" name="text_otz" required></textarea>
						</td>
					</tr>
					<tr>
						<td style="text-align:center;" colspan="2">
							<input style = "cursor:pointer;" id="basket_issue_order3" name="modal_submit_cart" type="submit" value="Отправить">
						</td>
					</tr>
				  </tbody></table>
				  <input type="hidden" name = "id_item" value = "'.($_REQUEST['id']).'">
				  <input type="hidden" name = "id_user" value = "'.($_SESSION['auto_user']['id']).'">
				</form>
		</div>';
?>