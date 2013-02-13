<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NavMenu
 *
 * @author studio
 */
class TPL_NavMenu {

    private $menu,
            $theme_location = 'primary',
            $fallback_cb = '',
            $depth = 1,
            $link_before = '',
            $link_after = '',
            $before = '',
            $after = '',
            $echo = true,
            $container = false,
            $container_class = '',
            $menu_class = 'nav',
            $walker ='',
            $items = '',
            $menu_name = '',
            $items_wrap = '<ul id=\"%1$s\" class=\"%2$s\">%3$s</ul>',
            $menu_array = array();

    public function set_items_wrap($items_wrap) {
        $this->items_wrap = $items_wrap;
        return $this;
    }

    public function set_container_class($container_class) {
        $this->container_class = $container_class;
        return $this;
    }

    public function set_walker($walker) {
        $this->walker = $walker;
        return $this;
    }

    public function set_items($items) {
        $this->items = $items;
        return $this;
    }

    public function set_menu_name($menu_name) {
        $this->menu_name = $menu_name;
        return $this;
    }

    public function set_menu($menu) {
        $this->menu = $menu;
        return $this;
    }

    public function set_theme_location($theme_location) {
        $this->theme_location = $theme_location;
        return $this;
    }

    public function set_fallback_cb($fallback_cb) {
        $this->fallback_cb = array($this, 'default_menu');
        return $this;
    }

    public function set_depth($depth) {
        $this->depth = $depth;
        return $this;
    }

    public function set_link_before($link_before) {
        $this->link_before = $link_before;
        return $this;
    }

    public function set_link_after($link_after) {
        $this->link_after = $link_after;
        return $this;
    }

    public function set_before($before) {
        $this->before = $before;
        return $this;
    }

    public function set_after($after) {
        $this->after = $after;
        return $this;
    }

    public function set_echo($echo) {
        $this->echo = $echo;
        return $this;
    }

    public function set_container($container) {
        $this->container = $container;
        return $this;
    }

    public function set_menu_class($menu_class) {
        $this->menu_class = $menu_class;
        return $this;
    }

    public function set_menu_array($menu_array) {
        $this->menu_array = $menu_array;
        return $this;
    }

    public function __construct() {
        $this->fallback_cb = array($this,'default_menu');
    }

    /**
     * Factory pattern
     * @return \EXT_WPNavs
     */
    public function factory() {
        return $factory = new TPL_NavMenu();
    }


    public function default_menu(){

    }

    /**
     * <code>
     * Ttp_NavMenu::factory()->set_depth(0)->menu('primary');
     * </code>
     * @param type $theme_location
     * @return \cwp_navs
     */
    public function menu($theme_location) {
        //$this->theme_location = $theme_location;

        $this->theme_location = $theme_location;

        wp_nav_menu(array(
            'theme_location' => $this->theme_location,
            'fallback_cb' => $this->fallback_cb,
            'container' => $this->container,
            'container_class' => $this->container_class,
            'menu_class' => $this->menu_class,
            'echo' => $this->echo,
            'before' => $this->before,
            'after' => $this->after,
            'link_before' => $this->link_before,
            'link_after' => $this->link_after,
            'depth' => $this->depth,
            'walker' => $this->walker
        ));
        return $this;
    }

    public function add_loginout() {
        add_filter('wp_nav_menu_items', array($this, 'loginout'), 10, 2);
    }

    /**
     * @param type $items
     * @param type $args
     * @param type $location
     * @return string
     */
    public function loginout($items, $args) {
        if (is_user_logged_in() && $args->theme_location == $this->theme_location) {
            $items .= '<li><a href="' . wp_logout_url() . '">' . __('Log Out', 'corewp') . '</a></li>';
        } elseif (!is_user_logged_in() && $args->theme_location == $this->theme_location) {
            $items .= '<li><a href="' . site_url('wp-login.php') . '">' . __('Log In', 'corewp') . '</a></li>';
        }
        return $items;
    }

    /**
     */
    public function add_search() {
        add_filter('wp_nav_menu_items', array($this, 'add_search_box'));
    }

    /**
     *
     * @param type $items
     * @param type $args
     * @param type $location
     * @return type
     */
    public function add_search_box($items, $args) {
        ob_start();
        ?>
        <form class="navbar-search pull-right" method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>" role="search">
            <input type="text" class="search-query" name="s" id="s" placeholder="<?php esc_attr_e('Search &hellip;', 'bj'); ?>" />
            <input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e('Search', 'bj'); ?>" />
        </form>
        <?php
        $form = ob_get_clean();
        if ($args->theme_location == $this->theme_location)
            return $items .= $form;
        return $items;
    }

}

class nav_walker extends Walker_Nav_Menu {
    // http://wordpress.stackexchange.com/questions/14037/menu-items-description/14039#14039

    /**
     * Start the element output.
     *
     * @param  string $output Passed by reference. Used to append additional content.
     * @param  object $item   Menu item data object.
     * @param  int $depth     Depth of menu item. May be used for padding.
     * @param  array $args    Additional strings.
     * @return void
     */
    function start_el(&$output, $item, $depth, $args) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;

        $class_names = join(
                ' '
                , apply_filters(
                        'nav_menu_css_class'
                        , array_filter($classes), $item
                )
        );

        !empty($class_names)
                and $class_names = ' class="' . esc_attr($class_names) . '"';

        $output .= "<li id='menu-item-$item->ID' $class_names>";

        $attributes = '';

        !empty($item->attr_title)
                and $attributes .= ' title="' . esc_attr($item->attr_title) . '"';
        !empty($item->target)
                and $attributes .= ' target="' . esc_attr($item->target) . '"';
        !empty($item->xfn)
                and $attributes .= ' rel="' . esc_attr($item->xfn) . '"';
        !empty($item->url)
                and $attributes .= ' href="' . esc_attr($item->url) . '"';

        // insert description for top level elements only
        // you may change this
        $description = (!empty($item->description) and 0 == $depth ) ? '<small class="nav_desc">' . esc_attr($item->description) . '</small>' : '';

        $title = apply_filters('the_title', $item->pointer_title, $item->ID);

        $item_output = $args->before
                . "<a $attributes>"
                . $args->link_before
                . $title
                . '</a> '
                . $args->link_after
                . $description
                . $args->after;

        // Since $output is called by reference we don't need to return anything.
        $output .= apply_filters(
                'walker_nav_menu_start_el'
                , $item_output
                , $item
                , $depth
                , $args
        );
    }

    
}