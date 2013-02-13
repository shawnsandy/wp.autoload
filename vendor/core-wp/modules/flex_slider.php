<?php
/**
 * @package WordPress
 * @subpackage Core-WP
 * @author shawnsandy
 */

/**
 * Description of flex_slider
 *
 * @author Studio365
 */
class flex_slider {

    //put your code here
    public function __construct() {

    }

    public static function config($array=array()) {
        extract($array);
        include CM_PATH . "/flex-slider/config.php";
    }

    public static function load() {
        $js = CM_URL .'/flex-slider/js/jquery.flexslider-man.js';
        $style = CM_URL .'/flex-slider/css/flexslider.css';
        wp_enqueue_script('flex-slider', $js, array('jquery'));
        wp_enqueue_style('flex-slider', $style);
    }

    public static function tpl($query='showposts=3', $data=array('class'=>'flexslider'), $tpl="flex-slider-index") {
        ?>
        <div class="flexslider-container">
            <div class="flexslider">
                <ul class="slides">
                    <?php
                    $fx_query = new WP_Query($query);
                    if ($fx_query->have_posts()) :
                        while ($fx_query->have_posts()):
                        $fx_query->the_post();
                            core_module::tpl($tpl, 'flex-slider', $data);
                        endwhile;
                    endif; wp_reset_query();
                    ?>
                </ul>
            </div>
        </div>
        <?php
    }

}
?>
