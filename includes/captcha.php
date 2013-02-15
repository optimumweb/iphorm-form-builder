<?php

session_start();

defined('IPHORM_INCLUDES_DIR') || define('IPHORM_INCLUDES_DIR', realpath(dirname(__FILE__ )));
require_once IPHORM_INCLUDES_DIR . '/JSON.php';
require_once IPHORM_INCLUDES_DIR . '/iPhorm/Captcha.php';

$config = base64_decode(stripslashes($_GET['c']));
$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
$config = $json->decode($config);

if (is_array($config) && array_key_exists('options', $config)) {
    $captchaOptions = $config['options'];

    if (array_key_exists('length', $captchaOptions)) {
        $captchaOptions['length'] = abs(intval($captchaOptions['length']));
        $captchaOptions['length'] = min($captchaOptions['length'], 32);
        $captchaOptions['length'] = max($captchaOptions['length'], 2);
    } else {
        $captchaOptions['length'] = 5;
    }

    if (array_key_exists('width', $captchaOptions)) {
        $captchaOptions['width'] = abs(intval($captchaOptions['width']));
        $captchaOptions['width'] = min($captchaOptions['width'], 300);
        $captchaOptions['width'] = max($captchaOptions['width'], 20);
    } else {
        $captchaOptions['width'] = 190;
    }

    if (array_key_exists('height', $captchaOptions)) {
        $captchaOptions['height'] = abs(intval($captchaOptions['height']));
        $captchaOptions['height'] = min($captchaOptions['height'], 300);
        $captchaOptions['height'] = max($captchaOptions['height'], 10);
    } else {
        $captchaOptions['height'] = 60;
    }

    if (!array_key_exists('bgColour', $captchaOptions) || ($captchaOptions['bgColour'] = hex2RGB($captchaOptions['bgColour'])) === false) {
        $captchaOptions['bgColour'] = array(
            'red' => 255,
            'green' => 255,
            'blue' => 255
        );
    }

    if (!array_key_exists('textColour', $captchaOptions) || ($captchaOptions['textColour'] = hex2RGB($captchaOptions['textColour'])) === false) {
        $captchaOptions['textColour'] = array(
            'red' => 10,
            'green' => 10,
            'blue' => 10
        );
    }

    if (array_key_exists('font', $captchaOptions) && file_exists(IPHORM_INCLUDES_DIR . '/fonts/' . $captchaOptions['font'])) {
        $captchaOptions['font'] = IPHORM_INCLUDES_DIR . '/fonts/' . $captchaOptions['font'];
    } else {
        $captchaOptions['font'] = IPHORM_INCLUDES_DIR . '/fonts/Typist.ttf';
    }

    if (array_key_exists('minFontSize', $captchaOptions)) {
        $captchaOptions['minFontSize'] = abs(intval($captchaOptions['minFontSize']));
        $captchaOptions['minFontSize'] = min($captchaOptions['minFontSize'], 72);
        $captchaOptions['minFontSize'] = max($captchaOptions['minFontSize'], 5);
    } else {
        $captchaOptions['minFontSize'] = 15;
    }

    if (array_key_exists('maxFontSize', $captchaOptions)) {
        $captchaOptions['maxFontSize'] = abs(intval($captchaOptions['maxFontSize']));
        $captchaOptions['maxFontSize'] = min($captchaOptions['maxFontSize'], 72);
        $captchaOptions['maxFontSize'] = max($captchaOptions['maxFontSize'], 5);
    } else {
        $captchaOptions['maxFontSize'] = 30;
    }

    if (array_key_exists('minAngle', $captchaOptions)) {
        $captchaOptions['minAngle'] = abs(intval($captchaOptions['minAngle']));
        $captchaOptions['minAngle'] = min($captchaOptions['minAngle'], 360);
    } else {
        $captchaOptions['minAngle'] = 0;
    }

    if (array_key_exists('maxAngle', $captchaOptions)) {
        $captchaOptions['maxAngle'] = abs(intval($captchaOptions['maxAngle']));
        $captchaOptions['maxAngle'] = min($captchaOptions['maxAngle'], 360);
    } else {
        $captchaOptions['maxAngle'] = 30;
    }

    $captchaOptions['uniqId'] = $config['uniqId'];
    $captchaOptions['tmpDir'] = $config['tmpDir'];
    $captcha = new iPhorm_Captcha($captchaOptions);
    $captcha->display();
}

/**
 * Convert a hexa decimal color code to its RGB equivalent
 *
 * @param string $hexStr (hexadecimal color value)
 * @param boolean $returnAsString (if set true, returns the value separated by the separator character. Otherwise returns associative array)
 * @param string $seperator (to separate RGB values. Applicable only if second parameter is true.)
 * @return array or string (depending on second parameter. Returns False if invalid hex color value)
 */
function hex2RGB($hexStr, $returnAsString = false, $seperator = ',')
{
    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
    $rgbArray = array();
    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
    } else {
        return false; //Invalid hex color code
    }
    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
}

/**
 * Recursive directory creation based on full path.
 *
 * Will attempt to set permissions on folders.
 *
 * @since 2.0.1
 *
 * @param string $target Full path to attempt to create.
 * @return bool Whether the path was created. True if path already exists.
 */
function wp_mkdir_p( $target ) {
    // from php.net/mkdir user contributed notes
    $target = str_replace( '//', '/', $target );

    // safe mode fails with a trailing slash under certain PHP versions.
    $target = rtrim($target, '/'); // Use rtrim() instead of untrailingslashit to avoid formatting.php dependency.
    if ( empty($target) )
        $target = '/';

    if ( file_exists( $target ) )
        return @is_dir( $target );

    // Attempting to create the directory may clutter up our display.
    if ( @mkdir( $target ) ) {
        $stat = @stat( dirname( $target ) );
        $dir_perms = $stat['mode'] & 0007777;  // Get the permission bits.
        @chmod( $target, $dir_perms );
        return true;
    } elseif ( is_dir( dirname( $target ) ) ) {
            return false;
    }

    // If the above failed, attempt to create the parent node, then try again.
    if ( ( $target != '/' ) && ( wp_mkdir_p( dirname( $target ) ) ) )
        return wp_mkdir_p( $target );

    return false;
}