<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WP_Bootstrap
 *
 * @author studio
 */
class WP_Bootstrap {

    private function __construct() {

    }

    private static $instance;

    /**
     * Singleton Pattern
     * @return class object
     */
    public static function instance() {
        if (!is_object(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }



}

