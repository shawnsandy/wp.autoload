<?php

/**
 * Description of Ext_Mail
 *
 * @author studio
 */
class Ext_Mail {



    private $content_type = 'text/html',
            $sender_email,
            $sender_name;
    private $user_name,
            $user_email,
            $activation_subject,
            $retrieve_pass_title,
            $activation_email_page = 'activation-email.php',
            $reg_notification_email_page = 'reg-notification-email.php',
            $retrieve_pass_email_page = 'retrieve-pass-email.php',
            $email_header = 'email-header.php',
            $email_footer  = 'remail-footer.php';

    public function set_email_header($email_header) {
        $this->email_header = $email_header;
        return $this;
    }

    public function set_email_footer($email_footer) {
        $this->email_footer = $email_footer;
        return $this;
    }


    public function set_activation_email_page($activation_email) {
        $this->activation_email_page = $activation_email;
        return $this;
    }

    public function set_reg_notification_email_page($reg_notification_email) {
        $this->reg_notification_email_page = $reg_notification_email;
        return $this;
    }

    public function set_retrieve_pass_email_page($retrieve_pass_email) {
        $this->retrieve_pass_email_page = $retrieve_pass_email;
        return $this;
    }

    public function set_activation_subject($subject) {
        $this->activation_subject = $subject;
        return $this;
    }


    function __construct() {

    }

    public static function factory(){
        $factory = new Ext_Mail();
        return $factory;
    }

    public function get_user_name() {
        return $this->user_name;
    }

    public function set_user_name($user_name) {
        $this->user_name = $user_name;
        return $this;
    }

    public function get_user_email() {
        return $this->user_email;
    }

    public function set_user_email($user_email) {
        $this->user_email = $user_email;
    }

    public function get_content_type() {
        return $this->content_type;
    }

    public function set_content_type($content_type) {
        $this->content_type = $content_type;
        return $this;
    }

    public function get_sender_email() {
        return $this->sender_email;
    }

    public function set_sender_email($sender_email) {
        $this->sender_email = $sender_email;
        return $this;
    }

    public function get_sender_name() {
        return $this->sender_name;
    }

    public function set_sender_name($sender_name) {
        $this->sender_name = $sender_name;
        return $this;
    }

    public function publish_post() {

    }

    public function retrieve_password_title() {
        return $this->retrieve_pass_title;

    }

    public function set_subject_message($subject_message) {
        $this->activation_subject = $subject_message;
    }

    public function filters() {
        add_filter('wp_mail_content_type', array($this, 'get_content_type'));
        add_filter('wp_mail_from', array($this, 'get_sender_email'));
        add_filter('wp_mail_from_name', array($this, 'get_sender_name'));
        add_filter('retrieve_password_title', array($this, 'retrieve_password_title'));
        add_filter('retrieve_password_message', array($this, 'retrieve_password_message'));
    }

      public function set_retrieve_pass_title($retrieve_pass_title) {
        $this->retrieve_pass_title = $retrieve_pass_title;
    }


    public function retrieve_password_message($content,$key) {

        global $wpdb;

        $user_login = $wpdb->get_var("SELECT user_login FROM $wpdb-<users WHERE user_activation_key = '$key'");

	ob_start();

	$email_subject = $this->retrieve_pass_title;

	$this->message_header();

        $this->message($this->retrieve_pass_email_page);

	$this->message_footer();

	$message = ob_get_contents();

	ob_end_clean();

	return $message;

    }

    public function actions() {
        add_action('publish_post', array($this, 'publish_post'));
        do_action('ext_mail_action');
    }

    public function create_emails() {
        $this->filters();
        $this->actions();
    }

    public function user_activation($user_id,$plaintext_pass) {
        $user = new WP_User($user_id);
        $this->user_name = stripslashes($user->user_login);
        $this->user_email = stripslashes($user->user_email);
        $subject = ucfirst($this->user_name).' '. $this->activation_subject;
        ob_start();
        $this->message_header();
        $this->message($this->activation_email_page);
        $this->message_footer();
        $message = ob_get_contents();
        ob_end_clean();
        wp_mail($this->user_email, $subject, $message);
    }

    public function message_header() {
        if (file_exists(get_stylesheet_directory() . '/'.$this->email_header)):
            include_once get_stylesheet_directory() . '/'.$this->email_header;
        endif;
    }

    public function message($template_file = null){
        if(file_exists(get_stylesheet_directory().'/'.$template_file))
            include_once get_stylesheet_directory().'/'.$template_file;
    }

    public function message_footer() {
        if (file_exists(get_stylesheet_directory() . '/'.$this->email_footer)):
            include_once get_stylesheet_directory() . '/'.$this->email_footer;
        endif;
    }

}