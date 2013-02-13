<?php

/**
 * Description of cycle
 *
 * @author Studio365
 */
class cycle {

    public function __construct() {

    }

    public static function load() {
        $script = CM_URL .'/cycle/js/jquery.cycle.all.js';
        wp_enqueue_script('cycle', $script, array('jquery'));
    }

    /**
     *
     * @param type $array
     * @param type $id 
     */
    public static function config($array=array(),$id='cycle') {
        extract($array);
        include CM_PATH . '/cycle/config.php';
    }

    /**
     *
     * @param string $query post query
     * @param string $tpl template file
     * @param array $data additional post data
     */
    public static function tpl($query='showposts=5', $tpl='index', $data=array('thumbnail' => 'slider-image', 'id' => 'cycle')) {
        //echo "<div class='slider'>";
        //core_mods::modules('index', 'cycle');
        //echo "</div>";
        if(is_array($data))
            extract($data);
        ?>
         <div class="cycle-slider">
            <div id="<?php echo (isset($id) ? $id : 'cycle'); ?>">
                <?php $q_cycle = new WP_Query('showposts=5'); ?>
                <?php if ($q_cycle->have_posts()): ?>
                    <?php while ($q_cycle->have_posts()) : $q_cycle->the_post(); ?>
                        <?php //core_module::tpl("index", 'cycle',$data) ?>
                        <?php cwp_layout::tpl_part('cycle', 'index'); ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="cycle-nav"><a id="prev" href="#">Prev</a> <a id="next" href="#">Next</a></div>

        <?php
    }

}
?>
