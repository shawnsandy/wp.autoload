<?php

/**
 * Description of al_manager
 *
 * @author Studio365
 */
define('AL_DIR', dirname(__FILE__));
define('AL_URL', plugins_url() . '/al-manager');




include_once AL_DIR . '/autoloadManager.php';

class al_manager {

    private static $instance;

    /**
     *
     */
    private function __construct() {
        //$this->autoload();
    }

    /**
     *
     * @return type
     */
    public static function instance() {
        if (!isset(self::$instance)) {
            self::$instance = new al_manager();
        }
        return self::$instance;
    }

    /**
     * class factory
     * @return \al_manager
     */
    public static function load() {
        return new al_manager;
    }

    /**
     * class factory
     * @return \al_manager
     */
    public static function factory() {
        return new al_manager;
    }

    /**
     * Sigleton pattern
     */

    /**
     *
     */
    public function autoload() {
//        //autoload class
//        $autoloadManager = new AutoloadManager();
//        //sets the save path fo the file
//        $autoloadManager->setSaveFile(AL_DIR . '/autoload.php');
        // Define folders array
        $folders = array();
        //default folder
        //*******THEME VENDOR DIRECTORY********
        $folders[] = AL_DIR . '/includes/';
        $folders[] = AL_DIR . '/inc/';
        $folders[] = WP_PLUGIN_DIR . '/al-manager/vendor/';
        if (file_exists(get_stylesheet_directory() . '/vendor/'))
            $folders[] = get_stylesheet_directory() . '/vendor/';
        if (file_exists(get_template_directory() . '/vendor/'))
            $folders[] = get_template_directory() . '/vendor/';
        //*******WP_CONTENT VENDOR DIRECTORY********
        if (file_exists(WP_CONTENT_DIR . '/vendor/'))
            $folders[] = WP_CONTENT_DIR . '/vendor/';
        //add the filter
        $_folders = $this->get_class_folders();

        if (is_array($_folders))
            $folders = array_merge($_folders, $folders);

        // add Folder paths stored in the folder array
//        foreach ($all_folders as $path):
//            $autoloadManager->addFolder($path);
//        endforeach;
//        $autoloadManager->register();

        $this->add_classes(AL_DIR . '/autoload.php', $folders);
        return $this;
    }

    public function get_class_folders() {
        $folders = get_option('ALM_class_folders');
        return is_array($folders) ? $folders : array();
    }

    /**
     * Add you class to the folder
     * @param string $folder - $folder full path to your class folder
     * @return \al_manager
     */
    public function add_class_folder($folder = null) {
        $fl = $this->get_class_folders();
        if (!file_exists($folder))
            return $this;
        if (!in_array($folder, $fl)):
            $addfl = array_merge($fl, array($folder));
            update_option('ALM_class_folders', $addfl);
        endif;

        return $this;
    }

    public function del_class_folder($folder_name = null) {
        if (isset($folder)):
            if ($opts = get_option('ALM_class_folders')):
                foreach ($opts as $key => $value) {
                    if ($value == $folder):
                        unset($opts[$key]);
                    endif;
                }
            endif;
            update_option('ALM_class_folders', $opts);
        endif;
    }

    public function clean_options() {
        $opts = $this->get_class_folders();
        foreach ($opts as $key => $value) {
            if (!file_exists($value)):
                $this->del_class_folder($value);
            endif;
        }
    }

    public function add_classes($save_to = null, $folders = array()) {

        $autoloadManager = new AutoloadManager();
        //sets the save path fo the file
        $autoloadManager->setSaveFile($save_to);
        // add Folder paths stored in the folder array
        foreach ($folders as $path):
            $autoloadManager->addFolder($path);
        endforeach;

        $autoloadManager->register();
    }

    public function add_folders_filter() {

        if (has_filter('alm_filter')):
            $folders = array();
            $_folders = apply_filters('alm_filter', $folders);
            //check if is array / not empty
            if (empty($_folders) or !is_array($_folders))
                return false;

            foreach ($_folders as $value) {
                $this->add_class_folder($value);
            }
            return $this;
        endif;
    }

    public function del_folders_filter() {

        if (has_filter('del_alm_filter')):
            $folders = array();
            $_folders = apply_filters('del_alm_filter', $folders);
            //check if is array / not empty
            if (empty($_folders) or !is_array($_folders))
                return false;

            foreach ($_folders as $value) {
                $this->del_class_folder($value);
            }
            return $this;
        endif;
    }

    /**
     * use to add your custom classes please create the custom
     */
    public static function custom_path() {
        add_filter('alm_filter', array('al_manager', 'custom'));
    }

    public function custom($folders) {
        $dir = array(AL_DIR . '/custom/');
        $folders = array_merge($dir, $folders);
        return $folders;
    }

    public static function add_libraries() {
        add_filter('alm_filter', array('al_manager', 'libraries'));
    }

    public function libraries($folders) {
        $dir = array(AL_DIR . '/library/');
        $folders = array_merge($dir, $folders);
        return $folders;
    }

    public static function add_vendors() {
        //sample fliter adds 'inc' dir to the autoload paths
        $vendors = array(
            WP_CONTENT_DIR . '/vendor/',
            WP_PLUGIN_DIR . '/al-manager/vendor/',
        );
        $p = array(WP_PLUGIN_DIR . '/al-manager/inc/', WP_PLUGIN_DIR . '/al-manager/vendor/');
        $folders = array_merge($vendors, $folders);
        return $folders;
    }

}

