$(function(){

    $('#content .services-short-list article > header > h2').on('click', function(e){
       var elem = $(this),
           parent = elem.closest('article')
       ;

       if(parent.hasClass('active')) return false;
       parent.siblings('.active').find('div').slideUp(300).end().removeClass('active');

       parent.addClass('active').find('div').slideDown(200);


    }).eq(0).click();

    if($('#content .catalog-main').length){
        $$.resolution(function(e, resolution){
            if(resolution <= 600 && !$('#content .catalog-main').hasClass('interchange')){
               var left = $('#content .catalog-main .left-content');
               //var right = $('#content .catalog-main .right-content');
                $('#content .catalog-main').addClass('interchange');
               left.insertAfter(left.next());
            }else if($('#content .catalog-main').hasClass('interchange') && resolution > 600 ){
                var left = $('#content .catalog-main .left-content');
                $('#content .catalog-main').removeClass('interchange');
                left.insertBefore(left.prev());
            }
        });
    }

});