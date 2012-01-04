<?php 
require_once(dirname(dirname(__FILE__)).'/assets/lib/decorator.class.php');
require_once(dirname(dirname(__FILE__)).'/assets/config.php'); 
?>
<!DOCTYPE html>
<html manifest="../assets/appcache.php">

<head>
    <title><?php echo Config::get('about', 'title_text'); ?></title>
    <link rel="stylesheet" href="../assets/css.php" type="text/css" media="screen" />
    <?php
	if ($_SERVER['SERVER_NAME'] == 'mobile-qa.berkeley.edu'  || $_SERVER['SERVER_NAME'] == 'm-qa.berkeley.edu')  // development environment
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

<body>

	<h1 id="header">
        <a href="../">
        <img src="../assets/img/berkeley-home.png" alt="Berkeley" width="88" height="35" />        
        </a>
		<a href="index.php">
		<span>About</span>
		</a>
    </h1>
