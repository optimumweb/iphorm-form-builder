<?php

/**
 * iPhorm_Validator_Email
 *
 * Validates that the value is a valid email address
 *
 * Based on http://code.google.com/p/php-email-address-validation/
 *
 * @package iPhorm
 * @subpackage Validator
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Validator_Email extends iPhorm_Validator_Abstract
{
    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct($options = null)
    {
        $this->_messageTemplates = array(
            'invalid' => __('Invalid email address',  'iphorm')
        );

        if (is_array($options)) {
            if (array_key_exists('messages', $options)) {
                $this->setMessageTemplates($options['messages']);
            }
        }
    }

    /**
     * Check email address validity
     * @param   strEmailAddress     Email address to be checked
     * @return  True if email is valid, false if not
     */
    public function isValid($strEmailAddress)
    {
        $valid = true;

        // Control characters are not allowed
        if (preg_match('/[\x00-\x1F\x7F-\xFF]/', $strEmailAddress)) {
            $valid = false;
        }

        // Check email length - min 3 (a@a), max 256
        if (!$this->check_text_length($strEmailAddress, 3, 256)) {
            $valid = false;
        }

        // Split it into sections using last instance of "@"
        $intAtSymbol = strrpos($strEmailAddress, '@');
        if ($intAtSymbol === false) {
            // No "@" symbol in email.
            $valid = false;
        }
        $arrEmailAddress[0] = substr($strEmailAddress, 0, $intAtSymbol);
        $arrEmailAddress[1] = substr($strEmailAddress, $intAtSymbol + 1);

        // Count the "@" symbols. Only one is allowed, except where
        // contained in quote marks in the local part. Quickest way to
        // check this is to remove anything in quotes. We also remove
        // characters escaped with backslash, and the backslash
        // character.
        $arrTempAddress[0] = preg_replace('/\./'
                                         ,''
                                         ,$arrEmailAddress[0]);
        $arrTempAddress[0] = preg_replace('/"[^"]+"/'
                                         ,''
                                         ,$arrTempAddress[0]);
        $arrTempAddress[1] = $arrEmailAddress[1];
        $strTempAddress = $arrTempAddress[0] . $arrTempAddress[1];
        // Then check - should be no "@" symbols.
        if (strrpos($strTempAddress, '@') !== false) {
            // "@" symbol found
            $valid = false;
        }

        // Check local portion
        if (!$this->check_local_portion($arrEmailAddress[0])) {
            $valid = false;
        }

        // Check domain portion
        if (!$this->check_domain_portion($arrEmailAddress[1])) {
            $valid = false;
        }

        if ($valid == false) {
            $message = sprintf($this->_messageTemplates['invalid'], $strEmailAddress);
            $this->addMessage($message);
        }

        // If we're still here, all checks above passed. Email is valid.
        return $valid;

    }

    /**
     * Checks email section before "@" symbol for validity
     * @param   strLocalPortion     Text to be checked
     * @return  True if local portion is valid, false if not
     */
    protected function check_local_portion($strLocalPortion) {
        // Local portion can only be from 1 to 64 characters, inclusive.
        // Please note that servers are encouraged to accept longer local
        // parts than 64 characters.
        if (!$this->check_text_length($strLocalPortion, 1, 64)) {
            return false;
        }
        // Local portion must be:
        // 1) a dot-atom (strings separated by periods)
        // 2) a quoted string
        // 3) an obsolete format string (combination of the above)
        $arrLocalPortion = explode('.', $strLocalPortion);
        for ($i = 0, $max = sizeof($arrLocalPortion); $i < $max; $i++) {
             if (!preg_match('.^('
                            .    '([A-Za-z0-9!#$%&\'*+/=?^_`{|}~-]'
                            .    '[A-Za-z0-9!#$%&\'*+/=?^_`{|}~-]{0,63})'
                            .'|'
                            .    '("[^\\\"]{0,62}")'
                            .')$.'
                            ,$arrLocalPortion[$i])) {
                return false;
            }
        }
        return true;
    }

    /**
     * Checks email section after "@" symbol for validity
     * @param   strDomainPortion     Text to be checked
     * @return  True if domain portion is valid, false if not
     */
    protected function check_domain_portion($strDomainPortion) {
        // Total domain can only be from 1 to 255 characters, inclusive
        if (!$this->check_text_length($strDomainPortion, 1, 255)) {
            return false;
        }
        // Check if domain is IP, possibly enclosed in square brackets.
        if (preg_match('/^(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])'
           .'(\.(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])){3}$/'
           ,$strDomainPortion) ||
            preg_match('/^\[(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])'
           .'(\.(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])){3}\]$/'
           ,$strDomainPortion)) {
            return true;
        } else {
            $arrDomainPortion = explode('.', $strDomainPortion);
            if (sizeof($arrDomainPortion) < 2) {
                return false; // Not enough parts to domain
            }
            for ($i = 0, $max = sizeof($arrDomainPortion); $i < $max; $i++) {
                // Each portion must be between 1 and 63 characters, inclusive
                if (!$this->check_text_length($arrDomainPortion[$i], 1, 63)) {
                    return false;
                }
                if (!preg_match('/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|'
                   .'([A-Za-z0-9]+))$/', $arrDomainPortion[$i])) {
                    return false;
                }
                if ($i == $max - 1) { // TLD cannot be only numbers
                    if (strlen(preg_replace('/[0-9]/', '', $arrDomainPortion[$i])) <= 0) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    /**
     * Check given text length is between defined bounds
     * @param   strText     Text to be checked
     * @param   intMinimum  Minimum acceptable length
     * @param   intMaximum  Maximum acceptable length
     * @return  True if string is within bounds (inclusive), false if not
     */
    protected function check_text_length($strText, $intMinimum, $intMaximum) {
        // Minimum and maximum are both inclusive
        $intTextLength = strlen($strText);
        if (($intTextLength < $intMinimum) || ($intTextLength > $intMaximum)) {
            return false;
        } else {
            return true;
        }
    }
}