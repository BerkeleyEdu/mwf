<?php 
require_once('../assets/config.php'); 
?><!DOCTYPE html>
<html manifest="../assets/appcache.php">

<head>
    <title>Cal Day</title>

	 <link rel="stylesheet" type="text/css" href="http://m.ucla.edu/assets/css.php?basic=http%3A%2F%2Fberkeley.edu%2Fcalday%2Fcss%2Fmobile%2Fbasic.css" />
    
    <?php
	if ($_SERVER['SERVER_NAME'] == 'mobile-qa.berkeley.edu')  // development environment
	{
		print '<script type="application/javascript" src="../assets/js.php?no_ga"></script>';
	}
	else
	{
		print '<script type="application/javascript" src="../assets/js.php"></script>';	
	}
	?>
    <meta name="viewport" content="height=device-height,width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;" />

</head>

<body class="second-level">

<h1 id="header"><a href="http://calday.berkeley.edu"><img src="http://berkeley.edu/calday/img/calday-app-secondary-logo.jpg" alt="Cal Day Mobile"></a></h1>
<div id="blubnr">Saturday, April 21</div>