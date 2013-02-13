<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function app_template_path() {
    return APP_Wrapping::$main_template;
}

function app_template_base() {
    return APP_Wrapping::$base;
}

class APP_Wrapping {

    /**
     * Stores the full path to the main template file
     */
    static $main_template;

    /**
     * Stores the base name of the template file; e.g. 'page' for 'page.php' etc.
     */
    static $base;

    static function wrap($template) {
        self::$main_template = $template;

        self::$base = substr(basename(self::$main_template), 0, -4);

        if ('index' == self::$base)
            self::$base = false;

        $templates = array('wrapper.php');

        if (self::$base)
            array_unshift($templates, sprintf('wrapper-%s.php', self::$base));

        return locate_template($templates);
    }

}

add_filter('template_include', array('APP_Wrapping', 'wrap'));
?>

<?php $base = app_template_base(); ?>

<?php get_header($base); ?>

<section id="primary">
    <div id="content" role="main">

<?php include app_template_path(); ?>

    </div><!-- #content -->
</section><!-- #primary -->

<?php get_sidebar($base); ?>
<?php get_footer($base); ?>
