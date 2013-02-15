<?php

/**
 * iPhorm_Validator_Identical
 *
 * Validates that the value is identical to the set token
 *
 * @package iPhorm
 * @subpackage Validator
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Validator_Identical extends iPhorm_Validator_Abstract
{
    /**
     * The token to check
     * @var mixed
     */
    protected $_token;

    /**
     * Constructor
     *
     * @param mixed $spec The token or an array of options
     */
    public function __construct($spec)
    {
        $this->_messageTemplates = array(
            'not_match' => __('Value does not match',  'iphorm')
        );

        if (is_string($spec)) {
            $this->setToken($spec);
        } elseif (is_array($spec)) {
            if (array_key_exists('token', $spec)) {
                $this->setToken($spec['token']);
            }
            if (array_key_exists('messages', $spec)) {
                $this->setMessageTemplates($spec['messages']);
            }
        }

        if ($this->getToken() === null) {
            throw new Exception('Token required for Identical validator');
        }
    }

    /**
     * Returns true if the given value is equal to the set value
     * Return false otherwise.
     *
     * @param string $value
     * @return boolean
     */
    public function isValid($value)
    {
        $token = $this->getToken();

        if ($value != $token) {
            $message = sprintf($this->_messageTemplates['not_match'], $value, $token);
            $this->addMessage($message);
            return false;
        }

        return true;
    }

    /**
     * Set the token
     *
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->_token = $token;
    }

    /**
     * Get the token
     *
     * @return mixed
     */
    public function getToken()
    {
        return $this->_token;
    }
}