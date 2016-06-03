function vacancyResponse(data) {
	$("#content #vacancy-acc-list").html("");
	$("#vacancy-filter-form .filter-item-type").hide();
	if(data.vacancies.length > 0) {
	$.each(data.vacancies, function(i, item) {
		$("#filter-type"+item.type).show();
		var str = '<div id="vv'+item.id+'"><h2><a href="'+item.url+'">'+item.title+'</a>&nbsp;→</h2>' +
			'<div class="content"><div class="description">'+item.description+'</div><div class="part1">' +
			(item.requirements ? '<h3>Требования</h3><div>'+item.requirements+'</div>' : '') +
			(item.responsibility ? '<h3>Обязанности</h3><div>'+item.responsibility+'</div>' : '') +
			'</div><div class="part2"><div class="gray">' +
			(item.conditions ? '<h3>Условия</h3>'+item.conditions : '') +
			(item.place ? '<h3>Место работы</h3>'+item.place : '') +
			(item.schedule ? '<h3>График работы</h3>'+item.schedule : '') +
			(item.contacts ? '<h3>Контактная информация</h3>'+item.contacts : '') +
			'</div>' +
			'<div class="buttons"><a href="#pretty-block-form-send-resume" rel="prettyForm" data-id="'+item.id+'"  class="button_mail"><span>Отправить <span>резюме</span></span></a>' +
			'<a href="#pretty-block-form-fill-questionnaire" rel="prettyForm"  data-id="'+item.id+'" class="button_anketa"><span>Заполнить <span>анкету кандидата</span></span></a>' +
			'</div></div><clear></clear></div></div>';
		$("#content #vacancy-acc-list").append(str);
	});

        initPrettyForm(function(){

        });

		if(document.location.hash.substring(1)) {
			var $item = $("#"+document.location.hash.substring(1));
			$item.find('> h2').click();
			Vostok.scrollTo($item,100);
		}
	}
	else $("#content #vacancy-acc-list").append("<span class='novacancy'>Вакансии не найдены</span>");
	$('#vacancy-filter-form').addClass('active');
}

function getVacanciesFromBD(){
	$('#vacancy-filter-form').removeClass('active');
	$('#vacancy-filter-form').ajaxSubmit({
		dataType:  'json',
		success:   vacancyResponse
	});
}

function vacancyChange(){
	if($("#vacancy-filter-form").hasClass('active')) {
		$("#content #vacancy-filter #cancel-filter").show();
		getVacanciesFromBD();
	}
}

$(document).ready(function () {

	getVacanciesFromBD();

	/*$('#content').on('click','#vacancy-acc-list > div > h2', function (e) {
		e.preventDefault();
		$(this).parent().toggleClass('open');
		//$("#vacancy-acc-list > div").removeClass('open');
		$(this).next().slideToggle(200);
		$(this).find('span.triangle').eq(0).toggleClass('up');
	});  */

	$('#content').on('click','#vacancy-filter-collapser, #hide-filter', function (e) {
		e.preventDefault();
		$(this).toggleClass('active');
		$("#vacancy-filter").fadeToggle(200);
	});

	$('#content').on('change','#vacancy-filter-form.active select', function (e) {
		vacancyChange();
	});

	$('#content #vacancy-filter-form input[type="checkbox"]').on('ifToggled', function(event){
		vacancyChange();
	});

	$$.resolution(function(e, resolution){
		if(resolution > 850) $("#vacancy-filter").show();
		else $("#vacancy-filter").hide();
		$("#vacancy-filter-collapser").removeClass('active');
	})

	$('#content').on('click','#cancel-filter a', function (e) {
		e.preventDefault();
		var region_id = $("#vacancy-region-id").val();
		$("#vacancy-filter-form").removeClass('active');
		$('#content #vacancy-filter-form input[type="checkbox"]').iCheck('uncheck');
		$("#vacancy-filter-form select").val((region_id ? region_id : 0)).change();
		getVacanciesFromBD();
		$("#content #vacancy-filter #cancel-filter").hide();
	});


});

