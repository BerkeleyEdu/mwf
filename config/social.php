<?php

/**
 * Configuration file for globally-used settings.
 *
 * This should NOT be included directly; instead /assets/config.php should be.
 *
 * @author ebollens
 * @version 20101021
 *
 * @uses Config
 * @link /assets/config.php
 */

require_once(dirname(dirname(__FILE__)).'/root/assets/lib/config.class.php');

Config::set('social', 'title_text', Config::get('global', 'title_text') . 'Social Media');

Config::set('social', 'header_image_sub', '../assets/img/berkeley-logo.png');

Config::set('social', 'header_image_sub_alt', 'UC Berkeley');

?>