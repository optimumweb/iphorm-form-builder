<?php

/**
 * iPhorm_Filter_Interface
 *
 * Custom filters should implement this class
 *
 * @package iPhorm
 * @subpackage Filter
 * @copyright Copyright (c) 2009-2011 ThemeCatcher (http://www.themecatcher.net)
 */
interface iPhorm_Filter_Interface
{
    public function filter($value);
}