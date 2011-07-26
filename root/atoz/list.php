<?php

require_once(dirname(dirname(__FILE__)).'/assets/config.php');
include(dirname(__FILE__).'/header.php');
$letter = strtoupper($_GET['atoz']);
$atoz_link = 'http://berkeley.edu/a-z/' . $_GET['atoz'] .'.txt';
?>


        <div class="content-elements content-padded">
        <div class="content-last">  
		Please note that most sites in this <a href="index.php">A-Z index</a> are not optimized for viewing on a mobile device.
        </div>
		<h1 class="content-first"><?php echo $letter ?></h1>
		<div class="content-last">
			<?php include ($atoz_link);?>
		 </div>
    	</div>


    <a class="button-full button-padded" href="index.php">Go Back to A-Z Index</a>

<?php include(dirname(__FILE__).'/footer.php'); ?>

</body>

</html>
