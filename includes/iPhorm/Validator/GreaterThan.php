<?php

/**
 * iPhorm_Validator_GreaterThan
 *
 * Validates that the value is greater than the set minimum
 *
 * @package iPhorm
 * @subpackage Validator
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Validator_GreaterThan extends iPhorm_Validator_Abstract
{
    /**
     * Minimum value
     * @var mixed
     */
    protected $_min;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct($options = null)
    {
        $this->_messageTemplates = array(
            'not_greater_than' => __('\'%1$s\' is not greater than \'%2$s\'',  'iphorm')
        );

        if (is_array($options)) {
            if (array_key_exists('min', $options)) {
                $this->setMin($options['min']);
            }
            if (array_key_exists('messages', $options)) {
                $this->setMessageTemplates($options['messages']);
            }
        }

        if ($this->getMin() === null) {
            throw new Exception("Missing option 'min'");
        }
    }

    /**
     * Returns true if and only if $value is greater than min option
     *
     * @param string $value
     * @return boolean
     */
    public function isValid($value)
    {
        if ($this->_min >= $value) {
            $message = sprintf($this->_messageTemplates['not_greater_than'], $value, $this->_min);
            $this->addMessage($message);
            return false;
        }

        return true;
    }

    /**
     * Sets the minimum value
     *
     * @param mixed $min
     */
    public function setMin($min)
    {
        $this->_min = $min;
    }

    /**
     * Get the minimum value
     *
     * @return mixed
     */
    public function getMin()
    {
        return $this->_min;
    }
}