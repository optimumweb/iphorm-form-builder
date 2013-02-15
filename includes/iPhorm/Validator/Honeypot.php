<?php

/**
 * iPhorm_Validator_Honeypot
 *
 * Validates that the value is empty
 *
 * @package iPhorm
 * @subpackage Validator
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Validator_Honeypot extends iPhorm_Validator_Abstract
{
    /**
     * Returns true if the given value is empty, false otherwise.
     *
     * @param string $value
     * @return boolean
     */
    public function isValid($value)
    {
        $value = (string) $value;

        if (strlen($value) === 0) {
            return true;
        }

        return false;
    }
}