<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


if (class_exists('WP_Customize_Control')) {


    class Customizer_Control_Layoutcontent extends WP_Customize_Control {

        public $type = 'select_post';
        public $post_type = '',
                $post_status = 'publish',
                $items = '-1';

        public $description = '';

        public function render_content() {

            $post = $this->post_data();
            ?>
            <label>
                <div class="customize-post-select-control"><?php echo esc_html($this->label); ?></div>
                <select <?php $this->link(); ?>>
            <?php
            foreach ($post as $data) {
                echo '<option value="' . $data->ID . '"' . selected($this->value(), $data->ID) . '>' . $data->post_title . '</option>';
            }
            ?>
                </select>
            </label>
                    <?php
                }

                /**
                 *
                 * @global type $wpdb
                 * @global type $post
                 * @param array $query - array(post_type => post, post_status => 'post', items => 5)
                 * @return type
                 */
                protected function post_data() {

                    global $wpdb, $post;
                    $query = "
	SELECT $wpdb->posts.ID, $wpdb->posts.post_title
	FROM $wpdb->posts
	WHERE $wpdb->posts.post_status = 'publish'
                AND
                $wpdb->posts.post_type = 'post'
                ORDER BY $wpdb->posts.ID DESC";
                    $_query = $wpdb->get_results($query, OBJECT);
                    return $_query;
                }

            }

        }