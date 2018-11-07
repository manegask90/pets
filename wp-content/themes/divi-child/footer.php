<?php
/**
 * Fires after the main content, before the footer is output.
 *
 * @since 3.10
 */
do_action( 'et_after_main_content' );

if ( 'on' == et_get_option( 'divi_back_to_top', 'false' ) ) : ?>

	<span class="et_pb_scroll_top et-pb-icon"></span>

<?php endif;

if ( ! is_page_template( 'page-template-blank.php' ) ) : ?>

			<footer id="main-footer" class="main_footer">
				<?php get_sidebar( 'footer' ); ?>
			</footer> <!-- #main-footer -->
		</div> <!-- #et-main-area -->

<?php endif; // ! is_page_template( 'page-template-blank.php' ) ?>

	</div> <!-- #page-container -->

	<?php wp_footer(); ?>


    <script>
        new UISearch( document.getElementById( 'sb-search' ) );

        jQuery(document).ready(function(){
            jQuery('form.newsletter').find("input[type=email]").each(function(ev)
            {
                if(!jQuery(this).val()) {
                    jQuery(this).attr("placeholder", "enter e-mail");
                }
            });
        });

        jQuery( '.advice_item' ).hover(
            function() {
                $( this ).addClass('active');
            }, function() {
                $( this ).removeClass('active');
            }
        );



        // Filtr stories
        jQuery(document).ready(function($) {
            $('#filter-list-stories .filter a').on('click', function (e) {
                e.preventDefault();
                var $that = $(this),
                    $type = $that.attr('data-type'),
                    $newsWrap = $('.news_posts_wrap'),
                    $mainPostId = $newsWrap.attr('data-main-post'),
                    $catId = $newsWrap.attr('data-cat');
                if (!$that.hasClass('active')) {
                    $('#filter-list-stories .filter a').removeClass('active');
                    $that.addClass('active');
                    setCookie('type', $type);
                    var data = {
                        'type': $type,
                        action: 'stories_filtr',
                    };
                    if ($mainPostId) {
                        data['mainPostId'] = $mainPostId;
                    }
                    if ($catId) {
                        data['catId'] = $catId;
                    }
                    $.ajax({
                        type: "POST", //Метод отправки
                        url: MyAjax.ajaxurl, //путь до php фаила отправителя
                        data: data,
                        success: function (response) {
                            $newsWrap.html(response);
                        }
                    });
                }

            });
        });

        // Filtr advices
        jQuery(document).ready(function($) {
            $('#filter-list-advices .filter a').on('click', function (e) {
                e.preventDefault();
                var $that = $(this),
                    $type = $that.attr('data-type'),
                    $newsWrap = $('.news_posts_wrap'),
                    $mainPostId = $newsWrap.attr('data-main-post'),
                    $catId = $newsWrap.attr('data-cat');
                if (!$that.hasClass('active')) {
                    $('#filter-list-advices .filter a').removeClass('active');
                    $that.addClass('active');
                    setCookie('type', $type);
                    var data = {
                        'type': $type,
                        action: 'advices_filtr',
                    };
                    if ($mainPostId) {
                        data['mainPostId'] = $mainPostId;
                    }
                    if ($catId) {
                        data['catId'] = $catId;
                    }
                    $.ajax({
                        type: "POST", //Метод отправки
                        url: MyAjax.ajaxurl, //путь до php фаила отправителя
                        data: data,
                        success: function (response) {
                            $newsWrap.html(response);
                        }
                    });
                }

            });
        });

        // Filtr
        jQuery(document).ready(function($) {
            $('.posts_filter-list .filter a').on('click', function (e) {
                e.preventDefault();
                var $that = $(this),
                    $type = $that.attr('data-type'),
                    $newsWrap = $('.news_posts_wrap'),
                    $mainPostId = $newsWrap.attr('data-main-post'),
                    $catId = $newsWrap.attr('data-cat');
                if (!$that.hasClass('active')) {
                    $('.posts_filter-list .filter a').removeClass('active');
                    $that.addClass('active');
                    setCookie('type', $type);
                    var data = {
                        'type': $type,
                        action: 'news_filtr',
                    };
                    if ($mainPostId) {
                        data['mainPostId'] = $mainPostId;
                    }
                    if ($catId) {
                        data['catId'] = $catId;
                    }
                    $.ajax({
                        type: "POST",
                        url: MyAjax.ajaxurl,
                        data: data,
                        success: function (response) {
                            $newsWrap.html(response);
                        }
                    });
                }

            });
        });


        function setCookie(name, value, options) {
            options = options || {};

            var expires = options.expires;

            if (typeof expires == "number" && expires) {
                var d = new Date();
                d.setTime(d.getTime() + expires * 1000);
                expires = options.expires = d;
            }
            if (expires && expires.toUTCString) {
                options.expires = expires.toUTCString();
            }

            value = encodeURIComponent(value);

            var updatedCookie = name + "=" + value;

            for (var propName in options) {
                updatedCookie += "; " + propName;
                var propValue = options[propName];
                if (propValue !== true) {
                    updatedCookie += "=" + propValue;
                }
            }

            document.cookie = updatedCookie;
        }

        // Input file
        jQuery(function(){

            jQuery(".wpcf7-file").change(function(){
                // var val = jQuery(this).val();
                var val = jQuery(".wpcf7-file")[0].files[0],
                    name = val.name;
                jQuery('.file_text .text').text(name);
            });

        });




        // Filtr events
        jQuery(document).ready(function($) {
            $('.event-filtr select').change(function (e) {
                e.preventDefault();
                var $thatSelect = $(this),
                    $selectedMonth = $('.filtr-select-month option:selected').val(),
                    $selectedCity  = $('.filtr-select-city option:selected').val(),
                    $selectedCityText  = $('.filtr-select-city option:selected').text(),
                    $eventsWrap    = $('.events_posts_wrap');
                if(jQuery(this).hasClass('filtr-select-city')){
                    jQuery('.span-city').text($selectedCityText);
                }

                setCookie('select-month', $selectedMonth);
                setCookie('select-city', $selectedCity);
                var data = {
                    'select-month': $selectedMonth,
                    'select-city':  $selectedCity,
                    action: 'events_filtr',
                };
                $.ajax({
                    type: "POST", //Метод отправки
                    url: MyAjax.ajaxurl, //путь до php фаила отправителя
                    data: data,
                    success: function (response) {
                        $eventsWrap.html(response);
                    }
                });

                if (!$thatSelect.hasClass('active')) {
                }

            });
        });

        // Bxslider
        jQuery(document).ready(function($) {
        //     $('.slider').bxSlider({
        //         pager: true,
        //         minSlides: 4,
        //         maxSlides: 4,
        //         moveSlides: 1,
        //         slideWidth: 320,
        //         controls: false,
        //     });
        // });
            // var mySlider, settings1 = {
            //         pager: true,
            //         minSlides: 4,
            //         maxSlides: 4,
            //         moveSlides: 1,
            //         slideWidth: 320,
            //         controls: false,
            //     touchEnabled:true
            // }, settings2 = {
            //     pager: true,
            //     minSlides: 2,
            //     maxSlides: 2,
            //     moveSlides: 0,
            //     slideWidth: 320,
            //     controls: false,
            //     touchEnabled:true
            // };
            // function settings() {return ($(window).width() > 575) ? settings1:settings2;}
            // mySlider = $('.slider').bxSlider(settings());
            // function tourLandingScript() {
            //     mySlider.reloadSlider($.extend(settings()));
            // }
            // $(window).resize(tourLandingScript);

            var width = $(document).width(),
                ttCarousel,
                ttCarousel_Config = {
                    pager: true,
                    minSlides: 2,
                    maxSlides: 2,
                    moveSlides: 3,
                    slideWidth: 320,
                    controls: false,
            },
                ttCarousel_Config_md = {
                    pager: true,
                    minSlides: 3,
                    maxSlides: 3,
                    moveSlides: 3,
                    slideWidth: 320,
                    controls: false,
                };
            if( width < 576) {
                ttCarousel = jQuery('.slider').bxSlider(ttCarousel_Config);
                console.log(width);
            } else if ( width < 1200 ) {
                ttCarousel = jQuery('.slider').bxSlider(ttCarousel_Config_md);
                console.log(width);
            } else {
                ttCarousel = jQuery('.slider').bxSlider({
                    pager: true,
                    minSlides: 4,
                    maxSlides: 4,
                    moveSlides: 3,
                    slideWidth: 320,
                    controls: false,
                });
                console.log('else');
            }

            // jQuery(window).resize(function() {
            //     if( jQuery(window).width() > carouselWidth) {
            //         if(ttCarousel) {
            //             ttCarousel.reloadSlider();
            //             console.log('reloading');
            //         } else {
            //             ttCarousel = jQuery('.event-carousel').bxSlider(ttCarousel_Config);
            //         }
            //     } else {
            //         if(ttCarousel) {
            //             ttCarousel.destroySlider();
            //             console.log('destroying');
            //         }
            //     }
            // });
        });

        <!--Viber share-->
        var text = "";
        var shareButtons = jQuery('.viber_share');
        shareButtons.each(function () {
            var shareLink = jQuery(this).closest('.blog_item').find('.blog_news_link').attr('href');
            jQuery(this).attr("href", "https://3p3x.adj.st/?adjust_t=u783g1_kw9yml&adjust_fallback=https%3A%2F%2Fwww.viber.com%2F%3Futm_source%3DPartner%26utm_medium%3DSharebutton%26utm_campaign%3DDefualt&adjust_campaign=Sharebutton&adjust_deeplink=" + encodeURIComponent("viber://forward?text=" + encodeURIComponent(text + " " + shareLink) ) );
        });



        <!--Telegram share-->
        var href_tel = jQuery('a.blog_news_link').attr('href');
        var shareButtonsTelegram = jQuery('.telegram-share');
        shareButtonsTelegram.each(function () {
            var shareLinkTelegram = jQuery(this).closest('.blog_item').find('.blog_news_link').attr('href');
            jQuery(this).attr("href", "https://telegram.me/share/url?url=" + encodeURIComponent(shareLinkTelegram));
        });



        // Form validator
        jQuery(document).ready(function($) {
            $('.newsletter .tnp-email').keyup(function() {
                if($(this).val() != '') {
                    var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
                    var mail = $('.newsletter .tnp-email');
                    if(pattern.test($(this).val())){
                        $(this).parents('.newsletter').removeClass('error').addClass('valid');
                        console.log('ok');
                    } else {
                        $(this).parents('.newsletter').removeClass('valid').addClass('error');
                        console.log('error');

                    }
                } else {
                    // $(this).css({'border' : '1px solid #ff0000'});
                    // $('#valid').text('Поле email не должно быть пустым');
                }
            });
        });

        // Hover search
        jQuery( ".sb-search" ).hover(
            function() {
                jQuery( this ).addClass( "search-hover" );
            }, function() {
                jQuery( this ).removeClass( "search-hover" );
            }
        );
</script>
</body>
</html>




<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="sidebarModal" tabindex="-1" role="dialog" aria-labelledby="sidebarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">НАПИСАТИ РЕДАКТОРУ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo do_shortcode( ' [contact-form-7 id="325" title="Contact form news"] ' ); ?>
            </div>
        </div>
    </div>
</div>
