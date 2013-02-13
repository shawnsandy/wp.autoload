<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mod_Emails
 *
 * @author studio
 */
abstract class Mail_BASE {

    /**
     * defines the email content type
     */
    abstract function content_type();

    /**
     * defines the sender email
     */
    abstract function sender_email();


    /**
     * defines the sender name
     */
    abstract function sender();


    /**
     * the function that you would like to applied when the set email filter is run
     */
    abstract function email_filter();

    /**
     * the funntion that would run when the set email action is run
     */
    abstract function email_action();



    /**
     * the email message
     */
    abstract function email_message();


    /**
     *
     * @var type
     */
    private $send_to_email, $send_to_name, $filter_name, $action_name, $subject;

    public function set_subject($subject) {
        $this->subject = $subject;
    }

    public function set_send_to_email($send_to_email) {
        $this->send_to_email = $send_to_email;
    }

    public function set_send_to_name($send_to_name) {
        $this->send_to_name = $send_to_name;
    }

    public function set_filter_name($filter_name) {
        $this->filter_name = $filter_name;
    }

    public function set_action_name($action_name) {
        $this->action_name = $action_name;
    }

    public function filters() {
        add_filter('wp_mail_content_type', array($this, 'content_type'));
        add_filter('wp_mail_from', array($this, 'sender_email'));
        add_filter('wp_mail_from_name', array($this, 'sender'));
        add_filter($this->filter_name, array($this, 'email_filter'));
    }

    public function actions() {
        add_action($this->action_name, array($this, 'email_action'));
    }

    public function send_email() {
        $this->filters();
        $this->actions();
        $message = $this->email_message();
        wp_mail($this->send_to_email, $this->subject, $message);
    }

}

class new_user_notification extends Mail_BASE {

    public function __construct() {

    }


    public function content_type() {
        return 'text/html';
    }

    /**
     * the email action function
     * return false not used
     */
    public function email_action() {
        return false;
    }

    /**
     * the email filter function
     * return false not used
     */
    public function email_filter() {
        return false;

    }

    /**
     *
     */


    public function email_message() {


    }

    /**
     * Email sender
     */
    public function sender() {

    }

   /**
    * Sender email
    */
    public function sender_email() {

    }

}