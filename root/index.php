<?php

/**
 * The front page when the user arrives at the mobile site on a mobile device.
 * If the user is on a non-mobile device and {'global':'site_nonmobile_url'} is
 * set in config/global.php, then they will be redirected.
 *
 * This page throws a fatal error if either {'global':'site_url'} or
 * {'global':'site_assets_url'} are not set in /config/global.php.
 *
 * @package frontpage
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110620
 *
 * @uses Config
 * @uses User_Agent
 * @uses JS
 * @uses Site_Decorator
 * @uses HTML_Decorator
 * @uses HTML_Start_HTML_Decorator
 * @uses Head_Site_Decorator
 * @uses Body_Start_HTML_Decorator
 * @uses Header_Site_Decorator
 * @uses Menu_Full_Site_Decorator
 * @uses Button_Full_Site_Decorator
 * @uses Footer_Site_Decorator
 * @uses Body_End_HTML_Decorator
 * @uses HTML_End_HTML_Decorator
 * 
 * @link /config/global.php
 * @link assets/redirect/unset_override.php
 */

/**
 * Require necessary libraries.
 */

require_once(dirname(__FILE__).'/assets/config.php');
require_once(dirname(__FILE__).'/assets/lib/user_agent.class.php');
require_once(dirname(__FILE__).'/assets/lib/decorator.class.php');
require_once(dirname(__FILE__).'/assets/redirect/unset_override.php');

/**
 * Ensure that site_url and site_asset_url have been set.
 */

if(!Config::get('global', 'site_url') || !Config::get('global', 'site_assets_url'))
	die('<h1>Fatal Error</h1><p>The configuration settings {global::site_url} and {global::site_asset_url} must be defined in '.dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'global.php</p>');

/**
 * Set an override for the classification if $_GET['ovrcls'] is defined, unset
 * it if $_GET['unovrcls'] is defined (unary), or redirect if non-mobile and
 * {'global':'site_nonmobile_url'} is true.
 */

if(isset($_GET['ovrcls']))
{
    User_Agent::set_override($_GET['ovrcls']);
    header('Location: '.Config::get('global', 'site_url'));
}
else if(isset($_GET['unovrcls']))
{
    User_Agent::unset_override();
    header('Location: '.Config::get('global', 'site_url'));
}
else if(!User_Agent::is_mobile() && $nonmobile_url = Config::get('global', 'site_nonmobile_url') && $_SERVER['SERVER_NAME'] != 'mobile-qa.berkeley.edu'  && $_SERVER['SERVER_NAME'] != 'm-qa.berkeley.edu')
{
   $nonmobile_url = Config::get('global', 'site_nonmobile_url');
   header('Location: '. $nonmobile_url);
}



/**
 * Get the menu from {'frontpage':'menu'} defined in config/frontpage.php.
 */

$menu = Config::get('frontpage', 'menu');

/**
 * Handle differences between a subsection and the top-level menu, using key
 * 'default' if on the front page or otherwise the $_GET['s'] parameter.
 */

if(isset($_GET['s']) && isset($menu[$_GET['s']]))
{
    $menu_items = $menu[$_GET['s']];
    $main_menu = false;
}
else
{
    $menu_items = $menu['default'];
    $main_menu = true;
}

/**
 * Start page
 */

echo HTML_Decorator::html_start()->render();

echo Site_Decorator::head()->set_title(Config::get('global', 'title_text'))->render();

echo HTML_Decorator::body_start($main_menu ? array('class'=>'front-page') : array())->render();
          
/*
 * Header
 */

if($main_menu)
    echo '<h1 id="header"><img src="'.Config::get('frontpage', 'header_image_main').'" alt="'.Config::get('frontpage', 'header_image_main_alt').'"><span>'.Config::get('frontpage', 'header_main_text').'</span></h1>';
else
    echo Site_Decorator::header()->set_title(ucwords(str_replace('_', ' ', $_GET['s'])))->render();
	
/*
*  campus photo
*/
if(User_Agent::is_full())
{
	$photo = rand(1, 9);
	echo '<img src="/assets/min/img.php?img=http%3A%2F%2F'. $_SERVER['SERVER_NAME'] . '%2Fassets%2Fimg%2Fcampusphotos%2F'. $photo . '.jpg&browser_width_percent=100&browser_height_percent=100" style="width: 100%;" alt="the many faces of Berkeley"/>';
}	
else
{
	echo '<p></p>';
}
	

/*
 * Search
 */
echo '<div class="center">';
$pos = strpos(User_Agent::get(),'BlackBerry'); 
	if ($pos !== false)
	{
	?>      
<form action="http://berkeley.edu/cgi-bin/news/gatewaysearchfunction.pl" method="get" name="searchform" >
		<input type="text" id="search_text" name="search_text" style='width:73%; max-width:300px' />
          <input id="search-button" class="form-last" name="Submit" type="submit" value="Search"/>
          <input type="hidden" name="display_type" value="mobile" />
           <input type="hidden" name="noscript" value="yes" />
      </form>


<?php
}
else
{
?> 
    <form action="http://berkeley.edu/cgi-bin/news/gatewaysearchfunction.pl" method="get" name="searchform" >
		<input type="text" id="search_text" name="search_text" style='width:73%; max-width:300px' />
          <input id="search-button" class="form-last" name="Submit" type="submit" value="Search"/>
          <input type="hidden" name="display_type" value="mobile" />
<noscript>
 <input type="hidden" name="noscript" value="yes" />
</noscript>
      </form>
      
<?php 
}
echo '</div>';


/*
 * Menu
 */

$menu = Site_Decorator::menu_full()->set_padded()->set_detailed();

if($main_menu)
    $menu->add_class('menu-front');
		

for($i = 0; $i < count($menu_items); $i++)
{
    $menu_item = $menu_items[$i];

    if(isset($menu_item['restriction']))
    {
        $function = $menu_item['restriction'];
        if(!User_Agent::$function())
            continue;
    }

    $menu->add_item($menu_item['name'],$menu_item['url'],isset($menu_item['id'])?array('id'=>$menu_item['id']):array());
}

echo $menu->render();

/**
 * Back button
 */

if(!$main_menu)
    echo Site_Decorator::button_full()
                ->set_padded()
                ->add_option(Config::get('global', 'back_to_home_text'), 'index.php')
                ->render();

/**
 * Footer
 */

$footer = Site_Decorator::footer();

$footer->show_powered_by(true);

echo $footer->render();

/**
 * End page
 */

echo HTML_Decorator::body_end()->render();

echo HTML_Decorator::html_end()->render();
