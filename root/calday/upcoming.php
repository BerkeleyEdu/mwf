<html>
<head> 
<title>Berkeley Mobile | CalDay</title>
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
    <link rel="stylesheet" href="http://m-qa.berkeley.edu/assets/css.php" type="text/css" media="screen" />
    <script type="application/javascript" src="http://m-qa.berkeley.edu/assets/js.php?no_ga"></script>
</script>
</head>
<body>

<h1 id="header">
        <a href="http://m-qa.berkeley.edu/">
        <img src="http://m-qa.berkeley.edu/assets/img/berkeley-home.png" alt="UC Berkeley" 
width="88" height="35" />         </a> 
<span><a href="index.php">Cal Day</a></span>    </h1>

<div class="content-full content-padded"> 
    <h1 class="content-first light">Upcoming Events</h1>    


<?php

// Server in the this format: <computer>\<instance name> or 
// <server>,<port> when using a non default port number
//$server = 'sql-qnon02.ist.berkeley.edu';
$server = 'sql-pnon02.ist.berkeley.edu';

// Connect to MSSQL
$link = mssql_connect($server, 'saral', 'Laras_$RO21932');

if (!$link || !mssql_select_db('Eventplanning', $link)) {
    die('Unable to connect or select database!');
}


// From:  http://www.web-max.ca/PHP/misc_2.php
// Calculate distance
function getDistanceBetweenPointsNew($lat1, $lon1, $lat2, $lon2) {	
	$distance = (3958*3.1415926*sqrt(($lat2-$lat1)*($lat2-$lat1) + cos($lat2/57.29578)*cos($lat1/57.29578)*($lon2-$lon1)*($lon2-$lon1))/180);

	print($distance);
}

// Convert string to number
function str2num($str){
if(strpos($str, '.') < strpos($str,',')){
		$str = str_replace('.','',$str);
		$str = strtr($str,',','.');           
	}
	else{
		$str = str_replace(',','',$str);           
	}
	return (float)$str;
}

$CalDayDate = 'Apr 16 2011';

//Next 30 minutes
//$thisStartTimeMin = $CalDayDate . ' ' . date("h:iA");
//$thisStartTimeMax = $CalDayDate . ' ' . date("h:iA", strtotime("+30 minutes"));

$thisStartTimeMin = $CalDayDate . ' ' . '10:00AM';
$thisStartTimeMax = $CalDayDate . ' ' . '11:00AM';

$query = "select EventTitle, DisplayTime, StartDateTime, EndDateTime, child.LocationName as childLocationName, parent.LocationName as parentLocationName from ";
$query .= " EventTimesLocations INNER JOIN Events on (EventTimesLocations.EventID = Events.EventID) ";
$query .= " LEFT OUTER JOIN CampusLocations as child on (EventTimesLocations.LocationID = child.LocationID) ";
$query .= " LEFT OUTER JOIN CampusLocations as parent on (child.ParentID = parent.LocationID) ";
$query .= " where StartDateTime > '". $thisStartTimeMin . "' and " . "StartDateTime < '". $thisStartTimeMax; 
$query .= "' order by StartDateTime, EndDateTime";

//print $query . "<br /><br />";

$data = mssql_query( $query, $link);       
$result = array();   

do {
    while ($row = mssql_fetch_object($data)){
        $result[] = $row;   
    }
}while ( mssql_next_result($data) );

mssql_close($link);  

// Coordinates
$loc_xml = @simplexml_load_file('http://www.berkeley.edu/data/ucb_map_coordinates.xml');

foreach ($result as $thisevent)
{	
	if ($thisevent->parentLocationName != '')
	{
		$event_location_name = utf8_decode($thisevent->parentLocationName);	
	}
	else
	{
		$event_location_name = utf8_decode($thisevent->childLocationName);	
	}
	
	$map_url = '';
	if ($event_location_name != '')
	{
		//get map info
		foreach ($loc_xml->Location as $locItem) 
		{										
	
			$map_location_name = utf8_decode($locItem->Name);
			
			//Event location
			$lat2 = str2num($locItem->Lat); 
			$lon2 = str2num($locItem->Lon);
	
			// event location is contained in map location name				
			$pos = strpos($map_location_name, $event_location_name);
			if ($pos !== false) 
			{
				$map_url = 'http://m.berkeley.edu/map/map.php?loc='.urlencode($map_location_name);				
				break;
			}
			// map location name is contained in event location name
			$pos2 = strpos($event_location_name, $map_location_name);
			if ($pos2 !== false) 
			{
				$map_url = 'http://m.berkeley.edu/map/map.php?loc='.urlencode($map_location_name);				
				break;
			}					
		}

	}
	
	// Check distance
	
	//Faking current location as Dwinelle Hall
	//$_GET['lat'] = '37.870350000000002'; 
	//$_GET['lon'] = '-122.26123'; 
	
	$distance = NULL;
	
	if ($_GET)
	{
		$lat1 = str2num($_GET['lat']);
		$lon1 = str2num($_GET['lon']);
		$distance = (3958*3.1415926*sqrt(($lat2-$lat1)*($lat2-$lat1) + cos($lat2/57.29578)*cos($lat1/57.29578)*($lon2-$lon1)*($lon2-$lon1))/180);
		// 24 minutes to walk 1 kilometer allowing for indirect route
		$walkingTime = round($distance*24);
	}
					
	if (str2num($distance) < 0.70 || $distance == NULL || $_GET['filter']=='none')
	{
		print '<p>';
		// Title
		print $thisevent->EventTitle . "<br />";
		
		// Time
		print $thisevent->DisplayTime . "<br />";
		
		// Location and map link
		if ($map_url != '')
		{
			print '<a href="' . $map_url . '">';
			print $thisevent->childLocationName . ' '  . $thisevent->parentLocationName . "</a><br />";
		}
		else
		{
			print $thisevent->childLocationName . ' '  . $thisevent->parentLocationName . "<br />";
		}
		if ($distance != NULL)
		{
			print '(' . $walkingTime .' minute walk)';
		}
		print '</p>';
	}
}

?>
</div>
</body>
</html>