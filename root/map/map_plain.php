<?php

require_once(dirname(dirname(__FILE__)).'/assets/lib/classification.class.php');
require_once(dirname(dirname(__FILE__)).'/assets/lib/screen.class.php');
require_once(dirname(dirname(__FILE__)).'/assets/config.php');
require_once(dirname(dirname(__FILE__)).'/assets/lib/location/locations.class.php');

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
          if(!Classification::is_full())
          { ?>
          
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

		<script type="text/javascript">
		  function initialize() {
		    var latlng = new google.maps.LatLng(37.872439999999997, -122.25955999999999);
		    var myOptions = {
		      zoom: 14,
		      center: latlng,
		      mapTypeId: google.maps.MapTypeId.ROADMAP,
			  disableDefaultUI: true
		    };
		   var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
  			var myLatLng = new google.maps.LatLng(37.872439999999997, -122.25955999999999);
}
		</script>

             <?php } ?>
            
    </head>
   <?php 
   	if(!Classification::is_full())
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
        </a>
		<a href="index.php"> 
		<img src="../assets/img/l2-map.png" alt="" width="45" height="35"/>
		<span>Maps &amp; Tour</span>
		</a>
    </h1>

          <div id="map_canvas"><?php
	
          if(!Classification::is_full())
          {
              echo '<noscript>';
			  echo '<img src="http://maps.google.com/maps/api/staticmap?center=37.872439999999997%2C-122.25955999999999&zoom=15&size='.Screen::get_width().'x'.Screen::get_height().'&sensor=false"></img>';
			   echo '</noscript>';
          }

          ?></div>
		  


          <a class="button-full" id="button-bottom" href="<?php echo isset($_GET['loc']) ? 'locations.php' : 'index.php'; ?>">Go to Maps &amp; Tour</a>

        <?php if(Classification::is_full()){  ?>
        <script type="text/javascript">		
            var map = mwf.ext.touch.location.buildMap("map_canvas");
            <?php
                echo 'map.setCenter(37.872439999999997, -122.25955999999999);';
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
        <?php } 
		
		

		?>

    </body>

</html>