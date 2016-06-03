var counterRequest = false;

var onCounterChange = function(val, elem){
    var container = elem.closest('article'),
        id =  container.data('prop-id')
        ;
    if(counterRequest) counterRequest.abort();
    counterRequest = $.ajax({ url: '/cart/?update', data: {id: id, count: val}, type: 'post', dataType: 'json',
        beforeSend: function(){
            Vostok.blockOverlay($('#content .order-block'));
        },
        success: function(data){
            Cart.render(data);
        }

    });
}

$(function(){
    $('div.rating-dis').raty({
      score: function() {
        return $(this).attr('data-score');
      },
      path:'/images',
      readOnly   : true
  });

  $('.wrp-rating-dis').fancybox({
      onClosed: function() {
      }
  });

  $(document).on("click", "#basket_issue_order3", send_form);

  function send_form () {
    if ($('#modal_text_otz').val()){
      $.post("/carlsberg_feedback.php", $("#modal_form").serialize(), onAjaxSuccess);
      return false;
    } 
    return;
  }
  
  function onAjaxSuccess (r) {
    $("#place_for_insert").html('Ваша отзыв принят!');
    $("#modal_form").remove();
  }

    $(".buy_this_item").on('click', function(){
            var $this = $(this), 
                item = $this.attr('data-item')
                price = $this.attr('data-price'),
                type  = $this.attr('data-type'),
                quantity = 1;
                
            $.ajax({
                  type: 'GET',
                  url: '/index.php',
                  data: {'add_to_cart':1,'item':item,'quantity':quantity,'type':type},
                  cache: false,
                  success: function(response)
                  {
                      if (response==1)
                      {
                          update_common_price(price, quantity, '+', type);
                          $($this).replaceWith(function(index, oldHTML)
                          {
                              return $('<a data-type="carlsberg" href="/carlsberg/zakaz_i_dostavka.html" class="readmore carlsberg">Корзина</a>');
                          });

                      }
                  }
            });
        });

    function update_common_price(price, quantity, sign, type)
    {
      var $basket = !type ?  $('span', $('.header-cart')) : $('span', $('.header-cart-carlsberg'));
      var common_count = $basket.html();
    
      if (sign=='+')
      {
          common_count = +common_count + +quantity;
      }

        $basket.html(common_count);
    }
});