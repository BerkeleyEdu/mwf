<?php
/**
* The front page when the user arrives at the mobile site on a mobile device.
* If the user is on a non-mobile device and
* Config::get('global','site_nonmobile_url') is set, then they will be
* redirected.
*
* @package frontpage
*
* @author ebollens
* @author trott
* @copyright Copyright (c) 2010-12 UC Regents
* @license http://mwf.ucla.edu/license
* @version 20120312
*
* @uses Config
* @uses Decorator
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
* @uses User_Agent
* @uses Classification
*
* @link assets/redirect/unset_override.php
*/
require_once(dirname(__FILE__) . '/assets/config.php');
require_once(dirname(__FILE__) . '/assets/lib/decorator.class.php');
require_once(dirname(__FILE__) . '/assets/redirect/unset_override.php');
require_once(dirname(__FILE__) . '/assets/lib/user_agent.class.php');
require_once(dirname(__FILE__) . '/assets/lib/classification.class.php');

// Feeds
require_once(dirname(dirname(dirname(__FILE__))).'/mwf/auxiliary/feed/feed_set.class.php');
require_once(dirname(dirname(dirname(__FILE__))).'/mwf/auxiliary/feed/feed.class.php');
require_once('/var/mobile/salt');


/**
* Handle differences between a subsection and the top-level menu, using key
* 'default' if on the front page or otherwise the $_GET['s'] parameter.
*/
$menu_section = isset($_GET['s']) ? $_GET['s'] : 'default';

$menu_names = Config::get('frontpage', 'menu.name.' . $menu_section);

if (!isset($menu_names)) {
    $menu_section = 'default';
    $menu_names = Config::get('frontpage', 'menu.name.' . $menu_section);
}

$menu_ids = Config::get('frontpage', 'menu.id.' . $menu_section);
$menu_urls = Config::get('frontpage', 'menu.url.' . $menu_section);
$menu_classes = Config::get('frontpage', 'menu.class.' . $menu_section);
$menu_externals = Config::get('frontpage', 'menu.external.' . $menu_section);

$main_menu = ($menu_section == 'default');

/**
* Start page
*/
echo HTML_Decorator::html_start()->render();

$head = Site_Decorator::head()->set_title(Config::get('global', 'title_text'));
if ($main_menu && Config::get('frontpage', 'customizable_home_screen'))
    $head->add_js_handler_library('full_libs', 'customizableMenu');
echo $head->render();

echo HTML_Decorator::body_start($main_menu ? array('class' => 'front') : array())->render();

/*
* Header
*/

//TODO: Use decorators rather than HTML
if ($main_menu)
    echo '<h1 id="header"><img src="' . Config::get('frontpage', 'header_image_main') . '" alt="' . Config::get('frontpage', 'header_image_main_alt') . '"><span>' . Config::get('frontpage', 'header_main_text') . '</span></h1>';
else
    echo Site_Decorator::header()->set_title(ucwords(str_replace('_', ' ', $_GET['s'])))->render();
	echo '<p></p>';

/*
 * Search
 */
echo '<div class="center">';
$pos = strpos(User_Agent::get_user_agent(),'BlackBerry'); 
	if ($pos !== false)
	{
	?>      
<form action="http://berkeley.edu/cgi-bin/news/gatewaysearchfunction.pl" method="get" name="searchform" id="ucbsearchform">
		<input type="text" id="ucbsearchtext" name="search_text" style='width:73%; max-width:300px' />
          <input id="ucbsearchbutton" class="form-last" name="Submit" type="submit" value="Search"/>
          <input type="hidden" name="display_type" value="mobile" />
           <input type="hidden" name="noscript" value="yes" />
      </form>


<?php
}
else
{
?> 
    <form action="http://berkeley.edu/cgi-bin/news/gatewaysearchfunction.pl" method="get" name="searchform" id="ucbsearchform">
		<input type="text" id="ucbsearchtext" name="search_text" style='width:73%; max-width:300px' placeholder="Search the Berkeley Web"/>
        <input id="ucbsearchbutton" class="form-last" name="Submit" type="submit" value="Search"/>
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

$menu = Site_Decorator::menu()->set_padded()->set_detailed();

if ($main_menu)
    $menu->set_home_screen();
	
if (Classification::is_full() )
{						
	// Get news 			
	$feed_set = new Feed_Set('http://www.berkeley.edu/data/ucb_news_feeds.xml');	
	foreach ($feed_set as $feed)
	{
		$news_link = 'news/' . $feed->get_page($salt);
   		$image_wrapper = true;
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
	$events_link = 'http://events.berkeley.edu/mobile/';
	$image_wrapper = true;	

	// Get Cal Day
	/*
	$photo = rand(1, 11);
	$calday_image_URL = "http://calday.berkeley.edu/calday/img/mobile/". $photo . ".jpg";
	$image = '<img class="thumbnail" alt="" src="'. $calday_image_URL . '" /> ';
	$calday_title = $image . "Saturday, April 21<br/>300 unforgettable events!";	
	$calday_link = 'http://calday.berkeley.edu';	
	$image_wrapper = true;	
	*/
}	
	

foreach ($menu_names as $key => $menu_name) {
    $list_item_attributes = array();
    if (isset($menu_classes[$key])) {
        $list_item_attributes['class'] = $menu_classes[$key];
    }
    if (isset($menu_ids[$key])) {
        $list_item_attributes['id'] = $menu_ids[$key];
    }

    $link_attributes = array();
    if (isset($menu_externals[$key])) {
        if ($menu_externals[$key])
            $link_attributes['rel'] = 'external';
    }
	
	if (Classification::is_full() )
	{
		if ($menu_name == 'News' && $news_title != '')
		{
			$menu_name = 'News<br/> <span class="feed_title">' . $news_title . '</span>';
			$menu_urls[$key] = $news_link;
		}
		elseif ($menu_name == 'Events'  && $events_title != '')
		{
			$menu_name = 'Events<br/> <span class="feed_title">' . $events_title . '</span>';
			$menu_urls[$key] = $events_link;
		}
		/*
		elseif ($menu_name == 'Cal Day')
		{
			$menu_name = 'Cal Day<br/> <span class="feed_title">' . $calday_title . '</span>';
			$menu_urls[$key] = $calday_link;
		}
		*/
	}
	

    $menu->add_item($menu_name, $menu_urls[$key], $list_item_attributes, $link_attributes, $key);
}

echo $menu->render(true);

/**
* Back button
*/
if (!$main_menu)
    echo Site_Decorator::button()
            ->set_padded()
            ->add_option(Config::get('global', 'back_to_home_text'), 'index.php')
            ->render();

/**
* Footer
*/
$footer = Site_Decorator::berkeley_footer();
$footer->show_powered_by(false);
if ($main_menu && Classification::is_full() && Config::get('frontpage','customizable_home_screen'))
    $footer->add_footer_link('Customize Home Screen', "/customize_home_screen.php");
echo $footer->render();

/**
* End page
*/
echo HTML_Decorator::body_end()->render();

echo HTML_Decorator::html_end()->render();
