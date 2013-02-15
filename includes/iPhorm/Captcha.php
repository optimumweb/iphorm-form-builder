<?php

/**
 * iPhorm_Captcha
 *
 * Generates and displays a CAPTCHA image
 *
 * @package iPhorm
 * @subpackage Captcha
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
class iPhorm_Captcha
{
    /**
     * The CAPTCHA code
     * @var string
     */
    protected $_code = '';

    /**
     * The unique ID of the form/CAPTCHA instance
     * @var string
     */
    protected $_uniqId = '';

    /**
     * The temporary directory to store cached fonts
     * @var string
     */
    protected $_tmpDir = '';

    /**
     * The length of the code in characters
     * @var int
     */
    protected $_length = 5;

    /**
     * The width in pixels
     * @var int
     */
    protected $_width = 115;

    /**
     * The height in pixels
     * @var int
     */
    protected $_height = 40;

    /**
     * The character pool from which to generate
     * @var string
     */
    protected $_characters = '23456789bcdfghjkmnpqrstvwxyz';

    /**
     * The background colour
     * @var string
     */
    protected $_bgColour = '#FFFFFF';

    /**
     * The text colour
     * @var string
     */
    protected $_textColour = '#222222';

    /**
     * The path to the font
     * @var string
     */
    protected $_font = 'Typist.ttf';

    /**
     * The minimum font size
     * @var int
     */
    protected $_minFontSize = 12;

    /**
     * The maximum font size
     * @var int
     */
    protected $_maxFontSize = 19;

    /**
     * The minimum angle off-centre of a character
     * @var int
     */
    protected $_minAngle = 0;

    /**
     * The maximum angle off-centre of a character
     * @var int
     */
    protected $_maxAngle = 20;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct($options = null)
    {
        if (is_array($options)) {
            if (array_key_exists('uniqId', $options)) {
                $this->_uniqId = $options['uniqId'];
            }

            if (array_key_exists('tmpDir', $options)) {
                $this->_tmpDir = $options['tmpDir'];
            }

            if (array_key_exists('length', $options)) {
                $this->_length = $options['length'];
            }

            if (array_key_exists('width', $options)) {
                $this->_width = $options['width'];
            }

            if (array_key_exists('height', $options)) {
                $this->_height = $options['height'];
            }

            if (array_key_exists('bgColour', $options)) {
                $this->_bgColour = $options['bgColour'];
            }

            if (array_key_exists('textColour', $options)) {
                $this->_textColour = $options['textColour'];
            }

            if (array_key_exists('font', $options)) {
                if (file_exists($options['font'])) {
                    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                        // For Windows, we need to copy the font to a temporary folder or it gets
                        // locked and prevents plugin upgrades
                        $filename = basename($options['font']);
                        $tmpDir = rtrim($this->_tmpDir, '/');
                        $iphormFontsTmpDir = $tmpDir . '/iphorm/fonts';
                        $cachedFontPath = $iphormFontsTmpDir . '/' . $filename;

                        if (file_exists($cachedFontPath)) {
                            $this->_font = $cachedFontPath;
                        } else {
                            if (!is_dir($iphormFontsTmpDir)) {
                                wp_mkdir_p($iphormFontsTmpDir);
                            }

                            if (is_writable($iphormFontsTmpDir)) {
                                copy($options['font'], $cachedFontPath);
                                $this->_font = $cachedFontPath;
                            }

                            // If the copy failed (safe mode etc) use the original path
                            if (!file_exists($cachedFontPath)) {
                                $this->_font = $options['font'];
                            }
                        }
                    } else {
                        // OS is not Windows, so use the font in the orginal path
                        $this->_font = $options['font'];
                    }
                }
            }

            if (array_key_exists('minFontSize', $options)) {
                $this->_minFontSize = $options['minFontSize'];
            }

            if (array_key_exists('maxFontSize', $options)) {
                $this->_maxFontSize = $options['maxFontSize'];
            }

            if (array_key_exists('minAngle', $options)) {
                $this->_minAngle = $options['minAngle'];
            }

            if (array_key_exists('maxAngle', $options)) {
                $this->_maxAngle = $options['maxAngle'];
            }
        }
    }

    /**
     * Display the CAPTCHA image
     */
    public function display()
    {
        $this->_generateCode();

        $image = imagecreate($this->_width, $this->_height);

        $bgColour = imagecolorallocate($image, $this->_bgColour['red'], $this->_bgColour['green'], $this->_bgColour['blue']);

        $textColour = imagecolorallocate($image, $this->_textColour['red'], $this->_textColour['green'], $this->_textColour['blue']);

        for($i = 0; $i < $this->_length; $i++) {
           $counter = mt_rand(0, 1);

           if ($counter == 0) {
              $angle = mt_rand($this->_minAngle, $this->_maxAngle);
           }

           if ($counter == 1) {
              $angle = mt_rand(360 - $this->_maxAngle, 360 - $this->_minAngle);
           }

           imagettftext($image, mt_rand($this->_minFontSize, $this->_maxFontSize), $angle, (($i + 1) * $this->_maxFontSize) - ($this->_maxFontSize / 2), mt_rand($this->_maxFontSize + 5, $this->_maxFontSize + 10), $textColour, $this->_font, substr($this->_code, $i, 1));
        }

        header('Content-Type: image/png');
        imagepng($image);
        imagedestroy($image);

        $_SESSION['iphorm-captcha-'. $this->_uniqId] = $this->_code;
    }

    /**
     * Generate a random CAPTCHA code
     */
    protected function _generateCode()
    {
        $this->_code = '';
        for ($i = 0; $i < $this->_length; $i++) {
            $this->_code .= substr($this->_characters, mt_rand(0, strlen($this->_characters) - 1), 1);
        }
    }
}