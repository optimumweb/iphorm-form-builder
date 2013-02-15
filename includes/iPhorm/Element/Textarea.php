<?php

/**
 * iPhorm_Element_Textarea
 *
 * Textarea element
 *
 * @package iPhorm
 * @subpackage Element
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Element_Textarea extends iPhorm_Element
{
    /**
     * Set the default value
     *
     * Replaces placeholder tags
     *
     * @param string $value
     * @param boolean $replacePlaceholders Whether or not to replace placeholder values
     */
    public function setDefaultValue($value, $replacePlaceholders = true)
    {
        $this->_defaultValue = $replacePlaceholders ? iPhorm::replacePlaceholderValues2($value) : $value;
    }
}