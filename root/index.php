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
 * @version 20110901
 *
 * @uses Config
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
require_once(dirname(__FILE__).'/assets/lib/decorator.class.php');
require_once(dirname(__FILE__).'/assets/redirect/unset_override.php');
require_once(dirname(__FILE__).'/assets/lib/classification.class.php');
require_once(dirname(__FILE__).'/assets/lib/user_agent.class.php');

// Feeds
require_once(dirname(dirname(dirname(__FILE__))).'/mwf/auxiliary/feed/feed_set.class.php');
require_once(dirname(dirname(dirname(__FILE__))).'/mwf/auxiliary/feed/feed.class.php');
$salt = Config::get('news', 'salt');

/**
 * Ensure that site_url and site_asset_url have been set.
 */

if(!Config::get('global', 'site_url') || !Config::get('global', 'site_assets_url'))
	die('<h1>Fatal Error</h1><p>The configuration settings {global::site_url} and {global::site_asset_url} must be defined in '.dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'global.php</p>');

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
/*
if(Classification::is_full())
{
	$photo = rand(1, 9);
	//echo '<img src="/assets/min/img.php?img=http%3A%2F%2F'. $_SERVER['SERVER_NAME'] . '%2Fassets%2Fimg%2Fcampusphotos%2F'. $photo . '.jpg&browser_width_percent=100&browser_height_percent=100" style="width: 100%;" alt="the many faces of Berkeley"/>';
	
	echo '<img src="/assets/min/img.php?img=http://'. $_SERVER['SERVER_NAME'] . '/assets/img/campusphotos/'. $photo . '.jpg&browser_width_percent=100&browser_height_percent=100" style="width: 100%;" alt="the many faces of Berkeley"/>';
}	
else
{
*/
	echo '<p></p>';
//}
	

/*
 * Search
 */
echo '<div class="center">';
$pos = strpos(User_Agent::get_user_agent(),'BlackBerry'); 
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
		<input type="text" id="search_text" name="search_text" style='width:73%; max-width:300px' placeholder="Search the Berkeley Web"/>
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

if (Classification::is_full() )
{						
	// Get news 			
	$feed_set = new Feed_Set('http://www.berkeley.edu/data/ucb_news_feeds.xml');	
	foreach ($feed_set as $feed)
	{
		$news_link= 'news/' . $feed->get_page($salt) . '" class="image-wrapper';
		break;
	}	
	$_GET['name'] = 'Top News';
	$_GET['path'] =	'http://newscenter.berkeley.edu/category/news/feed/';				
	$feed = Feed::build_page_from_request();
	$feed_items = $feed->get_items();
	preg_match_all('/<img[^>]+>/i',$feed_items[0]->get_description(), $result); 
	// remove extra space at end of image file path
	$news_title= str_replace('%20"', '"', $result[0][0]).$feed_items[0]->get_title();	
	
	// Get event
	$today = date('Y-m-d');
	$xml_file = file_get_contents('http://events.berkeley.edu/index.php/mobile/sn/pubaff/type/range/tab/critics_choice.html?startdate='.$today.'&enddate='.$today);
	$simple_xml = simplexml_load_string($xml_file);
	if ($simple_xml->Events->Event->Images->Image->URL != '')
	{
		$image = '<img class="thumbnail" alt="" src="http://m.berkeley.edu/assets/min/img.php?img=http://events.berkeley.edu'. $simple_xml->Events->Event->Images->Image->URL . '&max_height=60&max_width=60" /> ';
	}
	else
	{
		$image = '';
	}
	$events_title = $image . $simple_xml->Events->Event->EventTitle;	
	$events_link = 'http://events.berkeley.edu/mobile/" class="image-wrapper';
	
	/*
	// Get Cal Day
	$photo = rand(1, 2);
	$calday_image_URL = "http://calday-dev.berkeley.edu/calday/img/mobile/". $photo . ".jpg";
	$image = '<img class="thumbnail" alt="" src="'. $calday_image_URL . '" /> ';
	$calday_title = $image . "Saturday, April 21<br/>300 unforgettable events!";	
	$calday_link = 'http://calday.berkeley.edu" class="image-wrapper';	
	*/		
}
		

for($i = 0; $i < count($menu_items); $i++)
{
    $menu_item = $menu_items[$i];

    if(isset($menu_item['restriction']))
    {
        $function = $menu_item['restriction'];
        if(!Classification::$function())
            continue;
    }

	if (Classification::is_full() )
	{
		if ($menu_item['name'] == 'News' && $news_title != '')
		{
			$menu_item['name'] = 'News<br/> <span class="feed_title">' . $news_title . '</span>';
			$menu_item['url'] = $news_link;
		
		}
	
		elseif ($menu_item['name'] == 'Events'  && $events_title != '')
		{
			$menu_item['name'] = 'Events<br/> <span class="feed_title">' . $events_title . '</span>';
			$menu_item['url'] = $events_link;
		}
		/*
		elseif ($menu_item['name'] == 'Cal Day')
		{
			$menu_item['name'] = 'Cal Day<br/> <span class="feed_title">' . $calday_title . '</span>';
			$menu_item['url'] = $calday_link;
		}
		*/
	}

	
	$menu->add_item($menu_item['name'],$menu_item['url'],isset($menu_item['id'])?array('id'=>$menu_item['id']):array());

	
}

// Get news alert	
/*		
$xml_file = file_get_contents('http://ucbnews-sandbox.org/newsalert/?feedpage');
$simple_xml = simplexml_load_string($xml_file);
$alert_message = $simple_xml->channel->item->description;

if ($alert_message != '')
{
	 echo  '<div class="content-full content-padded" id="alert">' . $alert_message . '</div>';
}
*/		

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

$footer->show_powered_by(false);

echo $footer->render();

/**
 * End page
 */

echo HTML_Decorator::body_end()->render();

echo HTML_Decorator::html_end()->render();
