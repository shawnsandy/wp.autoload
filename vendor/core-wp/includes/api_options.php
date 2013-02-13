<?php

/**
 * Description of cwp_meta
 *
 * @author Studio365
 */
class api_options {

    //put your code here

            private $option_group,
            $option_name,
            $text_domain = 'corewp',
            $options,
            $validation_callback;



    public function get_options() {
        return $this->options;
    }

    public function set_validate($validation_callback) {
        $this->validation_callback = $validation_callback;
        return $this;
    }



    /**
     *
     * @param type $option_name
     * @param type $text_domain
     */
    public function __construct($option_name, $text_domain=null) {
        //$this->option_group = $option_group;
        $this->option_name = $option_name;
        $this->options = get_option("{$option_name}_options");
        if(isset($text_domain))
            $this->text_domain = $text_domain;
    }


    public static function factory($option_name,$text_domain=null){
        return new api_options($option_name,$text_domain);
    }

    public function register_settings($validation_callback){
        $this->validation_callback = $validation_callback;
        add_action('init', array($this,'settings'));

    }

    public function settings() {
        register_setting($this->option_name . '_group', $this->option_name . '_options', $this->validation_callback);
    }

    public function option($option){
        if(isset($this->options["{$option}"]))
        return $this->options["{$option}"];
        else false;
        return $this;
    }


    /**
     *
     * @param type $option
     * @param type $title
     * @param type $description
     */
    public function wysiwyg($option, $title='Input', $description='Description...') {
        ob_start();
        $option_attr = $this->option_name . '_options[' . $option . ']';
        ?>
         <h3><?php echo esc_attr($title); ?></h3>
        <p>
            <?php
            $args = array("textarea_name" => "posk_options[textarea_three]");
            wp_editor($this->option($option), "posk_options[textarea_three]", $args);
            ?>
        </p>
        <label class="description" for="<?php echo $option_attr; ?>"><?php echo $description; ?></label>
        <?php
        return ob_get_clean();
    }

    /**
     *
     * @param type $option
     * @param type $title
     * @param type $description
     * @return type
     */
    public function text_input($option, $title='Input', $description='Description...') {
        ob_start();
        $option_attr = $this->option_name . '_options[' . $option . ']'
        ?>

        <h3><?php echo esc_attr($title); ?></h3>
        <p>
            <input id="<?php echo $option_attr; ?>" class="regular-text" type="text" name="<?php echo $option_attr; ?>" value="<?php esc_attr_e($this->option($option)); ?>" />
            <label class="description" for="<?php echo $option_attr; ?>"><?php echo $description; ?></label>
        </p>
        <?php
        return ob_get_clean();
    }


    public function checkbox($option, $title='Checkbox', $description='Description...') {
        ob_start();
        $option_attr = $this->option_name . '_options[' . $option . ']'
        ?>
        <h3><?php echo esc_attr($title); ?></h3>
        <p>
            <input id="<?php echo $option_attr; ?>" name="<?php echo $option_attr; ?>" type="checkbox" value="1" <?php checked('1', $this->option($option)); ?> />

            <label class="description" for="<?php echo $option_attr; ?>"><?php echo $description; ?></label>
        </p>
        <?php
        return ob_get_clean();
    }


    public function select($option, $items= array(), $title='Select', $description='Description...') {
        ob_start();
        $option_attr = $this->option_name . '_options[' . $option . ']'
        ?>
        <h3><?php echo esc_attr($title); ?></h3>
        <p>
            <select name="<?php echo $option_attr; ?>">
        <?php
        $selected = $this->option($option);
        foreach ($items as $item) {
            $selected = ($options['dropdown1'] == $item) ? 'selected="selected"' : '';
            echo "<option value='$item' $selected>$item</option>";
        }
        ?>
            </select>

            <label class="description" for="<?php echo $option_attr; ?>"><?php echo $description; ?></label>
        </p>
        <?php
        return ob_get_clean();
    }

    function password($option, $title='Password', $description='Description...') {
        $options = $this->option($option);
        return"<input id='plugin_text_pass' name='plugin_options[pass_string]' size='40' type='password' value='{$options['pass_string']}' />";
    }

    function radio($option, $items = array(), $title='Radio button', $description='') {
        $options = get_option('plugin_options');
        $items = array("Square", "Triangle", "Circle");
        foreach ($items as $item) {
            $checked = ($this->option($option) == $item) ? ' checked="checked" ' : '';
            return "<label><input " . $checked . " value='$item' name='plugin_options[option_set1]' type='radio' /> $item</label><br />";
        }
    }

    public function render($fields = array(), $action='options.php', $save_button = "Save Settings") {
        ob_start();
        ?>
        <form method="post" action="<?php echo $options ?>">
        <?php settings_fields($this->option_name . '_group'); ?>
            <?php $options = get_option("{$this->option_name}_options"); ?>
            <p class="submit">
                <input type="submit" class="button-primary" value="<?php e_($save_button, $this->text_domain); ?>" />
            </p>
        </form>
        <?php

    }

    /**
     ***************VALIDATION***************************************************
     */


    public function valid_html_script($input = null){
        if(!isset($input) AND empty($input)) return $input = '';
        if(curent_user_can('unfiltered_html')):
          return  $input = stripslashes($input);
        else :
          return $input ='';
        endif;
    }

    public function valid_html($input=''){
        if(!empty($input)):
            $input = esc_html($input);
        endif;
        return $input;

    }

    public function valid_email($input=''){
        if(!empty($input) AND is_email($input)):
            $input = sanitize_email($input);
        endif;
        return $input;
    }


    public function valid_word_count($input='',$count=150){
        if(!empty($input)):
            $input = wp_trim_words($input,$count);
        endif;
        return $input;
    }







}
?>
