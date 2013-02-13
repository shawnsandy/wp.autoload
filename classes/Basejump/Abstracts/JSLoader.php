<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JavascriptLoader
 *
 * @author studio
 */
abstract class Basejump_Abstracts_JSLoader {

    private $scripts;
    private $styles;
    private $dependency = array('jquery'),
            $ver,
            $in_footer = true;

    public function set_ver($ver) {
        $this->ver = $ver;
    }

    public function set_in_footer($in_footer) {
        $this->in_footer = $in_footer;
    }

    public function set_scripts($scripts) {
        $this->scripts = $scripts;
    }

    public function set_styles($styles) {
        $this->styles = $styles;
    }

    public function set_dependency($dependency) {
        $this->dependency = $dependency;
    }

    //public abstract function enqueue_scripts();

    public abstract function footer_scripts();

    public abstract function head_scripts();

    /**
     * Constructor
     *
     * @param type $scripts
     * @param type $type
     */
    public function __construct() {

    }

    public function actions() {
        //add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_footer', array($this, 'footer_scripts'));
        add_action('wp_head', array($this, 'head_scripts'));
    }

    function enqueue_scripts($sources = array(), $type = 'js') {
        if (!is_array($sources) OR empty($sources))
            return;

        if ($type == 'js'):
            foreach ($sources as $name => $uri) {
                wp_register_script($name, $uri, $this->dependency, $this->ver, $this->in_footer);
                wp_enqueue_script($name);
            }
        else :
            foreach ($sources as $name => $uri) {
                wp_register_style($name, $uri);
                wp_enqueue_style($name);
            }
        endif;
    }

}