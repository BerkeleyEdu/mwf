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
        </a>
		<a href="index.php"> 
		<img src="../assets/img/l2-map.png" alt="" width="45" height="35"/>
		<span>Maps &amp; Tour</span>
		</a>
    </h1>