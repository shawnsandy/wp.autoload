<?php

/**
 * Description of CWP_CLASSES
 *
 * @author studio
 */
class CWP_CLASSES {

    public function __construct() {

    }

    public static function factory() {
        return $factory = new CWP_CLASSES();
    }

}

/**
 * @package WordPress
 * @subpackage Core-WP
 * @author shawnsandy
 */
class cwp_taxonomy {

    //put your code here


    private $hierarchical = true;
    private $show_ui = true;
    private $query_var = true;
    private $show_tagcloud = true;
    private $show_in_nav_menus = true;
    private $rewrite = array('slug' => 'name');
    private $taxonomy_name, $label_name;
    private $post_types = array('post', 'pages'),
            $singular_name = null,
            $show_admin_col = false;

    public function set_label_name($label_name) {
        $this->label_name = $label_name;
        return $this;
    }

    public function set_show_admin_col($show_admin_col) {
        $this->show_admin_col = $show_admin_col;
        return $this;
    }


    public function set_singular_name($singular_name) {
        $this->singular_name = $singular_name;
        return $this;
    }

    public function get_hierarchical() {
        return $this->hierarchical;
    }

    public function set_hierarchical($hierarchical) {
        $this->hierarchical = $hierarchical;
        return $this;
    }

    public function get_show_ui() {
        return $this->show_ui;
        return $this;
    }

    public function set_show_ui($show_ui) {
        $this->show_ui = $show_ui;
    }

    public function get_query_var() {
        return $this->query_var;
    }

    public function set_query_var($query_var) {
        $this->query_var = $query_var;
        return $this;
    }

    public function get_show_tagcloud() {
        return $this->show_tagcloud;
    }

    public function set_show_tagcloud($show_tagcloud) {
        $this->show_tagcloud = $show_tagcloud;
        return $this;
    }

    public function get_show_in_nav_menus() {
        return $this->show_in_nav_menus;
    }

    public function set_show_in_nav_menus($show_in_nav_menus) {
        $this->show_in_nav_menus = $show_in_nav_menus;
        return $this;
    }

    public function get_rewrite() {
        return $this->rewrite;
    }

    public function set_rewrite($rewrite) {
        $this->rewrite = $rewrite;
        return $this;
    }

    public function get_taxonomy_name() {
        return $this->taxonomy_name;
    }

    public function set_taxonomy_name($taxonomy_name) {
        $this->taxonomy_name = $taxonomy_name;
        return $this;
    }

    public function get_post_types() {
        return $this->post_types;
    }

    public function set_post_types($post_types) {
        $this->post_types = $post_types;
        return $this;
    }

    public function get_label_name() {
        return $this->label_name;
    }

    /**
     *
     * @param type $taxonomy_name
     * @param type $label_name
     */
    function __construct($taxonomy_name, $label_name = null) {
        $this->taxonomy_name = $taxonomy_name;
        $this->label_name = $label_name;
    }

    /**
     * register category style taxonomies
     */
    public function register() {
        // Add new taxonomy, make it hierarchical (like categories)
        $name = ucfirst($this->get_taxonomy_name());
        $label = (isset($this->label_name) ? $this->label_name : $this->taxonomy_name);
        $singular = (isset($this->singular_name) ? $this->singular_name : $this->taxonomy_name);
        $labels = array(
            'name' => _x($label, 'taxonomy general name'),
            'singular_name' => _x($singular, 'taxonomy singular name'),
            'search_items' => __('Search ' . $name),
            'all_items' => __('All ' . $label),
            'parent_item' => __('Parent ' . $singular),
            'parent_item_colon' => __('Parent ' . $label . ':'),
            'edit_item' => __('Edit ' . $singular),
            'update_item' => __('Update ' . $singular),
            'add_new_item' => __('Add New ' . $singular),
            'new_item_name' => __('New ' . $singular),
            'menu_name' => __($label),
        );

        register_taxonomy($this->get_taxonomy_name(), $this->get_post_types(), array(
            'hierarchical' => $this->hierarchical,
            'labels' => $labels,
            'show_ui' => $this->get_show_ui(),
            'query_var' => $this->get_query_var(),
            'rewrite' => array('slug' => $this->get_taxonomy_name()),
            'show_tagcloud' => $this->get_show_tagcloud(),
            'show_in_nav_menus' => $this->get_show_in_nav_menus(),
            'show_admin_column' => true,
        ));
    }

    public function tags() {
        $this->set_hierarchical(false);
        $this->register();
    }

    public function init() {
        add_action('init', array(&$this, 'register'), 0);
    }

}

/**
 * @package WordPress
 * @subpackage Core-WP
 * @author shawnsandy
 */
/**
 *
 */

/**
 * A simple form generation class for WordPress
 * <code>
 * $f_text['Sample Text'] = array(
 * 'desc' => 'A sample Text field',
 * 'field' => $c_form->setText(array('name'=>'sample-text','type'=>'text')));
 * $f_text['Sample Textarea'] = array(
 * 'desc' => 'A sample Textarea field',
 * 'field' => $c_form->setTextarea(array('name'=>'sample-text','value'=>'Textarea Value')));     *
 * $c_form->render($f_text,'form_name');
 * </code>
 */
class cwp_form {

    //put your code here

    private $text = array();
    private $button = array();
    private $textarea = array();
    private $checkbox = array();
    private $list = array();
    private $radio = array();
    private $captacha = null;
    private $action;
    private $method,
            $form_name,
            $button_label;

    public function __construct($form_name = 'cwp_form', $action = "", $method = "post") {
        $this->form_name = $form_name;
        $this->action = $action;
        $this->method = $method;
    }

    public function get_button_label() {
        return $this->button_label;
    }

    public function set_button_label($button_label) {
        $this->button_label = $button_label;
        return $this;
    }

    public function get_form_name() {
        return $this->form_name;
    }

    /**
     * Factory pattern
     * @param type $form_name
     * @param type $action
     * @param string $method
     * @return \cwp_form
     */
    public static function load($form_name, $action, $method = "post") {
        return new cwp_form($form_name, $action = "{$action}", $method = "post");
    }

    public function getCaptacha() {
        return $this->captacha;
    }

    public function getText() {
        return $this->text;
    }

    public function getButton() {
        return $this->button;
    }

    public function getTextarea() {
        return $this->textarea;
    }

    public function getCheckbox() {
        return $this->checkbox;
    }

    public function getList() {
        return $this->list;
    }

    public function getRadio() {
        return $this->radio;
    }

    public function getAction() {
        return $this->action;
    }

    public function setAction($action) {
        $this->action = $action;
        return $this;
    }

    public function setCaptacha($captacha) {
        $this->captacha = $captacha;
        return $this;
    }

    /**
     *
     * @param array $array - type,name,value,placeholder,required,pattern,min,max
     * @return type
     */
    public function setText($array = array()) {
        $required = (isset($array['required']) ? 'required' : null);
        $pattern = (isset($array['pattern']) ? "pattern=\"{$array['pattern']}\"" : null);
        $min = (isset($array['min']) ? "min=\"{$array['min']}\"" : null);
        $max = (isset($array['max']) ? "min=\"{$array['max']}\"" : null);
        $this->text = "<input type=\"{$array['type']}\" id=\"{$array['name']}\" name=\"{$array['name']}\"
        value=\"{$array['value']}\" placeholder=\"{$array['placeholder']}\" {$required} {$pattern}  />";
        return $this->text;
    }

    /*     * ---------------------text feilds -----------------------------* */

    /**
     *
     * @param type $name
     * @param type $value
     * @param type $placeholder
     * @param type $required
     * @param type $pattern
     * @return type
     */
    public function text_input($name, $value = '', $placeholder = '', $required = null, $pattern = null) {
        $array['type'] = "text";
        $array['name'] = $name;
        $array['value'] = $value;
        $array['placeholder'] = $placeholder;
        $array['required'] = $required;
        $array['pattern'] = $pattern;
        return $this->setText($array);
    }

    public function email_input($name, $value = '', $placeholder = 'Your Email Address', $required = true, $pattern = null) {
        $array['type'] = "email";
        $array['name'] = $name;
        $array['value'] = $value;
        $array['placeholder'] = $placeholder;
        $array['required'] = $required;
        $array['pattern'] = $pattern;
        return $this->setText($array);
    }

    public function tel_input($name, $value = '', $placeholder = 'Telphone Number 000-000-0000', $required = false, $pattern = null) {
        $array['type'] = "tel";
        $array['name'] = $name;
        $array['value'] = $value;
        $array['pattern'] = "\d{10}";
        $array['placeholder'] = $placeholder;
        $array['required'] = $required;
        return $this->setText($array);
    }

    public function url_input($name, $value = '', $placeholder = '(http:// yoururl.com)', $required = null) {
        $array['type'] = "url";
        $array['name'] = $name;
        $array['value'] = $value;
        $array['placeholder'] = $placeholder;
        $array['required'] = $required;
        return $this->setText($array);
    }

    public function hidden_input($name, $value = '') {
        $array['type'] = "hidden";
        $array['name'] = $name;
        $array['value'] = $value;
        return $this->setText($array);
    }

    /**
     * **************************buttons****************************************
     */

    /**
     *
     * @param type $button
     * @return type
     */
    public function setButton($button = array()) {
        $this->button = "<input type=\"{$array['type']}\" value=\"{$array['value']}\" name=\"{$array['name']}\" />";
        return $this->button;
    }

    /**
     * **************************textarea***************************************
     */

    /**
     *
     * @param type $textarea
     * @return type
     */
    public function setTextarea($array = array()) {
        $required = (isset($array['required'])) ? 'required' : null;
        $pattern = (isset($array['pattern']) ? "pattern=\"{$array['pattern']}\"" : null);
        $this->textarea = "<textarea name=\"{$array['name']}\" rows=\"4\"
        cols=\"20\" placeholder=\"{$array['placeholder']}\" {$required} maxlength=\"{$array['maxlength']}\"  >{$array['value']}</textarea>";
        return $this->textarea;
    }

    /**
     *
     * @param type $name
     * @param type $value
     * @param type $required
     * @param type $placeholder
     * @return type
     */
    public function textarea($name, $value = '', $required = null, $placeholder = '', $max = 150) {
        $arr['name'] = $name;
        $arr['value'] = $value;
        $arr['required'] = $required;
        $arr['placeholder'] = $placeholder;
        $arr['maxlength'] = $max;
        return $this->setTextarea($arr);
    }

    public function setCheckbox($checkbox = array()) {
        $this->checkbox = "<input type=\"checkbox\" name=\"{$array['name']}\"
        value=\"{$array['value']}\" checked=\"{$array['checked']}\" />";
        return $this->checkbox;
    }

    public function setList($list = array()) {
        $this->list = "<select name=\"{$array['name']}\"><option>{$array['value']}</option></select>";
        return $this->list;
    }

    public function setRadio($radio = array()) {
        $this->radio = $radio;
        return $this->radio;
    }

    /**
     * *********************Erros**********************************************
     */
    public function form_error($error = array()) {
        if (is_array($error) AND !empty($error)) {
            $er[] = "<div class=\"cwp_error\" >";
            foreach ($error as $key => $value) {
                $er[] = "<strong>{$key} : {$value}</strong>";
            }
            $er[] = "<div>";
            return $er;
        }
    }

    /**
     *
     * @param type $arrays
     */
    public function render($arrays = array()) {
        $form = $this->form_name;
        echo "<form name=\"{$form}\" action=\"{$this->action}#{$form}\" id=\"{$form}\" method=\"{$this->method}\" enctype=\"multipart/form-data\" >";
        wp_nonce_field('nonce-action-' . $this->form_name, 'nonce-' . $this->form_name);
        echo "\r\n";
        echo "<fieldset class=\"cwp_form\">";
        foreach ($arrays as $key => $value) {
            $name = ucfirst($key);
            echo "<p id=\"{$key}\">";
            echo "<label>{$name} <span class=\"desc\"> {$value['desc']}</span></label>";
            //echo "<span class=\"desc\"> {$value['desc']}</span>";
            echo $value['field'];
            echo "</p>";
            echo "\r\n";
        }
        echo "</fieldset>";

        echo "\r\n";
        if (isset($this->captacha)):
            echo "<label>Just a litle(ugly) anti-spam verification</label>";
            echo "<p class=\"captacha\">{$this->captacha}</p>";

        endif;
        echo "<input type=\"submit\" value=\"{$this->button_label}\" name=\"{$form}_submit\" />";


        echo "</form>";
    }

    /**
     *
     * @param type $name $_POST['name_of_nonce_field']
     * @param type $action 'name_of_my_action'
     * @return type
     */
    public function verify_nonce($data = array()) {
        //if(!empty($data)) var_dump ($data);
        //wp_verify_nonce($_POST['name_of_nonce_field'],'name_of_my_action'
        if (empty($data) OR !wp_verify_nonce($data['nonce-' . $this->form_name], 'nonce-action-' . $this->form_name)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     *
     * @param type $publickey
     * @return type
     */
    public function recaptcha($publickey) {
        if (file_exists(CWP_PATH . '/includes/recaptchalib.php')):
            require_once(CWP_PATH . '/includes/recaptchalib.php');
            return $o_cpatcha = recaptcha_get_html($publickey);
        endif;
    }

    /**
     *
     * @param type $privatekey
     * @return type
     */
    public function recaptcha_valid($privatekey) {
        if (file_exists(CWP_PATH . '/includes/recaptchalib.php')):
            require_once(CWP_PATH . '/includes/recaptchalib.php');
            if (isset($_POST["recaptcha_challenge_field"]) AND isset($_POST["recaptcha_response_field"])):
                $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
                if (!$resp->is_valid) {
                    // What happens when the CAPTCHA was entered incorrectly
                    die("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
                            "(reCAPTCHA said: " . $resp->error . ")");
                } else {
                    return $o_validate = true;
                }
            endif;
        endif;
    }

}

/**
 * Description of cwp_loop
 *
 * @author Studio365
 */
class cwp_loop {

    //put your code here

    public function __construct() {

    }

    /**
     * get loop for post-formats
     * //post-format-aside post-format-audio post-format-chat post-format-gallery post-format-image post-format-link post-format-status post-format-quote post-format-video
     * @global type $post
     * @param string $tpl tpl name
     * @param string $_formats default aside
     * @param String $operator (IN, NOT_IN)
     * @param boolean $reset
     */
    public static function formats($tpl = "general", $_formats = array('post-format-aside'), $operator = "IN", $reset = true) {
        //http://wordpress.mfields.org/2011/post-format-queries/

        $args = array(
            'tax_query' => array(
                array(
                    'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => $formats,
                    'operator' => "{$operator}"
                )
            )
        );

        $query = new WP_Query($args);
        if ($query->have_posts()):
            while ($query->have_posts()):
                $query->the_post();
                cwp_layout::tpl_part(NULL, $tpl);
            endwhile;
        endif;
        if ($reset)
            wp_reset_postdata();
    }

}

//post-format-aside post-format-audio post-format-chat post-format-gallery post-format-image post-format-link post-format-status post-format-quote post-format-video

/**
 *
 *
 * 'container' =>false,
  'menu_class' => 'nav',
  'echo' => true,
  'before' => '',
  'after' => '',
  'fallbck_cb => '',
  'link_before' => '',
  'link_after' => '',
  'depth' => 0,
  'walker' => new description_walker());
 * give access to all the theme walker classes
 */
class cwp_navs {

    private $menu,
            $theme_location = 'primary',
            $fallback_cb = array('cwp_navs', 'default_menu'),
            $depth = 0,
            $link_before = '',
            $link_after = '',
            $before = '',
            $after = '',
            $echo = true,
            $container = false,
            $container_class = '',
            $menu_class = '',
            $walker,
            $items = "",
            $menu_name = "",
            $menu_array = array();

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

    function __construct() {

    }

    /**
     * Add the wp_navs to themes
     * <code>
     * //set menu depth and the menu location to primary
     * <?php $p_nav = cwp_navs::factory()->set_depth(1)->menu('primary'); ?>
     * <?php cwp_navs::factory()->menu('browse'); ?>
     * </code>
     */
    public static function factory() {
        return new cwp_navs();
    }

    /**
     * <code>
     * cwp_navs::factory()->set_depth(0)->tbs_menu('primary');
     * </code>
     * @param type $theme_location
     * @return \cwp_navs
     */
    public function menu($theme_location = 'primary') {
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

    /**
     * <code>
     * cwp_navs::factory()->set_depth(0)->tbs_menu('primary');
     * </code>
     * @param type $theme_location
     * @return \cwp_navs
     */
    public function tbs_menu($theme_location = 'primary') {
        $this->theme_location = $theme_location;
        $this->menu_class = 'nav';

        wp_nav_menu(array(
            'theme_location' => $this->theme_location,
            'fallback_cb' => $this->fallback_cb,
            'container' => $this->container,
            'container_class' => $this->container_class,
            'menu_class' => 'nav',
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

    public function menu_description($location) {

        //$this->theme_location = $location;
        //$this->theme_location = $location;
        $this->walker = new nav_descriptions();
        return $this->menu($location);
    }

    public function default_menu() {
        ?>

        <ul class="nav">
            <li>
                <a href="<?php echo home_url() ?>" >Home</a>
            </li>
            <?php wp_list_categories('title_li=&depth=1number=5'); ?>
        </ul>
        <?php
    }

    /**
     * ************custom menu items ********************************************
     */
    public function add_item($items, $args, $location = 'primary', $content = "Items") {
        if ($args->theme_location == $location):
            $items .= '<li>' . $content . '</li>';
        endif;
    }

    /**
     * <code>
     * add_filter( 'wp_nav_menu_items', 'your_custom_menu_item', 10, 2 );
      function your_custom_menu_item ( $items, $args ) {
      $items = cwp_navs::factory()->add_drop_down($items, $args,'browse',"Another Dropwdown");
      return $items;
      }
     * </code>
     * @param type $items
     * @param type $args
     * @param type $location
     * @param type $name
     * @param type $content
     * @param type $class
     * @return string
     */
    public function add_drop_down($items, $args, $location, $name = "Drop Down", $content = 'Some Content', $class = 'ui box medium') {
        if ($args->theme_location == $location):
            $items .="<li><a href=\"#\">{$name}</a>";
            $items .="<ul><li><div class=\"{$class}\">{$content}</div></li></ul>";
            $items .="</li>";
        endif;
        return $items;
    }

    /**
     * <code>
     * add_filter( 'wp_nav_menu_items', 'add_loginout_link', 10, 2 );
      function add_loginout_link( $items, $args ) {
      $items = cwp_navs::factory()->add_loginout($items,$args,'primary');
      return $items;
      }
     * </code>
     * @param type $items
     * @param type $args
     * @param type $location
     * @return string
     */
    public function add_loginout($items, $args, $location) {
        if (is_user_logged_in() && $args->theme_location == $location) {
            $items .= '<li><a href="' . wp_logout_url() . '">' . __('Log Out', 'corewp') . '</a></li>';
        } elseif (!is_user_logged_in() && $args->theme_location == $this->theme_location) {
            $items .= '<li><a href="' . site_url('wp-login.php') . '">' . __('Log In', 'corewp') . '</a></li>';
        }
        return $items;
    }

    /**
     *
     * @param type $items
     * @param type $args
     * @param type $location
     * @return type
     */
    public function add_search_box($items, $args, $location) {
        if ($args->theme_location == $location)
            return $items . "<li class='menu-header-search'><form action='http://example.com/' id='searchform' method='get'><input type='text' name='s' id='s' placeholder='" . __('Search', 'corewp') . "></form></li>";
        return $items;
    }

}

/**
 * Adds a category desctiption below level 1 category titles
 *
 * @author Studio365
 */
class nav_descriptions extends Walker_Nav_Menu {
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

/**
 * Description of cwp_gallery
 *
 * @author Studio365
 */
class cwp_gallery {
    //put your code here

    /**
     * Add "Include in Rotator" option to media uploader
     *
     * @param $form_fields array, fields to include in attachment form
     * @param $post object, attachment record in database
     * @return $form_fields, modified form fields
     */
    public function be_attachment_field_rotator($form_fields, $post) {

        // Set up options
        $options = array('1' => 'Yes', '0' => 'No');

        // Get currently selected value
        $selected = get_post_meta($post->ID, 'be_rotator_include', true);

        // If no selected value, default to 'No'
        if (!isset($selected))
            $selected = '0';

        // Display each option
        foreach ($options as $value => $label) {
            $checked = '';
            $css_id = 'rotator-include-option-' . $value;

            if ($selected == $value) {
                $checked = " checked='checked'";
            }

            $html = "<div class='rotator-include-option'><input type='radio' name='attachments[$post->ID][be-rotator-include]' id='{$css_id}' value='{$value}'$checked />";

            $html .= "<label for='{$css_id}'>$label</label>";

            $html .= '</div>';

            $out[] = $html;
        }

        // Construct the form field
        $form_fields['be-include-rotator'] = array(
            'label' => 'Include in Rotator',
            'input' => 'html',
            'html' => join("\n", $out),
        );

        // Return all form fields
        return $form_fields;
    }

    /**
     * Save value of "Include in Rotator" selection in media uploader
     *
     * @param $post array, the post data for database
     * @param $attachment array, attachment fields from $_POST form
     * @return $post array, modified post data
     */
    public function be_attachment_field_rotator_save($post, $attachment) {
        if (isset($attachment['be-rotator-include']))
            update_post_meta($post['ID'], 'be_rotator_include', $attachment['be-rotator-include']);

        return $post;
    }

    public static function gallery_rotator() {
        add_filter('attachment_fields_to_edit', array('cwp_gallery', 'be_attachment_field_rotator'), 10, 2);
        add_filter('attachment_fields_to_save', array('cwp_gallery', 'be_attachment_field_rotator_save'), 10, 2);
    }

}

/**
 * Description of cwp_post
 *
 * @author Studio365
 */
class cwp_post {

    //put your code here

    public function __construct() {

    }

    /**
     * Uses WP default query to create a post loop
     * @global type $post
     * @param string / array $query
     * @param string $tpl_slug / default - base
     * @param string $tpl_name / default - general
     * <code><?php cwp_post::loop(array('post_type' => 'cwp_articles')); ?></code>
     */
    public static function loop($query = null, $tpl_slug = null, $tpl_name = null) {
        global $post;
        if (isset($query))
            query_posts($query);
        if (have_posts()):
            while (have_posts()):

                the_post();
                $post_type = get_post_type();
                $post_format = (get_post_format() ? get_post_format() : 'general');

                if ($tpl_slug == 'post_type'):
                    $tpl_slug = $post_type;
                endif;
                if ($tpl_name == 'format')
                    $tpl_name = $post_format;

                $slug = isset($tpl_slug) ? $tpl_slug : 'base';
                $name = isset($tpl_name) ? $tpl_name : 'general';
                cwp_layout::tpl_part($slug, $name);

            endwhile;
        else :
            cwp_layout::tpl_part(null, 'no_post');
        endif;
        wp_reset_query();
    }

    /**
     *
     * Uses WP_Query to create post loops
     * @param string / array $query
     * @param string $tpl_slug // default - base
     * @param string $tpl_name // default - general
     * @param string $def_tpl
     * <code></code>
     */
    public static function query($query = 'showposts=5', $tpl_slug = null, $tpl_name = null, $def_tpl = 'no_post') {
        global $post;
        $wp = new WP_Query();
        $wp->query($query);
        if ($wp->have_posts()):
            while ($wp->have_posts()):
                $wp->the_post();
                $post_type = get_post_type();
                $post_format = (get_post_format() ? get_post_format() : 'general');

                if ($tpl_slug == 'post_type')
                    $tpl_slug = $post_type;
                if ($tpl_slug == 'format')
                    $tpl_slug = $post_format;

                $slug = isset($tpl_slug) ? $tpl_slug : 'base';
                $name = isset($tpl_name) ? $tpl_name : 'general';

                cwp_layout::tpl_part($slug, $name);

            endwhile;
        else :

            cwp_layout::tpl_part(null, $def_tpl);

        endif;
        wp_reset_postdata();
    }


}

class cwp_post_gallery {

    public function __construct($post_parent) {
        $this->post_parent = $post_parent;
    }

    public static function factory($post_parent) {
        return $factory = new cwp_post_gallery($post_parent);
    }

    private $number_post = -1,
            $order = 'ASC',
            $post_parent = null,
            $image_size = 'thumbnail';

    public function set_image_size($image_size) {
        $this->image_size = $image_size;
        return $this;
    }


    public function set_number_post($number_post) {
        $this->number_post = $number_post;
        return $this;
    }

    public function set_order($order) {
        $this->order = $order;
         return $this;
    }

    public function set_post_parent($parent) {
        $this->post_parent = $parent;
         return $this;
    }

    public function display($items_class='span3',$container_class='row') {
        global $post;
        $argsThumb = array(
            'showposts' => $this->number_post,
            'order' => $this->order,
            'post_type' => 'attachment',
            'post_parent' => $post->ID,
            'post_mime_type' => 'image',
            'post_status' => null,
            //'exclude' => get_post_thumbnail_id($post->ID)
        );
        $attachments = get_posts($argsThumb);
        if ($attachments) {
            echo '<div class="'.$container_class.'">';
            foreach ($attachments as $attachment) {
                $img =  wp_get_attachment_image_src($attachment->ID,$this->image_size);
                $img_full =  wp_get_attachment_image_src($attachment->ID,'full');
                //echo apply_filters('the_title', $attachment->post_title);
                ob_start();
                ?>
                <div class="<?php echo $items_class  ?>">
                    <a href="<?php echo $img_full[0] ?>">
                    <img src="<?php echo $img[0]; ?>" />
                    </a>
                </div>
                <?php
                $content = ob_get_clean();
                echo $content;
            }
            echo '</div>';
        }
    }

    public function display_thumbnails($items_class='span3',$container_class='row') {
        global $post;
        $argsThumb = array(
            'showposts' => $this->number_post,
            'order' => $this->order,
            'post_type' => 'attachment',
            'post_parent' => $post->ID,
            'post_mime_type' => 'image',
            'post_status' => null,
            //'exclude' => get_post_thumbnail_id($post->ID)
        );
        $attachments = get_posts($argsThumb);
        if ($attachments) {
            echo '<div class="'.$container_class.'">';
            foreach ($attachments as $attachment) {
                $img =  wp_get_attachment_image_src($attachment->ID,$this->image_size);
                //echo apply_filters('the_title', $attachment->post_title);
                ob_start();
                ?>
                <div class="<?php echo $items_class  ?>">
                    <img src="<?php echo $img[0]; ?>" />
                </div>
                <?php
                $content = ob_get_clean();
                echo $content;
            }
            echo '</div>';
        }
    }

}

