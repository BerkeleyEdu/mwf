<?php

require_once(dirname(dirname(__FILE__)).'/assets/config.php');
include(dirname(__FILE__).'/header.php');
$letter = strtoupper($_GET['atoz']);
$atoz_link = 'http://berkeley.edu/academics/dept/' . $_GET['atoz'] .'.txt';
?>


        <div class="content-elements content-padded">
           <h1 class="content-first"><a href="academic.php">Schools, Colleges, &amp; Departments</a></h1>
            <p class="content-last"> 
            Please note that most sites in this <a href="academic.php">A-Z index</a> are not optimized for viewing on a mobile device.
            </p>        
        </div>
        
        <div class="content-elements content-padded">
            <h1 class="content-first"><?php echo $letter ?></h1>
            <div class="content-last"> 
                <?php include ($atoz_link);?>
            </div>
    	</div>


    <a class="button-full button-padded" href="academic.php">Go Back to Schools, Colleges, &amp; Departments</a>

<?php include(dirname(__FILE__).'/footer.php'); ?>

</body>

</html>
