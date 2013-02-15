<?php

/**
 * iPhorm
 *
 * The class representing the form
 *
 * @package iPhorm
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm
{
    /**
     * The form ID
     * @var int
     */
    protected $_id;

    /**
     * Name of the form
     * @var string
     */
    protected $_name = 'New form';

    /**
     * Title of the form
     * @var string
     */
    protected $_title = '';

    /**
     * Form description
     * @var string
     */
    protected $_description = '';

    /**
     * Is the form active?
     * @var boolean
     */
    protected $_active = true;

    /**
     * Element label placement
     * @var string
     */
    protected $_labelPlacement = 'above';

    /**
     * Element label width, used if label placement is 'left'
     * @var string
     */
    protected $_labelWidth = '150px';

    /**
     * The text indicating the element is required
     * @var string
     */
    protected $_requiredText = '(required)';

    /**
     * What type of success action - message/redirect
     * @var string
     */
    protected $_successType = 'message';

    /**
     * Success message
     * @var string
     */
    protected $_successMessage = 'Your message has been sent, thanks.';

    /**
     * The position of the success message relative to the form - above/below
     * @var string
     */
    protected $_successMessagePosition = 'above';

    /**
     * The timeout of the success message
     * @var float
     */
    protected $_successMessageTimeout = 10;

    /**
     * The type of success redirect - page/post/url
     * @var string
     */
    protected $_successRedirectType = '';

    /**
     * The value of the success redirect, the page ID, post ID or url
     * @var mixed
     */
    protected $_successRedirectValue = '';

    /**
     * Submit button text
     * @var string
     */
    protected $_submitButtonText = '';

    /**
     * Use Ajax to submit?
     * @var boolean
     */
    protected $_useAjax = true;

    /**
     * Show an iPhorm referral link under the form?
     * @var boolean
     */
    protected $_showReferralLink = false;

    /**
     * The text of the referral link
     * @var string
     */
    protected $_referralText = 'Powered by iPhorm';

    /**
     * Referral ThemeForest username
     * @var string
     */
    protected $_referralUsername = '';

    /**
     * Theme class name
     * @var string
     */
    protected $_theme = '';

    /**
     * Use Uniform?
     * @var boolean
     */
    protected $_useUniformJs = true;

    /**
     * Uniform theme
     * @var string
     */
    protected $_uniformJsTheme = 'default';

    /**
     * jQuery UI theme
     * @var string
     */
    protected $_jQueryUITheme = 'smoothness';

    /**
     * jQuery UI localization
     * @var string
     */
    protected $_jQueryUIL10n = '';

    /**
     * Use tooltips?
     * @var boolean
     */
    protected $_useTooltips = true;

    /**
     * How to display tooltips to the user
     * @var string
     */
    protected $_tooltipType = 'field';

    /**
     * The event that will trigger the tooltip
     * @var string
     */
    protected $_tooltipEvent = 'hover';

    /**
     * The tooltip classes
     * @var string
     */
    protected $_tooltipClasses = '';

    /**
     * Tooltip tip position
     * @var string
     */
    protected $_tooltipMy = 'left center';

    /**
     * Tooltip position on input
     * @var string
     */
    protected $_tooltipAt = 'right center';

    /**
     * Element background colour
     * @var null|array
     */
    protected $_elementBackgroundColour = null;

    /**
     * Element border colour
     * @var null|array
     */
    protected $_elementBorderColour = null;

    /**
     * Element text colour
     * @var null|array
     */
    protected $_elementTextColour = null;

    /**
     * Label text colour
     * @var null|array
     */
    protected $_labelTextColour = null;

    /**
     * Send notification email?
     * @var boolean
     */
    protected $_sendNotification = true;

    /**
     * Customise the notification email content?
     * @var boolean
     */
    protected $_customiseEmailContent = false;
    /**
     * The format of the notification email
     * @var string
     */
    protected $_notificationFormat = 'plain';

    /**
     * The content of the notification email
     * @var string
     */
    protected $_notificationEmailContent = '';

    /**
     * The ID of the element containing the email address of the notification Reply-To header
     * @var int
     */
    protected $_notificationReplyToElement = null;

    /**
     * The type of From address, static or element
     * @var string
     */
    protected $_notificationFromType = 'static';

    /**
     * The name of the sender
     * @var string
     */
    protected $_fromName = '';

    /**
     * The email of the sender
     * @var string
     */
    protected $_fromEmail = 'noreply@example.com';

    /**
     * The ID of the element containing the From email address
     * @var int
     */
    protected $_notificationFromElement = null;

    /**
     * Send autoreply email?
     * @var boolean
     */
    protected $_sendAutoreply = false;

    /**
     * The ID of the element containing the email address of the autoreply recipient
     * @var int
     */
    protected $_autoreplyRecipientElement = null;

    /**
     * The subject of the autoreply email
     * @var string
     */
    protected $_autoreplySubject = '';

    /**
     * The format of the autoreply email
     * @var string
     */
    protected $_autoreplyFormat = 'plain';

    /**
     * The content of the autoreply email
     * @var string
     */
    protected $_autoreplyEmailContent = '';

    /**
     * The type of From address, static or element
     * @var string
     */
    protected $_autoreplyFromType = 'static';

    /**
     * The email address of the autoreply sender
     * @var string
     */
    protected $_autoreplyFromEmail = '';

    /**
     * The name of the autoreply sender
     * @var string
     */
    protected $_autoreplyFromName = '';

    /**
     * The ID of the element containing the sender email address
     * @var int
     */
    protected $_autoreplyFromElement = null;

    /**
     * The recipients of the notification email
     * @var array
     */
    protected $_recipients = array();

    /**
     * The conditional recipient rules
     * @var array
     */
    protected $_conditionalRecipients = array();

    /**
     * The subject of the notification email
     * @var string
     */
    protected $_subject = 'Message from your website';

    /**
     * The method used to send emails, 'mail' or 'smtp'
     * @var string
     */
    protected $_emailSendingMethod = 'mail';

    /**
     * SMTP hostname
     * @var string
     */
    protected $_smtpHost = '';

    /**
     * SMTP port
     * @var int
     */
    protected $_smtpPort = 25;

    /**
     * SMTP encryption method, 'ssl' or 'tls'
     * @var string
     */
    protected $_smtpEncryption = '';

    /**
     * SMTP username
     * @var string
     */
    protected $_smtpUsername = '';

    /**
     * SMTP password
     * @var string
     */
    protected $_smtpPassword = '';

    /**
     * Unique form ID
     * @var string
     */
    protected $_uniqId = '';

    /**
     * The CSS styles of each HTML element
     * @var array
     */
    protected $_styles = array();

    /**
     * Whether to save form data to the database
     * @var boolean
     */
    protected $_saveToDatabase = true;

    /**
     * Whether or not to use the WP database to save form data
     * @var boolean
     */
    protected $_useWpDb = true;

    /**
     * The database host
     * @var string
     */
    protected $_dbHost = 'localhost';

    /**
     * The database username
     * @var string
     */
    protected $_dbUsername = '';

    /**
     * The database password
     * @var string
     */
    protected $_dbPassword = '';

    /**
     * The database name
     * @var string
     */
    protected $_dbName = '';

    /**
     * The database table
     * @var string
     */
    protected $_dbTable = '';

    /**
     * The database field to value array
     * @var array
     */
    protected $_dbFields = array();

    /**
     * Has the form been successfully sumitted?
     * @var boolean
     */
    protected $_submitted = false;

    /**
     * Character encoding to use
     * @var string
     */
    protected $_charset = 'UTF-8';

    /**
     * The elements of the form
     * @var array
     */
    protected $_elements = array();

    /**
     * The reCAPTCHA element
     * @var iPhorm_Element_Recaptcha
     */
    protected $_recaptchaElement;

    /**
     * Does the form have a datepicker element?
     * @var boolean
     */
    protected $_hasDatepickerElement = false;

    /**
     * Does the form have any elements with conditional logic?
     * @var boolean
     */
    protected $_hasConditionalLogic = false;

    /**
     * List of elements with active conditional logic
     * @var array
     */
    protected $_conditionalLogicElementIds = array();

    /**
     * List of element IDs that are included in other element's conditional
     * rules
     * @var array
     */
    protected $_conditionalLogicDependentElementIds = array();

    /**
     * Whether to animate the conditional logic changes
     * @var boolean
     */
    protected $_conditionalLogicAnimation = true;

    /**
     * The dynamic values
     * @var array
     */
    protected $_dynamicValues = array();

    /**
     * Whether to center the Fancybox window after conditional logic
     * @var boolean
     */
    protected $_centerFancybox = 200;

    /**
     * The parameter to pass to $.fancybox.center
     * @var boolean|int
     */
    protected $_centerFancyboxSpeed = true;

    /**
     * Class constructor
     *
     * @param array $config
     */
    public function __construct($config = null)
    {
        if (is_array($config)) {
            $this->fromConfig($config);
        }
    }

    /**
     * Set the form ID
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * Get the form ID
     *
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set the name of the form
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * Get the name of the form
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set the form title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->_title = $title;
    }

    /**
     * Get the form title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * Set the form description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->_description = $description;
    }

    /**
     * Get the form description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * Set whether the form is active
     *
     * @param boolean $flag
     */
    public function setActive($flag)
    {
        $this->_active = (bool) $flag;
    }

    /**
     * Get whether the form is active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->_active;
    }

    /**
     * Set the element label placement
     *
     * 'left', 'above' or 'inside'
     *
     * @param string $labelPlacement
     */
    public function setLabelPlacement($labelPlacement)
    {
        $this->_labelPlacement = $labelPlacement;
    }

    /**
     * Get the element label placement
     *
     * @return string
     */
    public function getLabelPlacement()
    {
        return $this->_labelPlacement;
    }

    /**
     * Set the element label width
     *
     * @param string $labelWidth
     */
    public function setLabelWidth($labelWidth)
    {
        $this->_labelWidth = $labelWidth;
    }

    /**
     * Get the element label width
     *
     * @return string
     */
    public function getLabelWidth()
    {
        return $this->_labelWidth;
    }

    /**
     * Set the required text
     *
     * @param string $requiredText
     */
    public function setRequiredText($requiredText)
    {
        $this->_requiredText = $requiredText;
    }

    /**
     * Get the required text
     *
     * @return string
     */
    public function getRequiredText()
    {
        return $this->_requiredText;
    }

    /**
     * Set the success type
     *
     * @param string $type
     */
    public function setSuccessType($successType)
    {
        $this->_successType = $successType;
    }

    /**
     * Get the success type
     *
     * @return string
     */
    public function getSuccessType()
    {
        return $this->_successType;
    }

    /**
     * Set the success message
     *
     * @param string $successMessage
     */
    public function setSuccessMessage($successMessage)
    {
        $this->_successMessage = $successMessage;
    }

    /**
     * Get the success message
     *
     * @return string
     */
    public function getSuccessMessage()
    {
        $successMessage = apply_filters('iphorm_success_message', $this->replacePlaceholderValues($this->_successMessage), $this);
        return apply_filters('iphorm_success_message_' . $this->getId(), $successMessage, $this);
    }

    /**
     * Set the success message position relative to the form
     *
     * @param string $successMessagePosition
     */
    public function setSuccessMessagePosition($successMessagePosition)
    {
        $this->_successMessagePosition = $successMessagePosition;
    }

    /**
     * Set the success message position relative to the form
     *
     * @return float
     */
    public function getSuccessMessagePosition()
    {
        return $this->_successMessagePosition;
    }

    /**
     * Set the success message timeout
     *
     * @param float $seconds
     */
    public function setSuccessMessageTimeout($seconds)
    {
        $this->_successMessageTimeout = (float) $seconds;
    }

    /**
     * Get the success message timeout
     *
     * @return int
     */
    public function getSuccessMessageTimeout()
    {
        return $this->_successMessageTimeout;
    }

    /**
     * Set the success redirect type
     *
     * 'post', 'page' or 'url'
     *
     * @param string $type
     */
    public function setSuccessRedirectType($type)
    {
        $this->_successRedirectType = $type;
    }

    /**
     * Get the success redirect type
     *
     * @return string
     */
    public function getSuccessRedirectType()
    {
        return $this->_successRedirectType;
    }

    /**
     * Set the success redirect value
     *
     * Post ID, page ID or URL
     *
     * @param mixed $value
     */
    public function setSuccessRedirectValue($value)
    {
        $this->_successRedirectValue = $value;
    }

    /**
     * Get the success redirect value
     *
     * @return mixed
     */
    public function getSuccessRedirectValue()
    {
        return $this->_successRedirectValue;
    }

    /**
     * Get the success redirect URL
     *
     * @return string
     */
    public function getSuccessRedirectURL()
    {
        $url = '';

        switch ($this->_successRedirectType) {
            case 'page':
            case 'post':
                $url = get_permalink($this->_successRedirectValue);
                break;
            case 'url':
                $url = $this->_successRedirectValue;
                break;
        }

        return $url;
    }

    /**
     * Set the submit button text
     *
     * @param string $submitButtonText
     */
    public function setSubmitButtonText($submitButtonText)
    {
        $this->_submitButtonText = $submitButtonText;
    }

    /**
     * Get the submit button text
     *
     * @return string
     */
    public function getSubmitButtonText()
    {
        return (strlen($this->_submitButtonText)) ? $this->_submitButtonText : _x('Send', 'submit the form', 'iphorm');
    }

    /**
     * Set whether to use Ajax to submit
     *
     * @param boolean $flag
     */
    public function setUseAjax($flag)
    {
        $this->_useAjax = $flag;
    }

    /**
     * Get whether to use Ajax
     *
     * @return $flag
     */
    public function getUseAjax()
    {
        return $this->_useAjax;
    }

    /**
     * Set whether to show a referral link
     *
     * @param boolean $flag
     */
    public function setShowReferralLink($flag)
    {
        $this->_showReferralLink = (bool) $flag;
    }

    /**
     * Get whether to show a referral link
     *
     * @return boolean
     */
    public function getShowReferralLink()
    {
        return $this->_showReferralLink;
    }

    /**
     * Set the referral link text
     *
     * @param string $text
     */
    public function setReferralText($text)
    {
        $this->_referralText = $text;
    }

    /**
     * Get the referral link text
     *
     * @return string
     */
    public function getReferralText()
    {
        return $this->_referralText;
    }

    /**
     * Set the referral link ThemeForest username
     *
     * @param string $username
     */
    public function setReferralUsername($username)
    {
        $this->_referralUsername = $username;
    }

    /**
     * Get the referral link ThemeForest username
     *
     * @return string
     */
    public function getReferralUsername()
    {
        return $this->_referralUsername;
    }

    /**
     * Set the theme name
     *
     * @param string $theme
     */
    public function setTheme($theme)
    {
        $this->_theme = $theme;
    }

    /**
     * Get the theme name
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->_theme;
    }

    /**
     * Set whether to use Uniform
     *
     * @param boolean $flag
     */
    public function setUseUniformJs($flag)
    {
        $this->_useUniformJs = $flag;
    }

    /**
     * Get whether to use Uniform
     *
     * @return boolean
     */
    public function getUseUniformJs()
    {
        return $this->_useUniformJs;
    }

    /**
     * Set the Uniform theme
     *
     * @param string $uniformJsTheme
     */
    public function setUniformJsTheme($uniformJsTheme)
    {
        $this->_uniformJsTheme = $uniformJsTheme;
    }

    /**
     * Get the Uniform theme
     *
     * @return string
     */
    public function getUniformJsTheme()
    {
        return $this->_uniformJsTheme;
    }

    /**
     * Set the jQuery UI theme
     *
     * @param string $theme
     */
    public function setjQueryUITheme($theme)
    {
        $this->_jQueryUITheme = $theme;
    }

    /**
     * Get the jQuery UI theme
     *
     * @return string
     */
    public function getjQueryUITheme()
    {
        return $this->_jQueryUITheme;
    }

    /**
     * Set the jQuery localization
     *
     * @param string $l10n
     */
    public function setjQueryUIL10n($l10n)
    {
        $this->_jQueryUIL10n = $l10n;
    }

    /**
     * Get the jQuery localization
     *
     * @return string
     */
    public function getjQueryUIL10n()
    {
        return $this->_jQueryUIL10n;
    }

    /**
     * Set whether to use tooltips
     *
     * @param boolean $flag
     */
    public function setUseTooltips($flag)
    {
        $this->_useTooltips = $flag;
    }

    /**
     * Get whether to use tooltips
     *
     * @return boolean
     */
    public function getUseTooltips()
    {
        return $this->_useTooltips;
    }

    /**
     * Set how to display tooltips to the user
     *
     * @param string $tooltipType
     */
    public function setTooltipType($tooltipType)
    {
        $this->_tooltipType = $tooltipType;
    }

    /**
     * Get how to display tooltips to the user
     *
     * @return string
     */
    public function getTooltipType()
    {
        return $this->_tooltipType;
    }

    /**
     * Set the event that will trigger the tooltip
     *
     * @param string $tooltipEvent
     */
    public function setTooltipEvent($tooltipEvent)
    {
        $this->_tooltipEvent = $tooltipEvent;
    }

    /**
     * Get the event that will trigger the tooltip
     *
     * @return string
     */
    public function getTooltipEvent()
    {
        return $this->_tooltipEvent;
    }

    /**
     * Set the tooltip classes for the qTip configuration
     *
     * @param string $tooltipClasses
     */
    public function setTooltipClasses($tooltipClasses)
    {
        $this->_tooltipClasses = $tooltipClasses;
    }

    /**
     * Get the tooltip classes
     *
     * @return string
     */
    public function getTooltipClasses()
    {
        return $this->_tooltipClasses;
    }

    /**
     * Set the tooltip 'my' position, which is the tip position
     * on the tooltip
     *
     * @param string $tooltipMy
     */
    public function setTooltipMy($tooltipMy)
    {
        $this->_tooltipMy = $tooltipMy;
    }

    /**
     * Get the tooltip 'my' position
     *
     * @return string
     */
    public function getTooltipMy()
    {
        return $this->_tooltipMy;
    }

    /**
     * Set the tooltip 'at' position, which is the the tip
     * position on the input
     *
     * @param string $tooltipAt
     */
    public function setTooltipAt($tooltipAt)
    {
        $this->_tooltipAt = $tooltipAt;
    }

    /**
     * Get the tooltip 'at' position
     *
     * @return string
     */
    public function getTooltipAt()
    {
        return $this->_tooltipAt;
    }

    /**
     * Set the global element background colour
     *
     * @param string $colour The CSS hex colour
     */
    public function setElementBackgroundColour($colour)
    {
        if (strlen($colour) > 0) {
            $this->_elementBackgroundColour = iPhorm::parseCss('background-color: ' . $colour . ';');
        } else {
            $this->_elementBackgroundColour = null;
        }
    }

    /**
     * Get the global element background colour
     *
     * @return array|null An array of CSSRuleSet's
     */
    public function getElementBackgroundColour()
    {
        return $this->_elementBackgroundColour;
    }

    /**
     * Set the global element border colour
     *
     * @param string $colour The CSS hex colour
     */
    public function setElementBorderColour($colour)
    {
        if (strlen($colour) > 0) {
            $this->_elementBorderColour = iPhorm::parseCss('border: 1px solid ' . $colour . ';');
        } else {
            $this->_elementBorderColour = null;
        }
    }

    /**
     * Get the global element border colour
     *
     * @return array|null An array of CSSRuleSet's
     */
    public function getElementBorderColour()
    {
        return $this->_elementBorderColour;
    }

    /**
     * Set the global element text colour
     *
     * @param string $colour The CSS hex colour
     */
    public function setElementTextColour($colour)
    {
        if (strlen($colour) > 0) {
            $this->_elementTextColour = iPhorm::parseCss('color: ' . $colour . ';');
        } else {
            $this->_elementTextColour = null;
        }
    }

    /**
     * Get the global element text colour
     *
     * @return array|null An array of CSSRuleSet's
     */
    public function getElementTextColour()
    {
        return $this->_elementTextColour;
    }

    /**
     * Set the global label text colour
     *
     * @param string $colour The CSS hex colour
     */
    public function setLabelTextColour($colour)
    {
        if (strlen($colour) > 0) {
            $this->_labelTextColour = iPhorm::parseCss('color: ' . $colour . ';');
        } else {
            $this->_labelTextColour = null;
        }
    }

    /**
     * Get the global label text colour
     *
     * @return array|null An array of CSSRuleSet's
     */
    public function getLabelTextColour()
    {
        return $this->_labelTextColour;
    }

    /**
     * Set whether to send the notification email
     *
     * @param boolean $flag
     */
    public function setSendNotification($flag)
    {
        $this->_sendNotification = (bool) $flag;
    }

    /**
     * Get whether to send the notification email
     *
     * @return boolean
     */
    public function getSendNotification()
    {
        return $this->_sendNotification;
    }

    /**
     * Set whether to customise the email content
     *
     * @param boolean
     */
    public function setCustomiseEmailContent($flag)
    {
        $this->_customiseEmailContent = $flag;
    }

    /**
     * Get whether to customise the email content
     *
     * @return boolean
     */
    public function getCustomiseEmailContent()
    {
        return $this->_customiseEmailContent;
    }

    /**
     * Set the format of the notification email
     *
     * 'plain' or 'html'
     *
     * @param string $notificationFormat
     */
    public function setNotificationFormat($notificationFormat)
    {
        $this->_notificationFormat = $notificationFormat;
    }

    /**
     * Get the format of the notification email
     *
     * @return string
     */
    public function getNotificationFormat()
    {
        return $this->_notificationFormat;
    }

    /**
     * Set the content of the notification email
     *
     * @param string $content
     */
    public function setNotificationEmailContent($content)
    {
        $this->_notificationEmailContent = $content;
    }

    /**
     * Get the content of the notification email
     *
     * @return string
     */
    public function getNotificationEmailContent()
    {
        return $this->_notificationEmailContent;
    }

    /**
     * Set the notification Reply-To element
     *
     * @param int $elementId
     */
    public function setNotificationReplyToElement($elementId)
    {
        $this->_notificationReplyToElement = $elementId;
    }

    /**
     * Get the notification Reply-To element
     *
     * @return iPhorm_Element_Email
     */
    public function getNotificationReplyToElement()
    {
        return $this->getElementById($this->_notificationReplyToElement);
    }

    /**
     * Set the type of From address, static or element
     *
     * @param string $type
     */
    public function setNotificationFromType($type)
    {
        $this->_notificationFromType = $type;
    }

    /**
     * Get the type of From address, static or element
     *
     * @return string
     */
    public function getNotificationFromType()
    {
        return $this->_notificationFromType;
    }

    /**
     * Set the email "From" name
     *
     * @param string $name
     */
    public function setFromName($name)
    {
        $this->_fromName = $name;
    }

    /**
     * Get the email "From" name
     *
     * @return string
     */
    public function getFromName()
    {
        return $this->_fromName;
    }

    /**
     * Set the email "From" address
     *
     * @param string $email
     */
    public function setFromEmail($email)
    {
        $this->_fromEmail = $email;
    }

    /**
     * Get the email "From" address
     *
     * @return string
     */
    public function getFromEmail()
    {
        return $this->_fromEmail;
    }

    /**
     * Set the email "From" address element ID
     *
     * @param int $elementId
     */
    public function setNotificationFromElement($elementId)
    {
        $this->_notificationFromElement = $elementId;
    }

    /**
     * Get the email "From" address element ID
     *
     * @return iPhorm_Element_Email
     */
    public function getNotificationFromElement()
    {
        return $this->getElementById($this->_notificationFromElement);
    }

    /**
     * Get the notification "From" name/email
     *
     * @return array
     */
    public function getNotificationFromInfo()
    {
        $emailValidator = new iPhorm_Validator_Email();
        $info = array(
            'email' => '',
            'name' => ''
        );

        // First see if we should set it to a submitted email address
        if ($this->getNotificationFromType() == 'element') {
            $notificationFromElement = $this->getNotificationFromElement();
            if ($notificationFromElement instanceof iPhorm_Element_Email && strlen($notificationFromElement->getValue())) {
                $info['email'] = $notificationFromElement->getValue();
            }
        }

        // If it's empty try the static address
        if (!(strlen($info['email']) && $emailValidator->isValid($info['email']))) {
            $info['email'] = $this->getFromEmail();
            $info['name'] = $this->getFromName();
        }

        // As a last resort set to a fake address
        if (!(strlen($info['email']) && $emailValidator->isValid($info['email']))) {
            $info['email'] = 'noreply@example.com';
        }

        return $info;
    }

    /**
     * Set whether to send the autoreply
     *
     * @param boolean $flag
     */
    public function setSendAutoreply($flag)
    {
        $this->_sendAutoreply = (bool) $flag;
    }

    /**
     * Get whether to send the autoreply
     *
     * @return boolean
     */
    public function getSendAutoreply()
    {
        return $this->_sendAutoreply;
    }

    /**
     * Set the autoreply recipient element
     *
     * The value submitted to this element will be the recipient
     * of the autoreply email
     *
     * @param int $elementId The ID of the element
     */
    public function setAutoreplyRecipientElement($elementId)
    {
        $this->_autoreplyRecipientElement = $elementId;
    }

    /**
     * Get the autoreply recipient element
     *
     * @return iPhorm_Element_Email
     */
    public function getAutoreplyRecipientElement()
    {
        return $this->getElementById($this->_autoreplyRecipientElement);
    }

    /**
     * Set the subject of the autoreply email
     *
     * @param string $subject
     */
    public function setAutoreplySubject($subject)
    {
        $this->_autoreplySubject = $subject;
    }

    /**
     * Get the autoreply subject
     *
     * @return string
     */
    public function getAutoreplySubject()
    {
        return $this->_autoreplySubject;
    }

    /**
     * Set the format of the autoreply email
     *
     * 'html' or 'plain'
     *
     * @param string $format
     */
    public function setAutoreplyFormat($format)
    {
        $this->_autoreplyFormat = $format;
    }

    /**
     * Get the format of the autoreply email
     *
     * @return string
     */
    public function getAutoreplyFormat()
    {
        return $this->_autoreplyFormat;
    }

    /**
     * Get the content of the autoreply email
     *
     * @param string $content
     */
    public function setAutoreplyEmailContent($content)
    {
        $this->_autoreplyEmailContent = $content;
    }

    /**
     * Set the content of the autoreply email
     *
     * @return string
     */
    public function getAutoreplyEmailContent()
    {
        return $this->_autoreplyEmailContent;
    }

    /**
     * Set the autoreply From address type, static or element
     *
     * @param string $type
     */
    public function setAutoreplyFromType($type)
    {
        $this->_autoreplyFromType = $type;
    }

    /**
     * Get the autoreply From address type, static or element
     *
     * @return string
     */
    public function getAutoreplyFromType()
    {
        return $this->_autoreplyFromType;
    }

    /**
     * Set the autoreply From email address
     *
     * @param string $email
     */
    public function setAutoreplyFromEmail($email)
    {
        $this->_autoreplyFromEmail = $email;
    }

    /**
     * Get the autoreply From email address
     *
     * @return string
     */
    public function getAutoreplyFromEmail()
    {
        return $this->_autoreplyFromEmail;
    }

    /**
     * Set the autoreply From name
     *
     * @param string $name
     */
    public function setAutoreplyFromName($name)
    {
        $this->_autoreplyFromName = $name;
    }

    /**
     * Get the autoreply From name
     *
     * @return string
     */
    public function getAutoreplyFromName()
    {
        return $this->_autoreplyFromName;
    }

    /**
     * Set the ID of the element containing the From address
     *
     * @param int $elementId
     */
    public function setAutoreplyFromElement($elementId)
    {
        $this->_autoreplyFromElement = $elementId;
    }

    /**
     * Get the ID of the element containing the From address
     *
     * @return iPhorm_Element_Email
     */
    public function getAutoreplyFromElement()
    {
        return $this->getElementById($this->_autoreplyFromElement);
    }

    /**
     * Get the autoreply "From" name/email
     *
     * @return array
     */
    public function getAutoreplyFromInfo()
    {
        $emailValidator = new iPhorm_Validator_Email();
        $info = array(
            'email' => '',
            'name' => ''
        );

        // First see if we should set it to a submitted email address
        if ($this->getAutoreplyFromType() == 'element') {
            $autoreplyFromElement = $this->getAutoreplyFromElement();
            if ($autoreplyFromElement instanceof iPhorm_Element_Email && strlen($autoreplyFromElement->getValue())) {
                $info['email'] = $autoreplyFromElement->getValue();
            }
        }

        // If it's empty try the static address
        if (!(strlen($info['email']) && $emailValidator->isValid($info['email']))) {
            $info['email'] = $this->getAutoreplyFromEmail();
            $info['name'] = $this->getAutoreplyFromName();
        }

        // If it's still empty try the notification from address
        if (!(strlen($info['email']) && $emailValidator->isValid($info['email']))) {
            $info['email'] = $this->getFromEmail();
            $info['name'] = $this->getFromName();
        }

        // As a last resort set to a fake address
        if (!(strlen($info['email']) && $emailValidator->isValid($info['email']))) {
            $info['email'] = 'noreply@example.com';
        }

        return $info;
    }

    /**
     * Set the recipients of the notification email
     *
     * @param array $recipients
     */
    public function setRecipients($recipients)
    {
        $this->_recipients = $recipients;
    }

    /**
     * Get the recipients of the notification email
     *
     * @return array
     */
    public function getRecipients()
    {
        return $this->_recipients;
    }

    /**
     * Set the conditional recipients setup
     *
     * @param array $recipients
     */
    public function setConditionalRecipients($recipients)
    {
        $this->_conditionalRecipients = $recipients;
    }

    /**
     * Get the conditional recipients setup
     *
     * @return array
     */
    public function getConditionalRecipients()
    {
        return $this->_conditionalRecipients;
    }

    /**
     * Set the subject of the notification email
     *
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->_subject = $subject;
    }

    /**
     * Get the subject of the notification email
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->_subject;
    }

    /**
     * Set the email sending method, 'mail' or 'smtp'
     *
     * @param string $emailSendingMethod
     */
    public function setEmailSendingMethod($emailSendingMethod)
    {
        $this->_emailSendingMethod = $emailSendingMethod;
    }

    /**
     * Get the email sending method
     *
     * @return string
     */
    public function getEmailSendingMethod()
    {
        return $this->_emailSendingMethod;
    }

    /**
     * Set the SMTP host
     *
     * @param string $smtpHost
     */
    public function setSmtpHost($smtpHost)
    {
        $this->_smtpHost = $smtpHost;
    }

    /**
     * Get the SMTP host
     *
     * @return string
     */
    public function getSmtpHost()
    {
        return $this->_smtpHost;
    }

    /**
     * Set the SMTP port
     *
     * @param int $smtpPort
     */
    public function setSmtpPort($smtpPort)
    {
        $this->_smtpPort = $smtpPort;
    }

    /**
     * Get the SMTP port
     *
     * @return int
     */
    public function getSmtpPort()
    {
        return $this->_smtpPort;
    }

    /**
     * Set the SMTP encryption, 'tls' or 'ssl'
     *
     * @param string $smtpEncryption
     */
    public function setSmtpEncryption($smtpEncryption)
    {
        $this->_smtpEncryption = $smtpEncryption;
    }

    /**
     * Get the SMTP encryption
     *
     * @return string
     */
    public function getSmtpEncryption()
    {
        return $this->_smtpEncryption;
    }

    /**
     * Set the SMTP username
     *
     * @param string $smtpUsername
     */
    public function setSmtpUsername($smtpUsername)
    {
        $this->_smtpUsername = $smtpUsername;
    }

    /**
     * Get the SMTP username
     *
     * @return string
     */
    public function getSmtpUsername()
    {
        return $this->_smtpUsername;
    }

    /**
     * Set the SMTP password
     *
     * @param string $smtpPassword
     */
    public function setSmtpPassword($smtpPassword)
    {
        $this->_smtpPassword = $smtpPassword;
    }

    /**
     * Get the SMTP password
     *
     * @return string
     */
    public function getSmtpPassword()
    {
        return $this->_smtpPassword;
    }

    /**
     * Set the unique form ID
     *
     * The unique ID is unique to each form instance, even the same form
     * on the same page
     *
     * @param string $uniqId
     */
    public function setUniqId($uniqId)
    {
        $this->_uniqId = $uniqId;
    }

    /**
     * Get the unique form ID
     */
    public function getUniqId()
    {
        return $this->_uniqId;
    }

    /**
     * Set whether to save form data to the database
     *
     * @param boolean $flag
     */
    public function setSaveToDatabase($flag)
    {
        $this->_saveToDatabase = (bool) $flag;
    }

    /**
     * Get whether to save form data to the database
     *
     * @return boolean
     */
    public function getSaveToDatabase()
    {
        return $this->_saveToDatabase;
    }

    /**
     * Set whether to use the WordPress database for saving form data
     *
     * @param boolean $flag
     */
    public function setUseWpDb($flag)
    {
        $this->_useWpDb = (bool) $flag;
    }

    /**
     * Get whether to use the WordPress database for saving form data
     *
     * @return boolean
     */
    public function getUseWpDb()
    {
        return $this->_useWpDb;
    }

    /**
     * Set the database host
     *
     * @param string $dbHost
     */
    public function setDbHost($dbHost)
    {
        $this->_dbHost = $dbHost;
    }

    /**
     * Get the database host
     *
     * @return string
     */
    public function getDbHost()
    {
        return $this->_dbHost;
    }

    /**
     * Set the database username
     *
     * @param string $dbUsername
     */
    public function setDbUsername($dbUsername)
    {
        $this->_dbUsername = $dbUsername;
    }

    /**
     * Get the database username
     *
     * @return string
     */
    public function getDbUsername()
    {
        return $this->_dbUsername;
    }

    /**
     * Set the database password
     *
     * @param string $dbPassword
     */
    public function setDbPassword($dbPassword)
    {
        $this->_dbPassword = $dbPassword;
    }

    /**
     * Get the database password
     *
     * @return string
     */
    public function getDbPassword()
    {
        return $this->_dbPassword;
    }

    /**
     * Set the database name
     *
     * @param string $dbName
     */
    public function setDbName($dbName)
    {
        $this->_dbName = $dbName;
    }

    /**
     * Get the database name
     *
     * @return string
     */
    public function getDbName()
    {
        return $this->_dbName;
    }

    /**
     * Set the database table
     *
     * @param string $dbTable
     */
    public function setDbTable($dbTable)
    {
        $this->_dbTable = $dbTable;
    }

    /**
     * Get the database table
     *
     * @return string
     */
    public function getDbTable()
    {
        return $this->_dbTable;
    }

    /**
     * Set the database fields
     *
     * @param array $dbFields
     */
    public function setDbFields($dbFields)
    {
        $this->_dbFields = $dbFields;
    }

    /**
     * Get the database fields
     *
     * @return array
     */
    public function getDbFields()
    {
        return $this->_dbFields;
    }

    /**
     * Get the JavaScript configuration for the iPhorm plugin
     *
     * @return string
     */
    public function getJsConfig()
    {
        $config = array(
            'id' => $this->getId(),
            'uniqueId' => $this->getUniqId(),
            'PHPSESSID' => session_id(),
            'successMessageTimeout' => $this->getSuccessMessageTimeout(),
            'clElementIds' => $this->getConditionalLogicElementIds(),
            'clDependentElementIds' => $this->getConditionalLogicDependentElementIds(),
            'centerFancybox' => $this->getCenterFancybox(),
            'centerFancyboxSpeed' => $this->getCenterFancyboxSpeed()
        );

        if (strpos(iphorm_get_http_referer(), 'iphorm_preview=1')) {
            $config['preview'] = true;
        }

        if ($this->getSuccessType() == 'redirect' && strlen($this->getSuccessRedirectType())) {
            $config['successRedirectURL'] = $this->getSuccessRedirectURL();
        }

        return iphorm_json_encode($config);
    }

    /**
     * Get the character encoding
     *
     * @return string
     */
    public function getCharset()
    {
        return $this->_charset;
    }

    /**
     * Set the character encoding
     *
     * @param string $charset
     */
    public function setCharset($charset)
    {
        $this->_charset = $charset;
    }

    /**
     * Add a single element to the form
     *
     * @param $element iPhorm_Element The element to add
     */
    public function addElement(iPhorm_Element $element)
    {
        $this->_elements[$element->getName()] = $element;

        if ($element instanceof iPhorm_Element_Recaptcha) {
            $this->_recaptchaElement = $element;
        } else if ($element instanceof iPhorm_Element_Date) {
            if ($element->getShowDatepicker()) {
                $this->_hasDatepickerElement = true;
            }
        }

        if ($element->getLogic() && count($element->getLogicRules())) {
            $this->_hasConditionalLogic = true;
            $this->_conditionalLogicElementIds[] = $element->getId();

            foreach ($element->getLogicRules() as $rule) {
                $this->_conditionalLogicDependentElementIds[] = (int) $rule['element_id'];
            }
        }
    }

    /**
     * Add multiple elements to the form
     *
     * @param $elements array The array of elements
     */
    public function addElements(array $elements)
    {
        foreach ($elements as $element) {
            $this->addElement($element);
        }
    }

    /**
     * Is the form valid?
     *
     * @param array $values The values to check against
     * @return boolean True if valid, false otherwise
     */
    public function isValid(array $values = array())
    {
        $valid = true;

        foreach ($this->getElements() as $element) {
            if ($element->getIsArray()) {
                $value = $this->_dissolveArrayValue($values, $element->getName());
            } else {
                $value = isset($values[$element->getName()]) ? $values[$element->getName()] : null;
            }

            if (!$element->isValid($value, $values)) {
                $valid = false;
            }
        }

        return $valid;
    }

    /**
     * Get all of the form elements
     *
     * @return array The form elements
     */
    public function getElements()
    {
        return $this->_elements;
    }

    /**
     * Get the element with the given name
     *
     * Returns the element or null if it doesn't exist
     *
     * @param string $name
     * @return null|iPhorm_Element
     */
    public function getElement($name)
    {
        $elements = $this->getElements();
        foreach ($elements as $element) {
            if ($element->getName() == $name) {
                return $element;
            }
        }
        return null;
    }

    /**
     * Get the elements and any errors they have
     *
     * @return array
     */
    public function getErrors()
    {
        $errors = array();

        foreach ($this->getElements() as $element) {
            $errors[$element->getName()] = array('label' => $element->getLabel(), 'errors' => $element->getErrors());
        }

        return $errors;
    }

    /**
     * Encode PHP data in JSON
     *
     * @param mixed $data The data to encode
     * @return string The JSON encoded response
     */
    public function jsonEncode($data)
    {
        require_once IPHORM_INCLUDES_DIR . '/JSON.php';
        $json = new Services_JSON();
        return $json->encode($data);
    }

    /**
     * Get the values of all fields
     *
     * @return array The values of all fields
     */
    public function getValues()
    {
        $values = array();

        foreach ($this->getElements() as $element) {
            $values[$element->getName()] = $element->getValue();
        }

        return $values;
    }

    /**
     * Get the values of a single field
     *
     * @param string $name The name of the field
     * @return mixed The value of the given field or null
     */
    public function getValue($name)
    {
        $element = $this->getElement($name);

        return $element instanceof iPhorm_Element ? $element->getValue() : null;
    }

    /**
     * Get the value of the element with the given name
     * as a string
     *
     * @param string $name
     * @return string
     */
    public function getValueAsString($name)
    {
        $element = $this->getElement($name);

        return $element instanceof iPhorm_Element ? $element->getValueAsString() : '';
    }

    /**
     * Get the value human readable value of the element
     * with the given name, formatted for the HTML email
     *
     * @param string $name The unique element name
     * @return string The formatted HTML
     */
    public function getValueHtml($name)
    {
        $element = $this->getElement($name);

        return $element instanceof iPhorm_Element ? $element->getValueHtml() : '';
    }

    /**
     * Get the value human readable value of the element
     * with the given name, formatted for the plain text email
     *
     * @param string $name The unique element name
     * @return string The formatted plain text
     */
    public function getValuePlain($name)
    {
        $element = $this->getElement($name);

        return $element instanceof iPhorm_Element ? $element->getValuePlain() : '';
    }

    /**
     * Internal autoloader for spl_autoload_register().
     *
     * @param string $class
     */
    public static function autoload($class)
    {
        // Don't interfere with other autoloaders
        if (strpos($class, 'iPhorm') !== 0) {
            return false;
        }

        $path = dirname(__FILE__). '/' . str_replace('_', '/', $class).'.php';

        if (!file_exists($path)) {
            return false;
        }

        require_once $path;
    }

    /**
     * Configure autoloading of iPhorm classes
     */
    public static function registerAutoload()
    {
        spl_autoload_register(array('iPhorm', 'autoload'));

        if (function_exists('__autoload')) {
            // Add any previously defined autoload function to the queue
            spl_autoload_register('__autoload');
        }
    }

    /**
     * Configure the form from the given configuration
     *
     * @param array $config
     */
    public function fromConfig(array $config)
    {
        if (array_key_exists('id', $config)) {
            $this->setId($config['id']);
        }

        if (array_key_exists('uniq_id', $config)) {
            $this->setUniqId($config['uniq_id']);
        } else {
            $this->setUniqId(md5($_SERVER['REMOTE_ADDR']) . $this->getId() . uniqid());
        }

        if (array_key_exists('name', $config)) {
            $this->setName($config['name']);
        }

        if (array_key_exists('title', $config)) {
            $this->setTitle($config['title']);
        }

        if (array_key_exists('description', $config)) {
            $this->setDescription($config['description']);
        }

        if (array_key_exists('send_notification', $config)) {
            $this->setSendNotification($config['send_notification']);
        }

        if (array_key_exists('customise_email_content', $config)) {
        	$this->setCustomiseEmailContent($config['customise_email_content']);
        }

        if (array_key_exists('subject', $config)) {
            $this->setSubject($config['subject']);
        }

        if (array_key_exists('notification_format', $config)) {
            $this->setNotificationFormat($config['notification_format']);
        }

        if (array_key_exists('notification_email_content', $config)) {
            $this->setNotificationEmailContent($config['notification_email_content']);
        }

        if (array_key_exists('notification_reply_to_element', $config)) {
            $this->setNotificationReplyToElement($config['notification_reply_to_element']);
        }

        if (array_key_exists('notification_from_type', $config)) {
            $this->setNotificationFromType($config['notification_from_type']);
        }

        if (array_key_exists('notification_from_element', $config)) {
            $this->setNotificationFromElement($config['notification_from_element']);
        }

        if (array_key_exists('send_autoreply', $config)) {
            $this->setSendAutoreply($config['send_autoreply']);
        }

        if (array_key_exists('autoreply_recipient_element', $config)) {
            $this->setAutoreplyRecipientElement($config['autoreply_recipient_element']);
        }

        if (array_key_exists('autoreply_subject', $config)) {
            $this->setAutoreplySubject($config['autoreply_subject']);
        }

        if (array_key_exists('autoreply_format', $config)) {
            $this->setAutoreplyFormat($config['autoreply_format']);
        }

        if (array_key_exists('autoreply_email_content', $config)) {
            $this->setAutoreplyEmailContent($config['autoreply_email_content']);
        }

        if (array_key_exists('autoreply_from_type', $config)) {
            $this->setAutoreplyFromType($config['autoreply_from_type']);
        }

        if (array_key_exists('autoreply_from_email', $config)) {
            $this->setAutoreplyFromEmail($config['autoreply_from_email']);
        }

        if (array_key_exists('autoreply_from_name', $config)) {
            $this->setAutoreplyFromName($config['autoreply_from_name']);
        }

        if (array_key_exists('autoreply_from_element', $config)) {
            $this->setAutoreplyFromElement($config['autoreply_from_element']);
        }

        if (array_key_exists('recipients', $config)) {
            $this->setRecipients($config['recipients']);
        }

        if (array_key_exists('conditional_recipients', $config)) {
            $this->setConditionalRecipients($config['conditional_recipients']);
        }

        if (array_key_exists('from_email', $config)) {
            $this->setFromEmail($config['from_email']);
        }

        if (array_key_exists('from_name', $config)) {
            $this->setFromName($config['from_name']);
        }

        if (array_key_exists('email_sending_method', $config)) {
            $this->setEmailSendingMethod($config['email_sending_method']);
        }

        if (array_key_exists('smtp_host', $config)) {
            $this->setSmtpHost($config['smtp_host']);
        }

        if (array_key_exists('smtp_port', $config)) {
            $this->setSmtpPort($config['smtp_port']);
        }

        if (array_key_exists('smtp_encryption', $config)) {
            $this->setSmtpEncryption($config['smtp_encryption']);
        }

        if (array_key_exists('smtp_username', $config)) {
            $this->setSmtpUsername($config['smtp_username']);
        }

        if (array_key_exists('smtp_password', $config)) {
            $this->setSmtpPassword($config['smtp_password']);
        }

        if (array_key_exists('active', $config)) {
            $this->setActive($config['active']);
        }

        if (array_key_exists('label_placement', $config)) {
            $this->setLabelPlacement($config['label_placement']);
        }

        if (array_key_exists('label_width', $config)) {
            $this->setLabelWidth($config['label_width']);
        }

        if (array_key_exists('required_text', $config)) {
            $this->setRequiredText($config['required_text']);
        }

        if (array_key_exists('success_type', $config)) {
            $this->setSuccessType($config['success_type']);
        }

        if (array_key_exists('success_message', $config)) {
            $this->setSuccessMessage($config['success_message']);
        }

        if (array_key_exists('success_message_position', $config)) {
            $this->setSuccessMessagePosition($config['success_message_position']);
        }

        if (array_key_exists('success_message_timeout', $config)) {
            $this->setSuccessMessageTimeout($config['success_message_timeout']);
        }

        if (array_key_exists('success_redirect_type', $config)) {
            $this->setSuccessRedirectType($config['success_redirect_type']);
        }

        if (array_key_exists('success_redirect_value', $config)) {
            $this->setSuccessRedirectValue($config['success_redirect_value']);
        }

        if (array_key_exists('submit_button_text', $config)) {
            $this->setSubmitButtonText($config['submit_button_text']);
        }

        if (array_key_exists('use_ajax', $config)) {
            $this->setUseAjax($config['use_ajax']);
        }

        if (array_key_exists('conditional_logic_animation', $config)) {
            $this->setConditionalLogicAnimation($config['conditional_logic_animation']);
        }

        if (array_key_exists('show_referral_link', $config)) {
            $this->setShowReferralLink($config['show_referral_link']);
        }

        if (array_key_exists('referral_text', $config)) {
            $this->setReferralText($config['referral_text']);
        }

        if (array_key_exists('referral_username', $config)) {
            $this->setReferralUsername($config['referral_username']);
        }

        if (array_key_exists('theme', $config)) {
            $this->setTheme($config['theme']);
        }

        if (array_key_exists('use_uniformjs', $config)) {
            $this->setUseUniformJs($config['use_uniformjs']);
        }

        if (array_key_exists('uniformjs_theme', $config)) {
            $this->setUniformJsTheme($config['uniformjs_theme']);
        }

        if (array_key_exists('jqueryui_theme', $config)) {
            $this->setjQueryUITheme($config['jqueryui_theme']);
        }

        if (array_key_exists('jqueryui_l10n', $config)) {
            $this->setjQueryUIL10n($config['jqueryui_l10n']);
        }

        if (array_key_exists('use_tooltips', $config)) {
            $this->setUseTooltips($config['use_tooltips']);
        }

        if (array_key_exists('tooltip_type', $config)) {
            $this->setTooltipType($config['tooltip_type']);
        }

        if (array_key_exists('tooltip_event', $config)) {
            $this->setTooltipEvent($config['tooltip_event']);
        }

        if (array_key_exists('tooltip_style', $config)) {
            $tooltipClasses = array();

            if ($config['tooltip_style'] == 'custom') {
                if (array_key_exists('tooltip_custom', $config) && strlen($config['tooltip_custom']) > 0) {
                    $tooltipClasses[] = $config['tooltip_custom'];
                }
            } else if (strlen($config['tooltip_style']) > 0) {
                $tooltipClasses[] = $config['tooltip_style'];
            }

            if (array_key_exists('tooltip_shadow', $config) && $config['tooltip_shadow']) {
                $tooltipClasses[] = 'ui-tooltip-shadow';
            }

            if (array_key_exists('tooltip_rounded', $config) && $config['tooltip_rounded']) {
                $tooltipClasses[] = 'ui-tooltip-rounded';
            }

            $this->setTooltipClasses(join(' ', $tooltipClasses));
        }

        if (array_key_exists('tooltip_my', $config)) {
            $this->setTooltipMy($config['tooltip_my']);
        }

        if (array_key_exists('tooltip_at', $config)) {
            $this->setTooltipAt($config['tooltip_at']);
        }

        if (array_key_exists('element_background_colour', $config)) {
            $this->setElementBackgroundColour($config['element_background_colour']);
        }

        if (array_key_exists('element_border_colour', $config)) {
            $this->setElementBorderColour($config['element_border_colour']);
        }

        if (array_key_exists('element_text_colour', $config)) {
            $this->setElementTextColour($config['element_text_colour']);
        }

        if (array_key_exists('label_text_colour', $config)) {
            $this->setLabelTextColour($config['label_text_colour']);
        }

        if (array_key_exists('styles', $config)) {
            $this->setStyles($config['styles']);
        }

        if (array_key_exists('save_to_database', $config)) {
            $this->setSaveToDatabase($config['save_to_database']);
        }

        if (array_key_exists('use_wp_db', $config)) {
            $this->setUseWpDb($config['use_wp_db']);
        }

        if (array_key_exists('db_host', $config)) {
            $this->setDbHost($config['db_host']);
        }

        if (array_key_exists('db_username', $config)) {
            $this->setDbUsername($config['db_username']);
        }

        if (array_key_exists('db_password', $config)) {
            $this->setDbPassword($config['db_password']);
        }

        if (array_key_exists('db_name', $config)) {
            $this->setDbName($config['db_name']);
        }

        if (array_key_exists('db_table', $config)) {
            $this->setDbTable($config['db_table']);
        }

        if (array_key_exists('db_fields', $config)) {
            $this->setDbFields($config['db_fields']);
        }

        if (array_key_exists('dynamic_values', $config)) {
            $this->setDynamicValues($config['dynamic_values']);
        }

        if (array_key_exists('center_fancybox', $config)) {
            $this->setCenterFancybox($config['center_fancybox']);
        }

        if (array_key_exists('elements', $config) && is_array($config['elements'])) {
            foreach ($config['elements'] as $eConfig) {
                if (isset($eConfig['type'])) {
                    $eClass = 'iPhorm_Element_' . ucfirst($eConfig['type']);
                    if (class_exists($eClass)) {
                        $eConfig['name'] = 'iphorm_' . $this->getId() . '_' . $eConfig['id'];
                        $eConfig['unique_id'] = 'iphorm_' . $this->getUniqId() . '_' . $eConfig['id'];
                        $eConfig['form'] = $this;
                        $this->addElement(new $eClass($eConfig));
                    }
                }
            }
        }

        if (array_key_exists('use_honeypot', $config) && $config['use_honeypot']) {
            $honeypot = new iPhorm_Element_Honeypot(array(
                'name' => 'iphorm_' . $this->getId() . '_0',
                'unique_id' => 'iphorm_' . $this->getUniqId() . '_0',
                'form' => $this
            ));
            $this->addElement($honeypot);
        }
    }

    /**
     * Get the element with the given ID. Returns the
     * element or null if no element was found.
     *
     * @param int $id
     * @return null|iPhorm_Element
     */
    public function getElementById($id)
    {
        foreach ($this->_elements as $element) {
            if ($element->getId() == $id) {
                return $element;
            }
        }

        return null;
    }

    /**
     * Get the reCAPTCHA element if the form has one
     *
     * @return null|iPhorm_Element_Recaptcha
     */
    public function getRecaptchaElement()
    {
        return $this->_recaptchaElement;
    }

    /**
     * Does the form have a Date element with datepicker enabled?
     *
     * @return boolean
     */
    public function hasDatepickerElement()
    {
        return $this->_hasDatepickerElement;
    }

    /**
     * Does the form have elements with conditional logic?
     *
     * @return boolean
     */
    public function hasConditionalLogic()
    {
        return $this->_hasConditionalLogic;
    }

    /**
     * Get the JSON formatted conditional logic of the elements
     *
     * @return string
     */
    public function getConditionalLogicJson()
    {
        $logic = array();
        $dependents = array();
        foreach ($this->_elements as $element) {
            if ($element->getLogic() && count($elementLogicRules = $element->getLogicRules())) {
                $logic[$element->getId()] = array(
                    'action' => $element->getLogicAction(),
                    'match' => $element->getLogicMatch(),
                    'rules' => $elementLogicRules
                );

                foreach ($elementLogicRules as $elementLogicRule) {
                    if (!isset($dependents[$elementLogicRule['element_id']])) {
                        $dependents[$elementLogicRule['element_id']] = array($element->getId());
                    } else {
                        $dependents[$elementLogicRule['element_id']][] = $element->getId();
                    }
                }
            }
        }

        return iphorm_json_encode(array('logic' => $logic, 'dependents' => $dependents, 'animate' => $this->getConditionalLogicAnimation()));
    }

    /**
     * Get the list of elements with active conditional logic
     *
     * @return string JSON encoded
     */
    public function getConditionalLogicElementIds()
    {
        return $this->_conditionalLogicElementIds;
    }

    /**
     * Get the list of element IDs that are dependents of other
     * element's conditional logic
     *
     * @return string JSON encoded
     */
    public function getConditionalLogicDependentElementIds()
    {
        return array_values(array_unique($this->_conditionalLogicDependentElementIds));
    }

    /**
     * Set whether to animate the conditional logic changes
     *
     * @param boolean $flag
     */
    public function setConditionalLogicAnimation($flag)
    {
        $this->_conditionalLogicAnimation = (bool) $flag;
    }

    /**
     * Get whether to animate the conditional logic changes
     *
     * @return boolean
     */
    public function getConditionalLogicAnimation()
    {
        return $this->_conditionalLogicAnimation;
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

    /**
     * Extract the value by walking the array using given array path.
     *
     * Given an array path such as foo[bar][baz], returns the value of the last
     * element (in this case, 'baz').
     *
     * @param  array $value Array to walk
     * @param  string $arrayPath Array notation path of the part to extract
     * @return string
     */
    protected function _dissolveArrayValue($value, $arrayPath)
    {
        // As long as we have more levels
        while ($arrayPos = strpos($arrayPath, '[')) {
            // Get the next key in the path
            $arrayKey = trim(substr($arrayPath, 0, $arrayPos), ']');

            // Set the potentially final value or the next search point in the array
            if (isset($value[$arrayKey])) {
                $value = $value[$arrayKey];
            }

            // Set the next search point in the path
            $arrayPath = trim(substr($arrayPath, $arrayPos + 1), ']');
        }

        if (isset($value[$arrayPath])) {
            $value = $value[$arrayPath];
        }

        return $value;
    }

    /**
     * Format a message with wrapping HTML <div> with classes. The
     * message should be escaped beforehand for display in the
     * browser, using htmlentities() for example
     *
     * @param string $message
     * @param string $type Additional class to add to the wrapper
     * @return string The HTML
     */
    protected function _formatMessage($message, $type = '')
    {
        $classes = array('message');
        if ($type !== '') {
            $classes[] = $type . '-message';
        }

        $xhtml = '<div class="' . join(' ', $classes) . '">' . $message . '</div>';

        return $xhtml;
    }

    /**
     * Replace all placeholder values in a string with their values
     *
     * Static version (element value placeholders will not be replaced)
     *
     * @param string $string
     * @return string
     */
    public static function replacePlaceholderValues2($string)
    {
        return preg_replace_callback('/{.+}/U', array('iPhorm', 'getPlaceholderValue2'), $string);
    }

    /**
     * Replace all placeholder values in a string with their values
     *
     * Non-static version (element value placeholders will also be replaced)
     *
     * @param string $string
     * @return string
     */
    public function replacePlaceholderValues($string)
    {
        return preg_replace_callback('/{.+}/U', array($this, '_getPlaceholderValue'), $string);
    }

    /**
     * Get the form value of a single placeholder
     *
     * Static version (element value placeholders will not be replaced)
     *
     * @param string $matches
     * @return string The the form value
     */
    public static function getPlaceholderValue2($matches)
    {
        $original = $matches[0];

        // Process any exact matches
        switch ($original) {
            case '{ip}':
                return iphorm_get_user_ip();
            case '{post_id}':
                return iphorm_get_current_post_id();
            case '{post_title}':
                return iphorm_get_current_post_title();
            case '{url}':
                return iphorm_get_current_url();
            case '{user_display_name}':
                $currentUser = wp_get_current_user();
                if ($currentUser->ID == 0) {
                    return '';
                } else {
                    return $currentUser->display_name;
                }
            case '{user_email}':
                $currentUser = wp_get_current_user();
                if ($currentUser->ID == 0) {
                    return '';
                } else {
                    return $currentUser->user_email;
                }
            case '{user_login}':
                $currentUser = wp_get_current_user();
                if ($currentUser->ID == 0) {
                    return '';
                } else {
                    return $currentUser->user_login;
                }
            case '{referring_url}':
                return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
            case '{current_date}':
            case '{submit_date}':
                return date_i18n('l, jS F Y');
            case '{current_time}':
            case '{submit_time}':
                return date_i18n('g:i a');
        }

        // Process variable tags
        if (stripos($original, '|') !== false) {
            $stripped = preg_replace('/(^{|}$)/', '', $original);
            $parts = explode('|', $stripped);

            switch ($parts[0]) {
                case 'current_date':
                case 'submit_date':
                case 'current_time':
                case 'submit_time':
                    return date_i18n($parts[1]);
            }
        }

        return $original;
    }

    /**
     * Set the CSS styles
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

        return array();
    }

    /**
     * Get the CSS style attribute for the specified HTML element
     *
     * @param string $which
     * @return string
     */
    public function getCss($which)
    {
        $output = '';
        $rules = array();

        if (($style = $this->getStyle($which)) !== null) {
            $rules = array_merge($rules, $style);
        }

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
     * Get the form value of a single placeholder
     *
     * Non-static version (element value placeholders will also be replaced)
     *
     * @param string $matches
     * @return string The the form value
     */
    protected function _getPlaceholderValue($matches)
    {
        $original = $matches[0];

        if (($replaced = self::getPlaceholderValue2($matches)) == $original) {
            if (stripos($original, '|') !== false) {
                $stripped = preg_replace('/(^{|}$)/', '', $original);
                $parts = explode('|', $stripped);

                // Try to match the right hand side to an exising element ID and return it's value
                $element = $this->getElementById(absint($parts[1]));

                if ($element instanceof iPhorm_Element) {
                    return $element->getValueAsString();
                }
            }
        } else {
            return $replaced;
        }

        return $original;
    }

    /**
     * Parses CSS and returns the array of CSSRuleSet's or
     * null if there is no valid CSS.
     *
     * @param string $css
     * @return array|null
     */
    public static function parseCss($css)
    {
        $parsed = null;

        if (strlen($css) > 0) {
            try {
                $parser = new CSSParser('iphorm { ' . $css . ' }');
                $doc = $parser->parse();
                $parsed = array();
                foreach ($doc->getAllRuleSets() as $ruleSet) {
                    $parsed = array_merge($parsed, $ruleSet->getRules());
                }
            } catch (Exception $e) {
                $parsed = null;
            }
        }

        return $parsed;
    }

    /**
     * Does the form have a file upload element?
     *
     * @return boolean
     */
    public function hasFileUploadElement()
    {
        foreach ($this->_elements as $element) {
            if ($element instanceof iPhorm_Element_File) {
                return true;
            }
        }

        return false;
    }

    /**
     * Does the form have at least one file element with SWFUpload
     * enabled?
     *
     * @return boolean
     */
    public function swfUploadEnabled()
    {
        foreach ($this->_elements as $element) {
            if ($element instanceof iPhorm_Element_File && $element->getEnableSwfUpload()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Sets whether the form been successfully sumitted
     *
     * @param boolean $flag
     */
    public function setSubmitted($flag)
    {
        $this->_submitted = (bool) $flag;
    }

    /**
     * Has the form been successfully sumitted?
     *
     * @return boolean
     */
    public function getSubmitted()
    {
        return $this->_submitted;
    }

    /**
     * Reset all form values to their default
     */
    public function reset()
    {
        foreach ($this->_elements as $element) {
            $element->reset();
        }
    }

    /**
     * Sets the dynamic values
     *
     * @param string|array $dynamicValues
     */
    public function setDynamicValues($dynamicValues)
    {
        if (is_string($dynamicValues)) {
            parse_str($dynamicValues, $dynamicValues);
        }

        $this->_dynamicValues = $dynamicValues;
    }

    /**
     * Get the dynamic values
     *
     * @return array
     */
    public function getDynamicValues()
    {
        return $this->_dynamicValues;
    }

    /**
     * Set whether to center the Fancybox window after conditional logic
     *
     * @param boolean $flag
     */
    public function setCenterFancybox($flag)
    {
        $this->_centerFancybox = (bool) $flag;
    }

    /**
     * Get whether to center the Fancybox window after conditional logic
     *
     * @return boolean
     */
    public function getCenterFancybox()
    {
        return $this->_centerFancybox;
    }

    /**
     * Set the parameter to pass to $.fancybox.center()
     *
     * It can be true to force alignment of the window if the content is too
     * big, or a speed in milliseconds at which to perform the center animation.
     *
     * @param boolean|int $flag
     */
    public function setCenterFancyboxSpeed($speed)
    {
        $this->_centerFancyboxSpeed = $speed;
    }

    /**
     * Get the parameter to pass to $.fancybox.center()
     *
     * @return boolean|int
     */
    public function getCenterFancyboxSpeed()
    {
        return $this->_centerFancyboxSpeed;
    }
}