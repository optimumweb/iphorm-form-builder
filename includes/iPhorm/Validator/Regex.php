<?php

/**
 * iPhorm_Validator_Regex
 *
 * Validates the value against a regular expression
 *
 * @package iPhorm
 * @subpackage Validator
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Validator_Regex extends iPhorm_Validator_Abstract
{
    /**
     * The regular expression pattern
     * @var string
     */
    protected $_pattern = '';

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct($options = null)
    {
        $this->_messageTemplates = array(
            'invalid' => __('Invalid value given',  'iphorm')
        );

        if (is_array($options)) {
            if (array_key_exists('pattern', $options)) {
                $this->_pattern = $options['pattern'];
            }

            if (array_key_exists('messages', $options)) {
                $this->setMessageTemplates($options['messages']);
            }
        }
    }

    /**
     * Returns true if the given value matches the regular expression pattern
     * Return false otherwise.
     *
     * @param string $value
     * @return boolean
     */
    public function isValid($value)
    {
        $value = (string) $value;

        $regexFilter = new iPhorm_Filter_Regex();
        $regexFilter->setPattern($this->getPattern());

        if ($value !== $regexFilter->filter($value)) {
            $message = sprintf($this->_messageTemplates['invalid'], $value);
            $this->addMessage($message);
            return false;
        }

        return true;
    }

    /**
     * Set the regular expression pattern
     *
     * @param string $pattern
     */
    public function setPattern($pattern)
    {
        $this->_pattern = $pattern;
    }

    /**
     * Get the regular expression pattern
     *
     * @return string
     */
    public function getPattern()
    {
        return $this->_pattern;
    }
}