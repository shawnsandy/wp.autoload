<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BJ-FORMS
 *
 * @author studio
 */
if (!file_exists(dirname(__FILE__) . 'recaptchalib.php'))
    return;

include_once dirname(__FILE__) . 'recaptchalib.php';

class BJ_FORMS {

    // Get a key from https://www.google.com/recaptcha/admin/create

            protected $captacha,
            $nonce,
            $publickey,
            $privatekey,
            $theme = null;

    public function set_theme($theme) {
        $this->theme = $theme;
    }

    public function set_captacha($captacha) {
        return $this->captacha = $captacha;
    }

    public function set_publickey($publickey) {
        $this->publickey = $publickey;
        return $this;
    }

    public function set_privatekey($privatekey) {
        $this->privatekey = $privatekey;
        return $this;
    }

    public function get_nonce() {
        return $this->nonce;
    }

    public function set_nonce($nonce) {
        $this->nonce = $nonce;
        return $this;
    }

    public function set_nonce_name($nonce_name) {
        $this->nonce_name = $nonce_name;
        return $this;
    }

    public function get_nonce_name() {
        return $this->nonce_name;
    }

    /**
     * Add capatcha
     * Validate capatcha
     * create nonces
     * Validate nonces
     */
    function __construct() {

    }

    /**
     * Factory patterm
     *
     * @param type $publickey - recaptcah public key
     * @param type $privatekey - recaptcha private key
     * @param type $nonce - wordpress nonce key : default bj_nonce ;
     * @param string $theme reCaptha theme name 'red' | 'white' | 'blackglass' | 'clean' | 'custom'
     * @return \BJ_FORMS
     */
    public static function factory($publickey, $privatekey, $nonce = 'bj_nonce', $theme = null) {
        $factory = new BJ_FORMS();
        //setup recaptcha
        $factory->nonce = $nonce;
        $factory->captacha = recaptcha::instance($publickey, $privatekey);
        if (isset($theme)) :
            $factory->theme = $theme;
            $factory->load_theme();
        endif;
        return $factory;
    }

    public function load_theme() {
        add_action('wp_head', array($this, 'theme'));
    }

    public function theme() {

        ?>
        <script type="text/javascript">
            var RecaptchaOptions = {
                theme : '<?php $this->theme ?>'
            };
        </script>
        <?php

    }

    public function nonce() {

        wp_nonce_field('action_' . $this->nonce, $this->nonce);
    }

    public function validate_nonce() {
        if (isset($_POST[$this->nonce])):
            return wp_verify_nonce($_POST["{$this->nonce}"], 'action_' . $this->nonce);
        else :
            return 'NO POST';
        endif;
    }

    public function recaptcha() {
        return $this->captacha->add();
    }

    public function recaptcha_valid() {

        if (!isset($_POST['recaptcha_challenge_field']) && !isset($_POST['recaptcha_response_field']))
            return false;

        $response = $this->captacha->response($_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);
        return $response;
    }

}

class BJ_Contact_Us {

    /** set the basic contact info * */

            private $fullname = '',
            $email = '',
            $subject = '',
            $message = '',
            $tel = '';

    public function set_fullname($fullname) {
        $this->fullname = $fullname;
        return $this;
    }

    public function set_email($email) {
        $this->email = $email;
        return $this;
    }

    public function set_subject($subject) {
        $this->subject = $subject;
        return $this;
    }

    public function set_message($message) {
        $this->message = $message;
        return $this;
    }

    public function set_tel($tel) {
        $this->tel = $tel;
        return $this;
    }

    /**
     * Post related vars
     */
            private $post_type = 'cwp_feedback',
            $post_status = 'draft';

    public function set_post_type($post_type) {
        $this->post_type = $post_type;
        return $this;
    }

    public function set_post_status($post_status) {
        $this->post_status = $post_status;
        return $this;
    }

    /**
     * Contact Notification vars
     * @var mixed
     */
            private $notification_subject,
            $notification_message,
            $notifier_email,
            $notifier_name;

    public function set_notification_subject($notification_subject) {
        $this->notification_subject = $notification_subject;
        return $this;
    }

    public function set_notification_message($notification_message) {
        $this->notification_message = $notification_message;
        return $this;
    }

    public function set_notifier_email($notifier_email) {
        $this->notifier_email = $notifier_email;
        return $this;
    }

    public function set_notifier_name($notifier_name) {
        $this->notifier_name = $notifier_name;
        return $this;
    }

    public function __construct() {

    }

    public static function factory($notify_subject = "RE : Contact/Information", $notify_message = null) {
        if (!isset($notify_message))
            $notify_message = "Thank you for your inquiry, a response will be sent to you shortly.";
        $factory = new BJ_Contact_Us();
        $factory->notification_subject = $notify_subject;
        $factory->notification_message = "<p>{$notify_message}</p><p> Regards - {$factory->notifier_name}<p>";
        return $factory;
    }

    /**
     * simple data validation
     */
    public function process_data() {

        /**
         * @todo rewrite using post array data $data['post_title']
         */
        //data boolean
        $data_valid = true;
        //collect, assign and sanitize form;
        $data['fullname'] = !empty($this->fullname) ? sanitize_text_field($this->fullname) : $data_valid = false;
        $data['email'] = is_email($this->email) ? sanitize_email($this->email) : $data_valid = false;
        $data['subject'] = !empty($this->subject) ? sanitize_text_field($this->subject) : '';
        $data['message'] = !empty($this->message) ? esc_textarea($this->message) : $data_valid = false;
        $data['telephone'] = !empty($this->tel) ? sanitize_text_field($this->tel) : '';

        $post_author_ID = get_theme_mod('theme-admin', 1);
        if ($data_valid):
            //insert the data into the a post
            $post['post_title'] = wp_strip_all_tags($data['fullname'] . ' - ' . $data['subject']);
            $post['post_content'] = $data['subject'] . ' <br/> ' . $data['message'];
            $post['status'] = $this->post_status;
            $post['post_type'] = $this->post_type;
            $post['post_author'] = $post_author_ID;

            if ($post_id = wp_insert_post($post)):
                update_post_meta($post_id, 'contact_email', $data['email']);
                /**
                 * send out email notifications
                 */
                //enable html email
                add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
                //get the notifier data
                $notifier = get_userdata($post_author_ID);
                $this->notifier_name = $notifier->display_name;
                $headers[] = "From: {$notifier->display_name} <{$notifier->user_email}>";
                $headers[] = "Bcc: {$notifier->user_mail} ";
                $send_mail = wp_mail($data['email'], $this->notification_subject, $this->notification_message, $headers);
                if (!$send_mail) {
                    update_post_meta($post, 'mail_confirmation', 'Failed');
                    wp_mail($notifier->user_email, 'Contact notification failed', $post['post_title'], $headers);
                }

            endif;
        else :
            return false;
        endif;
    }

}