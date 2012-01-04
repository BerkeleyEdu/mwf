<?php require_once('../assets/config.php'); ?><!DOCTYPE html>
<html manifest="../assets/appcache.php">

<head>
    <title><?php echo Config::get('contact', 'title_text'); ?></title>
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
    
<script type="text/javascript" src="http://mobile.berkeley.edu/assets/min/js.php?basic=http%3A%2F%2F<?php echo $_SERVER['SERVER_NAME'];?>%2Fassets%2Fjs%2Fvalidate.contactForm.js"></script> 

</head>

<body>

	<h1 id="header">
        <a href="../">
       <img src="/assets/img/berkeley-home.png" alt="Berkeley" width="88" height="35" />       
        </a>
        <!--<img src="/assets/img/l2-mail.png" alt="" width="45" height="35"/>-->
        <a href="index.php">
		<span>Contact</span>
		</a>
    </h1>