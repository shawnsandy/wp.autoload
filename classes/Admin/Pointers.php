<?php

/**
 * Description of Pointers
 *
 * @author studio
 * @link  Credits
 */
class Admin_Pointers {

    protected $pointer_id,
            $pointer_anchor,
            $position = 'left',
            $align = 'center',
            $pointer_title,
            $pointer_content;

    public function set_pointer_title($title) {
        $this->pointer_title = $title;
        return $this;
    }

    public function set_pointer_content($pointer_content) {
        $this->pointer_content = $pointer_content;
        return $this;
    }

    public function set_pointer_id($pointer) {
        $this->pointer_id = $pointer;
        return $this;
    }

    public function set_pointer_anchor($pointer_anchor) {
        $this->pointer_anchor = $pointer_anchor;
        return $this;
    }

    public function set_position($position) {
        $this->position = $position;
        return $this;
    }

    public function set_align($align) {
        $this->align = $align;
        return $this;
    }

    function __construct() {

    }

    /**
     *
     * @param type $pointer_id
     * @param type $pointer_anchor
     * @param type $pointer_title
     * @param type $pointer_content
     * @return \Basejump_Admin_Pointers
     */
    static function factory($pointer_id,$pointer_anchor) {
        $factory = new Admin_Pointers;
        $factory->pointer_id = $pointer_id;
        $factory->pointer_anchor = $pointer_anchor;
        return $factory;
    }

    function add_pointer() {

        add_action('admin_enqueue_scripts', array($this, 'scripts'));
    }

    function scripts() {
        if ($this->admin_pointers_check()) {

            wp_enqueue_script('wp-pointer');
            wp_enqueue_style('wp-pointer');
            add_action('admin_print_footer_scripts', array($this, 'admin_footer'));
        }
    }

    function admin_pointers_check() {
      $pointers = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
      if(!in_array($this->pointer_id, $pointers)){
          return true;
      }
    }

    function admin_footer() {
        $pointer_content = "<h3>{$this->pointer_title}</h3><p>{$this->pointer_content}</p>";

        ?>
        <script type="text/javascript">// <![CDATA[
            jQuery(document).ready(function($) {
                /* make sure pointers will actually work and have content */
                if(typeof(jQuery().pointer) != 'undefined') {
                    $('<?php echo $this->pointer_anchor ?>').pointer({
                        content: '<?php echo $pointer_content; ?>',
                        position: {
                            edge: '<?php echo $this->position ?>',
                            align: '<?php echo $this->align ?>'
                        },
                        close: function() {
                            $.post( ajaxurl, {
                                pointer: '<?php echo $this->pointer_id ?>',
                                action: 'dismiss-wp-pointer'
                            });
                        }
                    }).pointer('open');
                }
            });
            // ]]></script>

        <?php
    }

    function admin_pointers() {

        $dismissed = explode(',', (string) get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true));
        $version = '1.0'; // replace all periods in 1.0 with an underscore


        $pointer_content = "<h3>{$this->pointer_title }</h3>";
        $pointer_content .= "<p>{$this->poniter_content}</p>";

        return array(
            $this->pointer_id . '_bj_new_items' => array(
                'content' => $pointer_content,
                'anchor_id' => $this->pointer_anchor,
                'edge' => $this->position,
                'align' => $this->align,
                'active' => (!in_array($this->pointer_id . 'new_items', $dismissed))
            ),
        );
    }

}