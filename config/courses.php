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

Config::set('courses', 'title_text', Config::get('global', 'title_text') . ' Courses');

Config::set('courses', 'header_image_sub', '../assets/img/berkeley-home.png');

Config::set('courses', 'header_image_sub_alt', ' Berkeley');

?>