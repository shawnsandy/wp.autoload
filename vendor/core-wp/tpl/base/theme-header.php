<!-- ###### -->
<div id="page">
<nav id="top" class="container">

        <div class="row">
            <div class="twelve columns">
                <?php wp_nav_menu(array('theme_location' => 'primary', 'fallback_cb' => 'base_default_menu')); ?>
                <!-- ###end-row### -->
            </div>
        </div>
        <!-- container -->

</nav>
    <!-- class content -->
<section id="header" class="container">

        <div class="row">
            <div class="four columns">
                <!-- class content -->
                <hgroup>
                    <h1 id="site-title"><span>
                            <a href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
                                <?php //bloginfo('name'); ?>
                                <img src="<?php echo cwp::logo(); ?>" alt="<?php bloginfo('name'); ?>" />
                            </a></span>
                    </h1>
                </hgroup>
            </div>
            <div class="eight columns">
                <div class="social">
                    <a href="<?php the_author_meta('twitter', 1); ?>">
                        <img src="<?php echo get_template_directory_uri() ?>/images/twitter.png" /></a>
                    <a href="<?php the_author_meta('facebook', 1); ?>">
                        <img src="<?php echo get_template_directory_uri() ?>/images/facebook.png" /></a>
                    <a href="<?php the_author_meta('google_plus', 1); ?>">
                        <img src="<?php echo get_template_directory_uri() ?>/images/google.png" /></a>
                    <a href="<?php the_author_meta('linkedin', 1); ?>
                       "><img src="<?php echo get_template_directory_uri() ?>/images/linkedin.png" /></a>
                    <a href="http://feeds.feedburner.com/<?php the_author_meta('feedburner_page', 1); ?>">
                        <img src="<?php echo get_template_directory_uri() ?>/images/rss.png" /></a>
                    <!-- class content -->
                </div>
                <!-- ###### -->
                <!-- class content -->

            </div>
            <!-- class content -->

        </div>
        <!-- class content -->



</section>

