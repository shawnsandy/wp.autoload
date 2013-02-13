<?php

/**
 * Description of cwp_theme
 *
 * @author Studio365
 * @todo create a dafault_id variable to structure the use of the classs allow the user to set the ID using an object and not worry about it
 * <code>cwp_theme::options()->setOption_id(4)</code>
 */
class cwp_theme {

    //put your code here
            private $main_copy,
            $header_copy,
            $footer_copy,
            $subscribe_copy,
            $copyright_copy,
            $contact_copy,
            $offline_copy,
            $_404_copy,
            $_404_elements,
            $default_option,
            $headline_copy;

    private static $instance;

    private function __construct() {
        //$this->default_option = cwpt::default_id();
    }

    /**
     * Factory pattern
     * @return \cwp_theme
     */
    public static function options() {
        return new cwp_theme;
    }


    /**
     * Singleton pattern.
     * @return type
     */
    public static function instance(){
         if (!is_object(self::$instance)) {
             $class = __CLASS__ ;
            self::$instance = new $class;
        }
        return self::$instance;
    }

    /**
     *
     * @return type
     */
    public static function default_id(){
        $def = null;
        // get the last published custom_optinos and use as id
        $args = array('showposts'=>1,'post_type'=>'cwp_custom_options','orderby'=>'menu_order');
        $def_opt = get_posts($args);
        if(isset($def_opt) AND !empty($def_opt))
        $def = $def_opt[0]->ID;
        return $def;
    }


    //********************************Custom options ***************************

    public static function the_main_copy($id = null) {
        if (!isset($id))
            $id = self::default_id();
        $meta = get_post_meta($id, '_cwpt_main_copy', true);
        $main_copy = $meta ? $meta : __('Go to options and enter your homepage copy here. Credibly seize an expanded array of customer service vis-a-vis mission-critical meta-services. Proactively target timely growth strategies through. ','corewp');
        return $main_copy;
    }

    public static function the_header_copy($id = null) {
        if (!isset($id)) $id = self::default_id();
        $meta = get_post_meta($id, '_cwpt_header_copy', true);
        $header_copy = $meta ? $meta : __('Go to options and replace with your header copy','corewp');
        return $header_copy;

    }

    public static function the_footer_copy($id = null) {
        if (!isset($id)) $id = self::default_id();
        $meta = get_post_meta($id, '_cwpt_footer_copy', true);
        $footer_copy = $meta ? $meta : __('Go to options and replace with your header copy','corewp');
        return $footer_copy;
    }

    public static function the_subscribe_copy($id = null) {
       if (!isset($id)) $id = self::default_id();
        $meta = get_post_meta($id, '_cwpt_sucscribe_copy', true);
        $sucscribe_copy = $meta ? $meta : __('Subscribe and get the latest updates, news, specials and more...','corewp');
        return $sucscribe_copy;
    }

    public static function the_copyright_copy($id = null) {
        if (!isset($id)) $id = self::default_id();
        $meta = get_post_meta($id, '_cwpt_copyright_copy', true);
        $copyright_copy = $meta ? $meta : __('All Rights Reserved','corewp');
        return $copyright_copy;
    }

    public static function the_contact_copy($id = null) {
        if (!isset($id)) $id = self::default_id();
            $meta = get_post_meta($id, '_cwpt_contact_copy', true);
        $contact_copy = $meta ? $meta : __('All Rights Reserved','corewp');
        return $contact_copy;

    }

    public static function the_offline_copy($id = null) {
        if (!isset($id)) $id = self::default_id();
        $meta = get_post_meta($id, '_cwpt_offline_copy', true);
        $copy = $meta ? $meta : __('Sorry we missed you, we currently taking care of some loose ends, we will be online shortly, you can stay in touch or contact us, get news and updates on Twitter, Facebook, Google+ .','corewp');
        return $copy;
    }

    public static function the_404_copy($id = null) {
        if (!isset($id)) $id = self::default_id();
        $meta = get_post_meta($id, '_cwpt_404_copy', true);
        $copy = $meta ? $meta : __('Go to options and replace with your header copy','corewp');
        return $copy;
    }

    public static function the_404_elements($id = null) {
        if (!isset($id)) $id = self::default_id();
        $meta = get_post_meta($id, '_cwpt_404_elements', true);
        $copy = $meta ? $meta : __('Go to options and replace with your header copy','corewp');
        return $copy;
    }

    public static function the_headline_copy($id = null) {
        if (!isset($id))
            $id = self::default_id();
        $meta = get_post_meta($id, '_cwpt_headline_copy', true);
        $headline_copy = $meta ? $meta : __('This is where your headline copy will appear','corewp') ;
        return $headline_copy;
    }

    public static function the_offline_slug($id = null) {
        if (!isset($id))
            $id = self::default_id();
        $meta = get_post_meta($id, '_cwpt_offline_slug', true);
        $headline_copy = $meta ? $meta : __('Offline Mode','corewp') ;
        return $headline_copy;
    }

    public static function the_404_slug($id = null) {
        if (!isset($id))
            $id = self::default_id();
        $meta = get_post_meta($id, '_cwpt_404_slug', true);
        $headline_copy = $meta ? $meta : __('Sorry it appears that the page you are loooking for is not available!','corewp') ;
        return $headline_copy;
    }

    public static function the_content($id=null) {
        // get the last published custom_optinos and use as id
        //$args = array('showposts'=>1,'post_type'=>'cwp_custom_options','orderby'=>'menu_order');
        if (!isset($id))
            $id = self::default_id();
        $def_opt = get_post($id);
        if(isset($def_opt) AND !empty($def_opt))
        $content = $def_opt->post_content;
        return $content;
        //return $headline_copy;
    }

    public static function show_home($id = null) {
        global $post;
        if (!isset($id))
            $id = $post->ID;
        $meta = get_post_meta($id, '_cwpt_show_home', true);
        return $meta;
    }

    //*******************Images*************************************************

    /**
     *
     * @param type $id
     * @param type $size
     * @return type
     */
    public static function theme_logo($id, $size = 'theme-logo') {
        if (!isset($id))
            $id = self::default_id();
        if(MultiPostThumbnails::has_post_thumbnail('cwp_custom_options', $id)):
        return MultiPostThumbnails::the_post_thumbnail('cwp_custom_options', 'theme-logo', $id, $size);
            else :
        return false ;
        endif;

    }


    /**
     *
     * @param type $id
     * @param type $size
     * @return type
     */
    public static function theme_404_image($id=null, $size = '404-large') {
        if (!isset($id))
            $id = self::default_id();
        if(MultiPostThumbnails::has_post_thumbnail('cwp_custom_options', $id)):
         return MultiPostThumbnails::the_post_thumbnail('cwp_custom_options', '404-image', $id, $size);
            else :
          return false;
        endif;

    }

    /**
     *
     * @param type $id
     * @param type $size
     * @return type
     */
    public static function theme_offline_image($id=null, $size = 'offline-large') {
        if (!isset($id)) $id = self::default_id();
        if(MultiPostThumbnails::has_post_thumbnail('cwp_custom_options', $id)):
         return MultiPostThumbnails::the_post_thumbnail('cwp_custom_options', 'offline-image', $id, $size);
            else :
         return false;
        endif;

    }


    /**
     * sizes - large,medium,thumbnail
     * @param type $size
     * @param type $width
     * @param type $height
     * @param type $crop
     */
    public static function set_image_($size='large',$width=1024,$height=800,$crop=false){
        //size_w,size_h,c
        update_option($size.'_large_w', $width);
        update_option($size.'_large_h', $height);
        if($crop)
        update_option($size.'_crop', $crop);
    }

    public static function edit_options($info="Edit Options"){
        echo '<span class="label label-warning">'.$info.'</span>';
    }

  

}

