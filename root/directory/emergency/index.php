<?php
require_once(dirname(dirname(dirname(__FILE__))).'/assets/lib/decorator.class.php');
?>

<!DOCTYPE html>

<html manifest="../assets/appcache.php">
<head>
    <title>Berkeley Mobile | Directory - Emergency Info</title>
    <link rel="stylesheet" href="../../assets/css.php" type="text/css" media="screen" /> 
	<?php
	if ($_SERVER['SERVER_NAME'] == 'mobile-qa.berkeley.edu')  // development environment
	{
		print '<script type="application/javascript" src="../../assets/js.php?no_ga"></script>';
	}
	else
	{
		print '<script type="application/javascript" src="../../assets/js.php"></script>';	
	}
	?>
    <meta name="viewport" content="height=device-height,width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;" />
    <link rel="stylesheet" href="../css/directory.css" type="text/css" media="screen" />
</head>

<body>

     <?php include('header.php'); ?>
    
	<div class="menu-full menu-detailed menu-padded"> 

        <h1 class="menu-first light">Emergency Info</h1>
    
	    <ol>
	        <li id="phone"><a href="tel:8007059998">Emergency Info Hotline: 800-705-9998</a></li>

	        <li id="phone" class="menu-last"><a href="tel:5106423333">Report Campus Emergencies: 510-642-3333</a></li>
	    </ol>
    
</div>    

    <a class="button-full button-padded" href="..">Go to Directory</a>
    
    <?php include('footer.php'); ?>

</body>

</html>