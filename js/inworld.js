function setMarkers(map, locations, autocenter, onMarkerClick) {
	var image, markers = [];
	if (autocenter) var latlngbounds = new google.maps.LatLngBounds();
	for (var i = 0; i < locations.length; i++) {
		var point = locations[i];

		image = {
			url:(point['image'] ? point['image'] : '/images/layout/inworld_marker' + point['type'] + '.png'),
			size:(point['image'] ? new google.maps.Size(85, 105) : new google.maps.Size(32, 42)),
			origin:new google.maps.Point(0, 0),
			anchor:(point['image'] ? new google.maps.Point(55, 90) : new google.maps.Point(13, 39))
		};

		var myLatLng = new google.maps.LatLng(point['x'], point['y']);
		if (autocenter) latlngbounds.extend(myLatLng);
		var marker = new google.maps.Marker({
			position:myLatLng,
			map:map,
			ttype: point['type'],
			icon:image,
			title:point['title'],
			zIndex:point['order'],
			content:point['content']
		});
		markers.push(marker);
		if (onMarkerClick) google.maps.event.addListener(marker, 'click', onMarkerClick);
	}
	if($("#map-selector .switcher.active").eq(0).attr('rel') == 'all') {
		//var markerCluster = new MarkerClusterer(map, markers, mcOptions);
	}
	if (autocenter) {
		map.setCenter(latlngbounds.getCenter(), map.fitBounds(latlngbounds));
	}

	if (locations.length <= 1 || $('body').hasClass('_480')) {
		map.setZoom(3);
	}
	return markers;
}

function deleteMarkers(markers) {
	var k = markers;
	if (markers) {
		for (var i = 0; i < markers.length; i++) {
			markers[i].setMap(null);
		}
	}
	return k;
}

function drawMarkers(markers, map) {
	if (markers) {
		for (var i = 0; i < markers.length; i++) {
			markers[i].setMap(map);
		}
	}
}

var infoWindowOptions = {
	alignBottom: false,
	boxClass: 'inworld-point-box',
	disableAutoPan: false
	,maxWidth: '250px'
	,pixelOffset: new google.maps.Size(3, -47)
	,zIndex: -1
	,boxStyle: {
		opacity: 0.8,
		width: "280px",
		marginTop: '8px'
	}
	,closeBoxMargin: "6px 0px 0px 0px"
	,closeBoxURL: "/images/layout/filters-reset-all-button-white.png"
	,infoBoxClearance: new google.maps.Size(1, 1)
	,isHidden: false
	,pane: "floatPane"
	,enableEventPropagation: false
};


function vostokContactsMapInitialize(map, center_x, center_y, zoom, points_to_draw, autocenter) {

	map = new google.maps.Map(document.getElementById('vostok-contacts-map'), {
		disableDefaultUI:true,
		navigationControl:false,
		center:new google.maps.LatLng(center_x, center_y),
		zoom:zoom,
		mapTypeId:'Vostok'
	});

	google.maps.event.addListener(map, 'click', function () {
		infoWindow.close();
	});

	var infoWindow = new InfoBox(infoWindowOptions);
	//var infoWindow = new google.maps.InfoWindow;

	var onMarkerClick = function () {
		var mrk = this;
		var latLng = mrk.getPosition();
		infoWindow.setContent(mrk.content);
		infoWindow.boxClass_ = 'inworld-point-box point'+mrk.ttype;
		infoWindow.open(map, mrk);

	};
	var styledMapType = new google.maps.StyledMapType(styles['Vostok'], {name:'Vostok'});
	map.mapTypes.set('Vostok', styledMapType);
	if (points_to_draw) return setMarkers(map, points_to_draw, autocenter, onMarkerClick);

}

function refreshAdaptiveMap() {
	var cou = $("#map-selector .switcher").length;
	var wid = $("#map-contacts").outerWidth();
	var bdwid = $("body").outerWidth();
	var bdcont = $("#content").outerWidth();
	var mwid = Math.round(wid / cou);
	$("#map-selector .switcher").css({'width':mwid});
	$.each($("#map-selector .arrows i"), function (index, value) {
		$(value).css({'left':(mwid * (index + 1)) - (mwid / 2) - 8});

	});
	var dd = (bdcont - wid)/2;
	$("#content #vostok-contacts-map").css("margin","-20px -"+parseInt(dd)+"px")
}

$(document).ready(function () {
	var points = false;
	var vostok_map;
	var markers;
	var data_x;
	var data_y;
	var data_zoom;
	$.getJSON('/inworld/?json', {},
		function (data) {
			if (data.success) {
				points = data.points;
				data_x = data.x;
				data_y = data.y;
				data_zoom = data.zoom;
				markers = vostokContactsMapInitialize(vostok_map, data.x, data.y, data.zoom, data.points, false);
			}
		});

	$('#content').on('click', '#map-selector .switcher:not(.disabled)', function (e) {
		var cur = $(this);
		if (!$(cur).hasClass('active')) {
			var rel = $(cur).attr('rel');
			$("#vostok-contacts-map").css('opacity', '0.5');
			mcOptions.styles[0].url = "/images/layout/inworld_mix_marker_" + rel + ".png";
			$("#content #vostok-contacts-map").attr('rel', rel);
			$.getJSON('?json', {'type':rel},
				function (data) {
					if (data.success) {
						$("#map-selector .switcher").removeClass('active');
						$(cur).addClass('active');
						deleteMarkers(markers);
						markers = vostokContactsMapInitialize(vostok_map, data.x, data.y, data.zoom, data.points, true);
						$("#content #map-selector").attr('rel', rel);
						$("#content #map-selector .switcher:not('.active')").addClass('hide');
						$("#content #map-selector .switcher.active").removeClass('hide');
						if ($('body').hasClass('_480')) {
							$("#map-selector .switcher.active i").show();
						}
						$("#vostok-contacts-map").css('opacity', '1');
					}
				});
		}
		else {
			if ($('body').hasClass('_480')) {
				var switches = $('body._480 #content #map-selector .switcher');
				var switches_vis = $("body._480 #content #map-selector .switcher:visible");
				if (switches_vis.length == 1) {
					switches.removeClass('hide');
					$("#map-selector .arrows").addClass('open');
				}
				else {
					$("body._480 #content #map-selector .switcher:not('.active')").addClass('hide');
					$("#map-selector .arrows").removeClass('open');
				}
				$("#map-selector .switcher.active i").hide();
			}
		}


	});

	$$.resize(function (e, resolution) {
		refreshAdaptiveMap();
		if (points) {
			markers = vostokContactsMapInitialize(vostok_map, data_x, data_y, data_zoom, points, false);
		}
	});


});
