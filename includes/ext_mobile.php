<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class Ext_Mobile extends Mobile_Detect {

    private static $instance;

    /**
     * Singleton Pattenr
     * @return class object
     */
    public static function instance() {
        if (!is_object(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }

    /**
     *
     */
    private function __construct() {
        parent::__construct();
    }



    /**
     * detect if mobile is phone
     * @return boolean
     */
    public function isPhone() {
        if ($this->isAndroid() OR $this->isIphone() OR $this->isWindowsphone() OR $this->isBlackberry() ):
            return true;
        else:
            return false;
        endif;
    }

    /**
     * detect if mobile is tablet
     * @return boolean
     */
    public function isTablet(){
        if($this->isAndroidtablet() or $this->isBlackberrytablet() or $this->isIpad()):
            return true;
        else :
            return false;
        endif;
    }

    /**
     * class factory
     * @return \mod_mobile
     *
     */
    public static function detect() {
        return new mod_mobile;
    }

    /**
     * Singleton pattern
     */



    /**
     * adds a .mobile class to the WP body
     */
    public static function mobile_class(){
        if(mod_mobile::detect()->isMobile()) :
            add_filter( 'body_class', array('mod_mobile','add_mobile_class'));
        endif;
    }

    /**
     * mobile function
     * @param array $classes
     * @return string
     */
    public function add_mobile_class($classes){
        $classes[] = 'mobile';
     return $classes;
    }

}

