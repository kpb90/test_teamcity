$(document).ready(function () {

	var vostok_map;
	var markers;
	$.getJSON('/contacts/?json', {},
		function (data) {
			if (data.success) {
				markers = vostokContactsMapInitialize(vostok_map, data.x, data.y, data.zoom, data.points, false, true);
			}
		});



	$('#content').on('click', '#contacts-tabs a', function (e) {
		e.preventDefault();
		$hr = $(this);
		$("#content-contacts .country-contacts").hide();
		$("#contacts-tabs a").removeClass('active');
		$hr.addClass('active');
		$("#content-contacts .country-contacts[rel='"+$hr.attr('rel')+"']").show();
	});

	if($("#contacts-tabs a").length) $("#contacts-tabs a.active").click();
});