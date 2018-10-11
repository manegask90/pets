// jQuery(function($){
//     $(document).on('click', '#true_loadmore', function(){
//         $(this).text('Загружаю...');
//         var data = {
//             'action': 'loadmore',
//             'query': true_posts,
//             'page' : current_page
//         };
//         $.ajax({
//             url:ajaxurl,
//             data:data,
//             type:'POST',
//             success:function(data){
//                 if( data ) {
//                     $('#true_loadmore').text('Загрузить ещё').before(data);
//                     current_page++;
//                     if (current_page == max_pages) $("#true_loadmore").remove();
//                 } else {
//                     $('#true_loadmore').remove();
//                 }
//             }
//         });
//     });
// });


jQuery(function($){
    $(window).scroll(function(){
        var bottomOffset = 2000; // отступ от нижней границы сайта, до которого должен доскроллить пользователь, чтобы подгрузились новые посты
        var data = {
            'action': 'loadmore',
            'query': true_posts,
            'page' : current_page
        };
        if( $(document).scrollTop() > ($(document).height() - bottomOffset) && !$('body').hasClass('loading')){
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
                        $('#true_loadmore').before(data);
                        $('body').removeClass('loading');
                        current_page++;
                    }
                }
            });
        }
    });
});