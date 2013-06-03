<?php

/**
 * Description of PostsAdvanced
 *
 * @author studio
 */
class Widgets_AdvancedPost extends WP_Widget {

    protected $var;

    //$widget_id, $widget_name, $widget_description, $width = 300
    public function __construct() {

        /**
         * Setup your widget here
         */
        $widget_id = 'advanced-posts';
        $widget_name = 'Recent Posts Advanced';
        $widget_description = 'Displays the most recent posts on your site with advanced options : post_types, thumbnail size, hide title and description...';
        $width = 300;
        $widget_options = array('classname' => $widget_id . '-widget', 'description' => $widget_description);
        $control_options = array('width' => $width, 'height' => 350, 'id_base' => $widget_id);

        parent::__construct(
                $widget_id, // Base ID
                $widget_name, // Name
                $widget_options, // widget Options
                $control_options// Args
        );
    }

    /**
     * How to display the widget on the screen.
     */
    function widget($args, $instance) {
        extract($args);

        /* Our variables from the widget settings. */
        $title = apply_filters('widget_title', $instance['title']);
        $page = $instance['page'];
        //$thumbs = $instance['thumbs'];
        $qty = $instance['qty'];
        $show_desc = $instance['desc'];
        $desc_words = $instance['desc_words'];
        $thumb_size = $instance['thumb_size'];
        //$show_sex = isset( $instance['show_sex'] ) ? $instance['show_sex'] : false;

        /* Before widget (defined by themes). */
        echo $before_widget;
        echo "<div class=\"recent-post-thumbs\" >";

        /* Display the widget title if one was input (before and after defined by themes). */
        if ($title)
            echo $before_title . $title . $after_title;
        //echo $page;
        //cwp_layout::tpl_part($slug, $name);
        $q_args = array(
            'meta_key' => '_thumbnail_id',
            'showposts' => $qty,
            'post_type' => $page,
        );
        $t_query = new WP_Query($q_args);
        if ($t_query->have_posts()):
            while ($t_query->have_posts()):
                $t_query->the_post();
                ?>
                <div class="recent-thumbs">
                    <span class="recent-thumb">
                        <?php if (has_post_thumbnail()): ?>
                            <a href="<?php echo get_permalink(get_the_ID()); ?>" title="">
                                <?php the_post_thumbnail($thumb_size); ?>
                            </a>

                        <?php endif ?>
                    </span>
                    <?php if ($show_desc == 'ON'): ?>
                        <span class="recent-thumb-desc">
                            <a href="<?php echo get_permalink(get_the_ID()); ?>" title="">
                                <strong><?php the_title(); ?></strong>
                            </a>
                            <?php echo wp_trim_words(get_the_excerpt(), $desc_words, '...'); ?>
                        </span>
                    <?php endif; ?>
                    <br class="clear"/>
                </div>
                <?php
            endwhile;
        endif;
        wp_reset_postdata();

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
        $instance['page'] = strip_tags($new_instance['page']);
        $instance['qty'] = strip_tags($new_instance['qty']);
        $instance['thumb_size'] = strip_tags($new_instance['thumb_size']);
        $instance['desc'] = strip_tags($new_instance['desc']);
        $instance['desc_words'] = strip_tags($new_instance['desc_words']);
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
        $defaults = array('title' => __('Recent Post', 'recent-thumbs-widget'), 'page' => 'post', 'qty' => 5, 'desc_words' => 25, 'desc' => 'ON', 'thumb_size' => 'recent-thumb');
        $instance = wp_parse_args((array) $instance, $defaults);

        global $_wp_additional_image_sizes;
        ?>

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'recent-thumbs-widget'); ?></label>
            <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>"
                   value="<?php echo $instance['title']; ?>" style="width:90%;" />
        </p>

        <!-- Your Name: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id('page'); ?>"><?php _e('Post Types:', 'recent-thumbs-widget'); ?></label>

            <select id="<?php echo $this->get_field_id('page'); ?>" name="<?php echo $this->get_field_name('page'); ?>" style="width:90%;" >

                <?php
                $args = array(
                    'public' => true,
                    'show_in_nav_menus' => true
                );
                $obj = 'objects';
                $pages = get_post_types($args, $obj);
                foreach ($pages as $value) {
                    $post_name = ucfirst($value->name);
                    echo "   <option value=\"{$value->name}\" ". selected($value->name, $instance['page']).">{$post_name}</option>";
                }
                ?>
            </select>
        </p>

        <!-- Your Name: Text Input -->
        <p>


            <label for="<?php echo $this->get_field_id('thumb_size'); ?>"><?php _e('Thumbnail Size:', 'recent-thumbs-widget'); ?></label>


            <select id="<?php echo $this->get_field_id('thumb_size'); ?>" name="<?php echo $this->get_field_name('thumb_size'); ?>" style="width:90%;" >
                <option></option>
                <?php foreach ($_wp_additional_image_sizes as $size => $size_attrs): ?>
                    <option value="" <?php selected($size, $instance['thumb_size']); ?>><?php echo $size ?></option>
                <?php endforeach; ?>
            </select>


        </p>
        <p>
            <label for="<?php echo $this->get_field_id('qty'); ?>"><?php _e('Quantity:', 'recent-thumbs-widget'); ?></label>
            <input id="<?php echo $this->get_field_id('qty'); ?>" name="<?php echo $this->get_field_name('qty'); ?>"
                   value="<?php echo $instance['qty']; ?>" style="width:90%;"  />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('desc_words'); ?>"><?php _e('Description length:', 'recent-thumbs-widget'); ?></label>
            <input id="<?php echo $this->get_field_id('desc_words'); ?>" name="<?php echo $this->get_field_name('desc_words'); ?>"
                   value="<?php echo $instance['desc_words']; ?>" style="width:90%;" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('desc'); ?>"><?php _e('Hide Title / Description', 'recent-thumbs-widget'); ?></label>
            <input type="checkbox" id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>" value="ON" <?php echo ($instance['desc'] == 'ON') ? 'checked="checked"' : ''; ?> />

        </p>



        <?php
    }

    public static function register_widget() {
        add_action('widgets_init', array(__CLASS__, 'the_widget'));
    }

    public function the_widget() {
        register_widget(__CLASS__);
    }

}

