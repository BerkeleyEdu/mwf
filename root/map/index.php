<?php
require_once(dirname(dirname(__FILE__)).'/assets/config.php');
include(dirname(__FILE__).'/header.php');

?>

    <div class="menu-full menu-detailed menu-padded" >
         <ol>
             <li class="menu-first menu-last"><a href="http://berkeley.edu/mobile/tour/">Campus Tour</a></li>
             <li class="menu-first"><a href="map_plain.php">Campus Map</a></li>            
             <li><a href="locations.php">Buildings</a></li>            
             <li><a href="libraries.php">Libraries</a></li>
             <li><a href="museums.php">Museums</a></li>
             <li><a href="nearby.php">Near By</a></li>
             <li><a href="food.php">On-Campus Dining</a></li>
             <?php
			 	// To do:  check with PTO re map
			 	//echo '<span class=only-webkit><li><a href="parking.php">Parking</a></li></span>';
			 ?>
             <li><a href="outdoor.php">Outdoor</a></li>
             <li><a href="sports_fac.php">Sports Facilities</a></li>
             <li class="menu-last"><a href="housing.php">Student Housing</a></li>             
        </ol>
	</div>

    <a class="button-full button-padded" href="..">Go to UCB Mobile</a>

<?php include(dirname(__FILE__).'/footer.php'); ?>