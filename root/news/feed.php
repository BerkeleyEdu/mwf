<?php

require_once(dirname(dirname(__FILE__)).'/assets/config.php');
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/mwf/auxiliary/feed/feed.class.php');


$feed = Feed::build_page_from_request();

$feed_items = $feed->get_items();

include(dirname(__FILE__).'/header.php');

$salt = Config::get('news', 'salt');

?>

    <?php if(!$feed->verify_page($_GET['signature'], $salt)){ ?>

        <div class="content-full content-padded">
            <h1 class="light content-first">Error</h1>
            <p class="content-last"><em><strong>Security exception encountered while processing page.</strong> Please try again later.</em></p>
        </div>

    <?php } else { ?>
	
        <div class="menu-full menu-detailed menu-padded">
            <h1 class="light menu-first"><?php echo $feed->get_name(); ?></h1>
             <ol>

                <?php
				
                foreach($feed_items as $feed)
				{
                  	preg_match_all('/<img[^>]+>/i',$feed->get_description(), $result); 
					echo '<li><a class=image-wrapper href="'.$feed->get_page($salt).'">'. str_replace('%20"', '"', $result[0][0]).$feed->get_title().'</a>';
					echo '</li>';
					$i++;
				}
					
                ?>
            </ol>
        </div>

    <?php  } ?>

    <a class="button-full button-padded" href="index.php">Go to News Categories</a>

<?php include(dirname(__FILE__).'/footer.php'); ?>