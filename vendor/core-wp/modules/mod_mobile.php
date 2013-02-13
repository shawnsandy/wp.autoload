<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    /**
     *
     * @method boolean isiPhone()
     * @method boolean isBlackBerry()
     * @method boolean isHTC()
     * @method boolean isNexus()
     * @method boolean isDellStreak()
     * @method boolean isMotorola()
     * @method boolean isSamsung()
     * @method boolean isSony()
     * @method boolean isAsus()
     * @method boolean isPalm()
     *
     * @method boolean isBlackBerryTablet()
     * @method boolean isiPad()
     * @method boolean isKindle()
     * @method boolean isSamsungTablet()
     * @method boolean isMotorolaTablet()
     * @method boolean isAsusTablet()
     *
     * @method boolean isAndroidOS()
     * @method boolean isBlackBerryOS()
     * @method boolean isPalmOS()
     * @method boolean isSymbianOS()
     * @method boolean isWindowsMobileOS()
     * @method boolean isiOS()
     *
     * @method boolean isChrome()
     * @method boolean isDolfin()
     * @method boolean isOpera()
     * @method boolean isSkyfire()
     * @method boolean isIE()
     * @method boolean isFirefox()
     * @method boolean isBolt()
     * @method boolean isTeaShark()
     * @method boolean isBlazer()
     * @method boolean isSafari()
     * @method boolean isMidori()
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */

class mod_mobile extends Mobile_Detect {

    private static $instance;


    function __construct() {
        parent::__construct();
    }

    /**
     * detect if mobile is phone
     * @return boolean
     */
    public function isPhone() {
        if ($this->isMobile() AND !$this->isTablet()):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    /**
     * detect if mobile is tablet
     * @return boolean
     */
    public function isTabletDevice(){
        if($this->isGenericTablet() or $this->isBlackberrytablet() or $this->isIpad() or $this->isKindle() or $this->isSamsungTablet()
                or $this->isMotorolaTablet() or $this->isAsusTablet()):
            return true;
        else :
            return false;
        endif;
    }

    public static function  instance(){
         if (!isset(self::$instance)) {
            self::$instance = new mod_mobile();
        }
        return self::$instance;

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
     * adds a mobile class to the body
     */
    public static function mobile_class(){
        add_filter( 'body_class', array('mod_mobile','add_mobile_classes'));
    }

    public function add_mobile_class($classes){
        $classes[] = 'mobile';
     return $classes;
    }


    public function add_mobile_classes($class){

        //detect if is mobile device
        if(mod_mobile::detect()->isMobile()) $class[] = 'mobile';
        //mobile phone
        if(mod_mobile::detect()->isPhone()) $class[] = 'phone';
        //is tabler
        if(mod_mobile::detect()->isTablet()) $class[] = 'tablet';
        //is android
        if(mod_mobile::detect()->isAndroidOS()) $class[] = 'android';
        //is iOS
        if(mod_mobile::detect()->isiOS()) $class[] = 'ios';
        //return class
        return $class;

    }


}

