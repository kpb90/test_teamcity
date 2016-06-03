$(document).ready(function () {

	var vostok_map, markers;

	$.getJSON('?json', {},
		function (data) {
			if (data.success) {
				markers = vostokContactsMapInitialize(vostok_map, data.x, data.y, data.zoom, data.points, true , false);
			}
	});

	$('#content').on('click', '#map-selector .switcher:not(.disabled)', function (e) {
		var cur = $(this);
		if(!$(cur).hasClass('active')) {
			if ($('#map-collapser').hasClass('on')) {
				$("#vostok-contacts-map").animate({
					height:410
				}, 400);
			}
			var rel = $(cur).attr('rel');
			$("#vostok-contacts-map").css('opacity','0.5');
			$.getJSON('?json', {'type' : rel},
				function (data) {
					if (data.success) {
						deleteMarkers(markers);
						markers = vostokContactsMapInitialize(vostok_map, data.x, data.y, data.zoom, data.points, true, false);
						$("#map-selector .switcher").removeClass('active');
						$(cur).addClass('active')
						$("#content #map-selector").attr('rel',rel);
						$("#content #map-selector .switcher:not('.active')").addClass('hide');
						$("#content #map-selector .switcher.active").removeClass('hide');
						if($('body').hasClass('_480')) {
							$("#map-selector .switcher.active i").show();
						}
						$("#vostok-contacts-map").css('opacity','1');
					}
				});
		}
		else {
			if($('body').hasClass('_480')) {
				var switches = $('body._480 #content #map-selector .switcher');
				var switches_vis = $("body._480 #content #map-selector .switcher:visible");
				if(switches_vis.length == 1) switches.removeClass('hide');
				else $("body._480 #content #map-selector .switcher:not('.active')").addClass('hide');
				$("#map-selector .switcher.active i").hide();
			}
		}


	});

	$('#content').on('click', '#map-contacts .content article > .collapser a', function (e) {
		e.preventDefault();
		var link = $(this);
		if($(link).hasClass('active')) $(link).removeClass('active').html("Показать подробную информацию");
		else $(link).addClass('active').html("Скрыть подробную информацию");
		$(link).closest('article').find('.ext').slideToggle(400);

	});

	$.each($('#map-selector .switcher'), function(i, obj) {
		if($('#map-contacts .content h2.'+$(this).attr('rel')).length == 0 && $(this).attr('rel') != 'all') {
			$(this).addClass('disabled').insertBefore("#map-selector clear");
			$("#map-selector .arrows i[rel='"+$(this).attr('rel')+"']").appendTo("#map-selector .arrows").addClass('disabled');
		}
	});

	if($('#map-selector .switcher:not(.disabled)').length < 3) $('#map-selector').remove();


});