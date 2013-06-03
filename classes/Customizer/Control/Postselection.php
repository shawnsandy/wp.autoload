<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Postselection
 *
 * @author studio
 */
if (class_exists('WP_Customize_Control')) {


    class Customizer_Control_Postselection extends WP_Customize_Control {

        /**
         * @source http://ericjuden.com/2012/08/custom-taxonomy-control-for-the-theme-customizer/
         */
        public $type = 'posts_selection';
        var $defaults = array();
        public $args,
                $post_type,
                $test;

        public function render_content() {

            $this->defaults = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => -1,
            );

            // Parse defaults against what the user submitted
            $array = wp_parse_args($this->args, $this->defaults);
            $postdata = $this->post_data($this->post_type);
            ?>
            <div class="customize-control-title"><?php echo esc_html($this->label); ?></div></label>
            <select <?php $this->link() ?>>
                <option></option>
            <?php foreach ($postdata as $data): ?>
                    <option value="<?php echo $data->ID ?>" <?php selected($this->value(), $data->ID) ?> >
                <?php echo $data->post_title ?>
                    </option>
                    <?php endforeach; ?>

            </select>
                    <?php
                    echo $this->test;
                    // var_dump($postdata);
                    // Generate our select box
                }

                /**
                 *
                 * @global type $wpdb
                 * @global type $post
                 * @param array $query - array(post_type => post, post_status => 'post', items => 5)
                 * @return type
                 */
                protected function post_data($post_type = 'post', $post_status = 'publish') {

                    global $wpdb, $post;
                    $query = "
	SELECT $wpdb->posts.ID, $wpdb->posts.post_title
	FROM $wpdb->posts
	WHERE $wpdb->posts.post_status = '$post_status'
                AND
                $wpdb->posts.post_type = '$post_type'
                ORDER BY $wpdb->posts.ID DESC";
                    $_query = $wpdb->get_results($query, OBJECT);
                    return $_query;
                }

            }

        }