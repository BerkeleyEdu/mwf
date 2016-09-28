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

Config::set('news', 'title_text', Config::get('global', 'title_text') . ' News');

Config::set('news', 'header_image_sub', '../assets/img/berkeley-home.png');

Config::set('news', 'header_image_sub_alt', ' Berkeley');

//require_once('/var/mobile/salt');
require_once('/var/www/mobile/salt');
Config::set('news', 'salt', $salt);

?>