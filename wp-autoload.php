<?php

/**
 * Description of wp-autoload
 *
 * @author studio
 */
class wp_autoload {

    protected $class,
            $paths,
            $lowercase = false;

    public function set_paths($paths) {
        $this->paths = $paths;
        return $this;
    }

    public function set_lowercase($lowercase) {
        $this->lowercase = $lowercase;
        return $this;
    }

    public function set_class($class) {
        $this->class = $class;
        return $this;
    }

    public function __construct() {

    }

    /**
     *
     * @return \wp_autoload
     */
    static function factory() {
        $factory = new wp_autoload();
        return $factory;
    }

    /**
     * Load;
     * @param boolean $lowercase_paths - use lowercase path names
     */
    public function load($lowercase_paths = false) {
        $this->lowercase = $lowercase_paths;
//        $paths[] = WP_PLUGIN_DIR . '/al-manager/classes/';
//        $paths[] = WP_PLUGIN_DIR . '/';
//        $paths[] = WP_CONTENT_DIR . '/themes/';
        //$this->paths = $paths;
        $this->register();
    }

    public function register() {
        /**
         * autoload with compat
         */
        if (function_exists('__autoload'))
            spl_autoload_register('__autoload');
        spl_autoload_register(array($this, 'autoload'));
    }

    public function autoload($class) {

        $classname = $class . '.php';
        $classname = str_replace('_', '/', $classname);
        $this->get_path(WP_PLUGIN_DIR . '/al-manager/classes/' . $classname);
        $this->get_path(WP_PLUGIN_DIR . '/' . $classname);
        $this->get_path(WP_CONTENT_DIR . '/themes/' . $classname);
        $this->get_path(get_template_directory().'/classes/');

    }

    /**
     *
     * @param string $path
     * @param bool $lowercase
     */
    protected function get_path($path) {

        if (file_exists($path)):
            include_once $path;
        else :
            //echo $path;
        endif;
    }

    /**
     * Test function
     */
    public static function hello() {
        echo "hello world";
    }

}
