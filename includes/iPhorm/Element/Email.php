<?php

/**
 * iPhorm_Element_Email
 *
 * Email element
 *
 * @package iPhorm
 * @subpackage Element
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Element_Email extends iPhorm_Element
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

    /**
     * Get the human readable value for the HTML email
     *
     * @return string
     */
    public function getValueHtml()
    {
        $filteredValue = (string) $this->getValue();
        $value = '';

        if (strlen($filteredValue)) {
            $value = '<a href="mailto:' . $filteredValue . '">' . $filteredValue . '</a>';
        }

        return $value;
    }
}