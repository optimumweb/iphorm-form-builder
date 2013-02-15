<?php

/**
 * iPhorm_Validator_LessThan
 *
 * Validates that the value is less than the set maximum
 *
 * @package iPhorm
 * @subpackage Validator
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Validator_LessThan extends iPhorm_Validator_Abstract
{
    /**
     * Maximum value
     * @var mixed
     */
    protected $_max;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct($options = null)
    {
        $this->_messageTemplates = array(
            'not_less_than' => __('\'%1$s\' is not less than \'%2$s\'',  'iphorm')
        );

        if (is_array($options)) {
            if (array_key_exists('max', $options)) {
                $this->setMax($options['max']);
            } else {
                throw new Exception("Missing option 'max'");
            }
            if (array_key_exists('messages', $options)) {
                $this->setMessageTemplates($options['messages']);
            }
        }
    }

    /**
     * Returns true if and only if $value is less than max option
     *
     * @param string $value
     * @return boolean
     */
    public function isValid($value)
    {
        if ($this->_max <= $value) {
            $message = sprintf($this->_messageTemplates['not_less_than'], $value, $this->_max);
            $this->addMessage($message);
            return false;
        }

        return true;
    }

    /**
     * Sets the maximum value
     *
     * @param mixed $max
     */
    public function setMax($max)
    {
        $this->_max = $max;
    }

    /**
     * Get the maximum value
     *
     * @return mixed
     */
    public function getMax()
    {
        return $this->_max;
    }
}