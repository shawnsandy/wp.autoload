<?php
/**
 * theme page functions
 * just made more sense putting it here to me...
 * other options - use wp conditionals or load on every page
 * i try to avoid conditionals where ever i can
 * i dont have to go through a function file with 100s line of code
 * ...
 */

wp_enqueue_script('flex-slider');
wp_enqueue_style('flex-slider');
?>

<?php cwp_layout::header() ?>
<?php cwp_layout::theme_header(); ?>
<section>
    <div id="slider">
        <div class="container">
            <div class="row">
                <!-- container -->
                <div class="twelve">
                    <section id="flex-slider">
                        <div class="flexslider">
                            <ul class="slides">
                                <?php
                                $fx_args = array('numberposts'=>5,'post_type'=>'featured');
                                $fx_query = new WP_Query($fx_args);
                                ?>
                                <?php if($fx_query->have_posts()):
                                    while($fx_query->have_posts()): $fx_query->the_post(); ?>
                                <li>
                                    <a href="<?php echo esc_attr(the_permalink()); ?>">
                                     <?php the_post_thumbnail('slideshow-960'); ?>
                                    </a>
                                    <p class="flex-caption"><?php the_title() ?></p>
                                </li>
                                    <?php endwhile; ?>
                                <?php else : ?>

                                <li>
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/images/3-trunk.jpg" />
                                    <p class="flex-caption">Captions and cupcakes. Winning combination.</p>
                                </li>
                                <li>
                                    <a href="http://flex.madebymufffin.com">
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/images/pool.jpg" />
                                    </a>
                                    <p class="flex-caption">This image is wrapped in a link!</p>
                                </li>
                                <li>
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/images/old-boat.jpg" />
                                </li>
                                <?php endif;
                                wp_reset_postdata(); ?>
                            </ul>
                        </div>
                        <!--end slider-->
                    </section>
                </div>
                <div class="clear">Cleared</div>
            </div>
        </div>

    </div>

</section>
<section id="content">
<?php cwp_layout::main_tpl(); ?>
</section>
    <?php cwp_layout::theme_footer(); ?>
    <?php cwp_layout::footer(); ?>