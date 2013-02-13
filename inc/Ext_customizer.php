<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ext_customizer
 *
 * @author studio
 */
if (class_exists('WP_Customize_Control')):

    class Ext_customizer {

        private $section_name,
                $title,
                $piority = '35',
                $description = '';

        public function set_section($section) {
            $this->section_name = $section;
            return $this;
        }

        public function set_title($title) {
            $this->title = $title;
            return $this;
        }

        public function set_piority($piority) {
            $this->piority = $piority;
            return $this;
        }

        public function set_description($description) {
            $this->description = $description;
            return $this;
        }

        public function get_section_name() {
            return $this->section_name;
        }

        public function __construct($section) {
            $this->section_name = $section;
        }

        public static function add_section($section) {
            return $factory = new Ext_customizer_section($section);
        }

        public function set_section() {
            $wp_customize->add_section($this->section_name, array(
                'title' => $this->title,
                'priority' => $this->piority,
                'description' => $this->description
            ));
        }

    }

    class Ext_customizer_setting {

        private $setting,
                $section,
                $default_value = '',
                $label,
                $type = 'text';

        function __construct() {
            add_action('customize_register', array($this, 'control'));
        }

        /**
         * Singleton pattern
         * @return type
         */
        public static function instance() {
            if (!is_object(self::$instance)):
                $class = __CLASS__;
                self::$instance = new $class;
            endif;
            return self::$instance;
        }

        public static function add_control() {
            return $factory == new Ext_customizer_setting();
        }

        public function set_control() {

        }

        public function control($customize) {

        }

    }



endif;

