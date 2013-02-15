<?php

/**
 * iPhorm_Validator_Duplicate
 *
 * Checks that the submitted value has not already been submitted to
 * the WordPress database for this element.
 *
 * @package iPhorm
 * @subpackage Validator
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Validator_Duplicate extends iPhorm_Validator_Abstract
{
    /**
     * Whether to allow white space characters; off by default
     * @var iPhorm_Element
     */
    protected $_element;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct($options = null)
    {
        $this->_messageTemplates = array(
            'duplicate' => __('This value is a duplicate of a previously submitted form',  'iphorm')
        );

        if (is_array($options)) {
            if (array_key_exists('element', $options)) {
                $this->setElement($options['element']);
            }
        }

        if (!$this->getElement() instanceof iPhorm_Element) {
            throw new Exception('Element must be an instance of iPhorm_Element');
        }
    }

    /**
     * Returns true if the value has not been previously submitted.
     * Return false otherwise.
     *
     * @param $value
     * @return boolean
     */
    public function isValid($value)
    {
        global $wpdb;

        $sql = "SELECT `e`.`id` FROM " . iphorm_get_form_entry_data_table_name() . " ed LEFT JOIN " .
        iphorm_get_form_entries_table_name() . " e ON `ed`.`entry_id` = `e`.`id`
        WHERE `e`.`form_id` = %d
        AND `ed`.`element_id` = %d
        AND `ed`.`value` = '%s';";

        $result = $wpdb->get_row($wpdb->prepare($sql,
            $this->_element->getForm()->getId(),
            $this->_element->getId(),
            $this->_element->getValueHtml()
        ));

        if ($result != null) {
            $this->addMessage($this->_messageTemplates['duplicate']);
            return false;
        }

        return true;
    }

    /**
     * Set the element
     *
     * @param iPhorm_Element $element
     */
    public function setElement($element)
    {
        $this->_element = $element;
    }

    /**
     * Get the element
     *
     * @return iPhorm_Element
     */
    public function getElement()
    {
        return $this->_element;
    }
}