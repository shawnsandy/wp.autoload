<?php

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
class FN_forms {

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
            $button_label = 'Submit';

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
     * use to create new forms
     * @param type $form_name
     * @param type $action
     * @param string $method
     * @return \cwp_form
     */
    public static function load($form_name, $action, $method = "post") {
        $factory = FN_forms($form_name, $action = "{$action}", $method = "post");
        return new $factory;
    }


    /**
     * Factory pattern
     * For use in existing form code
     * @return \FN_forms
     *
     */
    public static function factory() {
        $factory = new FN_forms();
        return $factory;
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
    public function text_input($name, $value = '', $required = null, $placeholder = '', $pattern = null) {
        $array['type'] = "text";
        $array['name'] = $name;
        $array['value'] = $value;
        $array['placeholder'] = $placeholder;
        $array['required'] = $required;
        $array['pattern'] = $pattern;
        return $this->setText($array);
    }

    public function email_input($name, $value = '', $required = null, $placeholder = 'Your Email Address', $pattern = null) {
        $array['type'] = "email";
        $array['name'] = $name;
        $array['value'] = $value;
        $array['placeholder'] = $placeholder;
        $array['required'] = $required;
        $array['pattern'] = $pattern;
        return $this->setText($array);
    }

    public function tel_input($name, $value = '', $required = null, $placeholder = 'Telphone Number 000-000-0000', $pattern = null) {
        $array['type'] = "tel";
        $array['name'] = $name;
        $array['value'] = $value;
        $array['pattern'] = "\d{10}";
        $array['placeholder'] = $placeholder;
        $array['required'] = $required;
        return $this->setText($array);
    }

    public function url_input($name, $value = '', $required = null, $placeholder = '(http:// yoururl.com)') {
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


    public function open() {
        $form = $this->form_name;
        $fm ="<form name=\"{$form}\" action=\"{$this->action}#{$form}\" id=\"{$form}\" method=\"{$this->method}\" enctype=\"multipart/form-data\" >";
        $fm .=wp_nonce_field('nonce-action-' . $this->form_name, 'nonce-' . $this->form_name) . "\r\n";
        echo $fm;
    }

    public function close() {
        $fm ="<input type=\"submit\" value=\"{$this->button_label}\" name=\"{$this->form_name}_submit\" />";
        $fm .= "</form>";
        echo $fm;
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

