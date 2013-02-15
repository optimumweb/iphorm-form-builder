<?php

/**
 * iPhorm_Filter_Trim
 *
 * Trims whitespace
 *
 * @package iPhorm
 * @subpackage Filter
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Filter_Trim implements iPhorm_Filter_Interface
{
    /**
     * Trims whitespace and other characters from the
     * beginning and end of the given value.
     *
     * @param string $value The value to filter
     * @return string The filtered value
     */
    public function filter($value)
    {
        return trim($value);
    }
}