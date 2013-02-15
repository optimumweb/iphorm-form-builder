<?php

require_once IPHORM_INCLUDES_DIR . '/recaptchalib.php';

/**
 * iPhorm_Validator_Recaptcha
 *
 * Validates the reCAPTCHA solution
 *
 * @package iPhorm
 * @subpackage Validator
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Validator_Recaptcha extends iPhorm_Validator_Abstract
{
    /**
     * reCAPTCHA private key
     * @var string
     */
    protected $_privateKey = '';

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct($options = null)
    {
        $this->_messageTemplates = array(
            'invalid-site-private-key' => __('Invalid reCAPTCHA private key',  'iphorm'),
            'invalid-request-cookie' => __('The challenge parameter of the verify script was incorrect',  'iphorm'),
            'incorrect-captcha-sol' => __('The CAPTCHA solution was incorrect',  'iphorm'),
            'recaptcha-not-reachable' => __('reCAPTCHA server not reachable',  'iphorm')
        );

        if (is_array($options)) {
            if (array_key_exists('privateKey', $options)) {
                $this->_privateKey = $options['privateKey'];
            }
            if (array_key_exists('messages', $options)) {
                $this->setMessageTemplates($options['messages']);
            }
        }
    }

    /**
     * Checks the reCAPTCHA answer
     *
     * @param $value The value to check
     * @param $context The other submitted form values
     * @return boolean True if valid false otherwise
     */
    public function isValid($value, $context = null)
    {
        $ip = iphorm_get_user_ip();
        $challenge = isset($_POST['recaptcha_challenge_field']) ? $_POST['recaptcha_challenge_field'] : '';
        $response = isset($_POST['recaptcha_response_field']) ? $_POST['recaptcha_response_field'] : '';

        $resp = recaptcha_check_answer($this->_privateKey, $ip, $challenge, $response);

        if (!$resp->is_valid) {
            if (array_key_exists($resp->error, $this->_messageTemplates)) {
                $message = $this->_messageTemplates[$resp->error];
            } else {
                $message = $this->_messageTemplates['incorrect-captcha-sol'];
            }
            $this->addMessage($message);
            return false;
        }

        return true;
    }
}