<?php

require_once(dirname(dirname(__FILE__)).'/assets/config.php');
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/mwf/auxiliary/feed/feed_set.class.php');

try
{
    $feed_set = new Feed_Set('http://www.berkeley.edu/data/ucb_news_feeds.xml');
}
catch(Exception $e)
{
    $fetch_error = true;
}

include(dirname(__FILE__).'/header.php');

//$salt = Config::get('news', 'salt');
require_once('/var/mobile/salt');

?>

    <?php if(isset($fetch_error) && $fetch_error === true){ ?>

        <div class="content-full content-padded">
            <h1 class="light content-first">News Feeds</h1>
            <li><a href="http://m.youtube.com/view_playlist?gl=US&hl=en&client=mv-google&p=4DD1399BBF93AFBC">YouTube videos</a></li>

            <p class="content-last"><em><strong>Error encountered while fetching data.</strong> Please try again later.</em></p>
        </div>

    <?php } else { ?>

        <div class="menu-full menu-detailed menu-padded">
             <h1 class="light menu-first">Categories</h1>
             <ol>
                <?php 
                foreach($feed_set as $feed)
                    echo '<li><a href="'.$feed->get_page($salt).'">'.$feed->get_name().'</a></li>';
                ?>
				<li><a href="http://m.youtube.com/view_playlist?gl=US&hl=en&client=mv-google&p=4DD1399BBF93AFBC">YouTube videos</a></li>

            </ol>
        </div>

    <?php } ?>

    <a class="button-full button-padded" href="..">Go to Berkeley Mobile</a>

<?php include(dirname(__FILE__).'/footer.php'); ?>