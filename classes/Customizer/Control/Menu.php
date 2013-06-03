<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Menu
 *
 * @author studio
 * @link https://github.com/bueltge/Wordpress-Theme-Customizer-Custom-Controls/blob/master/menu_dropdown_custom_control.php source
 */
if (class_exists('WP_Customize_Control')) {


    class Customizer_Control_Menu extends WP_Customize_Control {

        public $type = 'menu_dropdown',
                $args = array();

        /**
         * Render the content on the theme customizer page
         */
        public function render_content() {
            ?>
            <label>
                <span class="customize-menu-dropdown"><?php echo esc_html($this->label); ?></span>
                <select name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>">
            <?php
            $menus = wp_get_nav_menus($this->args);
            if ($menus) {
                foreach ($menus as $menu) {
                    echo '<option value="' . $menu->term_id . '"' . selected($this->value, $menu->term_id) . '>' . $menu->name . '</option>';
                }
            }
            ?>
                </select>
            </label>
                    <?php
                }

            }

        }
