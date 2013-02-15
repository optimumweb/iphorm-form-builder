<?php

/**
 * iPhorm_Validator_Alpha
 *
 * Validates that the value contains only alphabet characters
 *
 * @package iPhorm
 * @subpackage Validator
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Validator_Alpha extends iPhorm_Validator_Abstract
{
    /**
     * Whether to allow white space characters; off by default
     * @var boolean
     */
    protected $_allowWhiteSpace = false;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct($options = null)
    {
        $this->_messageTemplates = array(
            'invalid' => __('Only alphabet characters are allowed',  'iphorm')
        );

        if (is_array($options)) {
            if (array_key_exists('allow_white_space', $options)) {
                $this->setAllowWhiteSpace($options['allow_white_space']);
            }

            if (array_key_exists('messages', $options)) {
                $this->setMessageTemplates($options['messages']);
            }
        }
    }

    /**
     * Returns true if the given value contains only alphabet characters.
     * Return false otherwise.
     *
     * @param string $value
     * @return boolean
     */
    public function isValid($value)
    {
        $value = (string) $value;

        $alphaFilter = new iPhorm_Filter_Alpha();
        $alphaFilter->setAllowWhiteSpace($this->_allowWhiteSpace);

        if ($value !== $alphaFilter->filter($value)) {
            $message = sprintf($this->_messageTemplates['invalid'], $value);
            $this->addMessage($message);
            return false;
        }

        return true;
    }

    /**
     * Set whether to allow white space
     *
     * @param boolean $flag
     */
    public function setAllowWhiteSpace($flag)
    {
        $this->_allowWhiteSpace = (bool) $flag;
    }

    /**
     * Get whether to allow white space
     *
     * @return boolean
     */
    public function getAllowWhiteSpace()
    {
        return $this->_allowWhiteSpace;
    }
}