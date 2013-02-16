<?php

/**
 * iPhorm_Element
 *
 * Base class for all elements
 *
 * @package iPhorm
 * @subpackage Element
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Element
{
    /**
     * Element ID
     * @var int
     */
    protected $_id;

    /**
     * Element name
     * @var string
     */
    protected $_name = '';

    /**
     * Element unique ID
     * @var string
     */
    protected $_uniqueId = '';

    /**
     * Element label
     * @var string
     */
    protected $_label = '';

    /**
     * Element admin label
     * @var string
     */
    protected $_adminLabel = '';

    /**
     * Element Podio ID
     * @var string
     */
    protected $_podioId = '';

    /**
     * Element description
     * @var string
     */
    protected $_description = '';

    /**
     * The default value
     * @var mixed
     */
    protected $_defaultValue;

    /**
     * Clear the default value on focus?
     * @var boolean
     */
    protected $_clearDefaultValue = false;

    /**
     * Reset the default value on blur?
     * @var boolean
     */
    protected $_resetDefaultValue = true;

    /**
     * Is the element hidden from the email?
     * @var boolean
     */
    protected $_isHidden = false;

    /**
     * Whether to save the value to the database
     * @var boolean
     */
    protected $_saveToDatabase = false;

    /**
     * The label placement for elements in this group
     * @var string
     */
    protected $_labelPlacement = 'inherit';

    /**
     * The width of the labels, can be any valid CSS width
     * @var string
     */
    protected $_labelWidth = '';

    /**
     * Tooltip text
     * @var string
     */
    protected $_tooltip = '';

    /**
     * Tooltip type, default inherits from global form setting     *
     * @var string
     */
    protected $_tooltipType = 'inherit';

    /**
     * Tooltip trigger event, default inherits from global form setting     *
     * @var string
     */
    protected $_tooltipEvent = 'inherit';

    /**
     * Whether conditional logic is enabled
     * @var boolean
     */
    protected $_logic = false;

    /**
     * Conditional logic action
     * @var string show|hide
     */
    protected $_logicAction = 'show';

    /**
     * Conditional logic rule match
     * @var string all|any
     */
    protected $_logicMatch = 'all';

    /**
     * Conditional logic rules
     * @var array
     */
    protected $_logicRules = array();

    /**
     * Element CSS styles
     * @var array
     */
    protected $_styles = array();

    /**
     * Element value
     * @var mixed
     */
    protected $_value;

    /**
     * Element filters
     * @var array
     */
    protected $_filters = array();

    /**
     * Element validators
     * @var array
     */
    protected $_validators = array();

    /**
     * Error messages
     * @var array
     */
    protected $_errors = array();

    /**
     * Is the element multiple input e.g. multiple select
     * @var boolean
     */
    protected $_isMultiple = false;

    /**
     * Is the element in an array?
     * @var boolean
     */
    protected $_isArray = false;

    /**
     * The form this element belongs to
     * @var iPhorm
     */
    protected $_form = null;

    /**
     * Constructor
     *
     * @param array $config The form configuration
     */
    public function __construct($config = null)
    {
        if (is_array($config)) {
            $this->fromConfig($config);
        }

        if ($this->_name === '') {
            throw new Exception('Every form element must have a name');
        }
    }

    /**
     * Set the ID of the form
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * Get the ID of the form
     *
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set the name of the element
     *
     * @param string $name
     */
    public function setName($name)
    {
        if (substr($name, -2) == '[]') {
            $this->setIsMultiple(true);
            $name = substr($name, 0, -2);
        }

        $this->_name = $name;
    }

    /**
     * Get the name of the element
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set the label of the element
     *
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->_label = $label;
    }

    /**
     * Get the label of the element
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->_label;
    }

    /**
     * Set the admin label
     *
     * @param string $adminLabel
     */
    public function setAdminLabel($adminLabel)
    {
        $this->_adminLabel = $adminLabel;
    }

    /**
     * Get the admin label
     *
     * @return string
     */
    public function getAdminLabel()
    {
        return (strlen($this->_adminLabel)) ? $this->_adminLabel : $this->getLabel();
    }

    /**
     * Set the Podio ID
     *
     * @param string $podioId
     */
    public function setPodioId($podioId)
    {
        $this->_podioId = $podioId;
    }

    /**
     * Get the Podio Id
     *
     * @return string
     */
    public function getPodioId()
    {
        return $this->_podioId;
    }

    /**
     * Set the description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->_description = $description;
    }

    /**
     * Get the description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * Set the required message
     *
     * @param string $requiredMessage
     */
    public function setRequiredMessage($requiredMessage)
    {
        if ($requiredMessage) {
            $requiredValidator = $this->getValidator('required');
            if ($requiredValidator instanceof iPhorm_Validator_Required) {
                $requiredValidator->setMessageTemplate('required', $requiredMessage);
            }
        }
    }

    /**
     * Set the default value
     *
     * @param mixed $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        $this->_defaultValue = $defaultValue;
    }

    /**
     * Get the default value
     *
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->_defaultValue;
    }

    /**
     * Set whether to clear the default value on focus
     *
     * @param boolean $flag
     */
    public function setClearDefaultValue($flag)
    {
        $this->_clearDefaultValue = (bool) $flag;
    }

    /**
     * Get whether to clear the default value on focus
     *
     * @return boolean
     */
    public function getClearDefaultValue()
    {
        return $this->_clearDefaultValue;
    }

    /**
     * Set whether to reset the default value on blur
     *
     * @param boolean $flag
     */
    public function setResetDefaultValue($flag)
    {
        $this->_resetDefaultValue = (bool) $flag;
    }

    /**
     * Get whether to reset the default value on blur
     *
     * @return boolean
     */
    public function getResetDefaultValue()
    {
        return $this->_resetDefaultValue;
    }

    /**
     * Set whether or not element is hidden
     *
     * @param boolean $flag
     */
    public function setIsHidden($flag)
    {
        $this->_isHidden = (bool) $flag;
    }

    /**
     * Get whether the element is hidden or not
     *
     * @return boolean
     */
    public function isHidden()
    {
        return $this->_isHidden;
    }

    /**
     * Set whether to save the value to the database
     *
     * @param boolean $flag
     */
    public function setSaveToDatabase($flag)
    {
        $this->_saveToDatabase = (bool) $flag;
    }

    /**
     * Get whether to save the value to the database
     *
     * @return boolean
     */
    public function getSaveToDatabase()
    {
        return $this->_saveToDatabase;
    }

    /**
     * Set the label placement of elements in this group
     *
     * @param string $labelPlacement
     */
    public function setLabelPlacement($labelPlacement)
    {
        $this->_labelPlacement = $labelPlacement;
    }

    /**
     * Get the label placement
     *
     * @return string
     */
    public function getLabelPlacement()
    {
        return $this->_labelPlacement;
    }

    /**
     * Set the label width of elements in this group
     *
     * @param string $labelWidth
     */
    public function setLabelWidth($labelWidth)
    {
        $this->_labelWidth = $labelWidth;
    }

    /**
     * Get the label width
     *
     * @return string
     */
    public function getLabelWidth()
    {
        return $this->_labelWidth;
    }

    /**
     * Set the tooltip text
     *
     * @param string $tooltip
     */
    public function setTooltip($tooltip)
    {
        $this->_tooltip = $tooltip;
    }

    /**
     * Get the tooltip text
     *
     * @return string
     */
    public function getTooltip()
    {
        return $this->_tooltip;
    }

    /**
     * Set the tooltip type
     *
     * @param string $tooltipType
     */
    public function setTooltipType($tooltipType)
    {
        $this->_tooltipType = $tooltipType;
    }

    /**
     * Get the tooltip type
     *
     * @return string
     */
    public function getTooltipType()
    {
        return $this->_tooltipType;
    }

    /**
     * Set the tooltip trigger event
     *
     * @param string $tooltipEvent
     */
    public function setTooltipEvent($tooltipEvent)
    {
        $this->_tooltipEvent = $tooltipEvent;
    }

    /**
     * Get the tooltip trigger event
     *
     * @return string
     */
    public function getTooltipEvent()
    {
        return $this->_tooltipEvent;
    }

    /**
     * Set whether to use conditional logic
     *
     * @param boolean $flag
     */
    public function setLogic($flag)
    {
        $this->_logic = (bool) $flag;
    }

    /**
     * Is conditional logic enabled?
     *
     * @return boolean
     */
    public function getLogic()
    {
        return $this->_logic;
    }

    /**
     * Set the conditional logic action
     *
     * @param string $logicAction
     */
    public function setLogicAction($logicAction)
    {
        $this->_logicAction = $logicAction;
    }

    /**
     * Get the conditional logic action
     *
     * @return string
     */
    public function getLogicAction()
    {
        return $this->_logicAction;
    }

    /**
     * Set the conditional logic match
     *
     * @param string $logicMatch
     */
    public function setLogicMatch($logicMatch)
    {
        $this->_logicMatch = $logicMatch;
    }

    /**
     * Get the conditional logic match
     *
     * @return string
     */
    public function getLogicMatch()
    {
        return $this->_logicMatch;
    }

    /**
     * Set the conditional logic rules
     *
     * @param array $logicRules
     */
    public function setLogicRules(array $logicRules)
    {
        $this->_logicRules = $logicRules;
    }

    /**
     * Get the conditional logic rules
     *
     * @return array
     */
    public function getLogicRules()
    {
        return $this->_logicRules;
    }

    /**
     * Parse and set the given CSS styles
     *
     * @param array $styles
     */
    public function setStyles(array $styles)
    {
        foreach ($styles as $style) {
            if (isset($style['type']) && isset($style['css'])) {
                $this->_styles[$style['type']] = iPhorm::parseCss($style['css']);
            }
        }
    }

    /**
     * Get all the CSS style rules
     *
     * @return array
     */
    public function getStyles()
    {
        return $this->_styles;
    }

    /**
     * Get the CSS rules for a specific HTML element
     *
     * @param $which
     * @return array
     */
    public function getStyle($which)
    {
        if (array_key_exists($which, $this->_styles)) {
            return $this->_styles[$which];
        }

        return null;
    }

    /**
     * Get the CSS style attribute for the specified HTML element
     *
     * @param string $which
     * @param array $additionalStyles An array of additional styles to merge
     * @return string
     */
    public function getCss($which, $additionalStyles = null)
    {
        $output = '';
        $rules = array();

        // Merge in the form style settings
        switch ($which) {
            case 'input':
                if (($backgroundColour = $this->_form->getElementBackgroundColour()) !== null) {
                    $rules = array_merge($rules, $backgroundColour);

                }
                if (($borderColour = $this->_form->getElementBorderColour()) !== null) {
                    $rules = array_merge($rules, $borderColour);
                }
                if (($textColour = $this->_form->getElementTextColour()) !== null) {
                    $rules = array_merge($rules, $textColour);
                }
                break;
            case 'label':
                if (($textColour = $this->_form->getLabelTextColour()) !== null) {
                    $rules = array_merge($rules, $textColour);
                }
                break;
        }

        // Merge in the global styles
        if (($globalStyle = $this->_form->getStyle($which)) !== null) {
            $rules = array_merge($rules, $globalStyle);
        }

        // Merge in the element styles
        if (($style = $this->getStyle($which)) !== null) {
            $rules = array_merge($rules, $style);
        }

        // Merge in extra element-specific styles
        $rules = $this->getExtraCss($which, $rules);

        // Merge in additional styles
        if (is_array($additionalStyles)) {
            foreach ($additionalStyles as $key => $value) {
                $additionalStyles[$key] = new CSSRule($key);
                $additionalStyles[$key]->addValue(array($value));
            }

            $rules = array_merge($rules, $additionalStyles);
        }

        // Generate the style tag if we have any rules
        if (count($rules)) {
            $output = "style='";
            foreach ($rules as $rule) {
                $output .= $rule->__toString();
            }
            $output .= "'";
        }

        return $output;
    }

    /**
     * Merge extra CSS and with current CSS styles
     *
     * Override this method in a subclass to add element specific
     * CSS
     *
     * @param string $which The name of the section
     * @param array $rules The array of existing rules
     */
    public function getExtraCss($which, $rules)
    {
        return $rules;
    }

    /**
     * Get the fully qualified name of the element
     *
     * @return string
     */
    public function getFullyQualifiedName()
    {
        $name = $this->getName();

        if ($this->getIsMultiple()) {
            $name .= '[]';
        }

        return $name;
    }

    /**
     * Set the flag that the element can have multiple values.
     *
     * @param boolean $flag
     */
    public function setIsMultiple($flag = true)
    {
        $this->_isMultiple = (bool) $flag;
    }

    /**
     * Does this element have multiple values?
     *
     * @return boolean
     */
    public function getIsMultiple()
    {
        return $this->_isMultiple;
    }

    /**
     * Set the flag to indicate that the element is
     * an array.
     *
     * @param boolean $flag
     */
    public function setIsArray($flag = true)
    {
        $this->_isArray = (bool) $flag;
    }

    /**
     * Is the element an array?
     *
     * @param boolean $flag
     */
    public function getIsArray()
    {
        return $this->_isArray;
    }

    /**
     * Add a filter
     *
     * @param string|iPhorm_Filter_Interface $filter The name or instance of the filter
     */
    public function addFilter($filter, $options = null)
    {
        if (is_string($filter)) {
            $filter = $this->_loadFilter($filter, $options);
        }

        if ($filter instanceof iPhorm_Filter_Interface) {
            $name = get_class($filter);
            $this->_filters[$name] = $filter;
        } else {
            throw new Exception('Filter passed to addFilter must be a string or instance of iPhorm_Filter_Interface');
        }
    }

    /**
     * Add multiple filters
     *
     * @param array $filters The array of filter names or instances
     */
    public function addFilters(array $filters)
    {
        foreach ($filters as $filter) {
            if (is_string($filter)) {
                $this->addFilter($filter);
            } else if ($filter instanceof iPhorm_Filter_Interface) {
                $this->addFilter($filter);
            } else if (is_array($filter)) {
                if (isset($filter[0])) {
                    $options = array();
                    if (isset($filter[1]) && is_array($filter[1])) {
                        $options = $filter[1];
                    }

                    $this->addFilter($filter[0], $options);
                }
            }
        }
    }

    /**
     * Set the filters, overrides previously added filters
     *
     * @param array $filters The array of filter names or instances
     */
    public function setFilters(array $filters)
    {
        $this->clearFilters();
        $this->addFilters($filters);
    }

    /**
     * Remove all filters
     */
    public function clearFilters()
    {
        $this->_filters = array();
    }

    /**
     * Does this element have filters?
     *
     * @return boolean
     */
    public function hasFilters()
    {
        return count($this->getFilters()) > 0;
    }

    /**
     * Get the filters
     *
     * @return array The array of filters
     */
    public function getFilters()
    {
        return $this->_filters;
    }

    /**
     * Does the element have the given filter?
     *
     * @param string $name The name of the filter
     * @return boolean
     */
    public function hasFilter($filter)
    {
        $result = false;

        if ($filter instanceof iPhorm_Filter_Interface) {
            $filter = get_class($filter);
        }

        if (is_string($filter)) {
            if (strpos($filter, 'iPhorm_Filter_') === false) {
                $filter = 'iPhorm_Filter_' . ucfirst($filter);
            }

            $result = array_key_exists($filter, $this->getFilters());
        }

        return $result;
    }

    /**
     * Get the filter with the given name
     *
     * @param string $filter The name of the filter
     * @return iPhorm_Filter_Interface|null The filter or null if the element does not have the filter
     */
    public function getFilter($filter)
    {
        $instance = null;

        if (strpos($filter, 'iPhorm_Filter_') === false) {
            $filter = 'iPhorm_Filter_' . ucfirst($filter);
        }

        $filters = $this->getFilters();
        if (array_key_exists($filter, $filters)) {
            $instance = $filters[$filter];
        }

        return $instance;
    }

    /**
     * Remove a filter with the given name
     *
     * @param string $filter The name of the filter
     */
    public function removeFilter($filter)
    {
        if (strpos($filter, 'iPhorm_Filter_') === false) {
            $filter = 'iPhorm_Filter_' . ucfirst($filter);
        }

        if (array_key_exists($filter, $this->_filters)) {
            unset($this->_filters[$filter]);
        }
    }

    /**
     * Add a validator
     *
     * @param string|iPhorm_Validator_Interface $validator The validator to add
     */
    public function addValidator($validator, $options = null)
    {
        if (is_string($validator)) {
            $validator = $this->_loadValidator($validator, $options);
        }

        if ($validator instanceof iPhorm_Validator_Interface) {
            $name = get_class($validator);
            $this->_validators[$name] = $validator;
        } else {
            throw new Exception('Validator passed to addValidator must be a string or instance of iPhorm_Validator_Interface');
        }
    }

    /**
     * Add mutliple validators
     *
     * @param array $validators The validators to add
     */
    public function addValidators(array $validators)
    {
        foreach ($validators as $validator) {
            if (is_string($validator)) {
                $this->addValidator($validator);
            } else if ($validator instanceof iPhorm_Validator_Interface) {
                $this->addValidator($validator);
            } else if (is_array($validator)) {
                if (isset($validator[0])) {
                    $options = array();
                    if (isset($validator[1]) && is_array($validator[1])) {
                        $options = $validator[1];
                    }

                    $this->addValidator($validator[0], $options);
                }
            }
        }
    }

    /**
     * Set the validators, overrides previously added validators
     *
     * @param array $validators The validators to add
     */
    public function setValidators(array $validators)
    {
        $this->clearValidators();
        $this->addValidators($validators);
    }

    /**
     * Remove all validators
     */
    public function clearValidators()
    {
        $this->_validators = array();
    }

    /**
     * Does the element have any validators?
     *
     * @return boolean
     */
    public function hasValidators()
    {
        return count($this->getValidators()) > 0;
    }

    /**
     * Get the validators
     *
     * @return array The validators
     */
    public function getValidators()
    {
        return $this->_validators;
    }

    /**
     * Does the element have the given validator?
     *
     * @param string|iPhorm_Validator_Interface $name The name or instance of the validator
     * @return boolean
     */
    public function hasValidator($validator)
    {
        $result = false;

        if ($validator instanceof iPhorm_Validator_Interface) {
            $validator = get_class($validator);
        }

        if (is_string($validator)) {
            if (strpos($validator, 'iPhorm_Validator_') === false) {
                $validator = 'iPhorm_Validator_' . ucfirst($validator);
            }

            $result = array_key_exists($validator, $this->getValidators());
        }

        return $result;
    }

    /**
     * Get the validator with the given name
     *
     * @param string $validator The name of the validator
     * @return iPhorm_Validator_Interface|null The validator or null if the element does not have the validator
     */
    public function getValidator($validator)
    {
        $instance = null;

        if (strpos($validator, 'iPhorm_Validator_') === false) {
            $validator = 'iPhorm_Validator_' . ucfirst($validator);
        }

        $validators = $this->getValidators();
        if (array_key_exists($validator, $validators)) {
            $instance = $validators[$validator];
        }

        return $instance;
    }

    /**
     * Remove a validator with the given name
     *
     * @param string $validator The name of the validator
     */
    public function removeValidator($validator)
    {
        if (strpos($validator, 'iPhorm_Validator_') === false) {
            $validator = 'iPhorm_Validator_' . ucfirst($validator);
        }

        if (array_key_exists($validator, $this->_validators)) {
            unset($this->_validators[$validator]);
        }
    }

    /**
     * Sets whether the element is required or not
     *
     * @param boolean $flag
     */
    public function setRequired($flag = true)
    {
        if ((bool) $flag === true) {
            $this->addValidator('required');
        } else {
            $this->removeValidator('required');
        }
    }

    /**
     * Gets whether the element is required or not
     *
     * @return boolean
     */
    public function getRequired()
    {
        return $this->hasValidator('required');
    }

    /**
     * Get the unfiltered (raw) value
     *
     * @return string The raw value
     */
    public function getValueUnfiltered()
    {
        return $this->_value;
    }

    /**
     * Set the value
     *
     * @param srting $value The value to set
     */
    public function setValue($value)
    {
        $this->_value = $value;
    }

    /**
     * Get the filtered value
     *
     * @return string The filtered value
     */
    public function getValue()
    {
        $valueFiltered = $this->_value;

        if (is_array($valueFiltered)) {
            $this->_filterValueRecursive($valueFiltered);
        } else {
            $this->_filterValue($valueFiltered);
        }

        return $valueFiltered;
    }

    /**
     * Get the value as string
     *
     * @return string
     */
    public function getValueAsString()
    {
        $filteredValue = $this->getValue();
        $value = '';

        if (is_scalar($filteredValue)) {
            $value = (string) $filteredValue;
        } else if (is_array($filteredValue)) {
            $arr = array();
            foreach ($filteredValue as $val) {
                if (is_scalar($val)) {
                    $arr[] = (string) $val;
                }
            }
            $value = join(', ', $arr);
        }

        return $value;
    }

    /**
     * Get the human readable value for the HTML email
     *
     * @return string
     */
    public function getValueHtml()
    {
        $filteredValue = $this->getValue();
        $value = '';

        if (is_scalar($filteredValue)) {
            $value = nl2br(esc_html((string) $filteredValue));
        } else if (is_array($filteredValue)) {
            foreach ($filteredValue as $val) {
                if (is_scalar($val)) {
                    $value .= nl2br(esc_html((string) $val)) . '<br />';
                }
            }
        }

        return $value;
    }

    /**
     * Get the human readable value for the plain text email
     *
     * @return string
     */
    public function getValuePlain()
    {
        $filteredValue = $this->getValue();
        $value = '';

        if (is_scalar($filteredValue)) {
            $value = (string) $filteredValue;
        } else if (is_array($filteredValue)) {
            foreach ($filteredValue as $val) {
                if (is_scalar($val)) {
                    $value .= (string) $val . IPHORM_EMAIL_NEWLINE;
                }
            }
        }

        return $value;
    }

    /**
     * Is the given value valid?
     *
     * @param string $value The value to check
     * @param array $context The other submitted form values
     * @return boolean True if valid, false otherwise
     */
    public function isValid($value, $context = null)
    {
        $this->setValue($value);
        $value = $this->getValue();

        $skipValidation = false;
        if (!$this->hasValidator('required')) {
            if (is_array($value)) {
                $skipValidation = true;
                foreach (array_values($value) as $av) {
                    if ($av != null) {
                        $skipValidation = false;
                        break;
                    }
                }
            } elseif ($value === '' || $value === null) {
                $skipValidation = true;
            }
        }

        // We can skip validating if the value is empty and the element is not required
        if ($skipValidation) {
            return true;
        }

        $this->_errors = array();
        $valid = true;

        foreach ($this->getValidators() as $validator) {
            if ($validator->isValid($value, $context)) {
                continue;
            } else {
                $errors = $validator->getMessages();
                $valid = false;
            }

            $this->_errors = array_merge($this->_errors, $errors);
        }

        return apply_filters('iphorm_element_valid_' . $this->getName(), $valid, $value, $this);
    }

    /**
     * Get the error messages
     *
     * @return array The error messages
     */
    public function getErrors()
    {
        return $this->_errors;
    }

    /**
     * Does the element have errors?
     *
     * @return boolean
     */
    public function hasErrors()
    {
        return count($this->getErrors()) > 0;
    }

    /**
     * Add an error message
     *
     * @param string $message
     */
    public function addError($message)
    {
        $this->_errors[] = $message;
    }

    /**
     * Add multiple error messages
     *
     * @param array $messages
     */
    public function addErrors(array $messages)
    {
        foreach ($messages as $message) {
            $this->addError($message);
        }
    }

    /**
     * Set multiple error messages
     *
     * @param array $messages
     */
    public function setErrors(array $messages)
    {
        $this->_errors = $messages;
    }

    /**
     * Set the form the element belongs to
     *
     * @param iPhorm $form
     */
    public function setForm(iPhorm $form)
    {
        $this->_form = $form;
    }

    /**
     * Get the form the element belongs to
     *
     * @return iPhorm
     */
    public function getForm()
    {
        return $this->_form;
    }

    /**
     * Configure the element from the given configuration
     *
     * @param array $config
     */
    public function fromConfig(array $config)
    {
        if (array_key_exists('form', $config)) {
            $this->setForm($config['form']);
        }

        if (array_key_exists('id', $config)) {
            $this->setId($config['id']);
        }

        if (array_key_exists('name', $config)) {
            $this->setName($config['name']);
        }

        if (array_key_exists('unique_id', $config)) {
            $this->setUniqueId($config['unique_id']);
        }

        if (array_key_exists('label', $config)) {
            $this->setLabel($config['label']);
        }

        if (array_key_exists('admin_label', $config)) {
            $this->setAdminLabel($config['admin_label']);
        }

        if (array_key_exists('podio_id', $config)) {
            $this->setPodioId($config['podio_id']);
        }

        if (array_key_exists('description', $config)) {
            $this->setDescription($config['description']);
        }

        if (array_key_exists('required', $config)) {
            $this->setRequired($config['required']);
        }

        if (array_key_exists('required_message', $config)) {
            $this->setRequiredMessage($config['required_message']);
        }

        if (array_key_exists('default_value', $config)) {
            $this->setDefaultValue($config['default_value']);
            $this->setValue($this->getDefaultValue());
        }

        if (array_key_exists('dynamic_default_value', $config) && array_key_exists('dynamic_key', $config) && strlen($config['dynamic_key'])) {
            $this->setDynamicDefaultValue($config['dynamic_key']);
        }

        if (array_key_exists('clear_default_value', $config)) {
            $this->setClearDefaultValue($config['clear_default_value']);
        }

        if (array_key_exists('reset_default_value', $config)) {
            $this->setResetDefaultValue($config['reset_default_value']);
        }

        if (array_key_exists('is_hidden', $config)) {
            $this->setIsHidden($config['is_hidden']);
        }

        if (array_key_exists('save_to_database', $config)) {
            $this->setSaveToDatabase($config['save_to_database']);
        }

        if (array_key_exists('label_placement', $config)) {
            $this->setLabelPlacement($config['label_placement']);
        }

        if (array_key_exists('label_width', $config)) {
            $this->setLabelWidth($config['label_width']);
        }

        if (array_key_exists('tooltip', $config)) {
            $this->setTooltip($config['tooltip']);
        }

        if (array_key_exists('tooltip_type', $config)) {
            $this->setTooltipType($config['tooltip_type']);
        }

        if (array_key_exists('tooltip_event', $config)) {
            $this->setTooltipEvent($config['tooltip_event']);
        }

        if (array_key_exists('logic', $config)) {
            $this->setLogic($config['logic']);
        }

        if (array_key_exists('logic_action', $config)) {
            $this->setLogicAction($config['logic_action']);
        }

        if (array_key_exists('logic_match', $config)) {
            $this->setLogicMatch($config['logic_match']);
        }

        if (array_key_exists('logic_rules', $config) && is_array($config['logic_rules'])) {
            $this->setLogicRules($config['logic_rules']);
        }

        if (array_key_exists('styles', $config) && is_array($config['styles'])) {
            $this->setStyles($config['styles']);
        }

        if (array_key_exists('filters', $config) && is_array($config['filters'])) {
            foreach ($config['filters'] as $fConfig) {
                if (isset($fConfig['type'])) {
                    $fClass = 'iPhorm_Filter_' . ucfirst($fConfig['type']);
                    if (class_exists($fClass)) {
                        $this->addFilter(new $fClass($fConfig));
                    }
                }
            }
        }

        if (array_key_exists('validators', $config) && is_array($config['validators'])) {
            foreach ($config['validators'] as $vConfig) {
                if (isset($vConfig['type'])) {
                    $vClass = 'iPhorm_Validator_' . ucfirst($vConfig['type']);
                    if (class_exists($vClass)) {
                        $this->addValidator(new $vClass($vConfig));
                    }
                }
            }
        }

        if (array_key_exists('prevent_duplicates', $config) && $config['prevent_duplicates']) {
            $this->addValidator('duplicate', array(
                'element' => $this
            ));
        }

        if (array_key_exists('duplicate_found_message', $config) && strlen($config['duplicate_found_message'])) {
            $duplicateValidator = $this->getValidator('duplicate');
            if ($duplicateValidator instanceof iPhorm_Validator_Duplicate) {
                $duplicateValidator->setMessageTemplate('duplicate', $config['duplicate_found_message']);
            }
        }
    }

    /**
     * Set the unique ID
     *
     * @param string $uniqueId
     */
    public function setUniqueId($uniqueId)
    {
        $this->_uniqueId = $uniqueId;
    }

    /**
     * Get the unique ID
     *
     * @return string
     */
    public function getUniqueId()
    {
        return $this->_uniqueId;
    }

    /**
     * Reset the value to default
     */
    public function reset()
    {
        $this->setValue($this->getDefaultValue());
    }

    /**
     * Sets the default value dynamically
     *
     * @param string key
     */
    public function setDynamicDefaultValue($key)
    {
        $value = '';

        $dynamicValues = $this->_form->getDynamicValues();
        if (isset($dynamicValues[$key])) {
            $value = $dynamicValues[$key];
        }

        if (isset($_GET[$key])) {
            $value = $_GET[$key];
        }

        $value = $this->prepareDynamicValue($value);

        $value = apply_filters('iphorm_element_value_' . $key, $value);

        if (!empty($value)) {
            $this->setDefaultValue($value, false);
            $this->setValue($this->getDefaultValue());
        }
    }

    /**
     * Subclasses can alter the dynamic default value to suit
     *
     * @param string $value
     */
    public function prepareDynamicValue($value)
    {
        return $value;
    }

    /**
     * Filter the given value by reference
     *
     * @param string $value
     */
    protected function _filterValue(&$value)
    {
        foreach ($this->getFilters() as $filter) {
            $value = $filter->filter($value);
        }
    }

    /**
     * Recursively filter the given value by reference
     *
     * @param array $value
     */
    protected function _filterValueRecursive(&$value)
    {
        if (is_array($value)) {
            array_walk($value, array($this, '_filterValueRecursive'));
        } else {
            $this->_filterValue($value);
        }
    }

    /**
     * Load the filter instance from the given name
     *
     * @param string $filter
     * @param array $options Options to pass to the filter
     * @return null|iPhorm_Filter_Interface The filter
     */
    protected function _loadFilter($filter, $options = null)
    {
        $instance = null;

        if (!empty($filter)) {
            $className = 'iPhorm_Filter_' . ucfirst($filter);
            if (class_exists($className)) {
                $instance = new $className($options);
            }
        }

        if ($instance == null) {
            throw new Exception("Filter '$filter' does not exist");
        }

        return $instance;
    }

    /**
     * Load the validator instance from the given name
     *
     * @param string $validator
     * @param array $options Options to pass to the validator
     * @return null|iPhorm_Validator_Interface The validator
     */
    protected function _loadValidator($validator, $options = null)
    {
        $instance = null;

        if (!empty($validator)) {
            $className = 'iPhorm_Validator_' . ucfirst($validator);
            if (class_exists($className)) {
                $instance = new $className($options);
            }
        }

        if ($instance == null) {
            throw new Exception("Validator '$validator' does not exist");
        }

        return $instance;
    }

    /**
     * Get the pretty version of the form element name. Translates
     * the machine name to a more human readable format.  E.g.
     * "email_address" becomes "Email address".
     *
     * @param string $name The form element name
     * @return string The pretty version of the name
     */
    protected function _prettyName($name)
    {
        $prettyName = str_replace(array('-', '_'), ' ', $name);
        $prettyName = ucfirst($prettyName);
        return $prettyName;
    }
}