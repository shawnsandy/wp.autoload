<?php

/**
 * Customizer - Create theme(s) customizer options
 *
 * @author studio
 */
class Customizer_Settings {

    /** general class varibles * */
    protected
    /**
     * @var string - holds the wp_customize object
     *
     */
            $wp_customize = '';

    /** general section variables */
    protected
    /**
     * @var string the name of the section;
     */
            $section_id,
            /**
             * @var string - customizer section
             */
            $section_priority = '80',
            /**
             *
             */
            $section_title,
            /**
             *
             */
            $section_description = '',
            /**
             *
             */
            $section_label = '',
            /**
             *
             */
            $section_type = '';

    /** general settings variables */
    protected
    /**
     * @var string - Type of setting - theme-mod (default) / option
     */
            $setting_type = 'theme_mod',
            /**
             * @var string User role / capability default edit_theme_options
             */
            $setting_capability = 'edit_theme_options',
            /**
             * @var string - the transport refresh (default) / postMessage
             */
            $setting_transport = 'refresh',
            /**
             *
             */
            $setting_default = '',
            /**
             *
             */
            $setting_name,
            /**
             *
             */
            $setting_santize_callback = null;

    /** general control variables * */
    protected
    /**
     *
     */
            $control_label,
            /**
             *
             */
            $control_type = 'text',
            /**
             *
             */
            $control_type_choices = null,
            /**
             * Used to add additional args for controls
             */
            $control_args = array();


    /**
     * Set additional options for control arguments     *
     * @param array/string $control_args - use get_control_args to capture options
     * @return \Customizer_Settings
     */
    public function set_control_args($control_args) {
        $this->control_args = $control_args;
        return $this;
    }

    /**
     *
     * checks to see it is a string or array and returns value(s)
     * @param string $value array value/item you are looking for
     * @param type $default set a default if the the value is not found
     * @return string;
     */
    public function get_control_args($value, $default='') {
        if(is_array($this->control_args)):
        $val = (isset($this->control_args["{$value}"])) ? $this->control_args["{$value}"] : $default;
        else :
            $val = $this->control_args;
        endif;
        return $val;

    }




    public function __construct() {

    }

    /**
     * Create a new customizer section
     * @param type $section_id
     * @param type $section_title
     * @param type $section_description
     * @param type $priority
     * @return type
     */
    public static function add_section($section_id = null, $section_title = 'Section Title', $section_description = '', $priority = 110) {

        $factory = new Customizer_Settings();

        if (isset($section_id)):
            $factory->section_id = $section_id;
            $factory->section_title = $section_title;
            $factory->section_description = $section_description;
            $factory->section_priority = $priority;
            //$this->add_new_section();
            add_action('customize_register', array($factory, 'add_new_section'));
        endif;
        return $section_id;
    }

    /**
     *
     * @param type $wp_customize
     */
    public function add_new_section($wp_customize) {
        $wp_customize->add_section($this->section_id, array(
            'title' => $this->section_title,
            'priority' => $this->section_priority,
            'description' => $this->section_description
                )
        );
    }

    /**
     * Factory method
     * @param string $section_id
     * @param string $setting_name
     * @param string $control_label
     * @param string $setting_default
     */
    public static function add_option($section_id, $setting_name, $control_label, $setting_default = '') {

        $option = new Customizer_Settings();

        $option->section_id = $section_id;

        $option->setting_name = $setting_name;

        $option->setting_default = $setting_default;

        $option->control_label = $control_label;

        return $option;
    }

    /**
     *
     * @param type $control_callback - name of function for the custom control
     */
    public function customizer($control_callback = 'add_control') {

        add_action('customize_register', array($this, 'add_setting'));
        add_action('customize_register', array($this, $control_callback));
    }

    public function add_setting($wp_customize) {

        // $this->setting($setting_name, $setting_default);

        $setting['default'] = $this->setting_default;
        $setting['type'] = $this->setting_type;
        $setting['capability'] = $this->setting_capability;
        $setting['transport'] = $this->setting_transport;
        if (isset($this->setting_santize_callback))
            $setting['sanatize_callback'] = $this->setting_santize_callback;

        $wp_customize->add_setting($this->setting_name, array($setting));
    }

    public function add_control($wp_customize) {

        // $this->control($setting_name, $control_label, $control_type);

        $control['label'] = $this->control_label;
        $control['section'] = $this->section_id;
        $control['type'] = $this->control_type;
        if (isset($this->control_type_choices) and is_array($this->control_type_choices))
            $control['choices'] = $this->control_type_choices;

        $wp_customize->add_control($this->setting_name, $control);
    }

    /**  modify protected variables methods  */
    public function set_setting_type($setting_type) {
        $this->setting_type = $setting_type;
        return $this;
    }

    public function set_setting_capability($setting_capability) {
        $this->setting_capability = $setting_capability;
        return $this;
    }

    public function set_setting_transport($setting_transport) {
        $this->setting_transport = $setting_transport;
        return $this;
    }

    /**
     * Set a control type
     * @param type $control_type (
     * @param array $type_choices use for defaults checkboxes, selects etc - Use custom control classname and customizer(custom_control) for classes without custom values
     * @return \Customizer_Settings
     */
    public function set_control_type($control_type, $type_choices = null) {
        $this->control_type = $control_type;
        if (isset($type_choices) and is_array($type_choices))
            $this->control_type_choices = $type_choices;
        return $this;
    }

    public function add_color_control($wp_customize) {
        // color control
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $this->setting_name, array(
            'label' => $this->control_label,
            'section' => $this->section_id,
            'settings' => $this->setting_name,
        )));
    }

    public function add_upload_control($wp_customize) {
        // upload control
        $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize, $this->setting_name, array(
            'label' => $this->control_label,
            'section' => $this->section_id,
            'settings' => $this->setting_name,
        )));
    }

    public function add_image_control($wp_customize) {

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $this->setting_name, array(
            'label' => $this->control_label,
            'section' => $this->section_id,
            'settings' => $this->setting_name,
        )));
    }

    public function add_background_image_control($wp_customize) {
        // background image control
        $wp_customize->add_control(new WP_Customize_Background_Image_Control($wp_customize, $this->setting_name, array(
            'label' => $this->control_label,
            'section' => $this->section_id,
            'settings' => $this->setting_name,
        )));
    }

    public function add_header_image_control($wp_customize) {
        // header image control
        $wp_customize->add_control(new WP_Customize_Header_Image_Control($wp_customize, $this->setting_name, array(
            'label' => $this->control_label,
            'section' => $this->section_id,
            'settings' => $this->setting_name,
        )));
    }

    public function select_layout_content($wp_customize) {
        // header image control
        $wp_customize->add_control(new Customizer_Control_Layoutcontent($wp_customize, $this->setting_name, array(
            'label' => $this->control_label,
            'section' => $this->section_id,
            'settings' => $this->setting_name
        )));
    }

    /**
     *
     * @param type $wp_customize
     */
    public function post_selections($wp_customize) {
        // header image control
        $wp_customize->add_control(new Customizer_Control_Postselection($wp_customize, $this->setting_name, array(
            'label' => $this->control_label,
            'section' => $this->section_id,
            'settings' => $this->setting_name,
            'post_type' => $this->get_control_args('post_type','post'),

        )));
    }


    public function custom_control($wp_customize) {
        $control = $this->control_type;
        $wp_customize->add_control(new $control($wp_customize, $this->setting_name, array(
            'label' => $this->control_label,
            'section' => $this->section_id,
            'settings' => $this->setting_name
        )));
    }

}
