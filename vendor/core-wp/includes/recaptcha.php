<?php

/**
 * @package WordPress
 * @subpackage Core-WP
 * @author shawnsandy
 */
//include_once CWP_PATH . "/includes/recaptchalib.php";
require_once( dirname( __FILE__ ).'/recaptchalib.php' );

class recaptcha {


    public function __construct($publickey, $privatekey="") {
        $this->publickey = $publickey;
        $this->privatekey = $privatekey;
    }

    private static $instance;

    /**
     * Singleton
     * @param type $publickey
     * @param type $privatekey
     * @return instance
     */
    public static function instance($publickey,$privatekey) {
        if (!is_object(self::$instance)) {
            //$class = __CLASS__;
            self::$instance = new recaptcha($publickey, $privatekey);
        }
        return self::$instance;
    }

    //put your code here
    // Get a key from https://www.google.com/recaptcha/admin/create
    private $publickey = "";
    private $privatekey = "";

# the response from reCAPTCHA
    private $resp = null;
# the error code from reCAPTCHA, if any
    private $error = null;

    public function getPublickey() {
        return $this->publickey;
    }

    public function setPublickey($publickey) {
        $this->publickey = $publickey;
    }

    public function getPrivatekey() {
        return $this->privatekey;
    }

    public function setPrivatekey($privatekey) {
        $this->privatekey = $privatekey;
    }

    public function getResp() {
        return $this->resp;
    }

    public function setResp($resp) {
        $this->resp = $resp;
    }

    public function getError() {
        return $this->error;
    }

    public function setError($error) {
        $this->error = $error;
    }


    public function add() {
        return recaptcha_get_html($this->publickey, $this->error);
    }

    /**
     *
     * @param type $challenge $_POST["recaptcha_challenge_field"]
     * @param type $response $_POST["recaptcha_response_field"]
     * @return boolean
     */
    public function response($challenge,$response) {
        # was there a reCAPTCHA response?

            $resp = recaptcha_check_answer($this->privatekey, $_SERVER["REMOTE_ADDR"], $challenge, $response);
            if ($resp->is_valid) {
                return TRUE;
            } else {
                # set the error code so that we can display it
                $this->error = $resp->error;
                return $this->getError();
            }

    }


}
