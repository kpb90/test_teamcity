<?php

	function get_yandex_map($xc, $yc, $name, $width, $height, $kk) 
	{
		return '
			<center><div class="green" style="padding: 5px; width: ' . $width. 'px;">
			<script type="text/javascript">
			if(typeof(YMaps) !== "undefined")
			{
			    YMaps.jQuery(function () {
			        var map' . $kk . ' = new YMaps.Map(YMaps.jQuery("#YMapsID-3711' . $kk . '")[0]);
			        map' . $kk . '.setCenter(new YMaps.GeoPoint(' . $xc . ', ' . $yc . '), 14, YMaps.MapType.MAP);
			        map' . $kk . '.addControl(new YMaps.Zoom());
			        map' . $kk . '.addControl(new YMaps.ToolBar());
			        map' . $kk . '.addControl(new YMaps.TypeControl());
			        YMaps.Styles.add("constructor#pmrdmPlacemark", {
			            iconStyle : {
			                href : "http://api-maps.yandex.ru/i/0.3/placemarks/pmrdm.png",
			                size : new YMaps.Point(28,29),
			                offset: new YMaps.Point(-8,-27)
			            }
			        });
			       map' . $kk . '.addOverlay(createObject("Placemark", new YMaps.GeoPoint(' . $xc . ', ' . $yc . '), "constructor#pmrdmPlacemark", "' . $name . '"));
			        function createObject (type, point, style, description) {
			            var allowObjects = ["Placemark", "Polyline", "Polygon"],
			                index = YMaps.jQuery.inArray( type, allowObjects),
			                constructor = allowObjects[(index == -1) ? 0 : index];
			                description = description || "";
			            var object = new YMaps[constructor](point, {style: style, hasBalloon : !!description});
			            object.description = description;
			            return object;
			        }
			    });
			    document.write("<div id=\"YMapsID-3711' . $kk . '\" style=\"width:' . ($width - 10). 'px;height:' . $height . 'px\"></div>");
			}
			</script>
			<div style="padding: 10px;text-align:center;"><span style = "color:white"><strong>Сан-фа: ' . $xc . ', ' . $yc . '</strong></span></div></div></center>
		';
	}

?>