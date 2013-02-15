<?php

/**
 * iPhorm_Validator_Interface
 *
 * @package iPhorm
 * @subpackage Validator
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
interface iPhorm_Validator_Interface
{
    public function isValid($value);
    public function getMessages();
}