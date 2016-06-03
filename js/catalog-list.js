
var document_height,
    window_height,
    footer_height
;

var refreshDocumentData = function(){
    document_height = $(document).height();
    window_height = $(window).height();
    footer_height = $('#footer').height();
};

var listSeparatorCounter = function(){
    this.count = 0;
    $('#content .catalog-list > i.separator').remove();
    var containerWidth = $('#content .catalog-list').width(),
        itemWidth = $('#content .catalog-list article').width() + 20,
        itemsCount  = Math.floor(containerWidth/itemWidth);

    if(this.count != itemsCount && $(window).width() <= 980){
        this.count = itemsCount;
        $('#content .catalog-list').addClass('separator');
        var separator = $('<i class="separator"></i>').css({width: containerWidth-20})
        var separator1 = $('<i class="separator"></i>').css({width: containerWidth-20})
        separator.insertAfter($('.catalog-list.separator article:nth-child('+itemsCount+'n)'));
        separator1.insertAfter($('.catalog-list.separator article:last'));
    }else{
        $('#content .catalog-list').removeClass('separator');
    }
}

var catalogList = {

    prev_params: {},
    params: {},
    data: {},
    parseURL: function(){
        var _this = this;
        var params = $.deparam.querystring(window.location.search.substring(1), true);
        _this.params = params;
        if(params.prop){
            var prop = params.prop;
            delete params.prop;

            _this.params['prop'] = {};
            $.each(prop, function(key, value){

                if(value) {

                    _this.params['prop'][key] = value;
                }
            });
        }



    },
    fillFilter: function(){
        this.parseURL();
        if(this.params.price_from || this.params.price_to){
            $('.catalog-list-filters input[name=price_from]').closest('.section').addClass('active');
        }
        if(this.params.price_from && this.params.price_to){
            $('#price-range-slider').attr('value', this.params.price_from+';'+this.params.price_to);
            $('.catalog-list-filters input[name=price_from]').val(this.params.price_from);
            $('.catalog-list-filters input[name=price_to]').val(this.params.price_to);
        }else if(this.params.price_from && !this.params.price_to){
            $('#price-range-slider').attr('value', this.params.price_from+';'+$('#price-range-slider').data('max_price'));
            $('.catalog-list-filters input[name=price_from]').val(this.params.price_from);
            $('.catalog-list-filters input[name=price_to]').val('');
        }else if(!this.params.price_from && this.params.price_to){
            $('#price-range-slider').attr('value', $('#price-range-slider').data('min_price')+';'+this.params.price_to);
            $('.catalog-list-filters input[name=price_from]').val('');
            $('.catalog-list-filters input[name=price_to]').val(this.params.price_to);
        }

        if(this.params.query) $('.catalog-list-filters input[name=query]').val(this.params.query);

        if(this.params.prop){
            $.each(this.params.prop, function(key, value){
                if(value){
                    $('.catalog-list-filters .section[data-id='+key+']').addClass('active');
                    for(var i=0; i<value.length; i++){
                        $('#prop_'+key+'_'+value[i]).prop('checked', true);
                    }

                }
            });
        }

        if(this.params.prop || this.params.query || this.params.price_from ||  this.params.price_to){
            $('.catalog-list-filters').addClass('active');
        }

        //Price Range Slider
        function scale(max, min){
            var scale = 7;
            var step = Math.round((max-min)/scale),
                result = []
                ;

            for (var i=1; i < scale;i++){
                result.push((Math.round((step*i+min)/100))*100);
            }
            return result;
        }

        $('#price-range-slider').slider({
            from: parseInt($('#price-range-slider').data('min_price')),
            to: parseInt($('#price-range-slider').data('max_price')),
            step: 1,
            smooth: true,
            scale: scale(parseInt($('#price-range-slider').data('max_price')),parseInt($('#price-range-slider').data('min_price'))),
            round: 0,
            dimension: "", skin: "plastic",
            calculate: function( value ){
                return value;
            },
            onstatechange: function(value){
                //console.log(value.split(';'))
            },
            callback: function(value){
                var prices = value.split(';'),
                    from = prices[0],
                    to = prices[1]
                    ;
                $('.catalog-list-filters').addClass('active');
                $('.catalog-list-filters input[name=price_from]').val(from);
                $('.catalog-list-filters input[name=price_to]').val(to);
                $('.catalog-list-filters input[name=price_from]').closest('.section').addClass('active');
                catalogList.params.page = 1;
                catalogList.params.price_from = from;
                catalogList.params.price_to = to;
                catalogList.load();
            }

        });


        //Custom checkbox
        $('.catalog-list-filters input[type=checkbox]').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            //radioClass: 'iradio_minimal-blue',
            increaseArea: '100%'
        });


    },
    buildURL: function(){
        var _this = this;
        var query = '?';
        query += $.param(_this.params);
        query = (query == '?')? '':query;

        if(window.history && history.pushState){
            history.pushState(null, null, window.location.pathname+query);
        }
    },

    load: function(callback){
        var _this = this;
        _this.buildURL();
        if(this.request){
            //Vostok.blockOverlay($('#content .catalog-block .right'));
            this.request.abort();
        }
        this.request = $.ajax({ url: window.location.pathname, data: _this.params, type: 'post', dataType: 'json',
            beforeSend: function(){
                if(!$('#content .catalog-block .catalog-list .block-overlay').length){
                    Vostok.blockOverlay($('#content .catalog-block .catalog-list'));
                }

            },

            success: function(data){
                if($.trim(data.html) !== ''){
                    _this.data = data;
                    _this.buildList(data);
                    if(callback) callback(data);
	                if(data.catIds){
		                if($(".search-category-filter .item").length) {
			                $(".search-category-filter .item").addClass("disabled");
			                $.each(data.catIds, function(key, item){
				                $(".search-category-filter").find(".item[data-id='"+item+"']").removeClass('disabled');
			                });
		                }
	                }
                    initPrettyForm();
                }else{
                    var text = '<h3>Результаты не найдены</h3>Ваш запрос не дал результатов. Измените критерии поиска.';
                    Vostok.prettyModal(text, function(){});
                    //убираем фокус, чтобы еще раз не тыкнул интер
                    //$('.catalog-list-filters input[name=price_from]').focus()
                    Vostok.blockOverlay($('#content .catalog-block .catalog-list'));

                }

                //Vostok.blockOverlay($('#content .catalog-block .catalog-list'));

            }
        });
    } ,
    buildList: function(data){
        var html = "";
        var _this = this;
        /*$.each(data.list, function(key, value){
            html += _this.item(value);
        });   */

        $('#content .catalog-block .catalog-list').html(data.html);
        $('#content .catalog-block .pager').html(_this.pager(data.pages, data.page));
        //if(!$('body').hasClass('_480')){


        //}
        refreshDocumentData();
        listSeparatorCounter();
        this.attachFavorites()
        this.fillCartItems()
    },

    item: function(data){

        //TO-DO-VOSTOK картинки
        var options = '';
        if(data.price){
            options = '<div class="options">'+
                '<div class="cart-action">'+
                '<i class="add-cart"></i>'+
                '<i class="add-compare"></i>'+
                '<div style="display: none;" class="compare">'+
                '<p>Добавить в список</p>'+
                '<p><span>К сравнению</span></p>'+
                '</div>'+
                '</div>' +
                '<div class="price"><span>'+data.price+'</span></div>'+
                '</div>';
        }else{
            options = '<div class="options">'+
                '<div class="cart-action hidden-price">'+
                '<i class="add-compare"></i>'+
                '<div style="display: none;" class="compare">'+
                '<p>Добавить в список</p>'+
                '<p><span>К сравнению</span></p>'+
                '</div>'+
                '</div>'+
                '<a class="notice" href="#pretty-block-form-ask-price" rel="prettyForm">'+
                '<i>цену уточняйте</i><br>'+
                '<i>у менеджера</i>'+
                '</a>'+
                '</div>';
        }

        return '<article class="type'+data.type+'" data-catalog-no="'+data.catalog_no+'" data-id="'+data.id+'">'+
            '<div class="type">'+data.catalog_code+'&nbsp;</div>'+
            '<h2><a href="'+data.url+'">'+data.title+'</a></h2>'+
            '<div class="code">'+
            '<p>Код по каталогу</p>'+
            '<p>'+data.catalog_code+'</p>'+
            '</div>'+
            '<div class="preview">'+
            '<a href="'+data.url+'">'+
            '<img src="'+data.cover+'" alt="">'+
            '<img src="'+data.cover_mini+'" alt="">'+
            '</a>'+
            '</div>'+options+

            '</article>';
    },

    pager: function(pages, page){
        var html = '';
        if(pages.length <= 1) return "";
        $.each(pages, function(key, value){
            html += '<a href="?page='+value+'" class="'+((page == value)?'active':'')+'" data-page="'+value+'">'+value+'</a>'
        });
        return html;
    },
    resetFilters: function(){

        $('.catalog-list-filters .section')
            .removeClass('active')
            .find('input[type=checkbox]')
            .prop('checked', false).parent().removeClass('checked');
        $('.catalog-list-filters').removeClass('active');

        //Сброс слайдера
        $("#price-range-slider").slider("value", $("#price-range-slider").data('min_price'), $("#price-range-slider").data('max_price'))

        //Сброс значений цены
        $('.catalog-list-filters input[name=price_from]').val('');
        $('.catalog-list-filters input[name=price_to]').val('');

        //Сброс строки поиска
        $('.catalog-list-filters input[name=query]').val('');

        if(catalogList.params.prop) delete catalogList.params.prop;
        if(catalogList.params.query) delete catalogList.params.query;
        if(catalogList.params.price_from || catalogList.params.price_from == 0) delete catalogList.params.price_from;
        if(catalogList.params.price_to || catalogList.params.price_from == 0) delete catalogList.params.price_to;
        if(catalogList.params.page) delete catalogList.params.page;
    },

    attachFavorites: function(){
        //Рисуем избранное для каждого товара
        if(Vostok.userAuth){
            $('.catalog-list article .preview-wrap').prepend('<i class="to-favorite u-add-to-favorites-link"><i></i></i>');

        }


    },
    fillCartItems: function(){

        if(this.cartItems){
            $.each(this.cartItems, function(key, value){
                $('.catalog-list article[data-id='+value+'] .add-cart').addClass('active')
            });
        }
    }

}



$(function(){

    refreshDocumentData();

    catalogList.fillCartItems();
    catalogList.attachFavorites();
    catalogList.fillFilter();
    /*window.setTimeout(function() {
        window.addEventListener('popstate', function() {
            catalogList.resetFilters();
            catalogList.fillFilter();
            catalogList.load();
        });
    }, 1000);*/


    $('.catalog-list-filters .section ul').each(function(key, item){
        if($(item).find('li').length > 5){
            $(item).jScrollPane({
                mouseWheelSpeed: 100
            });
        }
    });

    $('#catalog-mode-choose > i').on('click', function(){
        var elem = $(this);
        if(elem.hasClass('active')) return false;
        elem.siblings('.active').removeClass('active').end().addClass('active');
        $.ajax({ url: '?changeViewMode', type: 'post', data: { view_mode: elem.data('mode') },
           beforeSend: function(){
               listSeparatorCounter();
               var list = $('#content .catalog-block .catalog-list');
               if(list.hasClass('mode-list')){ list.removeClass('mode-list'); }else{ list.addClass('mode-list');}
           },
           success: function(){
               catalogList.load(function(){

                   var html = '';
                   $.each(catalogList.data.limits, function(key, value){
                       html += '<option value="'+key+'">По '+value+' товаров</option>';
                   });
                   $('.catalog-settings-limit select').html(html).ikSelect("reset").ikSelect('redraw');
               });

           }
        });
    });




    if($('#to-top-button').length){
        var button = $('#to-top-button');
        $(window).on('resize', function(){ refreshDocumentData(); });

        $(window).on('scroll', function(){
            var scrolls = getScrolls();
            var top  = scrolls.scrollTop;
            /*if((document_height - footer_height - window_height - top - 15 - 60) <= 0){
                button.css({ bottom:  top - $('.pager').offset().top + window_height + 15  })
            }else{
                button.css({ bottom: 60 })
            }   */

	        if(top - 15 - 60 <= 0){
	         button.css({ bottom:  top - $('.pager').offset().top + window_height + 15  })
	         }else{
	         button.css({ bottom: 60 })
	         }

            if(top > window_height/2){
                button.css({'display': 'block'});
            }else{
                button.css({'display': 'none'});
            }
        });

        $('#to-top-button').on('click', function(){
           Vostok.scrollTo(0, 100);
        });
    }


    $('.catalog-settings-limit select').on('change', function(){
        var elem = $(this);
        $.ajax({ url: '?changeLimit', type: 'post', data: { on_page: elem.val() },
            beforeSend: function(){
            },
            success: function(data){
                catalogList.load();

            }
        });
    });

    $('.catalog-settings-order select').on('change', function(){
        catalogList.params.order = $(this).val();
        catalogList.params.page = 1;
        catalogList.load();
    });

    $('#content .catalog-block .pager').on('click', '> a', function(e){
        e.preventDefault();
        if($(this).hasClass('active')) return false;
        catalogList.params.page = $(this).data('page');
        catalogList.load(function(){
            Vostok.scrollTo($('#content .catalog-block'));
        });
    });

    $('#content .catalog-expand-button').on('click', function(e){
        var list = $('#content');
        if(list.hasClass('filters-opened')){
            list.removeClass('filters-opened');
        }else{
            list.addClass('filters-opened');
        }
    });

    $('#content .back-to-list').on('click', function(){
        Vostok.scrollTo(100);
        $('#content .catalog-expand-button').trigger('click');
    });



    $$.resolution(function(f, resolution){
        if(resolution <= 720){
            var limit = $('.catalog-settings-limit');
            var order = $('.catalog-settings-order');
            limit.insertBefore(limit.prev());
            order.find('select').ikSelect({'autoWidth': false}).ikSelect('redraw');
        }

        listSeparatorCounter();
    });

    $$.resize(function(){
        listSeparatorCounter();
    });


    //Поставляем в избранном ли товар только при наведении
    if(Vostok.userAuth){
        $('body').on('mouseenter', '.catalog-list article', function(){
            var elem = $(this),
                id = elem.data('id');
            var favorite = elem.find('i.to-favorite');
            if(typeof catalogList.favoriteItems[id] !=  "undefined") favorite.addClass('remove');
        });
    }



    /**
     * Работа фильтров
     */

    //Разворачивание секций
    $('.catalog-list-filters .section .title').on('click', function(){
        var elem = $(this),
            parent = elem.parent()
        ;

        if(parent.hasClass('expand')){
            parent.removeClass('expand');
        }else{
            parent.addClass('expand');
            var jsp_api = parent.find('ul').data('jsp');
            if(jsp_api) jsp_api.reinitialise();

        }
    });

    //Поиск по слову/коду
    $('.catalog-list-filters .query-search-button').on('click', function(e){
        $('.catalog-list-filters').addClass('active');
        var value = $.trim($(this).parent().find('input').val());
        catalogList.params.page = 1;
        catalogList.params.query = value;
        catalogList.load();
    });

    $('.catalog-list-filters input[name=query]').on('keypress', function(e){
        var pp = false;
        if($('[id^=pretty-block-form-alert]').length && $('[id^=pretty-block-form-alert]').is(':visible')){
            pp = true;
        }else{
            pp = false;
        }
        if(e.keyCode == 13 && !pp){ $('.catalog-list-filters .query-search-button').click();}
    });


    $('.catalog-list-filters input[name^=price]').on('keypress', function(e){
        var pp = false;
        if($('[id^=pretty-block-form-alert]').length && $('[id^=pretty-block-form-alert]').is(':visible')){
            pp = true;
        }else{
            pp = false;
        }

        if(e.keyCode == 13 && !pp){
            var name = $(this).attr('name').split('_')[1];
            var value = $('#price-range-slider').attr('value');
            if(name == 'from'){
                var p1 = $(this).val();
                var p2 = value.split(';')[1];
            }else{
                var p2 = $(this).val();
                var p1 = value.split(';')[0];
            }

            $(this).closest('.section').addClass('active');

            $('#price-range-slider').slider("value", p1, p2);

            catalogList.params['price_'+name] = $(this).val();
            catalogList.load();

        }
    });

    //Выбор фильтра
    $('.catalog-list-filters').on('ifToggled', 'input[type=checkbox]', function(event){

        var section = $(this).closest('.section'),
            index = section.data('id');
        if(!catalogList.params.prop) catalogList.params.prop = {};
        if(!catalogList.params.prop[index]){
            catalogList.params.prop[index] = [];
        }

        if($(this).prop('checked')){
            catalogList.params.prop[index].push($(this).val());
            section.addClass('active').closest('.catalog-list-filters').addClass('active');
        }else{
            for (var i=0; i < catalogList.params.prop[index].length;i++){
                var value = catalogList.params.prop[index][i];
                if(value == $(this).val()) catalogList.params.prop[index].splice(i, 1);
            }
            if(!catalogList.params.prop[index].length){
                section.removeClass('active');
                delete catalogList.params.prop[index];
            }

            if($.isEmptyObject(catalogList.params.prop)){
                section.closest('.catalog-list-filters').removeClass('active');
            }
        }
        catalogList.params.page = 1;
        catalogList.load();
    });

    //Сброс секции фильтров
    $('.catalog-list-filters .reset').on('click', function(){
        var section = $(this).closest('.section'),
            inputs = section.find('input[type=checkbox]')
            ;

        section.removeClass('active');
        inputs.prop('checked', false).parent().removeClass('checked');
        if(section.data('id') && catalogList.params.prop[section.data('id')]) delete catalogList.params.prop[section.data('id')];
        catalogList.params.page = 1;
        if(section.find('input[name^=price]')){
           delete catalogList.params.price_from;
           delete catalogList.params.price_to;
           var value = $('#price-range-slider');
           $('#price-range-slider').slider('value', parseInt($('#price-range-slider').data('min_price')), parseInt($('#price-range-slider').data('max_price')));
            section.find('input[name^=price]').val('');
        }
        catalogList.load();

    });

    //Сброс всех фильтров
    $('#resetAllFilters').on('click', function(e){
        e.preventDefault();
        catalogList.resetFilters();
        catalogList.load(function(){
            Vostok.scrollTo($('#content .catalog-block'));
           ;
        });
    });








})