<?php

require_once(dirname(dirname(__FILE__)).'/assets/lib/classification.class.php');
require_once(dirname(dirname(__FILE__)).'/assets/config.php');
require_once(dirname(dirname(__FILE__)).'/assets/lib/location/locations.class.php');
$locations = new Locations('http://www.berkeley.edu/data/ucb_outdoor_map_coordinates.xml');
include(dirname(__FILE__).'/map_header.php');

?>


          <div id="map_canvas"><?php

          if(!Classification::is_full())
          {
              echo '<noscript>';
			  if(!isset($_GET['loc']))
              {
                  $location = array('lat'=>'37.872439999999997', 'lon'=>'-122.25955999999999');
                  $marker = '';
              }
              else if($location = $locations->find(urldecode($_GET['loc'])))
              {
                  $marker = '&markers=color:red%7Ccolor:red%7Clabel:C%7C'.$location['lat'].'%2C'.$location['lon'];
              }
              else
              {
                  $location = array('lat'=>'37.872439999999997', 'lon'=>'-122.25955999999999');
                  $marker = '';
              }


              echo '<img src="http://maps.google.com/maps/api/staticmap?center='.$location['lat'].'%2C'.$location['lon'].'&zoom=16&size='.User_Browser::width().'x'.User_Browser::height().$marker.'&sensor=false"></img>';
			  echo '</noscript>';
          }

          ?></div>

          <a class="button-full" id="button-bottom" href="outdoor.php">Go to Outdoor</a>

        <?php if(Classification::is_full()){ ?>
        <script type="text/javascript">
            var map = mwf.ext.touch.location.buildMap("map_canvas");
            <?php
            if(!isset($_GET['loc'])) {
                echo 'map.setCenter(37.872439999999997, -122.25955999999999);';
                foreach($locations as $location)
                    echo 'map.addLocation("'.$location['name'].'", '.$location['lat'].', '.$location['lon'].'); ';
            } else {
                $loc = urldecode($_GET['loc']);
                if($location = $locations->find($loc)){
                    echo 'map.addLocation("'.$location['name'].'", '.$location['lat'].', '.$location['lon'].'); ';
                    echo 'map.setCenter('.$location['lat'].', '.$location['lon'].'); ';
                }
            }
            ?>
			if (mwf.touch.geolocation.isSupported() )
			 {
				mwf.touch.geolocation.getPosition(
						function(pos)
						{  						
						map.addLocation('Your current location', pos['latitude'], pos['longitude'], "http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png"); 
						},
						function(err){ alert("Err:"+err); }
					)
			 }
        </script>
        <?php } ?>

    </body>

</html>