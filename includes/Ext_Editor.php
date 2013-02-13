<?php



/**
 * Description of Ext_MCE_Styles
 *
 * @author studio
 */

class Ext_Editor_Styles {


    private $styles = array();

    public function set_styles($styles) {
        $this->styles = $styles;
        return $this;
    }

    private function __construct() {

    }


    /**
     * Factory
     * <code>
     * $styles = array(
        array('title' => 'Button', 'inline' => 'span', 'classes' => 'btn'),
        array('title' => 'Primary', 'inline' => 'span', 'classes' => 'btn btn-primary'),
        array('title' => 'info', 'inline' => 'span', 'classes' => 'btn btn-info')
    );
     * Ext_MCE_Styles::add()->set_styles($styles)->add_filters();
     * </code>
     * @return \Ext_MCE_Styles
     */
    public static function create(){
        $factory = new Ext_Editor_Styles();
        return $factory;
    }

    /**
     * Actions
     */
    public function add_filters() {
        //http://codex.wordpress.org/TinyMCE_Custom_Buttons
        //http://wpsnipp.com/index.php/functions-php/creating-custom-styles-drop-down-in-tinymce/
        add_filter('tiny_mce_before_init', array($this, 'styles'));
        add_filter('mce_buttons_2', array($this, 'buttons'));
        //return $this;
    }

    public function buttons($buttons) {
        array_unshift($buttons, 'styleselect');
        return $buttons;
    }

    public function styles($settings) {
        //$settings['theme_advanced_blockformats'] = 'p,a,div,span,h1,h2,h3,h4,h5,h6,tr,';
        $style_formats = $this->styles;
                $settings['style_formats'] = json_encode($style_formats);
        return $settings;
    }

}