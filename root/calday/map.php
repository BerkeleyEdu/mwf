<?php
require_once(dirname(dirname(__FILE__)).'/assets/lib/classification.class.php');
require_once(dirname(dirname(__FILE__)).'/assets/lib/screen.class.php');
require_once(dirname(dirname(__FILE__)).'/assets/config.php');
require_once(dirname(dirname(__FILE__)).'/assets/lib/location/locations.class.php');

$locations = new Locations('http://www.berkeley.edu/data/ucb_calday_map_coordinates.xml');

?><!DOCTYPE html>
<html>
    <head>
        <title>Cal Day Map</title>
        <link rel="stylesheet" type="text/css" href="../assets/css.php?basic=http%3A%2F%2Fberkeley.edu%2Fcalday%2Fcss%2Fmobile%2Fbasic.css&standard=http%3A%2F%2Fberkeley.edu%2Fcalday%2Fcss%2Fmobile%2Fstandard.css&full=http%3A%2F%2Fberkeley.edu%2Fcalday%2Fcss%2Fmobile%2Ffull.css" />
		
        <?php echo $_SERVER['SERVER_NAME'] == 'mobile-qa.berkeley.edu'
              ? '<script type="application/javascript" src="../assets/js.php?no_ga"></script>'
              : '<script type="application/javascript" src="../assets/js.php"></script>'; ?>
              
         <script type="text/javascript" src="../assets/js.php?touch_libs=geolocation"></script>    
		<script type="text/javascript" src="../assets/lib/location/location.js"></script>
        
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <style>
            html { height: 100% }
            body { height: 100%; margin: 0px; padding: 0px }
            #map_canvas { position: absolute; top: 50px; left: 0; right: 0; bottom: 44px; z-index: 1; overflow: hidden; }
            a.button-full#button-bottom { position: absolute !important; bottom: 0px; left: 0px; right: 0px; width: 100%; z-index: 2; }
        </style>
    <?php	
          if(!Classification::is_full())
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
   	if(!Classification::is_full())
  	{ 
   		 echo '<body onload="initialize()" class="second-level">';
    }
    else
    {
    	 echo '<body class="second-level">';
    }
	?>
        
<h1 id="header"><a href="http://calday.berkeley.edu"><img src="http://berkeley.edu/calday/img/calday-app-secondary-logo.jpg" alt="Cal Day Mobile"></a></h1>
<div id="blubnr">Saturday, April 21</div>

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
                  $marker = '&markers=color:red%7Ccolor:red%7Clabel:C%7C'.$location['lat'].','.$location['lon'];
              }
              else
              {
                  $location = array('lat'=>'37.872439999999997', 'lon'=>'-122.25955999999999');
                  $marker = '';
              }


              echo '<img src="http://maps.google.com/maps/api/staticmap?center='.$location['lat'].','.$location['lon'].'&zoom=16&size='.Screen::get_width().'x'.Screen::get_height().$marker.'&sensor=false"></img>';
			  echo '</noscript>';
          }

          ?></div>

          <a class="button-full" id="button-bottom" href="http://calday.berkeley.edu">Go to Cal Day</a>

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