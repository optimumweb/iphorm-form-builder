<?php

/**
 * iPhorm_Validator_Required
 *
 * Validates that the value is not empty
 *
 * @package iPhorm
 * @subpackage Validator
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Validator_Required extends iPhorm_Validator_Abstract
{
    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct($options = null)
    {
        $this->_messageTemplates = array(
            'required' => __('This field is required',  'iphorm')
        );

        if (is_array($options)) {
            if (array_key_exists('messages', $options)) {
                $this->setMessageTemplates($options['messages']);
            }
        }
    }

    /**
     * Checks whether the given value is not empty. Also sets
     * the error message if value is empty.
     *
     * @param $value The value to check
     * @return boolean True if valid false otherwise
     */
    public function isValid($value)
    {
        $valid = true;

        if (is_array($value)) {
            $valid = false;
            foreach (array_values($value) as $val) {
                if ($val != null) {
                    $valid = true;
                }
            }
        } else if ($value === null || $value === '') {
            $valid = false;
        }

        if ($valid == false) {
            $this->addMessage($this->_messageTemplates['required']);
        }

        return $valid;
    }
}