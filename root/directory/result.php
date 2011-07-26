<?php

session_start();

if(!isset($_GET['u']))
    die();

include('ucb_directory.class.php');

$searcher = new UCLA_Directory();

?><!DOCTYPE html>

<html>
<head>
    <title>UCB Mobile | Directory</title>
    <link rel="stylesheet" href="../assets/css.php" type="text/css" media="screen" />
	<?php
	if ($_SERVER['SERVER_NAME'] == 'mobile-qa.berkeley.edu')  // development environment
	{
		print '<script type="application/javascript" src="../assets/js.php?no_ga&webkit_libs=transitions"></script>';
	}
	else
	{
		print '<script type="application/javascript" src="../assets/js.php&webkit_libs=transitions"></script>';	
	}
	?>
    <meta name="viewport" content="height=device-height,width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;" />
    <link rel="stylesheet" href="css/directory.css" type="text/css" media="screen" />
</head>

<body>

    <?php include('inc/header.php'); ?>

    <!-- RESULT DETAILS -->
    <?php include('inc/result.php'); ?>
        
    <div class="clear"></div>

    <a class="button-full button-padded" href="results.php">Go Back to Results</a>

    <?php include('inc/footer.php'); ?>

</body>

</html>