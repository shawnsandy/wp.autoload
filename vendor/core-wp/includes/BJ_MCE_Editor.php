<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BJ_MCE_Editor
 *
 * @author studio
 */
class BJ_MCE_Editor extends WP_Widget {

    /**
     * Widget setup.
     */
    //TODO change widget name
    function BJ_MCE_Editor() {

        /* Widget settings. */
        $widget_ops = array('classname' => 'bj-mce-editor', 'description' => __('Add HTML content to your post using default wordpress editor', 'bj'));

        /* Widget control settings. */
        //$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'example-widget' );
        $control_ops = array('width' => '600px', 'height' => '400px', 'id_base' => 'bj-mce-editor');

        /* Create the widget. */
        //TODO replace bj-mce-editor with widget slug/name
        $this->WP_Widget('bj-mce-editor', __('HTML Content', 'bj'), $widget_ops, $control_ops);
    }


    /**
     * Now to display the widget on the screen.
     */
    function widget($args, $instance) {
        extract($args);

        /* Our variables from the widget settings. */
        $title = apply_filters('widget_title', $instance['title']);
        $show_desc = $instance['desc'];
        $content = $instance['bj_mce_content'];
        //$show_sex = isset( $instance['show_sex'] ) ? $instance['show_sex'] : false;

        /* Before widget (defined by themes). */
        echo $before_widget;
        echo "<div class=\"bj-mce-editor\" >";

        /* Display the widget title if one was input (before and after defined by themes). */
        if ($title)
            echo $before_title . $title . $after_title;
        echo $content;



        /* After widget (defined by themes). */
        echo "</div>";
        echo $after_widget;
    }

    /**
     * Update the widget settings.
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        /* Strip tags for title and name to remove HTML (important for text inputs). */
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['desc'] = strip_tags($new_instance['desc']);
        if(current_user_can('unfiltered_html')):
        $instance['bj_mce_content'] = $new_instance['bj_mce_content'];
            else :
        $instance['bj_mce_content'] = stripcslashes(wp_filter_post_kses(addslashes($new_instance['bj_mce_content'])));
        endif;

        //$instance['thumbs'] = strip_tags($new_instance['thumbs']);
        return $instance;
    }

    /**
     * Displays the widget settings controls on the widget panel.
     * Make use of the get_field_id() and get_field_name() function
     * when creating your form elements. This handles the confusing stuff.
     */
    function form($instance) {

        /* Set up some default widget settings. */
        //TODO change title Sample widget to widget name
        $defaults = array('title' => __('HTML Content', 'bj'), 'desc' => '','bj_mce_content' => __('Add your content...','bj'));
        $instance = wp_parse_args((array) $instance, $defaults);
        $title = $instance['title'];
        $content = $instance['bj_mce_content'];
        ?>

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'bj-mce-editor'); ?></label>
            <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>"
                   value="<?php echo $title; ?>" style="width:90%;" />
        </p>
        <p>
            <?php
            /* wp editor */


            $args = array(
                'textarea_name' => $this->get_field_name('bj_mce_content'),
                'textarea_rows' => 25,
                //'teeny' => true
            ); // Optional arguments.
           wp_editor($content, $this->get_field_id('bj_mce_content'), $args);
           // the_editor($content, $this->get_field_id('bj_mce_content'));
            ?>
        </p>



        <?php
    }

    /*
     * Register the widget here in the
     * class requires autoloader / include this file
     */

    public static function register_widget() {
        add_action('widgets_init', array('BJ_MCE_Editor', 'register_bj_mce_editor'));
    }

    public function register_bj_mce_editor() {
        register_widget('BJ_MCE_Editor');
    }

}
