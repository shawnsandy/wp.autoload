<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mod_nivo
 *
 * @author Studio365
 */
class mod_nivo {

    private $id = 'slider',
    $boxCols = 8,
    $boxRows = 4,
    $startSlide = 0,
    $directionNav = 'true',
    $directioNavHide = 'true',
    $controlNav = 'false',
    $controlNavThumbs = 'false',
    $controlnavThumbsFromRel = 'false',
    $keyboardNav = 'true',
    $pauseOnHover = 'true',
    $captionOpacity = 0.8,
    $prevText = 'Prev',
    $nextText = 'Next',
    $effect = 'random',
    $slices = 15,
    $animSpeed = 500,
    $pauseTime = 3000,
    $theme = 'default';

    public function setTheme($theme) {
        $this->theme = $theme;
        return $this;
    }



    public function setID($class) {
        $this->id = $class;
        return $this;
    }

    public function setEffect($effect) {
        $this->effect = $effect;
        return $this;
    }


    public function setSlices($slices) {
        $this->slices = $slices;
        return $this;
    }


    public function setAnimSpeed($animSpeed) {
        $this->animSpeed = $animSpeed;
        return $this;
    }


    public function setPauseTime($pauseTime) {
        $this->pauseTime = $pauseTime;
        return $this;
    }



    public function setBoxCols($boxCols) {
        $this->boxCols = $boxCols;
        return $this;
    }

    public function setBoxRows($boxRows) {
        $this->boxRows = $boxRows;
        return $this;
    }

    public function setStartSlide($startSlide) {
        $this->startSlide = $startSlide;
        return $this;
    }

    public function setDirectionNav($directionNav) {
        $this->directionNav = $directionNav;
        return $this;
    }

    public function setDirectioNavHide($directioNavHide) {
        $this->directioNavHide = $directioNavHide;
        return $this;
    }

    public function setControlNav($controlNav) {
        $this->controlNav = $controlNav;
        return $this;
    }

    public function setControlNavThumbs($controlNavThumbs) {
        $this->controlNavThumbs = $controlNavThumbs;
        return $this;
    }

    public function setControlnavThumbsFromRel($controlnavThumbsFromRel) {
        $this->controlnavThumbsFromRel = $controlnavThumbsFromRel;
        return $this;
    }

    public function setKeyboardNav($keyboardNav) {
        $this->keyboardNav = $keyboardNav;
        return $this;
    }

    public function setPauseOnHover($pauseOnHover) {
        $this->pauseOnHover = $pauseOnHover;
        return $this;
    }

    public function setCaptionOpacity($captionOpacity) {
        $this->captionOpacity = $captionOpacity;
        return $this;
    }

    public function setPrevText($prevText) {
        $this->prevText = $prevText;
        return $this;
    }

    public function setNextText($nextText) {
        $this->nextText = $nextText;
        return $this;
    }

    /**
     ***************************************************************************
     */
    function __construct() {
        return $this;
    }

    public function init(){
        add_action('wp_enqueue_scripts',array(&$this,'scripts'));
        return $this;
    }

    public function scripts() {
        //wp_register_script('nivo-slider',get_template_directory_uri().'/library/nivo-slider/jquery.nivo.slider.pack.js',array('jquery'));
        wp_register_script('nivo-slider',cwp::locate_in_library('jquery.nivo.slider.pack.js', 'nivo'),array('jquery'));
        //wp_register_style('nivo-style', get_template_directory_uri().'/library/nivo-slider/');
        wp_register_style('nivo-style', cwp::locate_in_library('nivo-slider.css', 'nivo'));
        //wp_register_style('nivo-default', get_template_directory_uri()."/library/nivo-slider/themes/default/default.css",array('nivo-style'));
         wp_register_style('nivo-default', cwp::locate_in_library('default.css', 'nivo/themes/default'));
        //wp_register_style('nivo-pascal', get_template_directory_uri()."/library/nivo-slider/themes/pascal/pascal.css",array('nivo-style'));
        //wp_register_style('nivo-orman', get_template_directory_uri()."/library/nivo-slider/themes/orman/orman.css",array('nivo-style'));
        wp_enqueue_script('nivo-slider');
        wp_enqueue_style('nivo-style');

    }

    public function header() {

    }

    public function footer() {

    }

    public function admin_menu() {

    }

    public function settings() {

    }

    public function metabox() {

    }


    /**
     *
     * @param type $effect default random
      sliceDown
      sliceDownLeft
      sliceUp
      sliceUpLeft
      sliceUpDown
      sliceUpDownLeft
      fold
      fade
      random
      slideInRight
      slideInLeft
      boxRandom
      boxRain
      boxRainReverse
      boxRainGrow
      boxRainGrowReverse

     * @param type $slices
     * @param type $animSpeed
     * @param type $pauseTime
     */
    public function config() {
        ?>
         <script type="text/javascript">
           jQuery.noConflict();
            jQuery(window).load(function() {
            jQuery('#<?php echo $this->id ?>').nivoSlider({
                effect: '<?php echo $this->effect; ?>',//'random', // Specify sets like: 'fold,fade,sliceDown'
                slices: <?php echo $this->slices; ?>,//15, // For slice animations
                boxCols: <?php echo $this->boxCols; ?>, // For box animations
                boxRows: <?php echo $this->boxRows; ?>, // For box animations
                animSpeed: <?php echo $this->animSpeed; ?>,//500, // Slide transition speed
                pauseTime: <?php echo $this->pauseTime; ?>,//3000, // How long each slide will show
                startSlide: <?php echo $this->startSlide; ?>, // Set starting Slide (0 index)
                directionNav: <?php echo $this->directionNav; ?>, // Next & Prev navigation
                directionNavHide: <?php echo $this->directioNavHide; ?>, // Only show on hover
                controlNav: <?php echo $this->controlNav; ?>, // 1,2,3... navigation
                controlNavThumbs: <?php echo $this->controlNavThumbs; ?>, // Use thumbnails for Control Nav
                controlNavThumbsFromRel: <?php echo $this->controlnavThumbsFromRel; ?>, // Use image rel for thumbs
                controlNavThumbsSearch: '.jpg', // Replace this with...
                controlNavThumbsReplace: '_thumb.jpg', // ...this in thumb Image src
                keyboardNav: <?php echo $this->keyboardNav; ?>, // Use left & right arrows
                pauseOnHover: <?php echo $this->pauseOnHover; ?>, // Stop animation while hovering
                manualAdvance: false, // Force manual transitions
                captionOpacity: <?php echo $this->captionOpacity; ?>, // Universal caption opacity
                prevText: '<?php echo $this->prevText; ?>', // Prev directionNav text
                nextText: '<?php echo $this->nextText; ?>'
            });
            });
        </script>
        <?php
    }


}

