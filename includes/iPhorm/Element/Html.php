<?php

/**
 * iPhorm_Element_Html
 *
 * HTML element (renders HTML)
 *
 * @package iPhorm
 * @subpackage Element
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Element_Html extends iPhorm_Element
{
    /**
     * The HTML to display
     * @var string
     */
    protected $_content = '';

    /**
     * Whether or not the element should be hidden from the notification email
     * @var boolean
     */
    protected $_isHidden = true;

    /**
     * Whether the element should have an additonal wrapper and behave like a normal element
     *
     * @var boolean
     */
    protected $_enableWrapper = false;

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct($config = null)
    {
        parent::__construct($config);

        if (is_array($config)) {
            if (array_key_exists('content', $config)) {
                $this->setContent($config['content']);
            }
            if (array_key_exists('enable_wrapper', $config)) {
                $this->setEnableWrapper($config['enable_wrapper']);
            }
        }
    }

    /**
     * Set the HTML to display
     *
     * @param string $content
     */
    public function setContent($content)
    {
        $this->_content = $content;
    }

    /**
     * Get the HTML to display
     *
     * @return string
     */
    public function getContent()
    {
        return $this->_content;
    }

    /**
     * Set whether the element should have an additonal wrapper
     *
     * @param boolean $flag
     */
    public function setEnableWrapper($flag)
    {
        $this->_enableWrapper = (bool) $flag;
    }

    /**
     * Get whether the element should have an additonal wrapper
     *
     * @return boolean
     */
    public function getEnableWrapper()
    {
        return $this->_enableWrapper;
    }
}