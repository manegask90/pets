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
    </script>
</body>
</html>
