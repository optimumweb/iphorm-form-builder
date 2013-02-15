<?php

/**
 * iPhorm_Element_File
 *
 * File element
 *
 * @package iPhorm
 * @subpackage Element
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Element_File extends iPhorm_Element
{
    /**
     * File upload validator
     * @var iPhorm_Validator_FileUpload
     */
    protected $_fileUploadValidator = null;

    /**
     * Enable the Flash uploader
     * @var boolean
     */
    protected $_enableSwfUpload = true;

    /**
     * Allow more than one file upload?
     * @var boolean
     */
    protected $_allowMultipleUploads = false;

    /**
     * Add uploaded files as attachments of the notification email
     * @var boolean
     */
    protected $_addAsAttachment = false;

    /**
     * Save the uploaded files to the server
     * @var boolean
     */
    protected $_saveToServer = true;

    /**
     * Path to save the uploaded files
     * @var string
     */
    protected $_savePath = 'iphorm/{form_id}/{year}/{month}/';

    /**
     * The text for the browse button
     * @var string
     */
    protected $_browseText = '';

    /**
     * The default text inside the input
     * @var string
     */
    protected $_defaultText = '';

    /**
     * Number of upload fields to show
     * @var int
     */
    protected $_uploadNumFields = 1;

    /**
     * Include a link to add more upload fields
     * @var unknown_type
     */
    protected $_uploadUserAddMore = false;

    /**
     * The file containing the HTML for displaying the element
     * @var string
     */
    protected $_uploadAddAnotherText = '';

    /**
     * The value which is an array of any uploaded files
     * @var array
     */
    protected $_value = array();

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        if (array_key_exists('name', $config)) {
            $name = $config['name'];
            if (array_key_exists('allow_multiple_uploads', $config) && $config['allow_multiple_uploads']) {
                $this->setAllowMultipleUploads($config['allow_multiple_uploads']);
                $name .= '[]';
                unset($config['allow_multiple_uploads']);
            }
            $this->setName($name);
            unset($config['name']);
        }

        $this->_fileUploadValidator = new iPhorm_Validator_FileUpload(array(
            'name' => $this->getName()
        ));
        $this->addValidator($this->_fileUploadValidator);

        parent::__construct($config);

        if (array_key_exists('enable_swf_upload', $config)) {
            $this->setEnableSwfUpload($config['enable_swf_upload']);
        }

        if (array_key_exists('add_as_attachment', $config)) {
            $this->setAddAsAttachment($config['add_as_attachment']);
        }

        if (array_key_exists('save_to_server', $config)) {
            $this->setSaveToServer($config['save_to_server']);
        }

        if (array_key_exists('save_path', $config)) {
            $this->setSavePath($config['save_path']);
        }

        if (array_key_exists('browse_text', $config)) {
            $this->setBrowseText($config['browse_text']);
        }

        if (array_key_exists('default_text', $config)) {
            $this->setDefaultText($config['default_text']);
        }

        if (array_key_exists('upload_num_fields', $config)) {
            $this->setUploadNumFields($config['upload_num_fields']);
        }

        if (array_key_exists('upload_user_add_more', $config)) {
            $this->setUploadUserAddMore($config['upload_user_add_more']);
        }

        if (array_key_exists('upload_add_another_text', $config)) {
            $this->setUploadAddAnotherText($config['upload_add_another_text']);
        }

        if (array_key_exists('upload_allowed_extensions', $config)) {
            $allowedExtensions = array();
            if (strlen($config['upload_allowed_extensions'])) {
                $allowedExtensions = explode(',', $config['upload_allowed_extensions']);
            }
            $this->_fileUploadValidator->setAllowedExtensions($allowedExtensions);
        }

        if (array_key_exists('upload_maximum_size', $config)) {
            $this->_fileUploadValidator->setMaximumFileSize($config['upload_maximum_size'] * 1048576);
        }

        if (array_key_exists('messages', $config) && is_array($config['messages'])) {
            $this->_fileUploadValidator->setMessageTemplates($config['messages']);
        }
    }

    /**
     * Get this elements file upload validator
     *
     * @return iPhorm_Validator_FileUpload
     */
    public function getFileUploadValidator()
    {
        return $this->_fileUploadValidator;
    }

    /**
     * Is the uploaded file valid?
     *
     * @param string $value The value to check
     * @param array $context The other submitted form values
     * @return boolean True if valid, false otherwise
     */
    public function isValid($value, $context = null)
    {
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

        return $valid;
    }

    /**
     * Set whether more than one file upload is allowed
     *
     * @param boolean $flag
     */
    public function setAllowMultipleUploads($flag)
    {
        $this->_allowMultipleUploads = (bool) $flag;
    }

    /**
     * Get whether more than one file upload is allowed
     *
     * @return boolean
     */
    public function getAllowMultipleUploads()
    {
        return $this->_allowMultipleUploads;
    }

    /**
     * Set whether to add this element as an attachment to
     * the notification email
     *
     * @param boolean $flag
     */
    public function setAddAsAttachment($flag)
    {
        $this->_addAsAttachment = (bool) $flag;
    }

    /**
     * Get whether to add this element as an attachment to
     * the notification email
     *
     * @return boolean
     */
    public function getAddAsAttachment()
    {
        return $this->_addAsAttachment;
    }

    /**
     * Set whether to save this element to the server
     *
     * @param boolean $flag
     */
    public function setSaveToServer($flag)
    {
        $this->_saveToServer = (bool) $flag;
    }

    /**
     * Get whether to save this element to the server
     *
     * @return boolean
     */
    public function getSaveToServer()
    {
        return $this->_saveToServer;
    }

    /**
     * Set the path to save uploaded files to
     *
     * @param string $savePath
     */
    public function setSavePath($savePath)
    {
        $this->_savePath = $savePath;
    }

    /**
     * Get the path to save uploaded files to
     *
     * @return string
     */
    public function getSavePath()
    {
        return $this->_savePath;
    }

    /**
     * Set the text for the browse button
     *
     * @param string $browseText
     */
    public function setBrowseText($browseText)
    {
        $this->_browseText = $browseText;
    }

    /**
     * Get the text for the browse button
     *
     * @return string
     */
    public function getBrowseText()
    {
        return (strlen($this->_browseText)) ? $this->_browseText : _x('Browse...', 'for a file to upload', 'iphorm');
    }

    /**
     * Set the default text
     *
     * @param string $defaultText
     */
    public function setDefaultText($defaultText)
    {
        $this->_defaultText = $defaultText;
    }

    /**
     * Get the default text
     *
     * @return string
     */
    public function getDefaultText()
    {
        return (strlen($this->_defaultText)) ? $this->_defaultText : __('No file selected', 'iphorm');
    }

    /**
     * Set the number of upload fields to show
     *
     * @param int $uploadNumFields
     */
    public function setUploadNumFields($uploadNumFields)
    {
        $this->_uploadNumFields = (int) $uploadNumFields;
    }

    /**
     * Get the number of upload fields to show
     *
     * @return int
     */
    public function getUploadNumFields()
    {
        return $this->_uploadNumFields;
    }

    /**
     * Sets whether to add a link for the user to
     * add more upload fields
     *
     * @param boolean $flag
     */
    public function setUploadUserAddMore($flag)
    {
        $this->_uploadUserAddMore = (bool) $flag;
    }

    /**
     * Whether to add a link for the user to
     * add more upload fields
     *
     * @return boolean
     */
    public function getUploadUserAddMore()
    {
        return $this->_uploadUserAddMore;
    }

    /**
     * Sets the text for the add another upload field link
     *
     * @param string $text
     */
    public function setUploadAddAnotherText($text)
    {
        $this->_uploadAddAnotherText = $text;
    }

    /**
     * Get the text for the add another upload field link
     *
     * @return string
     */
    public function getUploadAddAnotherText()
    {
        return $this->_uploadAddAnotherText;
    }

    /**
     * Set whether to use the Flash uploader
     *
     * @param boolean $flag
     */
    public function setEnableSwfUpload($flag)
    {
        $this->_enableSwfUpload = (bool) $flag;
    }

    /**
     * Get whether to use the flash uploader
     *
     * @return boolean
     */
    public function getEnableSwfUpload()
    {
        return $this->_enableSwfUpload;
    }

    /**
     * Get the value as a string
     *
     * @return string
     */
    public function getValueAsString()
    {
        return $this->getValuePlain();
    }

    /**
     * Sets whether the element is required
     *
     * @param boolean $flag
     */
    public function setRequired($flag)
    {
        $this->_fileUploadValidator->setRequired((bool) $flag);
    }

    /**
     * Gets whether the element is required
     *
     * @return boolean
     */
    public function getRequired()
    {
        return $this->_fileUploadValidator->getRequired();
    }

    /**
     * Get the human readable value for the plain text email
     *
     * @return string
     */
    public function getValuePlain()
    {
        $plain = '';
        $value = $this->getValue();

        if (is_array($value)) {
            foreach ($this->getValue() as $file) {
                $plain .= $file['text'];
                if (isset($file['url'])) {
                    $plain .= ' (' . $file['url'] . ')';
                }
                $plain .= IPHORM_EMAIL_NEWLINE;
            }
        }

        return $plain;
    }

    /**
     * Get the human readable value for the HTML email
     *
     * @return string
     */
    public function getValueHtml()
    {
        $value = '';

        foreach ($this->getValue() as $file) {
            if (isset($file['url'])) {
                $value .= '<a href="' . $file['url'] . '">' . $file['text'] . '</a>';
            } else {
                $value .= $file['text'];
            }
            $value .= '<br />';
        }

        return $value;
    }

    /**
     * Add a file upload to the value
     *
     * @param array
     */
    public function addFile($file)
    {
        $this->_value[] = $file;
    }
}