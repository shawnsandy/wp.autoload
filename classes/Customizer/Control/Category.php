<?php
/**
 * Description of Categories
 *
 * @author studio
 * @link https://github.com/bueltge/Wordpress-Theme-Customizer-Custom-Controls/blob/master/category_dropdown_custom_control.php source
 */
if (class_exists('WP_Customize_Control')) {


    class Customizer_Control_Category extends WP_Customize_Control {

        public $type = 'category_dropdown',
                $args = array();


        public function render_content() {
            ?>
            <label>
                <span class="customize-category-select-control"><?php echo esc_html($this->label); ?></span>
                <select <?php $this->link(); ?>>
            <?php

            $cats = get_categories($this->args);
            foreach ($cats as $cat) {
                echo '<option value="' . $cat->term_id . '"' . selected($this->value(), $cat->term_id) . '>' . $cat->name . '</option>';
            }
            ?>
                </select>
            </label>
                    <?php
                }

            }

        }