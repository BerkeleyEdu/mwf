<?php

require_once(dirname(dirname(__FILE__)).'/assets/lib/user_agent.class.php');
require_once(dirname(dirname(__FILE__)).'/assets/lib/user_browser.class.php');
require_once(dirname(dirname(__FILE__)).'/assets/config.php');
require_once(dirname(dirname(__FILE__)).'/assets/lib/location/locations.class.php');
$locations = new Locations('http://www.berkeley.edu/data/ucb_map_coordinates.xml');

?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo Config::get('map', 'title_text'); ?></title>
        <link rel="stylesheet" href="../assets/css.php" type="text/css" media="screen" />
        <?php echo $_SERVER['SERVER_NAME'] == 'mobile-qa.berkeley.edu'
              ? '<script type="application/javascript" src="../assets/js.php?no_ga"></script>'
              : '<script type="application/javascript" src="../assets/js.php"></script>'; ?>
              
        <script type="text/javascript" src="../assets/js.php?touch_libs=geolocation"></script>   
		<script type="text/javascript" src="../assets/lib/location/location.js"></script>
        
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <style>
            html { height: 100% }
            body { height: 100%; margin: 0px; padding: 0px }
            #map_canvas { position: absolute; top: 38px; left: 0; right: 0; bottom: 44px; z-index: 1; overflow: hidden; }
            a.button-full#button-bottom { position: absolute !important; bottom: 0px; left: 0px; right: 0px; width: 100%; z-index: 2; }
        </style>
        <?php	
          if(!User_Agent::is_full())
          { 
			  if(!isset($_GET['loc']))
			  {
			  $location = array('lat'=>'37.872439999999997', 'lon'=>'-122.25955999999999');
				  $marker = '';
			  }
			  else if($location = $locations->find(urldecode($_GET['loc'])))
			  {
			  }
			  else
			  {
				  $location = array('lat'=>'37.872439999999997', 'lon'=>'-122.25955999999999');
			  }
		  
		  ?>
          
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

		<script type="text/javascript">
		  function initialize() {
		    var latlng = new google.maps.LatLng(<?php echo $location['lat'];?>, <?php echo $location['lon'];?>);
		    var myOptions = {
		      zoom: 15,
		      center: latlng,
		      mapTypeId: google.maps.MapTypeId.ROADMAP,
			  disableDefaultUI: true
		    };
		   var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

  			var myLatLng = new google.maps.LatLng(<?php echo $location['lat'];?>, <?php echo $location['lon'];?>);

			var mytitle = "<?php echo $location['name'];?>";
			 var marker = new google.maps.Marker({
			  	position: myLatLng,
			      map: map,
				  title: mytitle
			});

			
}
		</script>

             <?php } ?>
    </head>
    
     <?php 
   	if(!User_Agent::is_full())
  	{ 
   		 echo '<body onload="initialize()">';
    }
    else
    {
    	 echo '<body>';
    }
	?>
        
        <h1 id="header">
            <a href="../">
            <img src="../assets/img/berkeley-logo.png" alt="UC Berkeley" width="119" height="35" />
            <img src="../assets/img/l2-map.png" alt="" width="45" height="35"/>
            </a><span><a href="index.php">Maps &amp; Tour</a></span>
        </h1>

          <div id="map_canvas"><?php

          if(!User_Agent::is_full())
          {
              echo '<noscript>';
			  if(!isset($_GET['loc']))
              {
                  $location = array('lat'=>'37.872439999999997', 'lon'=>'-122.25955999999999');
                  $marker = '';
              }
              else if($location = $locations->find(urldecode($_GET['loc'])))
              {
                  $marker = '&amp;markers=color:red%7Ccolor:red%7Clabel:C%7C'.$location['lat'].'%2C'.$location['lon'];
              }
              else
              {
                  $location = array('lat'=>'37.872439999999997', 'lon'=>'-122.25955999999999');
                  $marker = '';
              }


              echo '<img src="http://maps.google.com/maps/api/staticmap?center='.$location['lat'].'%2C'.$location['lon'].'&amp;zoom=15&size='.User_Browser::width().'x'.User_Browser::height().$marker.'&amp;sensor=false"></img>';
			  echo '</noscript>';
          }

          ?></div>
          
          <?php
        if (isset($_GET['tour']))
        {
			print '<a class="button-full" id="button-bottom" href="http://berkeley.edu/mobile/tour/view.php?l=' . $_GET['tour'] . '">Go to Tour</a>';
        }
        else
        {	
          print '<a class="button-full" id="button-bottom" href="locations.php">Go to Buildings</a>';
         }
		 ?>

        <?php if(User_Agent::is_full()){ ?>
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