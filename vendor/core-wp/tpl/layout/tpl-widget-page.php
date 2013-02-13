<?php
/**
 * @package WordPress
 * @subpackage CORE-SF
 */

wp_enqueue_script('masonry');
function widget_masonry() {
    /** masonry config * */
    $arr['itemselector'] = 'widgets';
    $arr['singlemode'] = 'true';
    masonry::config($arr);
}

?>
<?php
cwp_layout::header();
cwp_layout::theme_header();
?>
<section id="content">
    <div class="wrapper"><!-- container -->
        <div class="container"><!-- container -->
            <div class="tweleve columns"><!-- container -->
                <section id="articles">
                    <?php cwp_layout::main_tpl(); ?>
                </section>
                <section id="page-widgets">
                    <?php dynamic_sidebar('widget-page') ?>
                </section>
            </div>
            <div class="clear">Cleared</div>
        </div>
    </div>
    <div class="clear">Cleared</div>
</section>
<?php cwp_layout::theme_footer(); ?>
<?php cwp_layout::footer() ?>
