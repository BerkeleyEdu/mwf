<?php require_once('../assets/config.php'); ?><!DOCTYPE html>
<html>

<head>
    <title><?php echo Config::get('choice', 'title_text'); ?></title>
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

<body class="choice-page">

<h1 id="header"><img src="../assets/img/berkeley-mobile-logo.png" alt="Berkeley Mobile" width="267" height="50" /><span>Berkeley Mobile</span></h1>
