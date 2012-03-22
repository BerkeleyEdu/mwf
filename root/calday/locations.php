<?php
require_once(dirname(dirname(__FILE__)).'/assets/lib/location/locations.class.php');

$locations = new Locations('http://www.berkeley.edu/data/ucb_calday_map_coordinates.xml');

include(dirname(__FILE__).'/header.php');

?>

    <div class="menu-full menu-detailed menu-padded">
         <h1 class="light menu-first">Locations</h1>
         <ol>
             
			 <li class=only-webkit><a href="map.php">All Locations</a></li>
			 <?php
             foreach($locations as $location)
             {
                echo '<li><a href="map.php?loc='.urlencode($location['name']).'">'.$location['name'].'</a></li>';
             }
             ?>
        </ol>
    </div>


    <a class="button-full button-padded" href="http://calday.berkeley.edu/">Go to Cal Day</a>

<?php include(dirname(__FILE__).'/footer.php'); ?>