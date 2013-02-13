<?php

/**
 * @package WordPress
 * @subpackage Core-WP
 * @author shawnsandy
 */

class cwp_meta {
    //put your code here
    public function __construct() {

    }

    public static function metabox() {
        $theme = get_theme_data(get_stylesheet_uri());
        $arr['id'] = 'cwp_meta';
        $arr['title'] = $theme['Ttile'].' Meta';
        $arr['template'] = self::locate_file_path('cwp_metabox.php');
        $arr['autosave'] = true;
        $meta = new WPAlchemy_MetaBox($arr);
    }

}

?>
