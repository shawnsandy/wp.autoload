<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once dirname(__FILE__) . '/includes/class.settings-api.php';

class Plugins_Settings {

    public function __construct() {

    }

    /**
     *
     * @return \Plugins_Settings
     */
    public static function factory() {
        $facotry = new Plugins_Settings;
        return $facotry;
    }

    /**
     *
     * @param type $name
     * @param type $label
     * @param type $desc
     * @param type $type
     * @param type $options
     * @param type $default
     * @return array
     */
    public static function set_feild($name, $label, $desc, $type, $options = null, $default = '') {

        $args['name'] = $name;
        $args['label'] = $label;
        $args['desc'] = $desc;
        $args['type'] = $type;
        $args['default'] = $default;
        if (isset($options))
            $args['options'] = $options;
        return $args;
    }

    public static function input($name = 'text', $label = 'Text Input', $desc = 'Text input description', $default = '') {
        //array $args
        $args = self::set_feild($name, $label, $desc, 'text', NULL, $default);

        return $args;
    }

    public static function textarea($name = 'textarea', $label = 'Textarea label', $desc = 'Textarea Desc', $default = '') {

        $args = self::set_feild($name, $label, $desc, 'textarea', NULL, $default);

        return $args;
    }

    public static function checkbox($name = 'Textbox', $label = 'Textbox Label', $desc = 'Textbox Description', $default = '') {

        $args = self::set_feild($name, $label, $desc, 'checkbox', NULL, $default);

        return $args;
        
    }

}