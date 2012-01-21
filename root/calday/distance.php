<?php

// from: http://www.inkplant.com/code/calculate-the-distance-between-two-points.php

function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2) {
    $theta = $longitude1 - $longitude2;
    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    $feet = $miles * 5280;
    $yards = $feet / 3;
    $kilometers = $miles * 1.609344;
    $meters = $kilometers * 1000;
     //return compact('miles','feet','yards','kilometers','meters'); 
	return compact('feet'); 
}

//Dwinelle Hall vs. Morrison Hall
$point1 = array('lat' => 37.870350000000002, 'long' => -122.26123);
$point2 = array('lat' => 37.870869999999996, 'long' => -122.25644);
$distance = getDistanceBetweenPointsNew($point1['lat'], $point1['long'], $point2['lat'], $point2['long']);
foreach ($distance as $unit => $value) {
    echo $unit.': '.number_format($value,4).'<br />';
}

?> 
