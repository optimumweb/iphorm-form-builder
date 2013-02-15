<?php

defined('IPHORM_UPLOAD_ERR_TYPE') || define('IPHORM_UPLOAD_ERR_TYPE', 128);
defined('IPHORM_UPLOAD_ERR_FILE_SIZE') || define('IPHORM_UPLOAD_ERR_FILE_SIZE', 129);
defined('IPHORM_UPLOAD_ERR_NOT_UPLOADED') || define('IPHORM_UPLOAD_ERR_NOT_UPLOADED', 130);

/**
 * iPhorm_Validator_FileUpload
 *
 * Validates an uploaded file
 *
 * @package iPhorm
 * @subpackage Validator
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Validator_FileUpload extends iPhorm_Validator_Abstract
{
    /**
     * The name of the element to check in the $_FILES array
     * @var string
     */
    protected $_name = '';

    /**
     * Allowed file extensions
     * @var array
     */
    protected $_allowedExtensions = array();

    /**
     * Maximum file size in bytes, default is 10MB (10485760 bytes)
     * @var int|float
     */
    protected $_maximumFileSize = 10485760;

    /**
     * Required flag
     * @var boolean
     */
    protected $_required = false;

    /**
     * Class constructor
     *
     * A string with the name of the element or an array of
     * options with a name key is required
     *
     * @param string|array $options
     */
    public function __construct($options)
    {
        $this->_messageTemplates = array(
            'not_uploaded_with_filename' => __('File \'%s\' is not an uploaded file', 'iphorm'),
            'not_uploaded' => __('File is not an uploaded file', 'iphorm'),
            'too_big_with_filename' => __('\'%s\' exceeds the maximum allowed file size', 'iphorm'),
            'too_big' => __('File exceeds the maximum allowed file size', 'iphorm'),
            'not_allowed_type_with_filename' => __('File type of \'%s\' is not allowed', 'iphorm'),
            'not_allowed_type' => __('File type is not allowed', 'iphorm'),
            'field_required' => __('This field is required', 'iphorm'),
            'one_required' => __('At least one file is required', 'iphorm'),
            'only_partial_with_filename' => __('\'%s\' was only partially uploaded', 'iphorm'),
            'only_partial' => __('File was only partially uploaded', 'iphorm'),
            'no_file' => __('No file was uploaded', 'iphorm'),
            'missing_temp_folder' => __('Missing a temporary folder', 'iphorm'),
            'failed_to_write' => __('Failed to write file to disk', 'iphorm'),
            'stopped_by_extension' => __('File upload stopped by extension', 'iphorm'),
            'unknown_error' => __('Unknown upload error', 'iphorm')
        );

        if (is_string($options)) {
            $this->setName($options);
        } elseif (is_array($options)) {
            if (array_key_exists('name', $options)) {
                $this->setName($options['name']);
            }
            if (array_key_exists('allowedExtensions', $options)) {
                $this->setAllowedExtensions($options['allowedExtensions']);
            }
            if (array_key_exists('maximumFileSize', $options)) {
                $this->setMaximumFileSize($options['maximumFileSize']);
            }
            if (array_key_exists('required', $options)) {
                $this->setRequired($options['required']);
            }
            if (array_key_exists('messages', $options)) {
                $this->setMessageTemplates((array) $options['messages']);
            }
        }

        if (!(is_string($this->getName()) && strlen($this->getName()))) {
            throw new Exception('Name option is required');
        }
    }

    /**
     * Returns true if and only if the uploaded file is free of errors
     *
     * @param string $value
     * @return boolean
     */
    public function isValid($value)
    {
        if (array_key_exists($this->_name, $_FILES) && is_array($_FILES[$this->_name])) {
            $file = $_FILES[$this->_name];
            if (is_array($file['error'])) {
                // Process multiple upload field
                $uploaded = 0;
                foreach ($file['error'] as $key => $error) {
                    if ($error === UPLOAD_ERR_OK) {
                        // The file uploaded OK
                        if (!iphorm_is_uploaded_file($file['tmp_name'][$key])) {
                            // The file is not an uploaded file - possibly an attack
                            $this->addMessage($this->_getFileUploadError(IPHORM_UPLOAD_ERR_NOT_UPLOADED, $file['name'][$key]));
                            return false;
                        }

                        if ($this->_maximumFileSize > 0 && $file['size'][$key] > $this->_maximumFileSize) {
                            // The file is larger than the size allowed by the settings
                            $this->addMessage($this->_getFileUploadError(IPHORM_UPLOAD_ERR_FILE_SIZE, $file['name'][$key]));
                            return false;
                        }

                        $pathInfo = pathinfo($file['name'][$key]);
                        $extension = array_key_exists('extension', $pathInfo) ? strtolower($pathInfo['extension']) : '';

                        if (count($this->_allowedExtensions) && !in_array($extension, $this->_allowedExtensions)) {
                            // The file extension is not allowed
                            $this->addMessage($this->_getFileUploadError(IPHORM_UPLOAD_ERR_TYPE, $file['name'][$key]));
                            return false;
                        }
                        $uploaded++;
                    } elseif ($error === UPLOAD_ERR_NO_FILE) {
                        continue;
                    } else {
                        $this->addMessage($this->_getFileUploadError($error, $file['name'][$key]));
                        return false;
                    }
                } // End foreach file

                // Second loop checks if we have at least one upload
                foreach ($file['error'] as $key => $error) {
                    if ($error === UPLOAD_ERR_NO_FILE) {
                        if ($this->getRequired() && $uploaded == 0) {
                            $this->addMessage($this->_messageTemplates['one_required']);
                            return false;
                        }
                    }
                }
            } else {
                // Process single upload field
                if ($file['error'] === UPLOAD_ERR_OK) {
                    // The file uploaded OK
                    if (!iphorm_is_uploaded_file($file['tmp_name'])) {
                        // The file is not an uploaded file - possibly an attack
                        $this->addMessage($this->_getFileUploadError(IPHORM_UPLOAD_ERR_NOT_UPLOADED));
                        return false;
                    }

                    if ($this->_maximumFileSize > 0 && $file['size'] > $this->_maximumFileSize) {
                        // The file is larger than the size allowed by the element settings
                        $this->addMessage($this->_getFileUploadError(IPHORM_UPLOAD_ERR_FILE_SIZE));
                        return false;
                    }

                    $pathInfo = pathinfo($file['name']);
                    $extension = array_key_exists('extension', $pathInfo) ? strtolower($pathInfo['extension']) : '';

                    if (count($this->_allowedExtensions) > 0 && !in_array($extension, $this->_allowedExtensions)) {
                        // The file extension is not allowed
                        $this->addMessage($this->_getFileUploadError(IPHORM_UPLOAD_ERR_TYPE));
                        return false;
                    }
                } elseif ($file['error'] === UPLOAD_ERR_NO_FILE) {
                    if ($this->getRequired()) {
                        $this->addMessage($this->_messageTemplates['field_required']);
                        return false;
                    }
                } else {
                    $this->addMessage($this->_getFileUploadError($file['error']));
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Set the name of the element to validate in $_FILES
     *
     * @param string $name
     */
    public function setName($name)
    {
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
     * Set the allowed extensions, an array of lowercase
     * extensions e.g. array('jpg', 'jpeg', 'gif'). An empty
     * array means all file extensions are allowed
     *
     * @param array $allowedExtensions
     */
    public function setAllowedExtensions(array $allowedExtensions)
    {
        foreach ($allowedExtensions as &$allowedExtension) {
            $allowedExtension = trim(strtolower($allowedExtension));
        }

        $this->_allowedExtensions = $allowedExtensions;
    }

    /**
     * Get the allowed extensions
     *
     * @return array
     */
    public function getAllowedExtensions()
    {
        return $this->_allowedExtensions;
    }

    /**
     * Set the maximum file size in bytes
     *
     * @param int|float $maximumFileSize
     */
    public function setMaximumFileSize($maximumFileSize)
    {
        $this->_maximumFileSize = $maximumFileSize;
    }

    /**
     * Get the maximum file size in bytes
     *
     * @return int|float
     */
    public function getMaximumFileSize()
    {
        return $this->_maximumFileSize;
    }

    /**
     * Set whether the file is required or not
     *
     * @param boolean $flag
     */
    public function setRequired($flag = true)
    {
        $this->_required = (bool) $flag;
    }

    /**
     * Get whether the file is required or not
     *
     * @return boolean
     */
    public function getRequired()
    {
        return $this->_required;
    }

    /**
     * Get the error message corresponding to the error code generated by
     * PHP file uploads and this validator
     *
     * @param int $errorCode The error code
     * @param string $filename (optional) The filename to add to the message
     * @return string The error message
     */
    protected function _getFileUploadError($errorCode, $filename = '')
    {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
            case IPHORM_UPLOAD_ERR_FILE_SIZE:
                if (strlen($filename)) {
                    $message = sprintf($this->_messageTemplates['too_big_with_filename'], $filename);
                } else {
                    $message = $this->_messageTemplates['too_big'];
                }
                return $message;
            case UPLOAD_ERR_PARTIAL:
                if (strlen($filename)) {
                    $message = sprintf($this->_messageTemplates['only_partial_with_filename'], $filename);
                } else {
                    $message = $this->_messageTemplates['only_partial'];
                }
                return $message;
            case UPLOAD_ERR_NO_FILE:
                return $this->_messageTemplates['no_file'];
            case UPLOAD_ERR_NO_TMP_DIR:
                return $this->_messageTemplates['missing_temp_folder'];
            case UPLOAD_ERR_CANT_WRITE:
                return $this->_messageTemplates['failed_to_write'];
            case UPLOAD_ERR_EXTENSION:
                return $this->_messageTemplates['stopped_by_extension'];
            case IPHORM_UPLOAD_ERR_TYPE:
                if (strlen($filename)) {
                    $message = sprintf($this->_messageTemplates['not_allowed_type_with_filename'], $filename);
                } else {
                    $message = $this->_messageTemplates['not_allowed_type'];
                }
                return $message;
            case IPHORM_UPLOAD_ERR_NOT_UPLOADED:
                if (strlen($filename)) {
                    $message = sprintf($this->_messageTemplates['not_uploaded_with_filename'], $filename);
                } else {
                    $message = $this->_messageTemplates['not_uploaded'];
                }
                return $message;
            default:
                return $this->_messageTemplates['unknown_error'];
        }
    }
}