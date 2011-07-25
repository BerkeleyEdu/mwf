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

Config::set('atoz', 'title_text', Config::get('global', 'title_text') . 'Websites A-Z');

Config::set('atoz', 'header_image_sub', '../assets/img/berkeley-logo.png');

Config::set('atoz', 'header_image_sub_alt', 'UC Berkeley');

?>