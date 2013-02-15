<?php

/**
 * iPhorm_Validator_Length
 *
 * Validates that length of the value is between the set maximum
 * and minimum
 *
 * @package iPhorm
 * @subpackage Validator
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Validator_Length extends iPhorm_Validator_Abstract
{
    /**
     * Minimum length
     * @var integer
     */
    protected $_min;

    /**
     * Maximum length.  If null, there is no maximum length
     * @var integer|null
     */
    protected $_max;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct($options = array())
    {
        $this->_messageTemplates = array(
            'invalid' => __('Invalid type given, value should be a string', 'iphorm'),
            'too_short' => __('Value must be at least %2$s characters long', 'iphorm'),
            'too_long' => __('Value must be less than %2$s characters long', 'iphorm')
        );

        if (is_array($options)) {
            if (!array_key_exists('min', $options) || !strlen($options['min'])) {
                $options['min'] = 0;
            }
            $this->setMin($options['min']);

            if (array_key_exists('max', $options) && strlen($options['max'])) {
                $this->setMax($options['max']);
            }
            if (array_key_exists('messages', $options)) {
                $this->setMessageTemplates($options['messages']);
            }
        }
    }

    /**
     * Returns true if and only if the string length of $value is at least the min option and
     * no greater than the max option (when the max option is not null).
     *
     * @param string $value
     * @return boolean
     */
    public function isValid($value)
    {
        if (!is_string($value)) {
            $this->addMessage($this->_messageTemplates['invalid']);
            return false;
        }

        $length = strlen(utf8_decode($value));

        if ($length < $this->_min) {
            $message = sprintf($this->_messageTemplates['too_short'], $value, $this->_min, $length);
            $this->addMessage($message);
            return false;
        }

        if ($this->_max !== null && $this->_max < $length) {
            $message = sprintf($this->_messageTemplates['too_long'], $value, $this->_max, $length);
            $this->addMessage($message);
            return false;
        }

        return true;
    }

    /**
     * Set the minimum length
     *
     * @param integer $min
     */
    public function setMin($min)
    {
        if ($this->_max !== null && $min > $this->_max) {
            throw new Exception('The minimum must be less than or equal to the maximum length');
        } else {
            $this->_min = max(0, (int) $min);
        }
    }

    /**
     * Get the minimum length
     *
     * @return integer
     */
    public function getMin()
    {
        return $this->_min;
    }

    /**
     * Set the maximum length
     *
     * @param integer $max
     */
    public function setMax($max)
    {
        if ($max < $this->_min) {
            throw new Exception('The maximum must be greater than or equal to the minimum length');
        } else {
            $this->_max = (int) $max;
        }
    }

    /**
     * Get the maximum length
     *
     * @return integer|null
     */
    public function getMax()
    {
        return $this->_max;
    }
}