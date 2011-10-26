<?php

require_once(dirname(dirname(__FILE__)).'/assets/config.php');
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/mwf/auxiliary/feed/feed_set.class.php');

try
{
    $feed_set = new Feed_Set('http://www.berkeley.edu/data/ucb_sports_feeds.xml');
}
catch(Exception $e)
{
    $fetch_error = true;
}

include(dirname(__FILE__).'/header.php');

$salt = Config::get('sports', 'salt');

?>
		 <div class="menu-full menu-detailed menu-padded">
        <div class="content-last">
		  <ol>
    	<li><a href="http://m.calbears.com/">CalBears.com Mobile</a></li>
		</ol>  
    	</div>
    	</div>

    <?php if(isset($fetch_error) && $fetch_error === true){ ?>

        <div class="content-full content-padded">
            <h1 class="light content-first">Sports Feeds</h1>
            <li><a href="http://m.youtube.com/calathletics">YouTube videos</a></li>
            <p class="content-last"><em><strong>Error encountered while fetching data.</strong> Please try again later.</em></p>
        </div>

    <?php } else { ?>

        <div class="menu-full menu-detailed menu-padded">
             
             <ol>
				<li><a href="http://m.youtube.com/calathletics">YouTube videos</a></li>
                <?php 
                foreach($feed_set as $feed)
                    echo '<li><a href="'.$feed->get_page($salt).'">'.$feed->get_name().'</a></li>';
                ?>
            </ol>
            
        </div>

    <?php } ?>
    
    <div class="menu-full menu-detailed menu-padded">
        <div class="content-last">
		  <ol>
    	<li><a href="http://m.bkstr.com/NavigationSearchDisplay/10001-4294962859-10433-1?demoKey=d&navActionType=addNewRefinement">Shop for Cal gear</a></li>
		</ol>  
    	</div>
    	</div>

    <a class="button-full button-padded" href="..">Go to UCB Mobile</a>

<?php include(dirname(__FILE__).'/footer.php'); ?>