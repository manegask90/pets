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



        // Filtr
        jQuery(document).ready(function($) {
            $('.posts_filter-list .filter a').on('click', function (e) {
                e.preventDefault();
                var $that = $(this),
                    $type = $that.attr('data-type'),
                    $newsWrap = $('.news_posts_wrap'),
                    $mainPostId = $newsWrap.attr('data-main-post');
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
    </script>
</body>
</html>




<!-- Modal -->
<div class="modal fade" id="sidebarModal" tabindex="-1" role="dialog" aria-labelledby="sidebarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
