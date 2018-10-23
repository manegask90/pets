<?php
/*
Template Name: Search Page
*/
get_header(); ?>

<div id="main-content">
	<div class="container">
		<div class="row">
		<?php
//        $args = array(
//            'posts_per_page' => -1,
//        );
//        query_posts($args);
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
					$post_format = et_pb_post_format(); ?>

					<div id="post-<?php the_ID(); ?>" <?php post_class( 'col-md-3 col-sm-6 et_pb_post' ); ?>>
                        <a href="<?php the_permalink(); ?>" class="">
                            <div class="blog_item">
                                <div class="img-wrapper">
                                    <?php the_post_thumbnail(); ?>
                                </div>
                                <div class="content">
                                    <div class="date">
                                        <h5 class="date_txt"><span><?php echo get_the_date('j. m. Y'); ?></span></h5>
                                    </div>
                                    <div class="content-text">
                                        <h4 class="event_tittle"><?php the_title() ?></h4>
                                        <div class="event_brief test"><?php echo kama_excerpt(array('maxchar'=>100)); ?></div>
                                    </div>
                                </div>
                            </div>
                        </a>
					</div> <!-- .et_pb_post -->
			<?php
					endwhile;

					if ( function_exists( 'kama_pagenavi' ) ) {?>
                        <div class="col-md-12 wp-pagenavi-wrap">
                            <?php kama_pagenavi(); ?>
                        </div>
            <?php } else {
						get_template_part( 'includes/navigation', 'index' );}
				else :
					get_template_part( 'includes/no-results', 'index' );
				endif;

			?>

			<?php //get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php

get_footer();
