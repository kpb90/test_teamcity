$(document).ready(function () {

	$('#content').on('click','#press-filter-collapser', function (e) {
		e.preventDefault();
		$(this).toggleClass('active');
		$("#press-filter").fadeToggle(200);
	});

	$$.resolution(function(e, resolution){
		if(resolution > 768) {
			$("#press-filter").show();
		}
		else {
			$("#press-filter").hide();
		}
		$("#press-filter-collapser").removeClass('active');
	});

	$('#content').on('click','#press-filter .year > a', function (e) {
		e.preventDefault();
		$("#press-filter #cur-year").val($(this).attr('rel'));
		$('#pressFilterForm').submit();
	});
	$('#content').on('click','#press-filter .months > div > a', function (e) {
		e.preventDefault();
		$("#press-filter #cur-month").val($(this).attr('rel'));
		$('#pressFilterForm').submit();
	});

	/*$('#content').on('click','#press-filter #cancel-filter a', function (e) {
		e.preventDefault();
		$("#press-filter #cur-month").val("");
		$("#press-filter #cur-year").val("");
		$("#press-filter select").val("");
		$('#pressFilterForm').submit();
	}); */


	$('#content').on('change','#press-filter select', function (e) {
		$('#pressFilterForm').submit();
	});

});