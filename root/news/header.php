<?php require_once('../assets/config.php'); ?><!DOCTYPE html>
<html>
<head>
    <title><?php echo Config::get('news', 'title_text'); ?></title>
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
    <!--<link rel="stylesheet" href="css/newsroom.css" type="text/css" media="screen" />-->
</head>

<body>

	<h1 id="header">
        <a href="../">
        <img src="<?php echo Config::get('news', 'header_image_sub'); ?>" alt="<?php echo Config::get('news', 'header_image_sub_alt'); ?>" width="119" height="35" /> </a>
		<a href="index.php">
		<img src="../assets/img/l2-news.png" alt="" width="45" height="35"/>
		<span>News</span>
		</a>
		
    </h1>