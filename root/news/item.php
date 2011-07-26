 <?php

require_once(dirname(dirname(__FILE__)).'/assets/config.php');
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/mwf/auxiliary/feed/feed.class.php');

$feed = Feed::build_page_from_request();

if(!($feed_item = $feed->build_item_from_request()))
    $fetch_error = true;

include(dirname(__FILE__).'/header.php');

$salt = Config::get('news', 'salt');

?>

    <?php if(!$feed_item->verify_page($_GET['signature'], $salt)){ ?>

        <div class="content-full content-padded">
            <h1 class="light content-first">Error</h1>
            <p class="content-last"><em><strong>Security exception encountered while processing page.</strong> Please try again later.</em></p>
        </div>

    <?php } else { ?>

        <div class="content-full content-padded">
            <h1 class="content-first">
			<?php echo $feed_item->get_title(); ?></h1>
            
            <div><?php echo $feed_item->get_description(); ?></div>

            <?php if($feed_item->get_link()){ ?>
            <div class="content-last">
            <?php 
				$full_site_url = parse_url($feed_item->get_link());
			?>
                <p class="center"><a href="<?php echo $feed_item->get_link(); ?>">View full article on  <strong><?php echo $full_site_url[host] ?></strong></a></p>
            </div>
            <?php } ?>
            
        </div>

    <?php } ?>

<a class="button-full button-padded" href="<?php echo $feed->get_page($salt); ?>">Go to Articles</a>

<?php include(dirname(__FILE__).'/footer.php'); ?>