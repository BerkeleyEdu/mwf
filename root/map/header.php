<?php 
require_once('../assets/config.php'); 
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo Config::get('map', 'title_text'); ?></title>
        <link rel="stylesheet" href="../assets/css.php" type="text/css" media="screen" />
        <?php echo $_SERVER['SERVER_NAME'] == 'mobile-qa.berkeley.edu' || $_SERVER['SERVER_NAME'] == 'm-qa.berkeley.edu'
              ? '<script type="application/javascript" src="../assets/js.php?no_ga"></script>'
              : '<script type="application/javascript" src="../assets/js.php"></script>'; ?>
              
        <script type="text/javascript" src="../assets/lib/location/location.js"></script>
        
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <style>
            html { height: 100% }
            body { height: 100%; margin: 0px; padding: 0px }
            #map_canvas { position: absolute; top: 38px; left: 0; right: 0; bottom: 44px; z-index: 1; overflow: hidden; }
            a.button-full#button-bottom { position: absolute !important; bottom: 0px; left: 0px; right: 0px; width: 100%; z-index: 2; }
        </style>
    </head>
    <body>
        
        <h1 id="header">
            <a href="../">
            <img src="../assets/img/berkeley-logo.png" alt="UC Berkeley" width="119" height="35" />
            <img src="../assets/img/l2-map.png" alt="" width="45" height="35"/>
            </a><span><a href="index.php">Maps &amp; Tour</a></span>
        </h1>