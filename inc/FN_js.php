<?php



/**
 * Description of FN_js_kit
 *
 * @author studio
 */
abstract class FN_js {

    private $js_settings = array(),
            $container_name;

    public function set_container_name($class_name) {
        $this->container_name = $class_name;
    }

    public function get_container_name() {
        return $this->container_name;
    }



    public function get_js_settings() {
        return $this->js_settings;
        return $this;
    }




    public function set_js_settings($js_settings = array()) {
        $this->js_settings = $js_settings;
    }



    /**
     * Locates a resource in the library file
     * <code> <?php echo cwp::locate_in_libary('myfile.css','css') ?> </code>
     * @param string $filename
     * @param string $dir default- css
     * @return string
     */
    public function locate_in_library($filename = null, $dir = 'css') {
        if (isset($filename)):
            $filepath = 'library/' . $dir . '/' . $filename;
            if (file_exists(get_stylesheet_directory() . '/' . $filepath)):
                $file = get_stylesheet_directory_uri() . '/' . $filepath;
            elseif (file_exists(get_template_directory_uri() . '/' . $filepath)):
                $file = get_template_directory() . '/' . $filepath;
            elseif (CWP_PATH . '/' . $filepath):
                $file = CWP_URL . '/' . $filepath;
            endif;
            return $file;
        endif;
    }

    public function run() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_footer', array($this, 'footer_scripts'));
        add_action('wp_head', array($this, 'head_scripts'));
    }

    public abstract function enqueue_scripts();

    public abstract function footer_scripts();

    public abstract function head_scripts();
}


/**
 * Masonry class.
 */
class FN_js_masonry extends FN_js {

    private $container_id = 'masonry',
            $item_selector = 'span4',
            $columns = 3;

    public function set_columns($columns) {
        $this->columns = $columns;
        return $this;
    }

    public function set_container_id($container_id) {
        $this->container_id = $container_id;
        return $this;
    }

    public function set_item_selector($item_selctor) {
        $this->item_selector = $item_selctor;
        return $this;
    }

    public function get_container_id() {
        return $this->container_id;
    }


    public function get_item_selector() {
        return $this->item_selector;
    }

    public function __construct($class_name) {

        /*
         * add masonry-page calls to the body
         */
        add_filter('body_class', array($this, 'masonry_page'));
        $this->set_container_name($class_name);
    }

    public static function factory($class_name = 'masonry'){
        $factory = new FN_js_masonry($class_name);
        $factory->enqueue_scripts();
        return $factory;
    }

    public function masonry_page($classes){
        $classes[] = 'masonry-page';
        return $classes;
    }

    /**
     * run masonry
     * @param type $item_selector
     * @param type $container_id
     * @return \FN_js_masonry
     */
    public function run_masonry($item_selector = 'span4',$container_id = 'masonry' ){
        $this->container_id = $container_id;
        $this->item_selector = $item_selector;
        $this->run();
        return $this;

    }

    public function enqueue_scripts() {
        wp_register_script('masonry', $this->locate_in_library('jquery.masonry.min.js', 'masonry'), array('jquery'));
        if (!is_admin()) wp_enqueue_script('masonry');
    }

    public function footer_scripts() {
        ?>
 <!-- Once the page is loaded, initalize the plug-in. -->
                 <script type="text/javascript">
             jQuery.noConflict();
             (function($) {
                 $(window).load(function(){
                     $('#<?php echo $this->get_container_name(); ?>').masonry({
                         itemSelector: '.<?php echo $this->item_selector ?>',
                         // set columnWidth a fraction of the container width
                         columnWidth: function( containerWidth ) {
                             return containerWidth / <?php echo $this->columns; ?>;
                         }

                     },
                     function() { $(this).css({
                             //margin: '0 0 80px 0'
                         });
                     });
                 });
             })(jQuery);

         </script>
        <?php

    }



    public function head_scripts() {
        return false;
    }




}

/**
 * FN curtains
 *
 */
class FN_js_curtains extends FN_js {


    public function __construct() {

    }

    public static function factory($class_name ='curtains'){
        $factory = new FN_js_curtains();
        $factory->set_container_name($class_name);
        return $factory;
    }

    public function enqueue_scripts() {

        wp_register_script('curtains_js', $this->locate_in_library('curtain.js', 'curtains'), array('jquery'));
        if (!is_admin())
            wp_enqueue_script('curtains_js');
        wp_register_style('curtains-css', $this->locate_in_library('curtain.css', 'curtains'));
        wp_enqueue_style('curtains-css');

    }

    private $scollSpeed = '450',
            $controls = 'curtains-menu',
            $curtainsLinks = 'curtain-links';

    public function set_scollSpeed($scollSpeed) {
        $this->scollSpeed = $scollSpeed;
        return $this;
    }


    public function set_controls($controls) {
        $this->controls = $controls;
        return $this;
    }


    public function set_curtainsLinks($curtainsLinks) {
        $this->curtainsLinks = $curtainsLinks;
        return $this;
    }



    public function footer_scripts() {
        ?>
             <!-- Once the page is loaded, initalize the plug-in. -->
             <script type="text/javascript">
                 jQuery.noConflict();

                 jQuery(function(){
                     jQuery('.<?php echo $this->get_container_name(); ?>').curtain({
                         scrollSpeed: <?php echo $this->scollSpeed ?>,
                         controls: '.<?php echo $this->controls ?>',
                         curtainLinks: '.<?php echo $this->curtainsLinks ?>'
                     });
                 });
             </script>
        <?php
    }

    public function head_scripts() {
        return false;

    }

}


/**
 * Flex Slider
 * @license https://github.com/woothemes/FlexSlider
 */
class FN_js_flex_slider extends FN_js {



    public static function factory($container_name = 'flexslider'){
        $factory = new FN_js_flex_slider($container_name);
        return $factory;
    }


    function __construct($container_name) {
        $this->set_container_name($container_name);
    }

    public function enqueue_scripts() {
        wp_register_script('flex-slide', $this->locate_in_library('jquery.flexslider-min.js', 'flex-slider'), array('jquery'));
        wp_register_style('flex-style', $this->locate_in_library('flexslider.css', 'flex-slider'));
        wp_enqueue_script('flex-slide');
        wp_enqueue_style('flex-style');
    }

    private $animation = 'fade',
            $directionNav = 'true',
            $randomize = 'true',
            $pauseOnHover = 'true',
            $slideShow = 'true',
            $slideShowSpeed = '7000',
            $direction = 'horizontal';



    public function set_direction($direction) {
        $this->direction = $direction;
        return $this;
    }

    public function set_animation($animation) {
        $this->animation = $animation;
        return $this;
    }


    public function set_directionNav($directionNav) {
        $this->directionNav = $directionNav;
        return $this;
    }


    public function set_pauseOnHover($pauseOnHover) {
        $this->pauseOnHover = $pauseOnHover;
        return $this;
    }


    public function set_slideShow($slideShow) {
        $this->slideShow = $slideShow;
        return $this;
    }


    public function set_slideShowSpeed($slideShowSpeed) {
        $this->slideShowSpeed = $slideShowSpeed;
        return $this;
    }


    public function set_randomize($randomize) {
        $this->randomize = $randomize;
        return $this;
    }



    public function footer_scripts() {
        ?>
                <!-- Place in the <head>, after the three links -->
                <script type="text/javascript" charset="utf-8">
                    jQuery(window).load(function() {
                        jQuery('.<?php echo $this->get_container_name(); ?>').flexslider({
                            animation: "<?php echo $this->animation; ?>",
                            directionNav : <?php echo $this->directionNav ?>,
                            randomize : <?php echo $this->randomize ?>,
                            pauseOnHover : <?php echo $this->pauseOnHover ?>,
                            touch : true,
                            direction : "<?php echo $this->direction ?>",
                            slideShow : <?php echo $this->slideShow ?>,
                            slideShowSpeed : <?php echo $this->slideShowSpeed ?>
                        });
                    });
                 </script>

        <?php
    }

    public function head_scripts() {
        return false;
    }

}


/**
 * @link http://jobyj.in/adipoli
* Adipoli is a simple jQuery plugin used to bring stylish image hover effects.
 */
class FN_js_adipoli extends FN_js {

    private $startEffect = 'overlay',
            $hoverEffect = 'popout';

    public function set_startEffect($startEffect) {
        $this->startEffect = $startEffect;
        return $this;
    }


    public function set_hoverEffect($hoverEffect) {
        $this->hoverEffect = $hoverEffect;
        return $this;
    }



    public function __construct($class_name) {

                         $this->set_container_name($class_name);
                     }

    public static function factory($class_name = 'adipoli'){
        $factory = new FN_js_adipoli($class_name);
        return $factory;
    }

    public function enqueue_scripts() {
        wp_register_script('adipoli', cwp::locate_in_library('jquery.adipoli.min.js', 'adipoli-v2'), array('jquery'),false,TRUE);
        wp_register_style('adipoli-style', cwp::locate_in_library('adipoli.css', 'adipoli-v2'));
        wp_enqueue_script('adipoli');
        wp_enqueue_style('adipoli-style');
    }

    public function footer_scripts() {
        ?>
        <script type="text/javascript" charset="utf-8">

        jQuery(document).ready(function($) {
            $('.<?php echo $this->get_container_name(); ?>').adipoli({
                'startEffect' : '<?php echo $this->startEffect ; ?>',
                'hoverEffect' : '<?php echo $this->hoverEffect ?>'
            });
        });
    </script>

    <?php

    }

    public function head_scripts() {
        return false;
    }

}