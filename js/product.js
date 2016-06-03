function refreshDots() {
	if($("#product-pictures .product-pictures-small .display").length) {
		var contoffset = $("#product-pictures .product-pictures-small .display").offset();
		var imgoffset = $("#product-pictures .product-pictures-small .display .dots + a > img").offset();
	}
	else {
		var contoffset = $("#product-pictures .product-pictures-small").offset();
		var imgoffset = $("#product-pictures .product-pictures-small .dots + a > img").offset();
	}

	$.each($("#product-pictures .product-pictures-small .dots i"), function(index, item) {
		$(item).offset({
			'top': $(item).offset().top + (imgoffset.top - contoffset.top),
			'left': $(item).offset().left + (imgoffset.left - contoffset.left)
		}).addClass('show');
	});

}

$(function(){
	var production = $('#product-production');
	var likes = $('#product-links-likes');
	var charact = $('#production-charact-comments');
	var pictures = $("#product-pictures");
	var info = $("#product-info");
	var title = $("#product-info .product-view > header");

     /*
    $('#product-info div.catalog-ex-buttons a.email_catalog_s').on('click', function(e){
        e.preventDefault();
        $.prettyPhoto.open('<div>asdasdasdadsasdasd</div>','Title','Description');
    });    */


	$('#product-pictures .product-pictures-small .dots + a > img').load(function() {
		refreshDots();
	});

	$('body').on('click', '#product-item-container #product-production .technologies header', function(e){
		e.preventDefault();
		$(this).toggleClass('active');
		$(this).next().stop().slideToggle(300);
	});
	$('body').on('click', '#production-charact-comments > .block header', function(e){
		e.preventDefault();
		$(this).toggleClass('active');
		$(this).next().stop().slideToggle(300);
	});


    $('body').on('submit', '#pretty-block-form-email-pdf-kinetica form', function(e){
        e.preventDefault();
        var form = $(this);
        var callbacks = { };
        callbacks.beforeData = function(form){
            form.find('input.error').text('');
            Vostok.blockOverlay(form.closest('.pp_content'));

        };

        callbacks.afterSuccess = function(data, form){
            form.html('<div>Страница в .pdf отправлена вам на почту.</div>');
	        window['yaCounter'+idMetrika].reachGoal('sendtomail');
        };

        callbacks.afterData = function(form){
            Vostok.blockOverlay(form.closest('.pp_content'));
        };

       Vostok.uniFormSubmit(form, callbacks);

    })

	$$.resolution(function(e, resolution){
		if(resolution > 980) {

			$(info).prependTo('#product-item-container .inner-body');
			$(likes).appendTo('#product-info');
			$(pictures).insertAfter("#product-info");
			$(charact).insertAfter("#product-pictures");
			$(title).prependTo('#product-info .product-view');
			$(production).prependTo("#product-item-container .inner-body");
		}
		if(resolution <= 981) {
			$(likes).insertAfter('#product-pictures');
			$(charact).appendTo("#product-item-container .inner-body");
			$(production).insertBefore("#production-charact-comments");
			$(info).prependTo('#product-item-container .inner-body');
			$(pictures).insertAfter("#product-info");
			$(title).prependTo('#product-info .product-view');
		}
		if(resolution <= 601){
			$(pictures).appendTo("#product-item-container .inner-body");
			$(info).appendTo("#product-item-container .inner-body");
			$(likes).appendTo("#product-item-container .inner-body");
			$(production).appendTo("#product-item-container .inner-body");
			$(charact).appendTo("#product-item-container .inner-body");
			$(title).prependTo('#product-item-container .inner-body');
		}
	});

});