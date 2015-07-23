<?php

require_once(dirname(dirname(__FILE__)).'/assets/config.php');
include(dirname(__FILE__).'/header.php');
$letter = strtoupper($_GET['atoz']);
$atoz_link = 'http://www.berkeley.edu/a-z/' . $_GET['atoz'] .'.txt';
?>


        <div class="content-elements content-padded">
            <p class="content-last">  
            Please note that most sites in this <a href="index.php">A-Z index</a> are not optimized for viewing on a mobile device.
            </p>
        </div>
        
        <div class="content-elements content-padded">
            <h1 class="content-first"><?php echo $letter ?></h1>
            <div class="content-last">
                <?php 
				//include ($atoz_link);
				if (file_responding($atoz_link))
				{
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $atoz_link); 
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_exec($ch);
					curl_close($ch);
				}
				?>
             </div>
    	</div>


    <a class="button-full button-padded" href="index.php">Go to A-Z Index</a>

<?php include(dirname(__FILE__).'/footer.php'); ?>

</body>

</html>
