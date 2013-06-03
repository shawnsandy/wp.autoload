<?php



/**
 * Date picker control
 * @link https://github.com/bueltge/Wordpress-Theme-Customizer-Custom-Controls/blob/master/date_picker_custom_control.php original source
 * @author studio
 */

if(!class_exists('WP_Customize_Control')) return null;


class Customizer_Control_Datepicker {

    /**
           * Enqueue the styles and scripts
           */
          public function enqueue()
          {
            wp_enqueue_style( 'jquery-ui-datepicker' );
          }

          /**
           * Render the content on the theme customizer page
           */
          public function render_content()
           {
              $this->enqueue();

                ?>
                    <label>
                      <span class="customize-date-picker-control"><?php echo esc_html( $this->label ); ?></span>
                      <input type="date" id="<?php echo $this->id; ?>" name="<?php echo $this->id; ?>" value="<?php echo $this->value(); ?>" class="datepicker" />
                    </label>
                <?php
           }

}

?>
