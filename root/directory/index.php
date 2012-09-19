<?php
require_once(dirname(dirname(__FILE__)).'/assets/lib/decorator.class.php');
require_once(dirname(dirname(__FILE__)).'/assets/config.php');
?>

<html manifest="../assets/appcache.php">
<head>
     <title><?php echo Config::get('global', 'title_text') . Config::get('directory', 'title_text'); ?></title>
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
    <link rel="stylesheet" href="css/directory.css" type="text/css" media="screen" />
    <meta name="viewport" content="height=device-height,width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;" />
    
    <link rel="stylesheet" href="http://mobile.berkeley.edu/assets/min/css.php?touch=http%3A%2F%2Fm.ucla.edu%2Fdirectory%2Fcss%2Fdirectory.css" type="text/css" />
 
</head>

<body>

    <?php include('inc/header.php'); ?>

    <?php include('inc/search.php'); ?>
    
    <?php include('inc/useful.php'); ?>
    
    <a class="button-full button-padded" href="..">Go to Berkeley Mobile</a>
    
    <?php include('inc/footer.php'); ?>

</body>

</html>