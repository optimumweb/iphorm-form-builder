<?php

/**
 * iPhorm_Element_Recaptcha
 *
 * ReCAPTCHA element
 *
 * @package iPhorm
 * @subpackage Element
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Element_Recaptcha extends iPhorm_Element
{
    /**
     * Is the element hidden from the notification email?
     * @var boolean
     */
    protected $_isHidden = true;

    /**
     * The reCAPTCHA theme to use
     * @var string
     */
    protected $_recaptchaTheme = 'red';

    /**
     * The language to use
     * @var string
     */
    protected $_recaptchaLang = 'en';

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct($config = null)
    {
        if (is_array($config)) {
            $recaptchaValidator = new iPhorm_Validator_Recaptcha(array(
                'privateKey' => get_option('iphorm_recaptcha_private_key')
            ));

            if (array_key_exists('recaptcha_theme', $config)) {
                $this->setRecaptchaTheme($config['recaptcha_theme']);
                unset($config['recaptcha_theme']);
            }

            if (array_key_exists('recaptcha_lang', $config)) {
                $this->setRecaptchaLang($config['recaptcha_lang']);
                unset($config['recaptcha_lang']);
            }

            if (array_key_exists('messages', $config) && is_array($config['messages'])) {
                $recaptchaValidator->setMessageTemplates($config['messages']);
                unset($config['messages']);
            }

            $config['name'] = 'recaptcha_response_field';
            parent::__construct($config);

            $this->addValidator($recaptchaValidator);
        }
    }

    /**
     * Set the reCAPTCHA theme
     *
     * @param string $recaptchaTheme
     */
    public function setRecaptchaTheme($recaptchaTheme)
    {
        $this->_recaptchaTheme = $recaptchaTheme;
    }

    /**
     * Get the reCAPTCHA theme
     *
     * @return string
     */
    public function getRecaptchaTheme()
    {
        return $this->_recaptchaTheme;
    }

    /**
     * Set the reCAPTCHA language
     *
     * @param string $recaptchaLang
     */
    public function setRecaptchaLang($recaptchaLang)
    {
        $this->_recaptchaLang = $recaptchaLang;
    }

    /**
     * Get the reCAPTCHA language
     *
     * @return string
     */
    public function getRecaptchaLang()
    {
        return $this->_recaptchaLang;
    }
}