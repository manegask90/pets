<ul class="et-social-icons">

<?php if ( 'on' === et_get_option( 'divi_show_facebook_icon', 'on' ) ) : ?>
	<li class="icons-li">
		<a href="<?php echo esc_url( et_get_option( 'divi_facebook_url', '#' ) ); ?>" class="icon">
			<i class="et-social-icon icon-fb_icon"></i>
		</a>
	</li>
<?php endif; ?>
<?php if ( 'on' === et_get_option( 'divi_show_twitter_icon', 'on' ) ) : ?>
	<li class="icons-li">
		<a href="<?php echo esc_url( et_get_option( 'divi_twitter_url', '#' ) ); ?>" class="icon">
		    <i class="et-social-icon icon-viber_icon"></i>
        </a>
	</li>
<?php endif; ?>
<?php if ( 'on' === et_get_option( 'divi_show_google_icon', 'on' ) ) : ?>
	<li class="icons-li">
		<a href="<?php echo esc_url( et_get_option( 'divi_google_url', '#' ) ); ?>" class="icon">
		    <i class="et-social-icon icon-telegram_icon"></i>
        </a>
	</li>
<?php endif; ?>
<?php if ( 'on' === et_get_option( 'divi_show_rss_icon', 'on' ) ) : ?>
<?php
	$et_rss_url = '' !== et_get_option( 'divi_rss_url' )
		? et_get_option( 'divi_rss_url' )
		: get_bloginfo( 'rss2_url' );
?>
	<li class="et-social-icon et-social-rss">
		<a href="<?php echo esc_url( $et_rss_url ); ?>" class="icon">
			<span><?php esc_html_e( 'RSS', 'Divi' ); ?></span>
		</a>
	</li>
<?php endif; ?>

</ul>