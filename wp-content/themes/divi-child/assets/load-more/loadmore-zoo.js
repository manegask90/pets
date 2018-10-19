// Zoo
jQuery(function($){
    $(window).scroll(function(){
        var bottomOffset = 1500; // отступ от нижней границы сайта, до которого должен доскроллить пользователь, чтобы подгрузились новые посты

        if( $(document).scrollTop() > ($(document).height() - bottomOffset) && !$('body').hasClass('loading')){
            var posts_counter = jQuery('#main-content div.type-post').length;
            var data = {
                'posts_counter': posts_counter,
                'action': 'loadmore-zoo',
                'query': true_posts_zoo,
                'page' : current_page
            };

            $.ajax({

                url:ajaxurl,
                data:data,
                type:'POST',
                beforeSend: function( xhr){
                    $('body').addClass('loading');
                    $('#loader').show();
                },
                complete: function() {
                    $('#loader').hide();
                },
                success:function(data){
                    if( data ) {
                        $('#true_loadmore_zoo').before(data);
                        $('body').removeClass('loading');
                        current_page++;
                    }
                }
            });
        }
    });
});