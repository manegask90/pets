<?php
/**
 * Template Name: Calendrier
 */
?>

<?php get_header();
$mois_annee = array(
    'juillet',
    'septembre',
);

setlocale (LC_TIME, 'fr_FR');
$mois_calendar = strftime('%B');
$query_calendrier = new WP_Query( array(
    'category'    => 17
));
$has_thumb = has_post_thumbnail();

?>
    <div class="global-content">
        <?php foreach ($mois_annee as $mois): ?>
            <div class="panel-group" id="accordion-calendrier" role="tablist" aria-multiselectable="true">

                <div>
                    <?php
                    if ( $query_calendrier->have_posts() ) : while ( $query_calendrier->have_posts() ) : $query_calendrier->the_post();
                    $date = get_field('date');
                    $month = explode("/", $date)[2];
                    var_dump($month);


                    ?>

                    <div class="posts">
                        <?php echo the_title(); ?>
                    </div>


                        <?php if( have_rows('calendrier') ) : ?>
                            <?php while ( have_rows('calendrier') ) : the_row();

                                $date_debut = get_sub_field('jour_debut');
                                $date_fin = get_sub_field('jour_fin');
                                $lien_map = get_sub_field('lien_map');
                                $descr_spect = get_sub_field('description-date');
                                $mois_spectacle = explode(" ", $date_debut)[1];
                                $jour1_periode = explode(" ", $date_debut)[0];
                                $jour2_periode = explode(" ", $date_fin)[0];

                                if($mois_spectacle == $mois){ ?>


                                    <div class="col-xs-12 col-sm-6">

                                        <div class="infos-date-spectacle">
                                            <div class="date-spectacle">
                                                <?php if( !empty($date_fin) ) : ?>
                                                    Du <span><?php echo $jour1_periode; ?></span> au <span><?php echo $jour2_periode; ?></span> -
                                                <?php else : ?>
                                                    Le <span><?php echo $jour1_periode; ?></span> -
                                                <?php endif; ?>
                                            </div>
                                            <div class="lieu-spectacle">
                                                <?php if( !empty($lien_map) ): ?>
                                                    <a href="<?php echo $lien_map; ?>" targuet="_blank" title="Spectacle de la compagnie Virvolt à <?php the_sub_field('lieu'); ?>">
                                                        <?php the_sub_field('lieu'); ?>
                                                    </a>
                                                <?php
                                                else :
                                                    the_sub_field('lieu');
                                                endif;
                                                ?>
                                            </div>
                                            <?php if( !empty($descr_spect) ) : ?>
                                                <div class="description-date-spectacle">
                                                    <?php echo $descr_spect; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php }?>

                            <?php endwhile; ?>
                        <?php endif; ?>

                    <?php endwhile; endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php get_footer(); ?>