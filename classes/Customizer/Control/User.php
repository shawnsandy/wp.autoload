<?php

/**
 * Description of UserDropdown
 *
 * @author studio
 */
if (class_exists('WP_Customize_Control')) {


    class Customizer_Control_Users extends WP_Customize_Control {

        public $type = 'user_dropdown';
        public $query = array('orderby' => 'nicename');
        public $description = '';

        public function render_content() {
            $query = $this->query;
            $pgs = $this->user_array($query);
            ?>
            <label>
                <span  class="customize-control-title" ><?php echo esc_html($this->label); ?></span>
                <select <?php $this->link(); ?>>
                    <option></option>
            <?php foreach ($pgs as $key => $value): ?>
                        <option value="<?php echo $key ?>" <?php echo ($key == $this->value() ? 'selected' : '') ?>>
                        <?php echo $value; ?>
                        </option>
                        <?php endforeach; ?>
                </select>
                <span style="display: block"><?php echo esc_html($this->description) ?></span>
            </label>
            <?php
        }

        public function user_array($args = '') {
            /*
             * get list of pages and output an associate array with post_name and post-title
             * $pages['post_name'] = 'post_title';
             */

            $arrray = get_users($args);
            foreach ($arrray as $items) {
                $pgs["{$items->ID}"] = $items->user_nicename;
            }
            return $pgs;
        }

    }

}