<?php

/**
 * iPhorm_Element_Time
 *
 * Time element
 *
 * @package iPhorm
 * @subpackage Element
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Element_Time extends iPhorm_Element
{
    /**
     * The time display mode 12 or 24 hour
     * @var string
     */
    protected $_time1224 = '12';

    /**
     * Determines the gap between minutes
     * @var int
     */
    protected $_minuteGranularity = 1;

    /**
     * The date() format to display the time
     * @var string
     */
    protected $_timeFormat = 'g:i a';

    /**
     * Translated 'am'
     * @var string
     */
    protected $_amString = '';

    /**
     * Translated 'pm'
     * @var string
     */
    protected $_pmString = '';

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct($config = null)
    {
        parent::__construct($config);

        if (is_array($config)) {
            if (array_key_exists('time_12_24', $config)) {
                $this->setTime1224($config['time_12_24']);
            }

            if (array_key_exists('minute_granularity', $config)) {
                $this->setMinuteGranularity($config['minute_granularity']);
            }

            if (array_key_exists('time_format', $config)) {
                $this->setTimeFormat($config['time_format']);
            }

            if (array_key_exists('am_string', $config)) {
                $this->setAmString($config['am_string']);
            }

            if (array_key_exists('pm_string', $config)) {
                $this->setPmString($config['pm_string']);
            }
        }
    }

    /**
     * Sets 12 hour or 24 hour display mode
     *
     * '12' for 12 hour
     * '24' for 24 hour
     *
     * @param string $time1224
     */
    public function setTime1224($time1224)
    {
        $this->_time1224 = $time1224;
    }

    /**
     * Get the display mode, 12 or 24 hour
     *
     * @return string
     */
    public function getTime1224()
    {
        return $this->_time1224;
    }

    /**
     * Set the minute granularity which determines the gap
     * between minutes
     *
     * @param int $minuteGranularity
     */
    public function setMinuteGranularity($minuteGranularity)
    {
        $this->_minuteGranularity = $minuteGranularity;
    }

    /**
     * Get the minute granularity which determines the gap
     * between minutes
     *
     * @return int
     */
    public function getMinuteGranularity()
    {
        return $this->_minuteGranularity;
    }

    /**
     * Set the date() format for displaying the time
     *
     * @param string $timeFormat
     */
    public function setTimeFormat($timeFormat)
    {
        $this->_timeFormat = $timeFormat;
    }

    /**
     * Get the date() format for displaying the time
     *
     * @return string
     */
    public function getTimeFormat()
    {
        return $this->_timeFormat;
    }

    /**
     * Set the 'am' string
     *
     * @param string $amString
     */
    public function setAmString($amString)
    {
        $this->_amString = $amString;
    }

    /**
     * Get the 'am' string
     *
     * @param string $amString
     */
    public function getAmString()
    {
        return strlen($this->_amString) ? $this->_amString : _x('am', 'time, morning', 'iphorm');
    }

    /**
     * Set the 'pm' string
     *
     * @param string $pmString
     */
    public function setPmString($pmString)
    {
        $this->_pmString = $pmString;
    }

    /**
     * Get the 'pm' string
     *
     * @param string $amString
     */
    public function getPmString()
    {
        return strlen($this->_pmString) ? $this->_pmString : _x('pm', 'time, evening', 'iphorm');
    }

    /**
     * Get the human readable value for the HTML email
     *
     * @return string
     */
    public function getValueHtml()
    {
        return esc_html($this->getValueAsString());
    }

    /**
     * Get the human readable value for the plain text email
     *
     * @return string
     */
    public function getValuePlain()
    {
        return $this->getValueAsString();
    }

    /**
     * Get the value as string
     *
     * @return string
     */
    public function getValueAsString()
    {
        $v = $this->getValue();
        $value = '';

        if (isset($v['hour']) && isset($v['minute']) && isset($v['ampm'])) {
            if ($this->getTime1224() == '12') {
                $time = strtotime($v['hour'].':'.$v['minute'].' '.$v['ampm']);
            } else {
                $time = strtotime($v['hour'].':'.$v['minute']);
            }

            $value = date_i18n($this->getTimeFormat(), $time);
        }

        return $value;
    }

    /**
     * Prepare the dynamic default value
     *
     * @param string $value
     */
    public function prepareDynamicValue($value)
    {
        $parts = explode(',', $value);

        return array(
            'hour' => isset($parts[0]) ? $parts[0] : '',
            'minute' => isset($parts[1]) ? $parts[1] : '',
            'ampm' => isset($parts[2]) ? $parts[2] : ''
        );
    }
}