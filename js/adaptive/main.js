function is_array(inputArray) {
	return inputArray && !(inputArray.propertyIsEnumerable('length')) && typeof inputArray === 'object' && typeof inputArray.length === 'number';
}

$(function(){
    if($("img[usemap]").length && $("img[usemap]").rwdImageMaps)
    {
            $("img[usemap]").rwdImageMaps();
    }
    window.$$ = {
        mobile: (/iphone|ipad|ipod|android|blackberry|mini|windowssce|palm/i.test(navigator.userAgent))
    };

    $('.mblockdiv').on('click', function(){
	document.location.href = $(this).find('a').attr('href');	
    });	

    /**
     * Window resize system
     */
    (function(system, body, undefined){
        var resolutions = [980, 850, 768, 720, 600, 480, 360],
            list = [],
            mode;

        system
            .on('resize', function(){
                var width = system.width(), resolution, i = 0, output = [1000];

                while(resolution = resolutions[i++]){
                    if(width - 20 > resolution) break;
                    output.push(resolution);
                }

                if(list.length != output.length){
                    if(list.length > output.length){
                        body.removeClass('_' + list.slice(output.length).join(' _'));
                    }else{
                        body.addClass('_' + output.slice(list.length).join(' _'));
                    }

                    system.trigger('phast-resolution', [mode = Math.min.apply(null, output), list = output]);
                }

                system.trigger('phast-resize');

            });

        $$.resolution = function(namespace, callback){
            if(namespace === undefined){
                return mode;
            }else if(callback === undefined){
                callback = namespace;
                namespace = 'common';
            }else if(callback === null){
                return system.off('phast-resolution.resolution-' + namespace);
            }

            return system.on('phast-resolution.resolution-' + namespace, callback);
        };

        $$.resize = function(namespace, callback){
            if(namespace === undefined){
                return system.trigger('phast-resize');
            }else if(callback === undefined){
                callback = namespace;
                namespace = 'common';
            }else if(callback === null){
                return system.off('phast-resize.resize-' + namespace);
            }

            return system.on('phast-resize.resize-' + namespace, callback);
        };

    })($(window), $('body'));


    /**
     * Region cover
     */

    (function(frame){

        var $images = frame.find('img'),
            $regions = $('.regions'),
	        $rusRegions = $('.regions[data-country="1"]'),
            $region = $('.region'),
            $choose = $('.choose'),
            $wrapper = $('.choose-wrapper'),
            imagesExpected = $images.length,
            imagesLoaded = 0,
            width, pageX,
            mapFactor = [.2,.2,-.1,.1,-.2],
            forceTimer = setTimeout(function(){
                start();
            }, 10000),
            loaded = function(){
                if(++imagesLoaded >= imagesExpected){
                    start();
                }
            },
            start = function(){
                loaded = function(){};
                imagesLoaded = true;
                clearTimeout(forceTimer);

                $(document).on('mousemove', function(e){
                    if(Math.abs(e.pageX - pageX) > 8){
                        pageX = e.pageX;
                        render();
                    }
                });

                render();


                setTimeout(function(){
                    $('.footer').addClass('loaded');
                    $wrapper.addClass('visible');
	                if($('.button').length)
	                {
		                $('.button').delay(600).fadeIn(300);
		                $('.caption').on('click', function(){
			                $('.button').addClass('opened');
			                $choose.addClass('opened');
			                if($region.length){
				                $('.caption').fadeOut(300);
				                $region.fadeIn(300);
			                }
			                $choose.find('.sections > li.active').click();
		                });
	                }
	                else {
		                $($choose).delay(600).addClass('opened').fadeIn(300);

	                }
                }, 1000);



            },
            render = function(){
                if(imagesLoaded !== true) return;
                $images.each(function(key){
                    $(this).css({left: (width / 2 - this.offsetWidth / 2) - (pageX - width / 2) * mapFactor[key] });
                });
            };

        $$.resize(function(){
            width = $(document).width();
            pageX = width / 2;
            render();
        });

        $images.each(function(){

            this.onload = function(){
                loaded();
            };

            this.src = $(this).data('src');

        });

        $('.continue').on('click', function(e){
            e.preventDefault();

            $.ajax('?refuse', {type: 'post'}).complete(function(){
                document.location.reload();
            });
        });

	    $choose.find('.sections > li:not(.disabled)').on('click', function(e){
		    e.preventDefault();
		    but = $(this);
		    id = but.data('country');
		    list = $($choose).find('ul.regions[data-country="'+id+'"]');
		    if(list.length) {

			    $($choose).find('.sections > li').removeClass('active');
			    but.addClass('active');
			    $($choose).find('ul.regions').hide();
			    list.show();
		    }

	    });

	    $rusRegions.find('> li:lt(2)').appendTo($('<div class="important"></div>').prependTo($rusRegions));

    })($('#region-cover'));


    /**
     * Catalog promo
     *
    (function($root, undefined){ if(!$root.length) return;

        var width, distance, offset = 1, lock, incomingTimer, animateTimer, loopTimer, scrolled, ie = !!$('html.ie8, html.ie9').length;

        var $container = $root.find('> div.container'),
            $primalItems = $container.find('> div.item');

        $container
            .prepend($primalItems.eq($primalItems.length-1).clone())
            .append($primalItems.eq(0).clone())
        ;

        var $items = $container.find('> div.item'),
            $masks = $items.find('> div.mask'),
            $objects = $items.find('> div.object');

        var animateOutgoing = function($item, direction){
                var $mask = $item.find('> div.mask'),
                    $object = $item.find('> div.object');

                $item
                    .removeClass('incoming')
                    .addClass('outgoing ' + (direction > 0 ? 'left' : 'right'));

            },
            animateIncoming = function($item, direction){
                var $mask = $item.find('> div.mask'),
                    $object = $item.find('> div.object');

                $item
                    .removeClass('outgoing outgoing-prepare')
                    .addClass('incoming-prepare ' + (direction > 0 ? 'left' : 'right'))
                ;

                incomingTimer = setTimeout(function(){
                    $item.addClass('incoming');
                }, 50);

            },

            animate = function(direction){

                if(lock) return; lock = true;

                offset += direction;


                if(offset > $primalItems.length){
                    move(true, 0);
                    offset = 1;
                }else if(offset < 0){
                    move(true, $primalItems.length);
                    offset = $primalItems.length-1;
                }

                loop();

                if(ie || $$.resolution() <= 850){
                    move('degradation');
                    setTimeout(function(){
                        lock = false;
                    }, 1000);

                }else{
                    setTimeout(function(){

                        clearInterval(incomingTimer);

                        animateOutgoing($items.eq(offset-direction), direction);
                        animateIncoming($items.eq(offset), direction);

                        move();

                        animateTimer = setTimeout(function(){
                            $container.removeClass('animate');
                            $items.removeClass('incoming incoming-prepare outgoing left right');
                            lock = false;
                        }, 2500);


                    }, 50);
                }

            },

            move = function(instant, num){

                $items.removeClass('current');
                $items.eq(offset).addClass('current');

                if(instant){
                    $container.removeClass('animate');
                }else{
                    $container.addClass('animate');
                }
                if('degradation' == instant){
                    $container.stop().animate({left: -(num === undefined ? offset : num) * (distance + width)}, 1000);
                }else{
                    $container.stop().css({left: -(num === undefined ? offset : num) * (distance + width)});
                }

            },

            loop = function(){
                clearTimeout(loopTimer);
                loopTimer = setTimeout(function(){
                    animate(1);
                }, 12000);
            };

        $items
            .find('> div.object > div.product')
            .on('mouseenter', function(){
                clearTimeout(loopTimer);
            })
            .on('mouseleave', function(){
                loop();
            })
            .find('> i.prev').on('click', function(){
                animate(1);
            })
            .end()
            .find('> i.next').on('click', function(){
                animate(-1);
            });


        $('i.catalog-promo-scroller').on('click', function(){

            if($(document).scrollTop() > 0){
                scrolled = false;
                $(this).removeClass('im');
            }else{
                scrolled = !scrolled;
                $(this).toggleClass('im');
            }
            if(scrolled){
                $('html:not(:animated), body:not(:animated)').animate({scrollTop: $(this).offset().top - this.offsetHeight}, 1000);
            }else{
                $('html:not(:animated), body:not(:animated)').animate({scrollTop: 0}, 1000);
            }
            $$.resize();

        });

        $$.resize(function(){

            var height = (width = $root.width()) * (460/960);
            $masks.height(height).css({marginBottom: -height});
            //$objects.css({marginTop: -height});
            $items.css('margin-right', distance = ($(document).width() - width) / 2);
            move(true);
            loop();



            $items.each(function(){
                var $item = $(this),
                    $image = $item.find('.image'),
                    height = window.innerHeight - parseInt($item.find('.object').css('padding-top')) - $item.offset().top;

                if(!scrolled && $$.resolution() > 850 && window.innerHeight < 900){
                    $image.height(height < 507 ? 507 : height);
                }else{
                    $image.height(height < 507 && $$.resolution() > 850 ? height : 507);
                }

            });
        });

    })($('#catalog-promo'));
    */

    /**
     * Choose region
     */
    (function($root){ if(!$root.length) return;

        var $body = $('body'),
            $handler = $root.find('> a'),
            $container = $root.find('> div.header-region-choose'),
            $regions = $container.find('> ul.regions'),
            loaded, loading;

        var $blackout = $('<i class="region-choose-blackout"></i>')
            .on('click', function(e){
                e.preventDefault();
                e.stopPropagation();
                hide();
            });

        var show = function(){

		        $("#header-search").find('> a').removeClass('opened');
		        $("#header-search").find('> .header-search-box').hide().off('.search-box');
		        $body.off('.search-box');
		        $("i.header-search-blackout").detach();

                $handler.addClass('opened');
                $container.show().on('click.region-choose', function(e){
                    e.stopPropagation();
                });
                $body.on('click.region-choose', function(){
                    hide();
                });
                $blackout.prependTo($body);

            },
            hide = function(){
                $handler.removeClass('opened');
                $container.hide().off('.region-choose');
                $body.off('.region-choose');
                $blackout.detach();
            },
            open = function(){
                show();

                if(!loaded && !loading){
                    loading = true;
                    $
                        .ajax('/regions/', {
                            type: 'post'
                        })
                        .success(function(response){
                            $regions
                                .addClass('loaded')
                                .replaceWith(response);
		                        $container.find('> ul.regions').find('> li > a').each(function(){
			                        this.href = this.href.substring(0, this.href.length-1) + document.location.pathname + document.location.search;
                                });
		                    $container.find('.sections > li.active').click();
                            loaded = true;

                        })
                        .error(function(){
                            hide();
                        })
                        .complete(function(){
                            loading = false;
                        });
                }

            };

        $handler.on('click', function(e){
            e.stopPropagation();
            e.preventDefault();

            if($handler.hasClass('opened')){
                hide();
            }else{
                open();
            }

        });

	    $container.find('.sections > li:not(.disabled)').on('click', function(e){
		    e.preventDefault();
		    but = $(this);
		    id = but.data('country');
		    list = $container.find('ul.regions[data-country="'+id+'"]');
		    if(list.length) {
			    $container.find('.sections > li').removeClass('active');
			    but.addClass('active');
			    $container.find('ul.regions').hide();
			    list.show();
		    }

	    });

    })($('#choose-region'));


    /**
     * Search
     */
    (function($root){ if(!$root.length) return;

        var $body = $('body'),
            $handler = $root.find('> a'),
            $container = $root.find('> .header-search-box'),
            $choose = $container.find('.choose i'),
            $notice = $container.find('.notice span'),
            $form = $container.find('form');

        var initialized, type;

        var $blackout = $('<i class="header-search-blackout"></i>')
            .on('click', function(e){
                e.preventDefault();
                e.stopPropagation();
                hide();
            });

        var show = function(){
		        $("#choose-region > a").removeClass('opened');
		        $("#choose-region").find('> div.header-region-choose').hide().off('.region-choose');
		        $body.off('.region-choose');
		        $("i.region-choose-blackout").detach();

                $handler.addClass('opened');
                $container.show().on('click.search-box', function(e){
                    e.stopPropagation();
                });
                $body.on('click.search-box', function(){
                    hide();
                });
                $blackout.prependTo($body);

            },
            hide = function(){
                $handler.removeClass('opened');
                $container.hide().off('.search-box');
                $body.off('.search-box');
                $blackout.detach();
            },
            open = function(){
                show();

                if(!initialized){
                    initialized = true;
                    $choose.eq(0).click();
                }
            };

        $choose.on('click', function(){
            type = $(this).addClass('active').siblings('i').removeClass('active').end().data('type');
            $form.attr('action', 'http://sankt-peterburg.vostok.ru/search/' + type + '/');
            $notice.hide().filter('[data-type="'+type+'"]').show();
        });

        $handler.on('click', function(e){
            e.stopPropagation();
            e.preventDefault();

            if($handler.hasClass('opened')){
                hide();
            }else{
                open();
            }

        });


    })($('#header-search'));


    /**
     * Phast Slider
     */
    (function(){

        var namespaceGlob = 'phast-slider',
            namespaceCount = 0;

        var regexpNumber = /^\d+$/,
            regexpTrim = /^[\s{}]+|[\s{}]+$/g;

        var parseColsNumber = function(cols){
	    if(!cols)
		return 0;
            var output = [], i = 0, col;

            if(cols.match(regexpNumber)){
                output.push({
                    resolution: 1000,
                    number: cols
                });

            }else{
                cols = cols.replace(regexpTrim, '').split(',');
                while(col = cols[i++]){
                    col = col.split(':');
                    output.push({
                        resolution: col[0].replace(regexpTrim, '')-0,
                        number: col[1] - 0
                    });
                }

                output.sort(function(a, b){
                    return a.resolution < b.resolution ? 1 : -1;
                });

            }

            return output;
        }

        var init = function(element, forceslide){
            var $slider = $(element),
                $trash,
                html = '';

            html += '<div class="frame">';
            html += '<ul class="container">';
            if($slider.data('products')){
                $trash = $slider.find('script').detach();
            }
            $slider.find('> *').each(function(){
                if($slider.data('products')){
                    html += '<li class="element ' + this.className + '"><div class="element-inner-wrapper"><article data-id="'+$(this).data('id')+'" data-catalog-no="'+$(this).data('catalog-no')+'">' + this.innerHTML + '</article></div></li>';

                }else{
                    html += '<li class="element ' + this.className + '"><div class="element-inner-wrapper">' + this.innerHTML + '</div></li>';
                }
            });
            html += '</ul>';
            html += '</div>';
            html += '<a href="#slider-prev" class="nav prev"></a>';
            html += '<a href="#slider-next" class="nav next"></a>';

            $slider.html(html);
            if($trash) $slider.append($trash);

            var $frame = $slider.find('> div.frame'),
                $container = $frame.find('> .container'),
                $elements = $container.find('> .element'),
                $nav = $slider.find('> a.nav'),
                $navPrev = $nav.filter('.prev'),
                $navNext = $nav.filter('.next'),
                namespace = namespaceGlob + (++namespaceCount).toString(),
                colsNumberStorage = parseColsNumber($slider.data('cols')),
                colsNumber, colsWidth, colsTotal = $elements.length,
                step = 1, offset = ($slider.data('offset')-0)||0, lock;

            var move = function(step){
                var future = offset + step;

                if(future > colsTotal-colsNumber){
                    future = colsTotal-colsNumber;
                }else if(future < 0){
                    future = 0;
                }

                if(offset != future){
                    offset = future;
                    render();
                }
            };


            var render = function(force){

                if(colsTotal > colsNumber){

                    if(offset > colsTotal-colsNumber){
                        offset = colsTotal-colsNumber;
                    }else if(offset < 0){
                        offset = 0;
                    }

                    $navNext.show();
                    $navPrev.show();

                    if(offset + colsNumber == colsTotal){
                        $navNext.addClass('deactive');
                    }else{
                        $navNext.removeClass('deactive');
                    }

                    if(offset == 0){
                        $navPrev.addClass('deactive');
                    }else{
                        $navPrev.removeClass('deactive');
                    }
                }else{

                    if(offset > colsTotal){
                        offset = colsTotal;
                    }else if(offset < 0){
                        offset = 0;
                    }

                    $navNext.hide();
                    $navPrev.hide();
                }



                var $filtered = $elements.addClass('hidden');
                if(offset > 0) $filtered = $filtered.filter(':gt('+(offset-1)+')');
                $filtered.filter(':lt('+(colsNumber)+')').removeClass('hidden');

                animate(force);
            };

            var animate = function(force){
                if(force){
                    $container.stop().css({left: -offset * colsWidth});
                }else{
                    $container.stop().animate({left: -offset * colsWidth}, 300);
                }
            };

            if('ontouchend' in document){
                var touchStartX, touchMoveX,
                    touchStartY, touchMoveY;

                $frame
                    .on('touchstart', function(event){
                        event.stopPropagation();

                        touchStartX = event.originalEvent.targetTouches[0].pageX;
                        touchStartY = event.originalEvent.targetTouches[0].pageY;
                    })
                    .on('touchmove', function(event){
                        event.stopPropagation();

                        if(event.type = 'touchmove'){

                            touchMoveX = event.originalEvent.targetTouches[0].pageX;
                            touchMoveY = event.originalEvent.targetTouches[0].pageY;

                            if(Math.abs(touchStartY - touchMoveY) <= Math.abs(touchStartX - touchMoveX) * 1.5){
                                event.preventDefault();
                                $container.css({left: '-=' + (touchStartX-touchMoveX)*1.5});
                                touchStartX = touchMoveX;
                                touchStartY = touchMoveY;
                            }

                        }

                    })
                    .on('touchend', function(event){
                        event.stopPropagation();

                        offset = - Math.round(parseInt($container.css('left')) / colsWidth);
                        render();
                    });
            }


            $elements.find('a').on('click', function(e){
                var $element = $(this).closest('.element');
                if($element.is('.hidden')){
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();

                    move($element.prevAll(':not(.hidden):eq(0)').length ? step : -step);
                }
            });

            $nav
                .on('click', function(event){
                    event.preventDefault();
                    event.stopPropagation();

                    move( $(this).hasClass('prev') ? -step : step );
                });

            $$.resolution(namespace, function(e, resolution){
                for(i in colsNumberStorage){
                    if(colsNumberStorage[i].resolution < resolution) break;
                    colsNumber = colsNumberStorage[i].number;
                }
            });

            $$.resize(namespace, function(){
                $elements.width(colsWidth = $frame.width() / colsNumber);
                render(true);
            });


	     function changeSlide(){
                if($('.main-top-slider .next.deactive').length)
                    move(-colsTotal);
		else
                    $('.main-top-slider .next')[0].click();
       		setTimeout(changeSlide, 5000);
             }

     	     if(forceslide && $('.main-top-slider').length)
	        setTimeout(changeSlide, 5000);
	        
        };
		
        init($('.main-top-slider .slider'), true);
        init($('.news-actions-slider .slider'), false);

    })();




    /**
     * Phast Image Slider
     */
    (function(){

        var namespaceGlob = 'phast-image-slider',
            namespaceCount = 0;

        var regexpNumber = /^\d+$/,
            regexpTrim = /^[\s{}]+|[\s{}]+$/g;

        var init = function(element){
            var $slider = $(element),
                html = '';

            html += '<div class="view">';
            html += '<div class="wrapper"><div class="holder"></div></div>';
            html += '<i class="nav prev"></i>';
            html += '<i class="nav next"></i>';
            html += '</div>';
            html += '<div class="title"></div>';
            html += '<div class="line">';
            html += '<div class="frame">';
            html += '<ul class="container">';
            $slider.find('> *').each(function(){
                html += '<li class="element">' + this.innerHTML + '</li>';
            });
            html += '</ul>';
            html += '</div>';
            html += '<i class="nav prev"></i>';
            html += '<i class="nav next"></i>';
            html += '</div>';

            $slider.html(html);

            var $title = $slider.find('.title'),
                $view = $slider.find('.view').height($slider.data('height')),
                $wrapper = $view.find('.wrapper').height($slider.data('height')),
                $holder = $view.find('.holder'),
                $switch = $view.find('.nav'),
                $line = $slider.find('.line'),
                $nav = $line.find('.nav'),
                $navPrev = $nav.filter('.prev'),
                $navNext = $nav.filter('.next'),
                $frame = $line.find('.frame'),
                $container = $frame.find('ul'),
                $elements = $container.find('li'),
                $placeholders = $elements.find('a'),
                $images = $placeholders.find('img'),
                namespace = namespaceGlob + (++namespaceCount).toString(),
                total = $images.length,
                active, offset = 0, nav, step = 2, path,
                frameWidth, initialized, $viewImages;

            var
                render = function(){
                    $container.stop().animate({left: -offset}, 300);
                },

                move = function(step, index){

                    if(!nav) return;

                    var i, distance;

                    if(step === true){
                        var index = active-1 ;
                        offset = (path[index].trace) - frameWidth/2 - path[index].element/2;
                        if (offset > path[path.length - 1].trace - frameWidth) offset = path[path.length - 1].trace - frameWidth;
                        if (offset < 0) offset = 0;
                        render();
                        return;
                    }

                    if(step > 0){

                        for(i in path){
                            i -= 0;
                            distance = path[i];

                            if(distance.trace - offset > frameWidth){
                                distance = path.length < i + step ? path[path.length - 1] : path[i + step - 1];
                                offset = distance.trace - frameWidth;
                                render();
                                break;
                            }
                        }

                    }else{

                        for(i in path){
                            i -= 0;
                            distance = path[i];

                            if(distance.trace >= offset){
                                distance = i + step < 0 ? path[0] : path[i + step + 1];
                                offset = distance.trace - distance.element;
                                render();
                                break;
                            }
                        }

                    }

                };

            $nav
                .on('click', function(event){
                    event.preventDefault();
                    event.stopPropagation();

                    move( $(this).hasClass('prev') ? -step : step );
                });

            $switch
                .on('click', function(event){
                    event.preventDefault();
                    event.stopPropagation();

                    active += $(this).hasClass('prev') ? -1 : 1;
                    if(active > total) active = 1;
                    if(active < 1) active = total;

                    $elements.filter('[data-id="'+active+'"]').find('a').click();
                });


            var view_images = [];
            $elements
                .each(function(i){
                    $(this).attr('data-id', i+1);
                    view_images.push('<img src="/images/layout/pixel.png" data-id="'+(i+1)+'" data-loaded="0">');
                });
            $holder.append(view_images.join(''));
            $viewImages = $holder.find('img').hide();

            $placeholders
                .on('click', function(e){
                    e.preventDefault();

                    var $placeholder = $(this),
                        title = $placeholder.prop('title'),
                        $element = $placeholder.parent(),
                        elementId = $element.data('id'),
                        $image = $holder.find('img[data-id="'+elementId+'"]');

                    if($placeholder.parent().hasClass('active')) return;

                    active = elementId;

                    var show = function(){
                        $image.css({position: 'static', left: 0}).hide();
                        if(active == $image.data('id'))
                            $image.show(300).siblings('img').hide(300);
                    };


                    if($image.data('loaded')){
                        show();

                    }else{
                        $image.css({position: 'absolute', left: -10000}).show();
                        $image[0].onload = function(){
                            $image.data('loaded', true);
                            show();
                        };
                        $image[0].src = $placeholder.prop('href');

                    }

                    $placeholder.parent().addClass('active').siblings('li').removeClass('active');
                    $title.html(active + '/' + total + (title ? '<span>' + title + '</span>' : ''));

                    move(true);
                });


            $$.resolution(namespace, function(e, resolution){

            });

            $$.resize(namespace, function(){

                var trace = 0;
                path = [];

	            $.each($elements, function( i, item ) {
		            var width = $(item).outerWidth(true);
		            if(width == 10) width = 107;
		            trace = trace + width;
		            path.push({trace: trace, element: width});
	            });

                frameWidth = $frame.width();
                $viewImages.css('max-width', frameWidth);

                if(!initialized){
                    initialized = true;
                    $placeholders.eq(0).click()
                }

                if(nav = trace > frameWidth){
                    $nav.fadeIn(100);
                    move(true);
                }else{
                    $nav.fadeOut(100);
                }

            });


        };

	    $.each($('.image-slider'), function( i, item ) {
		    init(item);
	    });



    })();



    /**
     * Build main menu
     * Autosize
     */
    (function(menu){ if(!menu.length) return;
        build_menu (menu);
    })($('#menu'));
    (function(menu){ if(!menu.length) return;
        build_menu (menu);
    })($('#carlsberg_menu'));

    function build_menu (menu) {
        var level0 = menu.find('> div.menu > div > ul.level0'),
            level0Elements = level0.find('> li').append('<i></i>'),
            level0EI = level0Elements.find('> i'),
            level1 = level0Elements.find('> ul'),
            level1Elements = level1.find('> li').append('<i></i>'),
            level1EI = level1Elements.find('> i'),
            level2 = level1Elements.find('> ul'),
            level2Elements = level2.find('> li'),
            submenu = menu.find('> div.submenu'),
            submenuPlace = submenu.find('> div');

        level1.each(function(){
            if($(this).find('> li').length > 1) $(this).closest('li').addClass('has-children');
        });
        level2.closest('li').addClass('has-children');

        var handler = $('<div class="handler"><span></span><i></i></div>');

        var activeUndermenu = level2Elements.filter('.active:eq(0)'),
            activeSubmenu = level1Elements.filter('.active:eq(0)'),
            activeMenu = level0Elements.filter('.active:eq(0)'),
            activePage;

        if(activeMenu.length){
            if(activeMenu.hasClass('has-children')){
                activePage = activeMenu;
                submenu.addClass('freez');
            }

            if(activeSubmenu.length){
                handler.find('> span').text(activeSubmenu.find('> a').text());
            }else{
                handler.find('> span').text(activeMenu.find('> a').text());
            }

        }else{
            handler.find('> span').text('Выберите пункт меню ').addClass('index');
        }

        level0.before(handler).prepend('<li class="index"><a href="/">Главная</a></li>');

        var closeTimer, openTimer, close = function(){
            level0Elements.filter('.opened').removeClass('opened');

            if(activePage){
                activePage.trigger('open');
            }else{
                submenu.removeClass('opened').stop().animate({height: 0}, 300);
            }
        };

        var bind = function(options){
                options = options || {};

                if(options.mouse){

                    level0Elements.filter('.has-children')
                        .on('open.menu', function(){
                            var li = $(this),
                                ul = li.find('> ul'),
                                primalHeight, height, opened = submenu.hasClass('opened');

                            clearTimeout(closeTimer);
                            clearTimeout(openTimer);

                            li.addClass('opened').siblings('li').removeClass('opened');

                            primalHeight = opened ? submenu.css({height: 'auto'}).height() : submenu.height();

                            submenu.addClass('opened');
                            submenuPlace.empty().append(ul.clone());

                            height = opened ? submenu.height() : submenu.css({height: 'auto'}).height();

                            submenu
                                .css({height: primalHeight})
                                .stop().animate({height: height}, activePage && !opened  ? 0 : 300);

                        })
                        .on('mouseenter.menu', function(e){
                            clearTimeout(openTimer);
                            if(e.target.tagName != 'I'){
                                $(this).trigger('open');
                            }

                        })
                        .on('mouseleave.menu', function(){
                            clearTimeout(closeTimer);
                            clearTimeout(openTimer);
                            closeTimer = setTimeout(close, 2000);
                        });

                    level1Elements
                        .on('click.menu', function(){
                            clearTimeout(closeTimer);
                            clearTimeout(openTimer);
                        });

                    submenu
                        .on('mouseenter.menu', function(){
                            clearTimeout(closeTimer);
                        })
                        .on('mouseleave.menu', function(e){
                            clearTimeout(closeTimer);
                            closeTimer = setTimeout(close, 2000);
                        })
                        .on('mouseenter.menu', 'ul.level1 > li.has-children', function(){
                            var li = $(this),
                                ul = li.find('> ul'),
                                width = ul.outerWidth(),
                                offset = ul.offset(),
                                margin = width / 2 - li.outerWidth() / 2,
                                documentWidth = $(document).width();

                            if(width + offset.left - margin > documentWidth){
                                margin = width + offset.left - documentWidth;
                            }else if(offset.left - margin < 0){
                                margin =  offset.left;
                            }

                            ul.css({marginLeft: -margin});
                        });
                }else{

                    handler.on('click.menu', function(){
                        menu.toggleClass('opened');
                    });

                    level0EI
                        .on('click.menu', function(){
                            var li = $(this).closest('li'),
                                ul = li.find('> ul');

                            li.toggleClass('opened').siblings('li').removeClass('opened');
                            return false;
                        });

                    level1EI
                        .on('click.menu', function(){
                            var li = $(this).closest('li'),
                                ul = li.find('> ul');

                            li.toggleClass('opened').siblings('li').removeClass('opened');
                            return false;
                        });

                    if(activePage){
                        activePage.find('> i').click();
                    }

                    if(activeSubmenu){
                        activeSubmenu.find('> i').click();
                    }

                }

                if(activePage){
                    activePage.trigger('open');
                }

            },
            unbind = function(){
                level0Elements
                    .add(level0EI)
                    .add(level1Elements)
                    .add(submenu)
                    .add(handler)
                    .off('.menu');
                ;

            },
            cleanup = function(){
                clearTimeout(closeTimer);
                close();
            };

        menu.on('click.menu', 'li > a', function(){
            unbind();
        });

        $$.resolution(function(e, resolution){
            var options = {};

            if(resolution > 600){
                options.mouse = true;
            }

            unbind();
            cleanup();
            bind(options);


        });

        $$.resize(function(){
            var width = level0.width(), total = -20, padding;

            level0Elements.each(function(i, item){
                total += item.offsetWidth;
            });

            padding = (width - total) / level0Elements.length / 2;

            level0EI.css({marginLeft: -padding});
            if(!$('body').hasClass('_600')) $("#logo").css({'margin-top':$("header#header").innerHeight()});
            else $("#logo").css({'margin-top': 0});
        });     
    }

    /**
     * Magnetic footer
     */
    (function(footer, content){ if(!footer.length) return;
        var padding;
        $$.resize(function(){
            padding = footer[0].offsetHeight;
            content.css({paddingBottom: padding+70});
            footer.css({marginTop: -padding-30});
        });

    })($('#footer'), $('#content'));
});