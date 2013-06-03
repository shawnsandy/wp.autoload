<?php

/**
 * Description of Functions
 *
 * @author studio
 */
class Theme_Function {

    public function __construct() {

    }

    /**
     * Displays themes site logo
     * @param type $img_url default logo img url
     * @return string hmtl img of site name or set $img_url
     */
    public static function logo($img_url = null) {
        BJ::site_logo($img_url);
    }

    /**
     * Displaye the site slug of the default description
     * @return type
     */
    public static function slug() {
        echo BJ::site_slug();
    }

    public static function contact_us() {
        BJ::contact_org();
    }

    public static function contact_author() {
        BJ::contact_author();
    }

    public static function fluid_images() {
        Fn_Images::factory()->fluid_images();
    }

    public static function breadcrumbs(){
        core_functions::breadcrumbs();
    }


    public static function breadcrumb_list(){
        if ( !is_front_page() ) {
		echo '<ul class="breadcrumb"><li class="breadcrumb-info">You are here:</li> <a href="';
		echo get_option('home');
		echo '">';
		bloginfo('name');
		echo "</a> &raquo; ";
		}

		if ( is_category() || is_single() ) {
			$category = get_the_category();
			$ID = $category[0]->cat_ID;
			echo get_category_parents($ID, TRUE, ' &raquo; ', FALSE );
		}

		if(is_single() || is_page()) {the_title();}
		if(is_tag()){ echo "Tag: ".single_tag_title('',FALSE); }
		if(is_404()){ echo "404 - Page not Found"; }
		if(is_search()){ echo "Search"; }
		if(is_year()){ echo get_the_time('Y'); }

		echo "</ul>";

          }


    public static function add_contact_info(){
        cwp_social::contact_info();
    }


    public static function browser_shots(){
        cwp::browsershots();
    }

    public static function mobile_detect(){

        //return mod_mobile::instance();
        return new Mobile_Detect();

    }



    /**
     *
     * @param type $name
     * @param type $default
     * @return type
     */
    public static function theme_mod($name = '', $default){

        $mod = get_theme_mod($name);

        if(empty($mod)) return $default;

        return $mod;

    }

    public static function layout_content($option_name = 'option_name'){
        $option = get_theme_mod($option_name);

        if(empty($option)) return FALSE;
        $page = get_post($option);
        if (isset($page) or !empty($page)):
            return $page;
        else :
            return false;
        endif;
    }

}
