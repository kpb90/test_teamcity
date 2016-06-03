var onCounterChange = function(){};
function getUnit(n, u1, u234, u10){
	n = parseInt(n);
	n = Math.abs(n) % 100;
	if (n>10 && n<20) return u10;
	n = n % 10;
	if (n>1 && n<5) return u234;
	if (n==1) return u1;
	return u10;
}

function giveMePrettyPhoto() {

if ($("a[rel^='prettyPhoto']").length)
	$("a[rel^='prettyPhoto']").prettyPhoto({
		animation_speed: 'fast', /* fast/slow/normal */
		opacity: 0.60, /* Value between 0 and 1 */
		show_title: true, /* true/false */
		allow_resize: true, /* Resize the photos bigger than viewport. true/false */
		default_width: 500,
		default_height: 344,
		counter_separator_label: ' из ', /* The separator for the gallery counter 1 "of" 2 */
		theme: 'kinetica', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
		horizontal_padding: 20, /* The padding on each side of the picture */
		hideflash: false, /* Hides all the flash object on a page, set to TRUE if flash appears over prettyPhoto */
		wmode: 'opaque', /* Set the flash wmode attribute */
		autoplay: true, /* Automatically start videos: True/False */
		modal: false, /* If set to true, only the close button will close the window */
		deeplinking: false, /* Allow prettyPhoto to update the url to enable deeplinking. */
		overlay_gallery: false, /* If set to true, a gallery will overlay the fullscreen image on mouse over */
		keyboard_shortcuts: false,
		ie6_fallback: true,
		social_tools: false
	});

}

var initPrettyForm = function(callback){
	if ($("a[rel^='prettyForm']").length)
    $("a[rel^='prettyForm']").prettyPhoto({
        animation_speed: 0,//'fast', /* fast/slow/normal */
        opacity: 0.60, /* Value between 0 and 1 */
        show_title: true, /* true/false */
        allow_resize: false, /* Resize the photos bigger than viewport. true/false */
        default_width: 500,
        default_height: 344,
        counter_separator_label: ' из ', /* The separator for the gallery counter 1 "of" 2 */
        theme: 'kinetica', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
        horizontal_padding: 20, /* The padding on each side of the picture */
        hideflash: false, /* Hides all the flash object on a page, set to TRUE if flash appears over prettyPhoto */
        wmode: 'opaque', /* Set the flash wmode attribute */
        deeplinking: false, /* Allow prettyPhoto to update the url to enable deeplinking. */
        overlay_gallery: false, /* If set to true, a gallery will overlay the fullscreen image on mouse over */
        keyboard_shortcuts: false,
        ie6_fallback: true,
        social_tools: false,
        modal: true
    });

    if(callback) callback();
}

var initCounter = function(){
    $.each($("#content .count-adder"), function(i, obj) {
        $(obj).html("<span class='count-minus'></span>" +
            "<span class='value'><input type='text' value='"+( $(obj).attr('data-value') ? $(obj).attr('data-value') : 1)+"' name='count'>" +
            "<span class='unit'>"+( $(obj).attr('data-value') ? getUnit($(obj).attr('data-value'), $(obj).attr('data-unit1'), $(obj).attr('data-unit2'), $(obj).attr('data-unit5')) : $(obj).attr('data-unit1'))+"</span></span>" +
            "<span class='count-plus'></span>");
    });
}


function turnOffPrettyPhoto() {
	$("a[rel^='prettyPhoto']").unbind();
}

$(document).ready(function () {

$('.mblockdiv').click(function() {
	var el = $(this).find('a');
	if(el.length)
		document.location.href = el.first().attr('href');
});

	giveMePrettyPhoto();

    initPrettyForm();
if ($('.iTooltip').length)
    $('.iTooltip').tooltip({
		track: true,
		show: true,
		items: "[title],[data-description],[data-content]",
		content: function() {

			var conty = '';
			var element = $( this );
			if(element.is( "[data-content]" )) {
				conty = conty + "<div class='content'>" + element.attr( "data-description" ) + "</div>";
			}
			else {
				if ( element.is( "[title]" ) ) {
					conty = conty + "<header><a href='#'>" + element.attr( "title" ) + "</a></header>";
				}
				if ( element.is( "[data-description]" ) ) {
					conty = conty + "<div class='description'>" + element.attr( "data-description" ) + "</div>";
				}
			}

			return conty;
		}
	});
if ($('.iTooltip2').length)
	$('.iTooltip2').tooltip({
		track: false,
		show: false,
		items: "[title],[data-description],[data-content]",
		tooltipClass: 'blue-tooltip',
		close: function (event, ui) {
				if($(this).hasClass('openbubble'))$(this).tooltip('open');
		},
		open: function (event, ui) {
			giveMePrettyPhoto();
		},
		content: function() {
			var element = $( this );
			var conty = '<div><i class="close" data-dot="'+element.attr('id')+'"></i>';

			if(element.is( "[data-content]" )) {
				conty = conty + "<div class='content'>" + element.attr( "data-description" ) + "</div>";
			}
			else {
				if ( element.is( "[title]" ) && element.is( "[link]" ) ) {
					conty = conty + "<header><a href='" + element.attr( "link" ) + "'>" + element.attr( "title" ) + "</a></header>";
				}
				else if ( element.is( "[title]" ) ) {
					conty = conty + "<header>" + element.attr( "title" ) + "</header>";
				}
				if ( element.is( "[data-description]" ) ) {
					conty = conty + "<div class='description'>" + element.attr( "data-description" ) + "</div>";
				}
			}
			conty += '</div>';
			return conty;
		}
	}).off("mouseover mouseout mouseleave")
		.on("mouseout", function(){
			return false;
		})
		.on( "click", function(){
				if(!$(this).hasClass('openbubble')) {
				$('.iTooltip2').removeClass('openbubble');
			    $('.iTooltip2').tooltip('close');
				$(this).tooltip('open');
				$(this).addClass('openbubble');
			}
			return false;
		}).mouseleave(function () {
			return false;
		});

	$('body').on('click','.ui-tooltip-content i.close', function () {
		$('.iTooltip2').removeClass('openbubble');
		$('.iTooltip2').tooltip('close');
	});

	$.each($("#content .vostok-list-pager"), function(i, list) {
		$.each($(list).find(".container"), function(j, cont) {
			var str = "";
			var flag = true;
			if($(cont).find(".page").length > 1) {

				$.each($(cont).find(".page"), function(z, page) {
					str += "<div "+(flag ? " class='active'" : "")+"rel='"+$(page).attr('rel')+"'></div>";
					flag = false;
				});
				$(cont).append("<div class='pager2'><div class='left hide'></div><div class='right'></div></div><div class='pager'>"+str+"</div><clear></clear>");
			}

		});
	});

	$('#content').on('click','.vostok-list-pager > div.body > div.selector > div', function () {
		var elem = $(this);
		var id = elem.attr('rel');
		var container = $(this).parents('.vostok-list-pager').eq(0);
		$(container).find('div.body > div.selector > div').removeClass('active');
		elem.addClass('active');
		$(container).find('div.body > div.container').hide();
		$("#vostok-list-pager" + id).show();
	});

	$('#content').on('click', '.vostok-list-pager > div > div.body > div.container > div.pager > div',function () {
		var elem = $(this);
		var id = elem.attr('rel');
		var container = $(this).parents('.vostok-list-pager .container').eq(0);
		console.log(container);
		var next = container.find("div.pager2 .right").eq(0);
		var prev = container.find("div.pager2 .left").eq(0);
		elem.parent().find('div').removeClass('active');
		elem.addClass('active');
		container.find(".page:visible").hide();
		container.find(".page[rel='" + id + "']").show();
		if (elem.next().length == 0) next.addClass('hide');
		else next.removeClass('hide');
		if (elem.prev().length == 0) prev.addClass('hide');
		else prev.removeClass('hide');
	});

	$('#content').on('click','.vostok-list-pager > div > div.body > div.container > div.pager2 > div', function () {
		var elem = $(this);
		var container = $(this).parents('.vostok-list-pager .container').eq(0);
		if (!elem.hasClass('hide')) {
			var current = container.find(".page:visible").eq(0);
			var id = 0;
			if (elem.hasClass('left')) {
				var prev = current.prev('.page');
				if (prev) {
					current.hide();
					prev.show();
					id = prev.attr('rel');
					if (prev.prev('.page').length == 0) elem.addClass('hide');
					elem.next('.right').removeClass('hide');
				}
			}
			if (elem.hasClass('right')) {
				var next = current.next('.page');
				if (next) {
					current.hide();
					next.show();
					id = next.attr('rel');
					if (next.next('.page').length == 0) elem.addClass('hide');
					elem.prev('.left').removeClass('hide');
				}
			}
			container.find("div.pager > div").removeClass('active');
			container.find("div.pager > div[rel='" + id + "']").addClass('active');
		}
	});

	$("#content").on('click','.vostok-list-accordeon > div > .body > .block > .link > a', function (e) {
		e.preventDefault();
		var elem = $(this);
		var parent = elem.parent().parent();
		if (!parent.hasClass('active')) {
			$("#utilitiesBlock > .body > .block.active > .content").stop().slideToggle(200);
			$("#utilitiesBlock > .body > .block").removeClass('active');
			elem.parent().next().stop().slideToggle(300);
			parent.addClass('active');
		}
	});

	if($.ikSelect){
		$("select.ik-select").ikSelect({
			ddMaxHeight: 400,
			ddFullWidth: false,
			onShow: function(select){
				select.link.addClass('ik_select_link_opened');
			},
			onHide: function(select){
				select.link.removeClass('ik_select_link_opened');
			}
		});

		$("select.ik-select-minimal").ikSelect({
			ddMaxHeight: 400,
			ddFullWidth: false,
			equalWidths: false,
			autoWidth: false,
			onShow: function(select){
				select.link.addClass('ik_select_link_opened');
			},
			onHide: function(select){
				select.link.removeClass('ik_select_link_opened');
			}
		});

		$('input.ik-input-minimal').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass: 'iradio_minimal-blue',
			increaseArea: '100%'
		});
	}

	$$.resolution(function(e, resolution){
		/*if(resolution < 481) {
			 turnOffPrettyPhoto();
		}
		else {
			giveMePrettyPhoto();
		}*/
	})

	/*
	 * COUNTER
	 *
	 * */
	var mousedown_timer;
	var mousedown_count;

    initCounter();


	$('#content').on('click', 'div.count-adder span.count-plus', function(){
		var cont = $(this).closest('.count-adder');
		var elem = $(this),
			parent = elem.parent(),
			input = parent.find('input'),
			unit = parent.find('.unit');
		if(parent.data('blocked')) return false;
		input.val(parseInt(input.val())+1);
		unit.html(getUnit(input.val(),$(cont).attr('data-unit1'),$(cont).attr('data-unit2'),$(cont).attr('data-unit5')));
        if(parent.data('callback')) onCounterChange(input.val(), elem);
	});

	$('#content').on('focus', 'div.count-adder .value input', function(){
		$(this).parent().addClass('focus');
	});

	$('#content').on('blur', 'div.count-adder .value input', function(){
		$(this).parent().removeClass('focus');
	});

	$('#content').on('click', 'div.count-adder span.count-minus', function(){
		var cont = $(this).closest('.count-adder');
		var elem = $(this),
			parent = elem.parent(),
			input = parent.find('input'),
            unit = parent.find('.unit');
		if(parent.data('blocked')) return false;
		if(parseInt(input.val()) > 1) input.val(parseInt(input.val())-1);
		unit.html(getUnit(input.val(),$(cont).attr('data-unit1'),$(cont).attr('data-unit2'),$(cont).attr('data-unit5')));
        if(parent.data('callback')) onCounterChange(input.val(), elem);
	});

	$('#content').on('mousedown', 'div.count-adder span.count-plus', function(){
		var cont = $(this).closest('.count-adder');
		var elem = $(this),
			parent = elem.parent(),
			input = parent.find('input'),
			unit = parent.find('.unit');

		clearTimeout(mousedown_timer);
		clearInterval(mousedown_count);
		if(parent.data('blocked')) return false;
		mousedown_timer = setTimeout(function(){
			mousedown_count = setInterval(function(){
				input.val(parseInt(input.val())+1);
				unit.html(getUnit(input.val(),$(cont).attr('data-unit1'),$(cont).attr('data-unit2'),$(cont).attr('data-unit5')));
                if(parent.data('callback')) onCounterChange(input.val(), elem);
			}, 120)
		}, 300);

	});

	$('#content').on('mousedown', 'div.count-adder span.count-minus', function(){
		var cont = $(this).closest('.count-adder');
		var elem = $(this),
			parent = elem.parent(),
			input = parent.find('input'),
			unit = parent.find('.unit');
		if(parent.data('blocked')) return false;
		if(parseInt(input.val()) > 1){
			clearTimeout(mousedown_timer);
			clearInterval(mousedown_count);
			mousedown_timer = setTimeout(function(){
				mousedown_count = setInterval(function(){
					if(parseInt(input.val()) > 1) input.val(parseInt(input.val())-1);
					unit.html(getUnit(input.val(),$(cont).attr('data-unit1'),$(cont).attr('data-unit2'),$(cont).attr('data-unit5')));
                    if(parent.data('callback')) onCounterChange(input.val(), elem);
				}, 120)
			}, 300);
		}

	});

	$('#content').on('change', 'div.count-adder input', function(){
		var th = $(this);
		var cont = $(this).closest('.count-adder');
		var unit = $(this).next();
        var parent = $(this).closest('.count-adder');
		unit.html(getUnit(th.val(),$(cont).attr('data-unit1'),$(cont).attr('data-unit2'),$(cont).attr('data-unit5')));
        if(parent.data('callback')) onCounterChange($(this).val(), $(this));
	});

	$('#content').on('mouseup mouseout', 'div.count-adder span.count-plus', function(){
		clearTimeout(mousedown_timer);
		clearInterval(mousedown_count);
	});

	$('#content').on('mouseup mouseout', 'div.count-adder span.count-minus', function(){
		clearTimeout(mousedown_timer);
		clearInterval(mousedown_count);
	});

	$('div.pslider').each(function(i, item){
		item = $(item);
		var indexI = i;

		var slide = item.find('> div.slide'),
			cont = $(item).find('.container'),
			contw = 0,
			prev = slide.find('> a.prev'),
			next = slide.find('> a.next'),
			track = slide.find('> div.container > div.track'),
			display = item.find('> div.display'),
			preview = item.find('> div.display > a'),
			items = track.find('> a'),
			total = items.length,
			width = total * 70,
			offset = 0,
			hider = 0;

		//track.css({width: width});

		items.each(function(i, item){
			$(display).append("<a num='"+$(item).attr('num')+"' class='dn' rel='prettyphoto[prod]' href='"+$(item).attr('href')+"'><img alt='"+$(item).attr('data-title')+"' src='"+$(item).attr('data-preview')+"'></a>");
			giveMePrettyPhoto();
		});

		items.on('click', function(e){
			items.removeClass('active');
			display.find('a').addClass('dn');
			if($(this).prev().length == 0) {
				display.find('.dots').show();
			}
			else {
				display.find('.dots').hide();
			}
			display.find("a[num='"+$(this).attr('num')+"']").removeClass('dn');
			$(this).addClass('active');
			return false;
		}).eq(0).click();

		prev.on('click', function(){
			offset = ( track.css('margin-left') ? parseInt(track.css('margin-left')) : 0 );
			if(offset < 0) {
				if(offset > -70) {
					$(track).animate({'marginLeft' : 0});
					$(this).addClass('disabled');
				}
				else {
					offset = offset + 70;
					$(track).animate({'marginLeft' : offset },300);
				}
				$(this).next().removeClass('disabled');
			}
		});

		var prepareSlider = function() {
		}

		next.on('click', function(){

			offset = ( track.css('margin-left') ? parseInt(track.css('margin-left')) : 0 );
			hider =  width - contw - Math.abs(offset);
			if(hider > 0) {
				if(hider < 70) {
					$(track).animate({'marginLeft' : offset - hider});
					$(this).addClass('disabled');
				}
				else {
					offset = offset - 70;
					$(track).animate({'marginLeft' : offset },300);
				}
				$(this).prev().removeClass('disabled');
			}

		});

		$$.resize(function(e, resolution){
			contw = item[0].offsetWidth - 40;
			offset = ( track.css('margin-left') ? parseInt(track.css('margin-left')) : 0 );
			hider =  width - contw - Math.abs(offset);
			if ((width - contw) < 0) {
				$(item).find('.slide > a').addClass('disabled');
				$(track).animate({'marginLeft' : 0 },300);
			}
			else {
			   if(hider > 0) $(item).find('.slide > a.next').removeClass('disabled');
			   if(Math.abs(offset) > 0) $(item).find('.slide > a.prev').removeClass('disabled');
			}
		});

	});


});