<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Layout
 *
 * @author studio
 */
class Tpl_Layout {

    public function __construct() {

    }

    static $main_tpl;
    static $base_tpl;
    static $bj_tpl_directory;

    public static function base_tpl() {
        return self::$base_tpl;
    }

    public static function bj_tpl_directory() {

        return self::$bj_tpl_directory = get_option('bj_tpl_directory', 'tpl');
    }

    public static function set_bj_tpl_directory($bj_tpl_directory = 'tpl') {

        update_option('bj_tpl_directory', $bj_tpl_directory);
    }

    /**
     * use other tpl
     * @param type $name
     * @param type $slug
     * @since v 0.1
     */
    public static function use_tpl($name = NULL, $dir = 'themes') {
        $use = "index";
        if (isset($name))
            $use = "tpl/{$dir}/tpl-{$name}";
        get_template_part($use);
    }

    public static function content() {
        return self::$main_tpl;
    }

    public static function mobile_templates($template) {

        global $post;

        /**
         * detect if it is a is phone or go mobile
         * prefix the $template with mobile / phone
         * return the $template name
         */

        $phone = self::is_mobile();

         //$tpl = self::base($template);

        $template_name = self::template_name($template);
//        if(is_single()) $template_name = '-single';
//        if(is_page()) $template_name = '-page';
//        if(is_archive()) $template_name = '-archive';
//        if(is_search()) $template_name = '-search';
//        if(is_404()) $template_name = '-404';
//        if(is_post_type_archive() and isset($post->ID)) $template_name = get_post_type ($post->ID);

        if($phone):
            if($phone == 'mobile-device'):

            $located = locate_template(array(
                'mobile-'.$template_name.'.php',
                'mobile.php',
                'tablet-'.$template_name.'.php',
                'tablet.php',
                $template_name.'.php'
                ));
            else :
               $located = locate_template(array(
               'tablet-'.$template_name.'.php',
               'tablet.php',
               $template_name.'.php'
                ));
            endif;

        if (!empty($located))
                $template = $located;
        endif;

        return $template;

    }

    public static function is_mobile() {



        $detect = new Mobile_Detect();
        if(!$detect->isMobile())
            return false;

        $mobile = 'tablet-device';
        if ($detect->isMobile() && !$detect->isTablet()):
            $mobile = 'mobile-device';
        endif;
        return $mobile;
    }

    public static function post_type_templates($template) {

        /** access gobal */
        global $post;



        /** check for post id * */
        if (!isset($post->ID))
            return $template;

        /** get the post type */
        $post_type = get_post_type($post->ID);

        /** get the custom types */
        $custom_types = get_post_types(array('public' => TRUE,
            '_builtin' => false));

        //grab and use the post type the slug
        $obj = get_post_type_object($post_type);

        $slug = strtolower($obj->rewrite['slug']);

        /** if post type archive template name is post_type */
        if (is_post_type_archive()) {

            $located = locate_template(array(
                $post_type . '.php',
                $slug . '.php'));

            if (!empty($located))
                $template = $located;
            //get_query_template($post_type);
        }

        return $template;
    }

    public static function single_post_type_templates($template) {

        /** access gobal */
        global $post;
        /** get the post type */
        $post_type = get_post_type($post->ID);
        /** get the custom types */
        $custom_types = get_post_types(array('public' => TRUE,
            '_builtin' => false));

        if (is_single() && in_array($post_type, $custom_types)) {

            $obj = get_post_type_object($post_type);

            $template_name = strtolower($obj->rewrite['slug']);

            $located = locate_template(array('single-' . $post_type . '.php', 'single-' . $template_name . '.php'));

            if (!empty($located))
                $template = get_query_template('single-' . $template_name);
        }

        return $template;
    }

    public static function the_content() {
        return self::$main_tpl;
    }


    public static function template_name($template){
        return substr(basename($template), 0, -4);;
    }

    /**
     *
     * @param type $template
     */
    public static function tpl_include($template) {

        self::bj_tpl_directory();

        $tpl_dir = self::$bj_tpl_directory;

        self::$main_tpl = $template;

        //checks to see if mobile template is available
        //searches the stylesheet directory for the mobile template only allows easy disable.
        $mobile_themes = false;
        if (file_exists(get_stylesheet_directory() . '/mobile.php') or file_exists(get_template_directory() . '/mobile.php')):
            $mobile_themes = true;
        endif;

        //checks to see if mobile-phone tempalte is available
        $mobile_phone_themes = false;
        if (file_exists(get_stylesheet_directory() . '/mobile-phone.php') or file_exists(get_template_directory() . '/mobile-phone.php')):
            $mobile_phone_themes = true;
        endif;


        self::$base_tpl = substr(basename(self::$main_tpl), 0, -4);
        if ('index' == self::$base_tpl)
            self::$base_tpl = false;

        /**
         *  check to seee if a mobile templaate exists in stylesheet dir and load
         *  to disable mobile themes create a child theme without a mobile template
         */

            /*
             * go back to the default theme files
             * theme/tpl/layout/file.php -  theme/tpl/index.php
             */
            $templates = array($tpl_dir . '/themes/tpl-index.php', 'tpl/layout/tpl-index.php', 'tpl/layout/index.php',);
            if (self::$base_tpl) {

                //foundation themes  - may remove foundation entirely
                //array_unshift($templates, sprintf('tpl/sample/tpl-%s.php', self::$base_tpl));
                array_unshift($templates, sprintf($tpl_dir . '/layout/tpl-%s.php', self::$base_tpl));
                array_unshift($templates, sprintf($tpl_dir . '/themes/tpl-%s.php', self::$base_tpl));
            }


        return locate_template($templates);

        // self::locate_tpl($templates, null, true);
        // return self::locate_tpl($templates);
    }

    /**
     *
     * @param string $template_names
     * @param string $slug null
     * @param bool $load false
     * @param bool $require_once true
     * @return string
     */
    public static function locate_tpl($template_names, $slug = null, $load = false, $require_once = true) {

        $located = false;
        self::bj_tpl_directory();
        $path = self::$bj_tpl_directory;

        if (isset($slug))
            $path = $path . "/{$slug}/";
        foreach ((array) $template_names as $template_name) {
            if (!$template_name)
                continue;
            if (file_exists(STYLESHEETPATH . "/{$path}" . $template_name)) {
                $located = STYLESHEETPATH . "/{$path}" . $template_name;
                break;
            } else if (file_exists(TEMPLATEPATH . "/{$path}" . $template_name)) {
                $located = TEMPLATEPATH . "/{$path}" . $template_name;
                break;
            } else if (file_exists(STYLESHEETPATH . '/' . $template_name)) {
                $located = STYLESHEETPATH . '/' . $template_name;
                break;
            } else if (file_exists(TEMPLATEPATH . '/' . $template_name)) {
                $located = TEMPLATEPATH . '/' . $template_name;
                break;
            } else if (file_exists(CWP_PATH . "/{$path}" . $template_name)) {
                $located = CWP_PATH . "/{$path}" . $template_name;
                break;
            }
        }


        if ($load && '' != $located)
            return $located;
    }

    /**
     * Uses wordpress get_template part to retrieve template flies in the tpl directory
     * with slight template names variation $prefixes to the $name
     * $prefix = hierachy : ($slug-single-$name)
     * $prefix = post_type : ($slug-$post_type-$name)
     * @global type $post
     * @param type $slug
     * @param type $name
     * @param type $prefix
     * @param type $base_dir
     */
    public static function get_template_part($slug = 'content', $name = null, $base_dir = 'views') {
        get_template_part(self::$bj_tpl_directory . '/' . $base_dir . '/' . $slug, $name);
    }

    public static function get_header($name = null, $base_dir = 'layout') {
        $slug = 'tpl-header';
        Tpl_Layout::get_template_part($slug, $name, $base_dir);
    }

    public static function get_footer($name = null, $base_dir = 'layout') {
        $slug = 'tpl-footer';
        Tpl_Layout::get_template_part($slug, $name, $base_dir);
    }

    public static function get_content($name = null, $base_dir = 'views') {
        $slug = 'content';
        Tpl_Layout::get_template_part($slug, $name, $base_dir);
    }

    /**
     * Theme mods allow you theme designers to allow custom pre defined template content (modules) into themes
     * Modules (mods) file names are predefined in the theme.
     * Create the file module_name.php add your module to the theme/child tpl/modules directory
     * it's simple but works
     * @uses Tpl_Layout::theme_mods('module_name') //automatically locate and find modules from your stylesheet / template directory
     *
     */
    public static function theme_mods($module = null, $base = '', $dir = 'modules') {

        if (isset($module)):
            $locate_mod = Tpl_Layout::locate_tpl($module . '.php', $dir);
            if ($locate_mod) {
                Tpl_Layout::get_template_part($module, $base, $dir);
                return true;
            }
            else
                return false;
        endif;
    }

    /**
     * Theme mods allow you theme designers to allow custom pre defined template content (modules) into themes
     * Modules (mods) file names are predefined in the theme.
     * Create the file module_name.php add your module to the theme/child tpl/modules directory
     * it's simple but works
     * @uses Tpl_Layout::theme_mods('module_name') //automatically locate and find modules from your stylesheet / template directory
     *
     */
    public static function dropin($module = null, $name = '', $dir = 'modules') {
        return Tpl_Layout::theme_mods($module, $dir);
    }

    /**
     * Theme mods allow you theme designers to allow custom pre defined template content (modules) into themes
     * Modules (mods) file names are predefined in the theme.
     * Create the file module_name.php add your module to the theme/child tpl/modules directory
     * it's simple but works
     * @uses Tpl_Layout::theme_mods('module_name') //automatically locate and find modules from your stylesheet / template directory
     *
     */
    public static function section_mod($module = null, $name = null, $dir = 'modules') {
        if (!$name)
            $name = Tpl_Layout::$base_tpl;
        return Tpl_Layout::theme_mods($module, $name, $dir);
    }

    public static function tpl($tpl = null) {
        if (isset($tpl)):
            $locate_mod = Tpl_Layout::locate_tpl('tpl-' . $tpl . '.php', 'themes');
            if (!$locate_mod)
                $locate_mod = Tpl_Layout::locate_tpl('tpl-' . $tpl . '.php', 'layout');
            //Tpl_Layout::get_template_part ($module,'', $dir);
            if ($locate_mod)
                include_once $locate_mod;
            else
                _e('Error locating tpl', 'basejump');
        endif;
    }

    public static function layout_tpl_metabox($post_types = array('post')) {

        if (class_exists('RW_Meta_Box')) {
            $meta = BJ_METABOXES::factory();
            $meta_field[] = $meta->text_field('_page_tpl', 'Page Template', 'Enter page template name ()');
            $meta->set_metabox_context('side');
            $meta->set_metabox_fields($meta_field);
            $meta->add_metabox('tpl_meta', 'Page Tpl', $post_types);
        }
    }

}

