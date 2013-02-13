<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of captify
 *
 * @author Studio365
 */
/**
 * Define plugin directories
 */
define('CAP_PATH', WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)));
define('CAP_URL', WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)));

if (!class_exists('captify')):

    class img_captify {

        //put your code here
        public function __construct() {
            $this->loader();
        }

        public static function loader() {
            wp_enqueue_script('cpatify', CAP_URL . '/captify.tiny.js', array('jquery'));
            $src = CAP_URL . '/captify.css';
            if (flie_exist(get_stylesheet_directory() . '/captify.css'))
                $src = get_stylesheet_directory_uri() . '/captify.css';
            wp_enqueue_style('captify', $src);
        }

        /**
         * captify config values
         * config-array-values
         * // all of these options are... optional
          // ---
          // speed of the mouseover effect
          speedover: 'fast',
          // speed of the mouseout effect
          speedout: 'normal',
          // how long to delay the hiding of the caption after mouseout (ms)
          hidedelay: 500,
          // 'fade', 'slide', 'always-on'
          animation: 'slide',
          // text/html to be placed at the beginning of every caption
          prefix: '',
          // opacity of the caption on mouse over
          opacity: '0.7',
          // the name of the CSS class to apply to the caption box
          className: 'caption-bottom',
          // position of the caption (top or bottom)
          position: 'bottom',
          // caption span % of the image
          spanWidth: '100%'
         * @param array $array
         */
        public static function config($array=array(), $class='captify') {
            //http://thirdroute.com/projects/captify/
            extract($array);
            ?>
            <script type="text/javascript">
                $(function(){
                    $('img.<?php echo $class ?>').captify({
                        // all of these options are... optional
                        // ---
                        // speed of the mouseover effect
                        speedOver: '<?php echo (isset($speedover) ? $speedover : 'fast') ?>',// 'fast',
                        // speed of the mouseout effect
                        speedOut:  '<?php echo (isset($speedout) ? $speedout : 'normal') ?>',//'normal',
                        // how long to delay the hiding of the caption after mouseout (ms)
                        hideDelay: <?php echo (isset($hidedelay) ? $hidedelay : '500') ?>,//'500,
                        // 'fade', 'slide', 'always-on'
                        animation: '<?php echo (isset($animation) ? $animation : 'slide') ?>',
                        // text/html to be placed at the beginning of every caption
                        prefix: '<?php echo (isset($prefix) ? $prefix : 'slide') ?>',
                        // opacity of the caption on mouse over
                        opacity: '<?php echo (isset($opacity) ? $opacity : '0.7') ?>',//'0.7',
                        // the name of the CSS class to apply to the caption box
                        className: '<?php echo (isset($clasname) ? $classname : 'caption-bottom') ?>',//caption-bottom',
                        // position of the caption (top or bottom)
                        position: '<?php echo (isset($position) ? $position : 'bottom') ?>',//'bottom',
                        // caption span % of the image
                        spanWidth: '<?php echo (isset($spanwidth) ? $spanwidth : '100%') ?>'//'100%'
                    });
                })

            </script>
            <?php
        }

        public static function tpl($query='showposts=5', $template='captify', $module='loop', $data=null) {
            $query = new WP_Query($query);
            if ($query->have_posts()):
                while ($query->have_posts()):
                    core_tpl::modules($template, $module, $data);
                endwhile;
            endif;
            // Reset Post Data
            wp_reset_postdata();
        }

    }




endif;

