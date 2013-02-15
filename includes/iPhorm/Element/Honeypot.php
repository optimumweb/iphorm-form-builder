<?php

/**
 * iPhorm_Element_Honeypot
 *
 * Honeypot element
 *
 * @package iPhorm
 * @subpackage Element
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Element_Honeypot extends iPhorm_Element
{
    /**
     * Whether or not the element should be hidden from the notification email
     * @var boolean
     */
    protected $_isHidden = true;

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct($config = null)
    {
        parent::__construct($config);

        $honeypotValidator = new iPhorm_Validator_Honeypot();
        $this->addValidator($honeypotValidator);
    }
}