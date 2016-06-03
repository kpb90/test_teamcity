
var mcOptions = {maxZoom:10,
	gridSize:30,
	styles:[
		{
			height:53,
			url:"/images/layout/inworld_mix_marker_all.png",
			width:43,
			fontFamily:'Helvetica',
			textColor:'white',
			textSize:14,
			anchor:[13, 0],
			anchorIcon:[20, -40]
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

var getScrolls = function () {
	if (self.pageYOffset) {
		return {scrollTop:self.pageYOffset, scrollLeft:self.pageXOffset};
	} else if (document.documentElement && document.documentElement.scrollTop) { // Explorer 6 Strict
		return {scrollTop:document.documentElement.scrollTop, scrollLeft:document.documentElement.scrollLeft};
	} else if (document.body) {// all other Explorers
		return {scrollTop:document.body.scrollTop, scrollLeft:document.body.scrollLeft};
	}
}

var Vostok = {
	fixedEncodeURIComponent: function (str) {
		return encodeURIComponent(str).replace(/[!'()]/g, escape).replace(/\*/g, "%2A");
	},

	scrollTo:function (elem, speed, offset) {
		if (!speed) speed = 300;
		if (!offset) offset = 0;
		var offs = {}
		if (elem - 0 >= 0) {
			offs.top = elem;
		} else {
			offs = elem.offset();
		}

		if (offs) jQuery("html:not(:animated)" + ( !$.browser.opera ? ",body:not(:animated)" : "")).animate({ scrollTop:offs.top - 50 - offset}, speed);
	},

	blockOverlay:function (elem) {

		var overlay_elem = elem.find('> div.block-overlay');
		if (overlay_elem.length) {
			overlay_elem.remove();
		} else {
			var overlay = $('<div class="block-overlay"></div>');
			if($(elem).hasClass('catalog-list')) elem.append(overlay);
				else elem.prepend(overlay);
		}

	},
	uniFormSubmit:function (form, callbacks) {

		if (form.data('blocked')) return;
		if (callbacks.beforeData)  callbacks.beforeData(form);
		form.data('blocked', true);
		var ignoreDefaultLoading = form.data('ignoreDefaultLoading');
		var url = location.protocol + '//' + location.hostname + location.pathname;
		form.data('params', {url:url});
		form.ajaxSubmit({ dataType:'json', data:form.data('params'),
			beforeSend:function () {
				form.find('div.error').remove();
				form.find('.error').removeClass('error');
			},
			success:function (data) {

				form.data('blocked', false);

				if (data.error) {
					var first_error = '';
					$.each(data.error, function (key, value) {
						if (first_error == '') first_error = key;

						if (typeof  value == 'object') {
							$.each(value, function (index, value) {
								form.find('[name="' + key + '[]"]:eq(' + index + ')').addClass('error').closest('dd').append('<div class="error">' + value + '</div>').closest('dl').addClass('error');
							});
						} else {
							form.find('[name^=' + key + ']').addClass('error').closest('dd').append('<div class="error">' + value + '</div>').closest('dl').addClass('error');
						}

					});


					if (callbacks.afterData)  callbacks.afterData(form, data);

				} else if (data.success) {
					if (callbacks.afterData)  callbacks.afterData(form, data);
					if (callbacks.afterSuccess)  callbacks.afterSuccess(data, form);
				}


			}
		});

		return false;
	},
	prettyModal:function (content) {
		var id = 'pretty-block-form-alert' + (new Date().getTime());
		var button = $('<a href="#' + id + '" rel="prettyForm" class="dn"></a>');
		var body = $('<div id="' + id + '" class="dn"><div class="popup-pretty-container user-content popup-form">' + content + '</div></div>');
		$('body').append(button).append(body);
		initPrettyForm();

		button.trigger('click');

	},
	isElementScrolledIntoView:function (elem, offset) {
		if (!offset) offset = 0;
		var docViewTop = $(window).scrollTop();
		var docViewBottom = docViewTop + $(window).height();

		var elemTop = $(elem).offset().top;
		var elemBottom = elemTop + $(elem).height();

		return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop + offset));
	},
	notice:function (elem, options) {
		//if(!elem) elem = $('body');
		if (!options.pos) options.pos = 'bottom';
		if (!options.top) options.top = 0;
		if (!options.left) options.left = 0;


		var left = 0;
		var top = 0;
		var css = {};
		var notify = $('<div class="popup-notice">' + options.text + '<i class="close"></i></div>');
		if (elem) {
			if (elem.data('notify')) elem.data('notify').remove();
			var offs = elem.offset();
			left = offs.left + options.left;
			top = offs.top + elem.height() + options.top;
			css = { 'top':top, 'left':left };
			notify.css(css).appendTo('body');
			elem.data('notify', notify);
		} else {
			$('div.popup-notice').fadeOut(200, function () {$(this).remove()});
			css = { 'bottom':20, 'right':20, 'position':'fixed'}
		}
		notify.css(css).appendTo('body');
		$('i.close', notify).bind('click', function () { notify.remove(); });

		return notify;

	},

}

/*  Подсвечивание слова на странице */

function $_GET(key) {
		var s = window.location.search;
		s = s.match(new RegExp(key + '=([^&=]+)'));
		return s ? s[1] : false;
	}

$.fn.highlight = function (b, k) {
	function l() {
		$("." + c.className).each(function (c, e) {
			var a = e.previousSibling,
				d = e.nextSibling,
				b = $(e),
				f = "";
			a && 3 == a.nodeType && (f += a.data, a.parentNode.removeChild(a));
			e.firstChild && (f += e.firstChild.data);
			d && 3 == d.nodeType && (f += d.data, d.parentNode.removeChild(d));
			b.replaceWith(f)
		})
	}

	function h(b) {
		if($(b).closest('#catalog-menu').length > 0 || $(b).closest('.breadcrumbs').length > 0) return false;
		b = b.childNodes;
		for (var e = b.length, a; a = b[--e];)
			if (3 == a.nodeType) {

				if (!/^\s+$/.test(a.data)) {
					var d = a.data,
						d = d.replace(m, '<mark class="' + c.className + '">$1</mark>');
					$(a).replaceWith(d)
				}
			} else 1 == a.nodeType && a.childNodes && (!/(script|style)/i.test(a.tagName) && a.className != c.className) && h(a)
	}
	var c = {
		split: "\\s+",
		className: "highlight",
		caseSensitive: !1,
		strictly: !1,
		remove: !0
	}, c = $.extend(c, k);
	c.remove && l();
	b = $.trim(b);
	var g = c.strictly ? "" : "\\S*",
		m = RegExp("(" + g + b.replace(RegExp(c.split, "g"), g + "|" + g) + g + ")", (c.caseSensitive ? "" : "i") + "g");
	return this.each(function () {
		b && h(this)
	})
};


/**
 * Добавление в корзину
 */

var Cart = {

	openOptions:function (elem, id, select, cart) {
		var container = elem.closest('article')
			;

		if (elem.data('blocked') || Cart.blocked) return false;
		if (!select) {
			$('div.cart-action > i.add-cart').removeClass('opened');
			$('div.cart-action > div.add-product-form').removeClass('opened');
			$('.add-product-form.to-cart-params .error').remove();
		}

		if (Cart.request) {
			Cart.request.abort();
			elem.data('blocked', false);
		}


		elem.addClass('opened');

		if (select) {
			var selectId = elem.find('[selected="selected"]').attr('value');
			Vostok.blockOverlay(container.find('.color-' + selectId));
		}

		if (container.find('.add-product-form.color-' + id).length) {
			var options = container.find('.add-product-form.color-' + id);
			options.addClass('opened');

			if (!Vostok.isElementScrolledIntoView(options)) Vostok.scrollTo(options);

			if (select) {
				Vostok.blockOverlay(container.find('.color-' + selectId));
				elem.ikSelect("select", elem.find('[selected="selected"]').attr('value'));
				container.find('.add-product-form.color-' + selectId).removeClass('opened');
			}

			if (options.find('.count-minus').offset().left < -10) options.addClass('left');

		} else {
			elem.data('blocked', true);

			Cart.request = $.ajax({ url:'/cart/?addOptions', data:{ product_id:id }, dataType:'json', type:'post',
				success:function (data) {
					elem.data('blocked', false);
					var options = $(data.html);
					options.addClass('opened to-cart-params color-' + id);
					container.find('.cart-action').append(options);
					options.find('select').ikSelect({
						autoWidth:false,
						ddMaxHeight:200,
						ddFullWidth:false,
						onShow:function (select) {
							select.link.addClass('ik_select_link_opened');
						},
						onHide:function (select) {
							select.link.removeClass('ik_select_link_opened');
						}
					});

					if (!$('#pretty-block-sizes').length) options.find('.external-helper-page-link').hide();
					if (!Vostok.isElementScrolledIntoView(options)) Vostok.scrollTo(options);
					giveMePrettyPhoto();

					if (select) {
						Vostok.blockOverlay(container.find('.color-' + selectId));
						elem.ikSelect("select", elem.find('[selected="selected"]').attr('value'));
						container.find('.add-product-form.color-' + selectId).removeClass('opened');
					}

					if (cart) {
						options.find('form').append('<input name="cart" type="hidden" value="1">');
					}

					if (options.find('.count-minus').offset().left < -10) options.addClass('left');

				},
				abort:function () {
					elem.data('blocked', false);
				},
				error:function () {
					elem.data('blocked', false);
				}

			});
		}
	},

	blocked:false,
	render:function (data) {
		$('#content .order-block.cart').html(data.html);
		initCounter();

	}



}

function highlightTextOnPage(text,block) {
	var settings = {};
	settings.strictly = true;
	settings.caseSensitive = false;
	settings.className = "search_highlight";
	settings.remove = true;
	$(block).highlight(decodeURIComponent(text), settings)
}


$(function () {

	var highlight_text = $_GET('highlight');
	if(highlight_text) {
		highlightTextOnPage(highlight_text,"#content");
	}

	$('body').on('click', 'div.cart-action > i.add-compare', function () {
		$('div.cart-action > i.add-compare').removeClass('opened');
		$(this).addClass('opened').parent().find('div.compare').slideDown(100);
	});

	$('body').on('mouseleave', 'div.cart-action', function () {
		var $bl = $(this);
		setTimeout(function () {
			if (!$bl.is(':hover')) $bl.find('> i.add-compare').removeClass('opened').end().find('div.compare').slideUp(200);
		}, 600);

	});

	$('body').on('click', 'div.cart-action > div.compare', function () {
		$(this).parent().trigger('mouseleave');
	});

	//Список комментариев
	$('body').on('click', '.comments-list .more-comments', function (e) {
		var elem = $(this),
			list = elem.closest('.comments-list')
			;
		if (elem.data('blocked')) return false;
		elem.data('blocked', true);
		Vostok.blockOverlay(list);
		$.ajax({ url:'?moreComments', data:{page:list.data('page')}, type:'post', dataType:'json',
			success:function (data) {
				list.find('.list').append(data.html);
				list.data('all-count', data.all_count).data('page', data.page).data('on-page', data.comments_added + list.data('on-page'));
				var commentsDelta = list.data('all-count') - list.data('on-page');
				if (data.last_page) list.find('.more-comments').remove();
				if (!data.last_page && commentsDelta < 5) {
					var units = list.data('unit').split(',');
					list.find('.more-comments span:eq(0)').text(commentsDelta + " " + getUnit(commentsDelta, units[0], units[1], units[2]));
				}
				elem.data('blocked', false);
				Vostok.blockOverlay(list);

			}

		});
	});


	/**
	 * Формы обратной связи
	 */

		//Файл инпут
	$('body').on('change', '.pretty-file-input input', function () {
		var elem = $(this),
			parent = elem.closest('.pretty-file-input')
			;
		parent.parent().find('input[type=text]').attr('value', elem.val());
	});

	$('body').on('focus change', 'div.form input, div.form textarea', function () {
		var parent = $(this).closest('dl');
		parent.removeClass('.error').find('div.error').remove().end().find('input.error, textarea.error').removeClass('error');
	});


	//Копирование поля
	$('body').on('click', 'div.form i.copy', function (e) {
		var elem = $(this),
			parent = elem.parent(),
			input = parent.find('input:eq(0)'),
			copies = elem.data('copies')
			;
		if (!elem.hasClass('section-copy')) {
			var wrap = $('<dl><dt>' + input.data('title') + '<i class="remove-copy" title="Удалить"></i></dt><dd></dd></dl>');
			var newElem = input.clone().val("").removeClass('error');
			wrap.find('dd').append(newElem).end().insertBefore(elem);
			if (parent.find('dl').length > 4) {
				elem.hide();
			}
		} else {
			var elems = elem.closest('div').find('div:eq(0)').clone();

			elems.removeClass('error').find('input').removeClass('error').end().find('div.error').remove();


			elems.insertBefore(elem);
			elems.find('dt:eq(0)').append('<i class="remove-copy" title="Удалить"></i>');
			elems.find('input').val('');
			elem.data('created-copies', parseInt(elem.data('created-copies')) + 1);

			if (elems.find('select').length) {
				elems.find('select').appendTo(elems.find('select').closest('dd')).removeAttr('style');
				elems.find('.ik_select').remove();
				elems.find('select').addClass('ik-select').ikSelect({
					autoWidth:false,
					ddMaxHeight:200,
					customClass:'ik-form-select',
					ddCustomClass:'ik-form-select',
					ddFullWidth:false,
					onShow:function (select) {
						select.link.addClass('ik_select_link_opened');
					},
					onHide:function (select) {
						select.link.removeClass('ik_select_link_opened');
					}
				});
			}

			if (elem.data('created-copies') >= copies) {
				elem.hide();
			}
		}


	});

	$('body').on('click', 'div.form .remove-copy', function () {
		var section = $(this).closest('div.section');
		var copy = section.find('i.copy');


		if (section.length && copy.hasClass('section-copy')) {
			$(this).closest('div').remove();
			copy.show();
		} else {

			if ($(this).closest('div').find('dl').length < 6) {
				$(this).closest('div').find('.copy').show();
			}

			$(this).closest('dl').remove();
		}

		copy.data('created-copies', copy.data('created-copies') - 1);


	});

	//Написать письмо
	$('body').on('submit', '#writeLetter', function (e) {
		e.preventDefault();
		var form = $(this);
		var callbacks = { };
		callbacks.beforeData = function (form) {
			form.find('input.error').text('');
			Vostok.blockOverlay(form.closest('.pp_content'));

		};

		callbacks.afterSuccess = function (data, form) {
			form.closest('.popup-pretty-container').html('<div>' + data.message + '</div>');
			window['yaCounter' + idMetrika].reachGoal('wletter');
		};

		callbacks.afterData = function (form, data) {
			if (data.error) {
				if (!Vostok.isElementScrolledIntoView(form.find('dl.error:eq(0)'))) { Vostok.scrollTo(form.find('dl.error:eq(0)'), 300, 100); }
			}
			Vostok.blockOverlay(form.closest('.pp_content'));
		};

		Vostok.uniFormSubmit(form, callbacks);

	});

	//Заказать звонок
	$('body').on('submit', '#requestCall', function (e) {
		e.preventDefault();
		var form = $(this);
		var callbacks = { };
		callbacks.beforeData = function (form) {
			form.find('input.error').text('');
			Vostok.blockOverlay(form.closest('.pp_content'));

		};

		callbacks.afterSuccess = function (data, form) {
			form.closest('.popup-pretty-container').html('<div>Ваша заявка отправлена.</div>');
			window['yaCounter' + idMetrika].reachGoal('reqcall');
		};

		callbacks.afterData = function (form, data) {
			if (data.error) {
				if (!Vostok.isElementScrolledIntoView(form.find('dl.error:eq(0)'))) { Vostok.scrollTo(form.find('dl.error:eq(0)'), 300, 100); }
			}
			Vostok.blockOverlay(form.closest('.pp_content'));
		};

		Vostok.uniFormSubmit(form, callbacks);

	});


	//Заказать каталог
	$('body').on('submit', '#orderCatalog', function (e) {
		e.preventDefault();
		var form = $(this);
		var callbacks = { };
		callbacks.beforeData = function (form) {
			form.find('input.error').text('');
			Vostok.blockOverlay(form.closest('.pp_content'));

		};

		callbacks.afterSuccess = function (data, form) {
			var container = form.closest('.popup-pretty-container');
			container.html('<div>Ваша заявка отправлена.</div>');
			if (!Vostok.isElementScrolledIntoView(container)) { Vostok.scrollTo(container, 300, 100); }
			window['yaCounter' + idMetrika].reachGoal('reqcat');
		};

		callbacks.afterData = function (form, data) {
			Vostok.blockOverlay(form.closest('.pp_content'));
			if (data.error) {
				if (!Vostok.isElementScrolledIntoView(form.find('dl.error:eq(0)'))) { Vostok.scrollTo(form.find('dl.error:eq(0)'), 300, 100); }
			}

		};

		Vostok.uniFormSubmit(form, callbacks);

	});

	$('body').on('change', '#orderCatalog select[name=company_type]', function (e) {
		if ($(this).val() == 12) {
			$(this).closest('div.form').find('dl.company-type').show().addClass('visible');
		} else {
			$(this).closest('div.form').find('dl.company-type').hide().removeClass('visible');
		}
	});

	$('body').on('ifToggled', '#orderCatalog input[name^="survey"]', function (e) {
		if ($(this).val() == 10) {
			if ($(this).prop('checked')) {
				$(this).closest('div.form').find('dl.survey-text').show();
			} else {
				$(this).closest('div.form').find('dl.survey-text').hide();
			}
		}
	});


	//Комментарий к товару
	$('body').on('submit', '#productComment', function (e) {
		e.preventDefault();
		var form = $(this);
		var callbacks = { };
		callbacks.beforeData = function (form) {
			form.find('input.error').text('');
			Vostok.blockOverlay(form.closest('.pp_content'));

		};

		callbacks.afterSuccess = function (data, form) {
			var container = form.closest('.popup-pretty-container');

			if (!data.auth) {
				container.html('<div>Ваш отзыв будет размещен после премодерации.</div>');
				if (!Vostok.isElementScrolledIntoView(container)) { Vostok.scrollTo(container, 300, 100); }
			} else {
				var units = $('.comments-list').data('unit').split(',');
				container.closest('.pp_content_container').find('.pp_close').click();
				$('.comments-list .list').prepend(data.html);
				$('.comments-list .top-inline-block.count-comments .label').text(data.count);
				$('.comments-list .top-inline-block.count-comments .notice').text(getUnit(data.count, units[0], units[1], units[2]));
				$('.comments-list .more-comments span:eq(1)').text(data.count);
				if ($('.comments-list .comment-item').length > 5) $('.comments-list .comment-item:last').remove();

			}
			window['yaCounter' + idMetrika].reachGoal('review');

		};

		callbacks.afterData = function (form, data) {
			Vostok.blockOverlay(form.closest('.pp_content'));
			if (data.error) {
				if (!Vostok.isElementScrolledIntoView(form.find('dl.error:eq(0)'))) { Vostok.scrollTo(form.find('dl.error:eq(0)'), 300, 100); }
			}

		};

		Vostok.uniFormSubmit(form, callbacks);

	});


	//Звёздная оценка
	$('body').on('mouseover', '.rating-stars.add i', function () {
		var cur = $(this).attr('title') * 13,
			elem = $(this),
			container = elem.closest('.rating-stars'),
			actionElem = container.find('.cur_rating-stars')
			;
		actionElem.attr('rel', actionElem.css('width'));
		actionElem.css('width', cur);
	});

	$('body').on('mouseout', '.rating-stars.add i', function () {
		var cur = $(this).attr('title') * 13,
			elem = $(this),
			container = elem.closest('.rating-stars'),
			actionElem = container.find('.cur_rating-stars')
			;
		actionElem.css('width', actionElem.attr('rel'));
	});

	$('body').on('click', '.rating-stars.add i', function () {
		var cur = $(this).attr('title') * 13;
		var form = $(this).closest('div.form');

		var elem = $(this),
			container = elem.closest('.rating-stars'),
			actionElem = container.find('.cur_rating-stars')
			;
		form.find('input[name=mark]').val($(this).attr('title'));
		actionElem.attr('rel', cur);
	});


	//Написать письмо раздел производство
	$('body').on('submit', '#writeLetterProduction', function (e) {
		e.preventDefault();
		var form = $(this);
		var callbacks = { };
		callbacks.beforeData = function (form) {
			form.find('input.error').text('');
			Vostok.blockOverlay(form.closest('.pp_content'));

		};

		callbacks.afterSuccess = function (data, form) {
			form.closest('.popup-pretty-container').html('<div>' + data.message + '</div>');
		};

		callbacks.afterData = function (form, data) {
			if (data.error) {
				if (!Vostok.isElementScrolledIntoView(form.find('dl.error:eq(0)'))) { Vostok.scrollTo(form.find('dl.error:eq(0)'), 300, 100); }
			}
			Vostok.blockOverlay(form.closest('.pp_content'));
		};

		Vostok.uniFormSubmit(form, callbacks);

	});

	//Отправить резюме
	$('body').on('submit', '#sendResume', function (e) {
		e.preventDefault();
		var form = $(this);
		var callbacks = { };
		callbacks.beforeData = function (form) {
			form.find('input.error').text('');
			Vostok.blockOverlay(form.closest('.pp_content'));

		};

		callbacks.afterSuccess = function (data, form) {
			form.closest('.popup-pretty-container').html('<div>Ваше резюме отправлено.</div>');
			window['yaCounter' + idMetrika].reachGoal('resume');
		};

		callbacks.afterData = function (form, data) {
			Vostok.blockOverlay(form.closest('.pp_content'));
			if (data.error) {
				if (!Vostok.isElementScrolledIntoView(form.find('dl.error:eq(0)'))) { Vostok.scrollTo(form.find('dl.error:eq(0)'), 300, 100); }
			}

		};

		Vostok.uniFormSubmit(form, callbacks);

	});


	$('#vacancy-body').on('click.user', 'a.button_mail', function (e) {
		e.preventDefault();
		$('#sendResume select[name=vacancy_id] > option[selected=selected]').removeAttr('selected');
		$('#sendResume select[name=vacancy_id] > option[value="' + $(this).data('id') + '"]').attr('selected', 'selected');
		$('#sendResume dl.vacancy-select').show();
		$('#sendResume dl.vacancy').hide();
		$('#sendResume input[name=other_vacancy]').val(0);
	});


	$('#vacancy-body').on('click.user', 'a.button_send', function (e) {
		e.preventDefault();
		$('#sendResume select[name=vacancy_id] > option[selected=selected]').removeAttr('selected');
		$('#sendResume dl.vacancy').show();
		$('#sendResume dl.vacancy-select').hide();
		$('#sendResume input[name=other_vacancy]').val(1);
	});


	//Заполнить анкету
	$('body').on('submit', '#fillQuestionnaire', function (e) {
		e.preventDefault();
		var form = $(this);
		var callbacks = { };
		callbacks.beforeData = function (form) {
			form.find('input.error').text('');
			Vostok.blockOverlay(form.closest('.pp_content'));

		};

		callbacks.afterSuccess = function (data, form) {
			var container = form.closest('.popup-pretty-container');
			container.html('<div>Ваша анкета отправлена.</div>');
			if (!Vostok.isElementScrolledIntoView(container)) { Vostok.scrollTo(container, 300, 100); }
			window['yaCounter' + idMetrika].reachGoal('worksheet');
		};

		callbacks.afterData = function (form, data) {
			Vostok.blockOverlay(form.closest('.pp_content'));
			if (data.error) {
				if (!Vostok.isElementScrolledIntoView(form.find('dl.error:eq(0)'))) { Vostok.scrollTo(form.find('dl.error:eq(0)'), 300, 100); }
			}

		};

		Vostok.uniFormSubmit(form, callbacks);

	});


	$('#vacancy-body').on('click.user', 'a.button_anketa', function (e) {
		e.preventDefault();
		$('#fillQuestionnaire select[name=vacancy_id] > option[selected=selected]').removeAttr('selected');
		$('#fillQuestionnaire select[name=vacancy_id] > option[value="' + $(this).data('id') + '"]').attr('selected', 'selected');
		$('#fillQuestionnaire dl.vacancy-select').show();
		$('#fillQuestionnaire dl.vacancy').hide();
		$('#fillQuestionnaire input[name=other_vacancy]').val(0);
	});


	$('#vacancy-body').on('click.user', 'a.button_questionnaire', function (e) {
		e.preventDefault();
		$('#fillQuestionnaire select[name=vacancy_id] > option[selected=selected]').removeAttr('selected');
		$('#fillQuestionnaire dl.vacancy').show();
		$('#fillQuestionnaire dl.vacancy-select').hide();
		$('#fillQuestionnaire input[name=other_vacancy]').val(1);
	});


	//Оставить заявку – раздел Услуги
	$('body').on('submit', '#sendRequestServices', function (e) {
		e.preventDefault();
		var form = $(this);
		var callbacks = { };
		callbacks.beforeData = function (form) {
			form.find('input.error').text('');
			Vostok.blockOverlay(form.closest('.pp_content'));

		};

		callbacks.afterSuccess = function (data, form) {
			var container = form.closest('.popup-pretty-container');
			container.html('<div>Ваша заявка отправлена.</div>');
			if (!Vostok.isElementScrolledIntoView(container)) { Vostok.scrollTo(container, 300, 100); }
			window['yaCounter' + idMetrika].reachGoal('reqorder');
		};

		callbacks.afterData = function (form, data) {
			Vostok.blockOverlay(form.closest('.pp_content'));
			if (data.error) {
				if (!Vostok.isElementScrolledIntoView(form.find('dl.error:eq(0)'))) { Vostok.scrollTo(form.find('dl.error:eq(0)'), 300, 100); }
			}

		};

		Vostok.uniFormSubmit(form, callbacks);

	});


	//Комментарий к акции/новости
	$('body').on('submit', '#actionComment', function (e) {
		e.preventDefault();
		var form = $(this);
		var callbacks = { };
		callbacks.beforeData = function (form) {
			form.find('input.error').text('');
			Vostok.blockOverlay(form.closest('.pp_content'));

		};

		callbacks.afterSuccess = function (data, form) {
			var container = form.closest('.popup-pretty-container');

			if (!data.auth) {
				container.html('<div>Ваш комментарий будет размещен после премодерации.</div>');
				if (!Vostok.isElementScrolledIntoView(container)) { Vostok.scrollTo(container, 300, 100); }
			} else {
				var units = $('.comments-list').data('unit').split(',');
				container.closest('.pp_content_container').find('.pp_close').click();
				$('.comments-list .list').prepend(data.html);
				$('.comments-list .top-inline-block.count-comments .label').text(data.count);
				$('.comments-list .top-inline-block.count-comments .notice').text(getUnit(data.count, units[0], units[1], units[2]));
				$('.comments-list .more-comments span:eq(1)').text(data.count);
				if ($('.comments-list .comment-item').length > 5) $('.comments-list .comment-item:last').remove();
			}

		};

		callbacks.afterData = function (form, data) {
			Vostok.blockOverlay(form.closest('.pp_content'));
			if (data.error) {
				if (!Vostok.isElementScrolledIntoView(form.find('dl.error:eq(0)'))) { Vostok.scrollTo(form.find('dl.error:eq(0)'), 300, 100); }
			}

		};

		Vostok.uniFormSubmit(form, callbacks);

	});


	$('#content').on('click.user', '.catalog-list article div.options a.notice', function (e) {
		e.preventDefault();
		var container = $(this).closest('article'),
			title = container.find('h2').text(),
			id = container.data('id');
		$('#pretty-block-form-ask-price h3 span').html(title);
		$('#pretty-block-form-ask-price input[name=product_id]').val(id);
	});

	$('#content').on('click.user', '.preorder-product', function (e) {
		e.preventDefault();
		if ($(this).closest('article').length) {
			var container = $(this).closest('article'),
				title = container.find('h2').text(),
				id = container.data('id');
		} else {
			var container = $(this).closest('.product-view'),
				title = container.find('h1').text(),
				id = container.data('id');
		}

		$('#pretty-block-form-preorder-product h3 span').html(title);
		$('#pretty-block-form-preorder-product input[name=product_id]').val(id);
	});

	$('#content').on('click.user', '#product-item-container #product-info > .product-view .no-price', function (e) {
		e.preventDefault();
		var container = $(this).closest('.product-view');
		var title = container.find('header h1').text();
		var id = container.data('id');

		$('#pretty-block-form-ask-price h3 span').html(title);
		$('#pretty-block-form-ask-price input[name=product_id]').val(id);
	});


	//Узнать цену
	$('body').on('submit', '#askPrice', function (e) {
		e.preventDefault();
		var form = $(this);
		var callbacks = { };
		callbacks.beforeData = function (form) {
			Vostok.blockOverlay(form.closest('.pp_content'));
		};

		callbacks.afterSuccess = function (data, form) {
			var container = form.closest('.popup-pretty-container');
			container.html('<div>Ваш запрос отправлен</div>');
			if (!Vostok.isElementScrolledIntoView(container)) { Vostok.scrollTo(container, 300, 100); }

		};

		callbacks.afterData = function (form, data) {
			Vostok.blockOverlay(form.closest('.pp_content'));
			if (data.error) {
				if (!Vostok.isElementScrolledIntoView(form.find('dl.error:eq(0)'))) { Vostok.scrollTo(form.find('dl.error:eq(0)'), 300, 100); }
			}

		};

		Vostok.uniFormSubmit(form, callbacks);

	});

	//Узнать цену
	$('body').on('submit', '#preorderProduct', function (e) {
		e.preventDefault();
		var form = $(this);
		var callbacks = { };
		callbacks.beforeData = function (form) {
			Vostok.blockOverlay(form.closest('.pp_content'));
		};

		callbacks.afterSuccess = function (data, form) {
			var container = form.closest('.popup-pretty-container');
			container.html('<div>Ваш заявка на предзаказ отправлена</div>');
			if (!Vostok.isElementScrolledIntoView(container)) { Vostok.scrollTo(container, 300, 100); }

		};

		callbacks.afterData = function (form, data) {
			Vostok.blockOverlay(form.closest('.pp_content'));
			if (data.error) {
				if (!Vostok.isElementScrolledIntoView(form.find('dl.error:eq(0)'))) { Vostok.scrollTo(form.find('dl.error:eq(0)'), 300, 100); }
			}

		};

		Vostok.uniFormSubmit(form, callbacks);

	});


	//Добавить в избранное
	$('body').on('click', '.add-to-favorites', function (e) {
		e.preventDefault();
		//e.stopPropagation();
		//alert(1)
		var link = $(this);
		if (link.hasClass('add')) var action = 'add';
		else var action = 'delete';
		if (!link.hasClass('active')) return false;
		link.removeClass('active');
		var favAj = $.ajax('/api/favorites/', {
			type:'post',
			dataType:'json',
			data:{ act:action, uid:link.attr('rel') }
		})
			.success(function (response) {
				if (response.success) {
					if (action == 'add') {
						link.addClass('delete');
						link.removeClass('add');
					}
					else {
						link.removeClass('delete');
						link.addClass('add');
					}
					link.attr('rel', response.uid);
					var content = link.attr('rel2');
					link.attr('rel2', link.html()).html(content);
					window['yaCounter' + idMetrika].reachGoal('favorites');
				}

			})
			.error(function () {
				alert('Произошла системная ошибка. Повторите ещё раз.');
			})
			.complete(function () {
				link.addClass('active');
			});

	});

	//Добавить в избранное из списка
	$('body').on('click', '.catalog-list article > .preview-wrap .to-favorite', function (e) {
		e.preventDefault();
		var elem = $(this),
			action = elem.hasClass('remove') ? 'delete' : 'add',
			id = elem.closest('article').data('id'),
			container = elem.closest('article')
			;
		if (elem.data('blocked')) return false;
		if (action == 'delete') { delete catalogList.favoriteItems[id]; } else { catalogList.favoriteItems[id] = 2 }
		elem.toggleClass('remove');
		elem.data('blocked', true);

		if (container.closest('.catalog-list.favorite').length) {
			container.fadeOut(400, function () {$(this).remove()});
			listSeparatorCounter();
		}
		$.ajax({ url:'/api/favorites/?list', type:'post', dataType:'json', dataType:'json', data:{ act:action, uid:id },
			success:function (data) {
				elem.data('blocked', false);
			}
		});
	});

	//добавить к сравнению
	$('body').on('click', '.compare-product', function (e) {
		e.preventDefault();
		var $link = $(this);
		if ($link.hasClass('added')) {
			location.href = $link.attr('href');
			return false;
		}
		var $article = $(this).closest('article');
		var id = $link.attr('rel');
		var compare_count = $("#compare-slide-button > a > i");
		var favAj = $.ajax('/api/compare/', {
			type:'post',
			dataType:'json',
			data:{ uid:id }
		})
			.success(function (response) {
				if (response.success) {
					$link.addClass('added');
					$('#compare-slide-block').show();
					if ($(compare_count).length > 0) {
						$(compare_count).html(parseInt(compare_count.html()) + 1);
					}
					else {
						$("#compare-slide-button > a").append(" (<i>1</i>)");
					}
					//$link.find('b:last-child > span').append(" ("+response.count+")");
					window['yaCounter' + idMetrika].reachGoal('compare');
				}
				else {
					alert(response.error);
				}

			})
			.error(function () {
				alert('Произошла системная ошибка. Повторите ещё раз.');
			})
			.complete(function () {
			});
	});

	//Уведомить о поступлении
	$('body').on('click', '.subscribe-product-in-stock', function (e) {
		e.preventDefault();
		var $article = $(this).closest('article');
		if ($article.length > 0) {
			$("#subscribeProductFormH3").html("Уведомить о поступлении (" + $article.find('h2 > a').eq(0).html() + ")");
		}
		else {
			var $article = $(this).closest('#product-info').find('.product-view').eq(0);
			$("#subscribeProductFormH3").html("Уведомить о поступлении (" + $article.find('h1').eq(0).html() + ")");
		}

		var id = $article.attr('data-id');

		var inp = $("#subscribeProductForm").find("#unique-subscribe-product-id");
		if (inp.length > 0) {
			inp.val(id);
		}
		else $("#subscribeProductForm").prepend($("<input id='unique-subscribe-product-id'  type='hidden' value='" + id + "' name='product_id'>"));

	});

	$('body').on('submit', '#subscribeProductForm', function (e) {
		e.preventDefault();
		var form = $(this);
		var callbacks = { };
		callbacks.beforeData = function (form) {
			Vostok.blockOverlay(form.closest('.pp_content'));
		};

		callbacks.afterSuccess = function (data, form) {
			var container = form.closest('.popup-pretty-container');
			container.html('<div>Вы успешно подписаны на уведомление</div>');
			if (!Vostok.isElementScrolledIntoView(container)) { Vostok.scrollTo(container, 300, 100); }

		};

		callbacks.afterData = function (form, data) {
			Vostok.blockOverlay(form.closest('.pp_content'));
			if (data.error) {
				if (!Vostok.isElementScrolledIntoView(form.find('dl.error:eq(0)'))) { Vostok.scrollTo(form.find('dl.error:eq(0)'), 300, 100); }
			}

		};

		Vostok.uniFormSubmit(form, callbacks);

	});

	$('body').on('click', '.show-me-regions-please', function (e) {
		e.preventDefault();
		e.stopPropagation();
		$('#choose-region > a').click();
	});

	$('body').on('click', '#product-inner-help-for-price .ask-manager-please', function (e) {
		form = $($(this).attr('href')).find('form');
		if (form.find('.special-inp').length == 0) form.prepend("<input type='hidden' class='special-inp' name='special' value='1'>");
	});

	//Опции
	$('body').on('click', '.catalog-list article .options .cart-action .add-cart', function () {
		Cart.openOptions($(this), $(this).closest('article').data('id'));
	});

	//Закрытие опций
	$('body').on('click', function (e) {
		var target = $(e.target);
		if (!target.closest('.add-product-form').length && !target.hasClass('add-cart') && !Cart.blocked) {
			//$('.add-product-form.opened.to-cart-params input[name=count]').val(1);
			//$('.add-product-form.opened.to-cart-params select[name=size]').ikSelect('select', '');
			//$('.add-product-form').removeClass('opened');

			//$('.add-cart').removeClass('opened');
			//$('.add-product-form.to-cart-params .error').remove();
			if (Cart.request) {
				Cart.request.abort();
			}
		}
	});


	//Смена цвета
	$('body').on('change', '.add-product-form select[name=product_id]', function () {
		var elem = $(this),
			container = elem.closest('.add-product-form')
			;
		if (container.hasClass('to-cart-params')) {
			if (container.find('input[name=cart]').length) {
				Cart.openOptions(elem, elem.val(), true, true);
			} else {
				Cart.openOptions(elem, elem.val(), true);
			}

		} else {
			location.href = '/catalog/product/' + elem.val() + '/';
		}
	});

	//Добавить в корзину
	$('body').on('submit', '.add-product-form form', function (e) {
		e.preventDefault();
		e.preventDefault();
		var form = $(this);
		var callbacks = { };
		callbacks.beforeData = function (form) {
			Cart.blocked = true;
			Vostok.blockOverlay(form.closest('.add-product-form'));

			if (form.find('input[name=cart]').length) {
				Vostok.blockOverlay($('#content .order-block'));
			}


		};

		callbacks.afterSuccess = function (data, form) {
			$('body').click();
			form.find('select[name=size]').ikSelect('select', "");
			if (data.product_id == form.closest('article').data('id')) {
				form.closest('article').find('.add-cart').addClass('active');
			}

			if (!form.find('input[name=cart]').length) {
				var left = 0;
				var top = 10;
				var obj = {};
				if (!form.closest('.product-view').length) {
					obj = form.closest('article').find('.options')
				} else {
					obj = form.closest('.product-view');
					top = 30;
				}
				var notice = Vostok.notice(obj, {text:'Товар добавлен <br>в <a href="/cart/">корзину</a>', top:top, left:left});
				setTimeout(function () {
					notice.fadeOut(300, function () { $(this).remove() })
				}, 3555);
			}


			if (!catalogList.cartItems) catalogList.cartItems = [];
			catalogList.cartItems.push(data.product_id);
			$('#header .header-cart a > span').text(data.count);
			if (form.find('input[name=cart]').length) {
				Cart.render(data);
			}
			window['yaCounter' + idMetrika].reachGoal('addcart');
		};

		callbacks.afterData = function (form, data) {
			Cart.blocked = false;
			Vostok.blockOverlay(form.closest('.add-product-form'));
			if (form.find('input[name=cart]').length) {
				Vostok.blockOverlay($('#content .order-block'));
			}

			if (data.error) {
				var html = '';
				$.each(data.error, function (key, value) {
					if (html) html += '<br>';
					html += value;
				});

				form.find('.sizes').append('<div class="error">' + html + '</div>');
			}
		};

		Vostok.uniFormSubmit(form, callbacks);


	});


});


var timer,
	hover_disabled = false;

window.addEventListener('scroll', function() {
	clearTimeout(timer);
	if( ! hover_disabled && ! document.body.classList.contains('disable-hover')) {
		document.body.classList.add('disable-hover');
		hover_disabled = true;
	}

	timer = setTimeout(function(){
		document.body.classList.remove('disable-hover');
		hover_disabled = false;
	}, 300);
}, false);