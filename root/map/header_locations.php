<?php 
require_once(dirname(dirname(__FILE__)).'/assets/lib/decorator.class.php');
require_once(dirname(dirname(__FILE__)).'/assets/config.php');  
?>
<!DOCTYPE html>
<html>

<head>
    <title><?php echo Config::get('map', 'title_text'); ?></title>
    <link rel="stylesheet" href="../assets/css.php" type="text/css" media="screen" />
    <?php
	if ($_SERVER['SERVER_NAME'] == 'mobile-qa.berkeley.edu'  || $_SERVER['SERVER_NAME'] == 'm-qa.berkeley.edu')  // development environment
	{
		print '<script type="application/javascript" src="../assets/js.php?no_ga&touch_libs=jquery"></script>';
	}
	else
	{
		print '<script type="application/javascript" src="../assets/js.php?touch_libs=jquery"></script>';
	}
	?>
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;" />
</head>

<body>

	<h1 id="header">
        <a href="../">
        <img src="../assets/img/berkeley-home.png" alt="Berkeley" width="88" height="35" />
        </a>
		<a href="index.php"> 
		<!--<img src="../assets/img/l2-map.png" alt="" width="45" height="35"/>-->
		<span>Maps &amp; Tour</span>
		</a>
    </h1>