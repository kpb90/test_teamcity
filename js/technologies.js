$(function(){

    $(".technology-tabs a").on('click', function(e){
        e.preventDefault();
        if(!$(this).hasClass("active")){
            var cssClass = $(this).attr("class");
            $(".technology-list").hide();
            $(".technology-list."+cssClass).show();
            $(this).siblings('.active').removeClass("active").end().addClass('active');
        }else{
            $(this).removeClass("active");
            $(".technology-list").show();
        }
    });

    $('#technologyBlock > div.body > div.selector > div').on('click', function () {
        var elem = $(this);
        var id = elem.attr('rel');
        $('#technologyBlock > div.body > div.selector > div').removeClass('active');
        elem.addClass('active');
        $('#technologyBlock > div.body > div.container').hide();
        $("#technologyContainer" + id).show();
        var pane = $("#technologyContainer" + id).find('.page');
        var api = pane.data('jsp');

        api.reinitialise();

    });

    if($('.technology-list-section').length){
        $$.resolution(function(e, resolution){
            if(resolution <= 850){
                $('#content').addClass('no-padding');
                $('#technologyBlock').hide();
                $('#content .technology-list-section').removeClass('opened');
                $('#technology-list-button').removeClass('active');
            }else{
                $('#content .technology-list-section').removeClass('opened');
                $('#content').removeClass('no-padding');
                $('#technologyBlock').show();
                $('#technology-list-button').removeClass('active');
            }
        });

        $('#technology-list-button').on('click', function(e){
            var elem = $(this);
            if(!elem.hasClass("active")){
                elem.addClass("active");
                $('#technologyBlock').show();
                $('#content .technology-list-section').addClass('opened');
            }else{
                elem.removeClass("active");
                $('#content .technology-list-section').removeClass('opened');
                $('#technologyBlock').hide();
            }

        });
    }







});