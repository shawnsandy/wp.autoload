<?php


/**
 * Description of CustomPages
 *
 * @author studio
 */
if (class_exists('WP_Customize_Control')) {

    class Cutomizer_Control_Pages extends WP_Customize_Control {

        public $type = 'pages_dropdown';
        public $args = array();
        public $description = '';

        public function render_content() {
            $pgs = $this->page_array($this->args);
            ?>
            <label>
                <span  class="customize-control-title" ><?php echo esc_html($this->label); ?></span>
                <select <?php $this->link(); ?>>
                    <option></option>
            <?php foreach ($pgs as $key => $value): ?>
                    <option value="<?php echo $key ?>" <?php selected($key, $this->value()) ?>>
                        <?php echo $value; ?>
                        </option>
                        <?php endforeach; ?>
                </select>
                <span style="display: block"><?php echo esc_html($this->description) ?></span>
            </label>
            <?php
        }

        public function page_array($args = array()) {
            /*
             * get list of pages and output an associate array with post_name and post-title
             * $pages['post_name'] = 'post_title';
             */

            $pages = get_pages($args);
            foreach ($pages as $page) {
                $pgs["{$page->ID}"] = $page->post_title;
            }
            return $pgs;

        }

    }

}