<?php


/**
 * Customizes JetPack subsctiption.
 * @author studio
 * Credit : http://kovshenin.com/2012/using-jetpack-for-e-mail-subscriptions-in-wordpress/
 */
class Ext_jp_subscribe {

    private $invalid_email,
            $success_message,
            $subscription_title = 'Subscribe',
            $subscription_slug = 'Register for news and undates';

    public function setTitle($title) {
        $this->subscription_title = $title;
        return $this;
    }

        // Hold an instance of the class
    private static $instance;

    /**
     *
     * @param type $invalid_email
     * @return \ext_jp_subscribe
     */
    public function setInvalid_email($invalid_email) {
        $this->invalid_email = $invalid_email;
        return $this;
    }

    /**
     *
     * @param type $success_message
     * @return \ext_jp_subscribe
     */
    public function setSuccess_message($success_message) {
        $this->success_message = $success_message;
        return $this;
    }

    /**
     *
     */
    private function __construct() {
        // loads the handler function
        add_action('init', array($this, 'handler'));
    }

    /**
     * Factory method
     * @return \ext_jp_subscribe
     */
    public static function load() {
        $factory = new ext_jp_subscribe();
        return $factory;
    }

    /**
     * Singleton Pattern
     * @return class object
     */
     public static function instance(){
         if (!is_object(self::$instance)) {
             $class = __CLASS__ ;
            self::$instance = new $class;
        }
        return self::$instance;
    }

    /**
     * The subscription form
     * @param type $tpl
     * @param type $slug
     * @return type
     */
    public function form($tpl = NULL, $slug = 'exts') {
        if (!class_exists('Jetpack_Subscriptions')):
            _e('Sorry the Jetpack Class not found', 'al-manager');
            return;
        endif;
        if (isset($tpl) AND class_exists('cwp_layout')) :
            cwp_layout::tpl_part($slug, $tpl);
        else :
            ob_start();
            ?>

            <div class="jetpack-subscription">
                <h2><?php echo $this->subscription_title ; ?></h2>
                <p><?php echo $this->subscription_slug ; ?></p>
            <?php $status = isset($_REQUEST['subscribe']) ? $_REQUEST['subscribe'] : false; ?>
                <?php if ($status == 'invalid_email') : ?>
                    <p><?php echo $this->invalid_email; ?></p>
                <?php elseif ($status == 'success') : ?>
                    <p><?php echo $this->success_message; ?>.</p>
                <?php else : ?>
                    <form method="POST" class="jp-subscribe">
                    <?php wp_nonce_field('jp_subscribe_action', 'jp_subscribe_field'); ?>
                        <input type="hidden" name="my-form-action" value="subscribe" />
                        <input name="subscription-email" value="" placeholder="<?php _e('Enter your e-mail', 'al-manager') ?> "/>
                        <input type="submit" value="<?php _e('Subscribe', 'al-manager') ?>" />
                    </form>
            <?php endif; ?>
            </div>

            <?php
            $contents = ob_get_clean();
            echo $contents;
        endif;
    }

    /**
     * handles / validates and process the form     *
     */
    public function handler() {

        // if(empty($_POST) || !wp_verify_nonce($_POST['jp_subscribe_field'],'jp_subscribe_action')):

        if (isset($_POST['my-form-action']) && $_POST['my-form-action'] == 'subscribe') {
            $email = $_POST['subscription-email'];
            $subscribe = Jetpack_Subscriptions::subscribe($email, 0, false);
            // check subscription status (to be continued)
            // check subscription status
            if (is_wp_error($subscribe)) {
                $error = $subscribe->get_error_code();
            } else {
                $error = false;
                foreach ($subscribe as $response) {
                    if (is_wp_error($response)) {
                        $error = $response->get_error_code();
                        break;
                    }
                }
            }

            if ($error) {
                switch ($error) {
                    case 'invalid_email':
                        $redirect = add_query_arg('subscribe', 'invalid_email');
                        break;
                    case 'active': case 'pending':
                        $redirect = add_query_arg('subscribe', 'already');
                        break;
                    default:
                        $redirect = add_query_arg('subscribe', 'error');
                        break;
                }
            } else {
                $redirect = add_query_arg('subscribe', 'success');
            }

            wp_safe_redirect($redirect);
        }
        // endif;
    }

}