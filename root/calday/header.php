<?php 
require_once('../assets/config.php'); 
?><!DOCTYPE html>
<html manifest="../assets/appcache.php">

<head>
    <title>Cal Day</title>

	 <link rel="stylesheet" type="text/css" href="../assets/css.php?basic=http%3A%2F%2Fberkeley.edu%2Fcalday%2Fcss%2Fmobile%2Fbasic.css&standard=http%3A%2F%2Fberkeley.edu%2Fcalday%2Fcss%2Fmobile%2Fstandard.css&full=http%3A%2F%2Fberkeley.edu%2Fcalday%2Fcss%2Fmobile%2Ffull.css" />
    
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

<h1 id="header">	
    <a href="index.php"><img id="hdr-rt" src="http://calday.berkeley.edu/calday/img/mobile/hdr-rt.png"  alt="Berkeley" width="195" height="50">
	<img id="hdr-lft" src="http://calday.berkeley.edu/calday/img/mobile/hdr-lft.png"  alt="Cal Day Mobile" width="117" height="50">
    </a>
</h1>
<div id="subbnr"><h3>SAVE THE DATE | SATURDAY, APRIL 20TH</h3></div>