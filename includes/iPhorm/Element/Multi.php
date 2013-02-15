<?php

/**
 * iPhorm_Element_Multi
 *
 * Abstract class representing elements with options (select, radio and checkbox)
 *
 * @package iPhorm
 * @subpackage Element
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
abstract class iPhorm_Element_Multi extends iPhorm_Element
{
    /**
     * Element options
     * @var array
     */
    protected $_options = array();

    /**
     * Options layout, block or inline
     * @var string
     */
    protected $_optionsLayout = 'block';

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct($config = null)
    {
        if (is_array($config)) {
            if (array_key_exists('options_layout', $config)) {
                $this->setOptionsLayout($config['options_layout']);
                unset($config['options_layout']);
            }
        }

        parent::__construct($config);
    }

    /**
     * Add an element option
     *
     * @param string $option
     * @param string $value
     */
    public function addMultiOption($option, $value = '')
    {
        $option  = (string) $option;
        $this->_options[$option] = $value;
    }

    /**
     * Add multiple element options
     *
     * @param array $options
     */
    public function addMultiOptions(array $options)
    {
        foreach ($options as $option => $value) {
            if (is_array($value)
                && array_key_exists('key', $value)
                && array_key_exists('value', $value)
            ) {
                $this->addMultiOption($value['key'], $value['value']);
            } else {
                $this->addMultiOption($option, $value);
            }
        }
    }

    /**
     * Get the options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * Set the options layout, block or inline
     *
     * @param string $optionsLayout
     */
    public function setOptionsLayout($optionsLayout)
    {
        $this->_optionsLayout = $optionsLayout;
    }

    /**
     * Get the options layout, block or inline
     *
     * @return string
     */
    public function getOptionsLayout()
    {
        return $this->_optionsLayout;
    }
}