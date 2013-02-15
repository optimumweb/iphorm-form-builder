<?php

/**
 * iPhorm_Element_Hidden
 *
 * Hidden element
 *
 * @package iPhorm
 * @subpackage Element
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Element_Hidden extends iPhorm_Element
{
    /**
     * Set the default value
     *
     * Replaces placeholder tags
     *
     * @param string $value
     */
    public function setDefaultValue($value)
    {
        $this->_defaultValue = iPhorm::replacePlaceholderValues2($value);
    }
}