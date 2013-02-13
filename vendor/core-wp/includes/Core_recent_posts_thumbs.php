<?php



/**
 * Description of Recentposts_thumbnail
 *
 * @author Studio365
 */
class Core_recent_posts_thumbs extends WP_Widget {

    /**
     * CREDITS - http://www.wpshower.com
     */

    function Core_recent_posts_thumbs() {
        //parent::WP_Widget(false, $name = 'Post Thumbs');
        /* Widget settings. */
        $widget_ops = array('classname' => 'Core_recent_post_thumbs',
            'description' => __('Display latest post with thumbnails, for post, pages or custom post types', 'recent-post-thumbs'));

        /* Widget control settings. */
        $control_ops = array('id_base' => 'post-thumbs-widget');

        /* Create the widget. */
        $this->WP_Widget('recent-post-thumbs', __('Recent-Post-thumbs', 'core-wp'), $widget_ops, $control_ops);
    }



    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        ?>
            <?php echo $before_widget; ?>
            <?php if ( $title ) echo $before_title . $title . $after_title;  else echo '<div class="widget-body clear">'; ?>

            <?php
                global $post;
                if (get_option('rpthumb_qty')) $rpthumb_qty = get_option('rpthumb_qty'); else $rpthumb_qty = 5;
                if (get_option('rpthumb_page')) $rpthumb_page = get_option('rpthumb_page'); else $rpthumb_qty = 'post';
                $q_args = array(
                    'numberposts' => $rpthumb_qty,
                );
                $rpthumb_posts = get_posts($q_args);
                foreach ( $rpthumb_posts as $post ) :
                    setup_postdata($post);
            ?>
                <a href="<?php the_permalink(); ?>" class="rpthumb clear">
                    <?php if ( has_post_thumbnail() && !get_option('rpthumb_thumb') ) {
                        echo '<span class="recent_thumb">';
                        the_post_thumbnail('recent-thumb');
                        echo '</span>';

                    }
                    ?>
                    <span class="rpthumb-title" <?php echo $offset; ?>><?php the_title(); ?></span>
                    <span class="rpthumb-date" <?php echo $offset; unset($offset); ?>><?php the_time(__('M j, Y')) ?></span>
                </a>

            <?php endforeach; ?>

            <?php echo $after_widget; ?>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        update_option('rpthumb_qty', $_POST['rpthumb_qty']);
        update_option('rpthumb_thumb', $_POST['rpthumb_thumb']);
        update_option('rpthumb_thumb', $_POST['rpthumb_thumb']);
        return $instance;
    }

    function form($instance) {
                            $title = esc_attr($instance['title']);
                            ?>
                                            <p><label for="<?php echo $this->get_field_id('title'); ?>">
                                                    <?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>

                                            <p><label for="rpthumb_qty">Post Type:  </label>
                                                <select name="rpthumb_page" >
                                                    <option><?php echo get_option('rpthumb_page'); ?></option>
        <?php
        $args = array(
            'public' => true,
        );
        $obj = 'objects';
        $pages = get_post_types($args, $obj);
        foreach ($pages as $value) {
            echo "   <option value=\"{$value->name}\">{$value->name}</option>";
        }
        ?>
                                                </select>
                                            </p>
                                            <p><label for="rpthumb_qty">Number of posts:  </label><input type="text" name="rpthumb_qty" id="rpthumb_qty" size="2" value="<?php echo get_option('rpthumb_qty'); ?>"/></p>
                                            <p><label for="rpthumb_thumb">Hide thumbnails:  </label><input type="checkbox" name="rpthumb_thumb" id="rpthumb_thumb" <?php echo (get_option('rpthumb_thumb')) ? 'checked="checked"' : ''; ?>/></p>
        <?php
    }

}
add_action('widgets_init', 'init_core_thumbs');

function init_core_thumbs(){
    register_widget('Core_recent_posts_thumbs');
}

add_image_size('recent-thumb', 80, 80, true);

