function setMarkers(map, locations, autocenter, onMarkerClick, is_cluster) {
	var image, markers = [];
	var latlngbounds = new google.maps.LatLngBounds();
	for (var i = 0; i < locations.length; i++) {
		var point = locations[i];

		image = {
			url:(point['image'] ? point['image'] : '/images/layout/map_marker'+point['type']+'.png'),
			size:new google.maps.Size(32, 42),
			origin:new google.maps.Point(0, 0),
			anchor:new google.maps.Point(13, 39)
		};

		var myLatLng = new google.maps.LatLng(point['x'], point['y']);
		latlngbounds.extend(myLatLng);
		var marker = new google.maps.Marker({
			position:myLatLng,
			map:map,
			icon:image,
			title:point['title'],
			zIndex:point['order'],
			type: point['type'],
			id: point['id'],
			content: point['content']
		});
		markers.push(marker);
		if(onMarkerClick) google.maps.event.addListener(marker, 'click', onMarkerClick);
	}
	if(is_cluster) var markerCluster = new MarkerClusterer(map, markers,mcOptions);
	if(autocenter && locations.length != 1) map.setCenter( latlngbounds.getCenter(), map.fitBounds(latlngbounds));
	else if(locations.length == 1) {
		map.setZoom(17);
		map.setCenter(myLatLng);
	}
	else {
		//map.setCenter(latlngbounds.getCenter());
		//map.setZoom(3);
	}

	return markers;
}

function deleteMarkers(markers) {
	if (markers) {
		for (var i = 0; i < markers.length; i++) {
			markers[i].setMap(null);
		}
	}
}

var mcOptions = {
	maxZoom: 10,
	gridSize: 30,
	styles: [{
		height: 42,
		url: "/images/layout/map_marker.png",
		width: 32,
		fontFamily: 'Helvetica',
		textColor : 'white',
		textSize: 14,
		anchor: [10,0],
		anchorIcon: [20,-40]
	}
]};
var styles = {
	'Vostok':[
		{
			"featureType": "poi.business",
			"elementType": "labels",
			"stylers": [
			  { "visibility": "off" }
			]
		},
		{
			"featureType":"poi",
			"stylers":[
				{ "color":"#ffffff" }
			]
		},
		{
			"featureType":"poi",
			"elementType":"labels.text",
			"stylers":[
				{ "color":"#888888" },
				{ "weight":0.3 }
			]
		},
		{
			"featureType":"landscape",
			"elementType":"geometry.fill",
			"stylers":[
				{ "color":"#ffffff" }
			]
		},
		{
			"featureType":"water",
			"elementType":"geometry.fill",
			"stylers":[
				{ "color":"#00509e" }
			]
		},
		{
			"featureType":"water",
			"elementType":"labels.text",
			"stylers":[
				{ "color":"#888888" },
				{ "weight":0.3 }
			]
		},

		{
			"featureType":"administrative",
			"elementType":"labels.text",
			"stylers":[
				{ "color":"#888888" },
				{ "weight":0.3 }
			]
		},
		{
			"featureType":"road",
			"elementType":"geometry",
			"stylers":[
				{ "color":"#cccccc" }
			]
		}
	]
};

var infoWindowOptions = {
	alignBottom: false,
	boxClass: 'ui-tooltip box',
	disableAutoPan: false
	,maxWidth: '250px'
	,pixelOffset: new google.maps.Size(0, 0)
	,zIndex: 9
	,boxStyle: {
		opacity: 0.9,
		width: "280px",
		marginTop: '8px'
	}
	,closeBoxMargin: "0px 0px 0px 0px"
	,closeBoxURL: "/images/layout/filters-reset-button.png"
	,infoBoxClearance: new google.maps.Size(1, 1)
	,isHidden: false
	,pane: "floatPane"
	,enableEventPropagation: false
};

function vostokContactsMapInitialize(map, center_x, center_y, zoom, points_to_draw, autocenter , is_cluster) {
	map = new google.maps.Map(document.getElementById('vostok-contacts-map'), {
		disableDefaultUI:true,
		navigationControl:false,
		center:new google.maps.LatLng(center_x, center_y),
		zoom:zoom,
		mapTypeId:'Vostok'
	});
	google.maps.event.addListener(map, 'click', function() {
		infoWindow.close();
	});

	var infoWindow = new InfoBox(infoWindowOptions);
	//var infoWindow = new google.maps.InfoWindow;

	var onMarkerClick = function() {
		var mrk = this;
		if(mrk.type == 0) {
			location.href = '/contacts/'+mrk.id;
			return false;
		}
		var latLng = mrk.getPosition();
		infoWindow.setContent(mrk.content);
		infoWindow.open(map, mrk);
	};
	var styledMapType = new google.maps.StyledMapType(styles['Vostok'], {name:'Vostok'});
	map.mapTypes.set('Vostok', styledMapType);
	if (points_to_draw) return setMarkers(map, points_to_draw, autocenter, onMarkerClick, is_cluster);
}

var timeOut = null,
	myXHR = null;

$(document).ready(function () {

	$('#content').on('click', '#map-collapser', function (e) {
		var wid;
		if ($(this).hasClass('on')) wid = 410;
		else wid = 50;
		$("#vostok-contacts-map").animate({
			height:wid
		}, 400);
		$(this).toggleClass('on');
	});

	$('#content').on('click', '#similar-contact-points .header.toggle', function (e) {
		 $(this).toggleClass('open');
		 $(this).next().stop().slideToggle(300);
	});

	$('#content').on('click', '#similar-contact-points .header.toggle a', function (e) {
		e.stopPropagation();
	});

	$('#content').on('click', '#similar-contact-points .body h3.dashed > span', function (e) {
		$(this).toggleClass('open');
		$(this).closest('h3').next(".contacts").stop().slideToggle(300);
	});

	$('#content').on('click', '#map-contacts .content article header.dashed > span', function (e) {
		$(this).toggleClass('open');
		$(this).closest('header').next(".contacts").stop().slideToggle(300);
	});

	if($("#map-contacts .content article").length)$("#map-contacts .content article").eq(0).find(" header.dashed > span").click();

	$('#content').on('keyup', '#search-contacts-inp', function (e) {

		var ul = $("#content-contacts-search > div > ul");
		var search = $(this).val();
		if(search.length >= 3)
		{
			//if(timeOut) clearTimeout(timeOut);
			//timeOut = setTimeout(function(){
				if(myXHR) myXHR.abort();

				myXHR = $.ajax({
					type: "GET",
					url: "/contacts/?search",
					data: {query : search},
					dataType: 'json'
				}).done(function(data){
					 if(data.success) {
						 if(data.points.length) {
							 ul.html("");
							 $.each(data.points, function( i, item ) {
								 ul.append("<li><a href='"+item.link+"'>"+item.title+"</a></li>");
							 });
							 ul.fadeIn(300);
						 }
						 else ul.fadeOut(300);

					 }
				});
			//}, 250);
		}
		else ul.fadeOut(300);
	});

	$('#content').on('focus', '#search-contacts-inp', function (e) {
		if($(this).val() == "Введите город, ст.метро, адрес") {
			$(this).addClass('active');
			$(this).val("");
		}
	});

	$('#content').on('blur', '#search-contacts-inp', function (e) {
		if($(this).val() == "") {
			$(this).removeClass('active');
			$(this).val("Введите город, ст.метро, адрес");
		}
		$("#content-contacts-search > div > ul").fadeOut(300);
	});




});
