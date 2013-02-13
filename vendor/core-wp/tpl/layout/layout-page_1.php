<?php
/**
 *
 * @package WordPress
 * @subpackage basejump 5
 */

/*
  Template Name: Layout Page
 */


/**
 * theme page functions
 * just made more sense putting it here to me...
 * other options - use wp conditionals or load on every page
 * i try to avoid conditionals where ever i can
 * i dont have to go through a function file with 100s line of code
 * ...
 */

add_action('wp_header', 'tp_header');
add_action('wp_footer', 'tp_footer');

function tp_header(){

}

function tp_footer(){

}

?>
<?php get_header();
 cwp_layout::theme_header();
//cwp::get_theme_header(); ?>
<section id="content">
    <div class="container"><!-- container -->
        <div class="row"><!-- container -->
            <div class="eight columns"><!-- container -->
                <section id="articles">
                    <?php cwp::get_tpl(); ?>
                </section>
            </div>
            <div class="four columns"><!-- container -->
                <section id="sidebar">
                    <?php get_sidebar(); ?>
                </section><!-- #sidebar -->
            </div>
            <div class="clear">Cleared</div>
        </div>
    </div>
    <div class="clear">Cleared</div>
</section>
<?php
cwp_layout::theme_footer();
//cwp::get_theme_footer(); ?>
<?php get_footer() ?>