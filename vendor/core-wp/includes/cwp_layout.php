<?php

/**
 * @package WordPress
 * @subpackage Toolbox
 */

class cwp_layout {

    //put your code here

    public function __construct() {

    }

    private static $main_tpl;

    private static $base_tpl;

    public static function base_tpl() {
        return self::$base_tpl;
    }

    /**
     *
     * @param type $name
     * @param type $slug
     */
    public static function use_tpl($name = NULL,$slug=null) {
        $use = "index";
        if (isset($name))
            $use = "tpl-{$name}";
        self::tpl_part($slug, $use);
    }

    /**
     * Main Tpl Loads layout code (loop)
     * @param boolean $load use default wordpress loadtemplate
     * @param string $slug - location of directory in theme folder
     */
    public static function main_tpl($slug=null,$load=false) {
        $tpl = self::$main_tpl;
        if(isset($slug)) $tpl = $slug.'-'.self::$main_tpl;
        if($load):
            load_template($tpl);
        return;
        endif;
        include $tpl;
    }

    public static function tpl_include($template) {

        //checks to see if mobile theme is available
        $mobile_themes = false;
        if (file_exists(get_stylesheet_directory() . '/mobile.php') or file_exists(get_stylesheet_directory() . '/tbs-mobile.php')):
        $mobile_themes = true;
        endif;

        if (cwp::theme_settings('offline') == 1 and !current_user_can('manage_options'))
           self::$main_tpl = get_stylesheet_directory() . '/offline.php';
        else
            self::$main_tpl = $template;

        self::$base_tpl = substr(basename(self::$main_tpl), 0, -4);

        if ('index' == self::$base_tpl)
            self::$base_tpl = false;


        /**
         *  check to seee if a mobile templaate exists in stylesheet dir and load
         *  to disable mobile themes create a child theme without a mobile template
         */

        if ($mobile_themes AND mod_mobile::detect()->isPhone()) {
            /*
             * theme/tpl/layout/file.php -  theme/tpl/index.php
             */
            $templates = array('tpl/mobile/tbs-mobile.php', 'tpl/mobile/mobile.php',);
            if (self::$base_tpl) {
                //twitter bootstrap themes
                array_unshift($templates, sprintf('tpl/mobile/tpl-tbs-mobile-%s.php', self::$base_tpl));
                //foundation themes - may remove foundation entirely
                array_unshift($templates, sprintf('tpl/mobile/tpl-mobile-%s.php', self::$base_tpl));
            }
        } else {
            /*
             * theme/tpl/layout/file.php -  theme/tpl/index.php
             */
            $templates = array('tpl/layout/tbs-index.php','tpl/themes/index.php','tpl/layout/tpl-index.php','tpl/layout/index.php',);
            if (self::$base_tpl) {

                //foundation themes  - may remove foundation entirely
                //array_unshift($templates, sprintf('tpl/sample/tpl-%s.php', self::$base_tpl));
                array_unshift($templates, sprintf('tpl/layout/tpl-%s.php', self::$base_tpl));
                array_unshift($templates, sprintf('tpl/themes/tpl-%s.php', self::$base_tpl));
                //array_unshift($templates, sprintf('tpl/custom/tpl-%s.php', self::$base_tpl));
                //twitter bootstrap themes
                //array_unshift($templates, sprintf('tpl/sample/tpl-tbs-%s.php', self::$base_tpl));
                array_unshift($templates, sprintf('tpl/layout/tpl-tbs-%s.php', self::$base_tpl));
                array_unshift($templates, sprintf('tpl/themes/tpl-tbs-%s.php', self::$base_tpl));
               // array_unshift($templates, sprintf('tpl/custom/tpl-tbs-%s.php', self::$base_tpl));
            }
        }

        return locate_template($templates);

        //self::locate_tpl($template_names, $slug, $load, $require_once)
       // return self::locate_tpl($templates);

    }

    /**
     * searches for templates
     * @param string $slug default layout
     */
    public static function the_content($slug='layout') {
        $tpl = new core_tpl($slug);
        $template = $tpl->tpl($slug);
        load_template($template, false);
    }


    /**
     * locates and load templates
     * @param type $slug tpl directory - default content
     * @param type $name tpl name
     */
    public static function tpl_part($slug=null, $name = null,$load=true) {
        //do_action("get_template_part_{$slug}", $slug, $name);
        $templates = array();
        if (isset($name)):
            $templates[] = "themes/{$name}.php"; //**tpl/layout/name.php
            $templates[] = "layout/{$name}.php"; //**tpl/layout/name.php
            $templates[] = "base/{$name}.php"; //**tpl/content/name.php
            $templates[] = "base/general.php"; //**tpl/content/name.php
            //$templates[] = "sample/{$name}.php"; //**tpl/code/name.php
            $templates[] = "{$name}.php"; //**tpl/name.php
        endif;
        //$templates[] = "{$slug}.php";
        if (isset($slug)):
            $templates[] = "{$slug}/{$name}.php"; //** tpl/slug/name.php
            $templates[] = "{$slug}-{$name}.php"; //** tpl/slug/slug.php
            $templates[] = "{$slug}/index.php"; //** tpl/slug/index.php
            $templates[] = "{$name}.php";
            return $tpl = self::locate_tpl($templates, $slug, $load, false);
        else :
            return $tpl = self::locate_tpl($templates, null, $load, false);
        endif;
    }

    /**
     *
     * @param string $name tpl name
     * @param string $slug tpl dir
     */
    public function tpl_content($name='index',$slug = "content"){
        self::tpl_part($slug, $name);
    }

    /**
     *
     * @param string $template_names
     * @param string $slug null
     * @param bool $load false
     * @param bool $require_once true
     * @return string
     */
    public static function locate_tpl($template_names, $slug=null, $load = false, $require_once = true) {
        $located = '';
        $path = 'tpl/';
        if (isset($slug)) $path = "tpl/{$slug}/";
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
            load_template($located, $require_once);
        return $located;
    }

    public static function content($slug="layout") {
        $slug = $slug . '-content';
        $tpl = new core_tpl($slug);
        $template = $tpl->tpl($slug);
        load_template($template, false);
    }


    public static function format($post_format=null) {
        $name = "format-{$post_format}";
        self::tpl_part(null, $name);
    }

    public static function post_tpl($name=null,$post_query=null) {
        $tpl = '/'.$name.'.php';
        $cwp_query = $post_query;
        if(file_exists(get_stylesheet_directory().$tpl)){
            include_once get_stylesheet_directory().$tpl;
            return;
        } elseif (file_exists(get_template_directory().$tpl)){
            include_once get_template_directory().$tpl;
            return;
        }
    }



    /**
     *
     * @param type $slug
     */
    public static function header($slug=null) {
        $tpl = 'header';
        if (isset($slug))
            $tpl = "{$slug}-header";
        self::tpl_part(null, $tpl);
    }

    /*
     *
     * @param type $slug
     */
    public static function footer($slug=null) {
        $tpl = 'footer';
        if (isset($slug))
            $tpl = "{$slug}-footer";
        self::tpl_part(null, $tpl);
    }


    /**
     *
     * @param type $slug
     */
    public static function get_header($slug=null) {
        $tpl = 'header';
        if (isset($slug))
            $tpl = "header-{$slug}";
        self::tpl_part(null, $tpl);
    }

    /*
     *
     * @param type $slug
     */
    public static function get_footer($slug=null) {
        $tpl = 'footer';
        if (isset($slug))
            $tpl = "footer-{$slug}";
        self::tpl_part(null, $tpl);
    }

//
//    /**
//     *
//     * @param type $slug
//     */
//    public static function theme_header($slug=null) {
//        $name = 'theme-header';
//        if(isset($slug)):
//            $name = "{$slug}-header";
//        endif;
//        self::tpl_part(null, $name);
//    }

    /**
     *
     * @param type $slug
     */
    public static function get_theme_header($name=null) {
        $tpl = 'theme-header';
        if(isset($name)):
            $tpl = "theme-header-{$name}";
        endif;
        self::tpl_part('header', $tpl);
    }

//    /**
//     *
//     * @param type $slug
//     */
//    public static function theme_footer($slug=null) {
//         $name = 'theme-footer';
//        if(isset($slug)):
//            $name = "{$slug}-footer";
//        endif;
//        self::tpl_part(null, $name);
//    }


    /**
     *
     * @param type $slug
     */
    public static function get_theme_footer($name=null) {
         $tpl = 'theme-footer';
        if(isset($name)):
            $tpl = "theme-footer-{$name}";
        endif;
        self::tpl_part('footer', $tpl);
    }


    /**
     * Loads dynamic theme header
     * @param string $theme_prefix prefix theme headers/footer with - themename-
     * the_header('themename-')
     * create header tpl : themename-header-templatename.php
     * themename-header-home.php
     */
    public static function the_header($theme_prefix=null)
    {
        if(isset($theme_prefix)) $theme_prefix = "{$theme_prefix}-";
       $tpl = self::tpl_conditional("{$theme_prefix}header");
       self::locate_tpl($tpl, 'theme-header', true);
    }


    /**
     * Loads dynamic theme header
     * @param string $theme_prefix prefix theme headers/footer with - themename-
     * the_header('themename-')
     * create header tpl : themename-header-templatename.php
     * themename-header-home.php
     */
    public static function theme_header($theme_prefix=null,$slug='layout')
    {
        if(isset($theme_prefix)) $theme_prefix = "{$theme_prefix}-";
       $tpl = self::tpl_conditional("{$theme_prefix}header");
       self::locate_tpl($tpl, $slug, true);
    }


    /**
     * Loads dynamic theme footer
     * @param string $theme_prefix prefix theme headers/footer with - themename-
     * the_footer('themename')
     * create header tpl : themename-footer-templatename.php
     * themename-footer-home.php
     */
    public static function theme_footer($theme_prefix=null,$slug='layout')
    {
        if(isset($theme_prefix)) $theme_prefix = "{$theme_prefix}-";
       $tpl = self::tpl_conditional("{$theme_prefix}footer");
       self::locate_tpl($tpl, $slug, true);
    }

    /**
     * Loads dynamic theme footer
     * @param string $theme_prefix prefix theme headers/footer with - themename-
     * the_footer('themename')
     * create header tpl : themename-footer-templatename.php
     * themename-footer-home.php
     */
    public static function the_footer($theme_prefix=null)
    {
        if(isset($theme_prefix)) $theme_prefix = "{$theme_prefix}-";
       $tpl = self::tpl_conditional("{$theme_prefix}footer");
       self::locate_tpl($tpl, 'theme-footer', true);
    }

    /**
     *
     * returns a file name based on wordpress template file conditional functions for use in cwp layout
     * @global type $wp_query
     * @param string $_prefix tpl prefix default - header. if null is empty
     * @return string
     */
    public static function tpl_conditional($_prefix='header'){
        $prefix = 'index';
        if(isset($_prefix))
            $prefix="{$_prefix}-";
        //set up global
       global $wp_query;
        $id = $wp_query->get_queried_object_id();
        $object = $wp_query->get_queried_object();

        $template = get_post_meta($id, '_wp_page_template', true);
        $cwp_template = get_post_meta($id, '_cwp_page_template', true);
        //create a default template array
        $templates = array();

        if(is_home()){
            $templates[] = "{$prefix}home.php";
        }

        elseif(is_front_page()){
            $templates[] = "{$prefix}front-page.php";
        }


        elseif (is_single()) {

            $templates[] = "{$prefix}$cwp_template";
            $templates[] = "{$prefix}single-{$object->post_type}.php";
            $templates[] = "{$prefix}single.php";
        }

        elseif (is_page()) {
            $pagename = get_query_var('pagename');
            if (!empty($template) && !validate_file($template))
            $templates[] = "{$prefix}{$template}";
        elseif ($pagename)
            $templates[] = "{$prefix}page-{$pagename}.php";
        $templates[] = "{$prefix}page.php";


        }


        elseif (is_category()) {
            $templates[] = "{$prefix}category-{$object->slug}.php";
            $templates[] = "{$prefix}category-{$object->term_id}.php";
            $templates[] = "{$prefix}category.php";

        }

        elseif (is_archive() OR is_post_type_archive()) {
             $post_type = get_query_var('post_type');
            if ($post_type)
                $templates[] = "{$prefix}archive-{$post_type}.php";
            $templates[] = "{$prefix}archive.php";
        }

        elseif(is_search()){
            $templates[] = "{$prefix}search";

        }

        elseif(is_tag()){
        $templates[] = "{$prefix}tag-{$object->slug}.php";
        $templates[] = "{$prefix}tag.php";

        }

        elseif(is_tax()){
            $taxonomy = $object->taxonomy;
        $templates[] = "{$prefix}taxonomy-$taxonomy-{$term->slug}.php";
        $templates[] = "{$prefix}taxonomy-$taxonomy.php";
        $templates[] = "{$prefix}taxonomy.php";
        }

        elseif (is_author()){
            $templates[] = "{$prefix}author-{$object->user_nicename}.php";
            $templates[] = "{$prefix}author.php";
        }

        elseif(is_date()){
            $templates[] = "{$prefix}date.php";
        }


        elseif(is_404()){
            $templates[] = "{$prefix}404.php";
        }

        /*
        if(is_attachment()):
            global $posts;
        $type = explode('/', $posts[0]->post_mime_type);
        if ($template = $this->get_query_template($type[0]))
            return $template;
        elseif ($template = $this->get_query_template($type[1]))
            return $template;
        elseif ($template = $this->get_query_template("$type[0]_$type[1]"))
            return $template;
        else
            return $this->get_query_template('attachment');

        endif;
         */

        $templates[] = "{$_prefix}.php";
        return $templates;


    }


    /**
     *
     * @param type $slug
     */
    public static function sidebar($slug=null) {
        $tpl = 'sidebar';
        if (isset($slug))
            $tpl = "{$slug}-sidebar";
        self::tpl_part(null, $tpl);
    }

    /**
     *
     * @param type $slug
     */
    public static function get_sidebar($slug=null) {
        $tpl = 'sidebar';
        if (isset($slug))
            $tpl = "{$slug}-sidebar";
        self::tpl_part('base', $tpl);
    }

    /**
     *
     * @param type $slug
     */
    public static function the_sidebar($slug=null) {
        $tpl = 'sidebar';
        if (isset($slug))
            $tpl = "sidebar-{$slug}";
        self::tpl_part('base', $tpl);
    }

    public static function searchform($form='searchform',$slug='elements') {
        self::tpl_part($slug,$form );
    }

    public static function script($name=null){

        if(isset($name)){
            $tpl = $name ;
        }
        self::tpl_part('scripts', $tpl);
    }

    public static function get_template_part($slug,$name=NULL,$path = 'tpl'){
        //get_template_part($slug, $name);
        $file_dir = 'tpl/'.$slug.'/';

        if($file = file_exists($tpl_style_dir)):

        endif;


    }

}