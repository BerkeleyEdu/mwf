<?php

require_once(dirname(dirname(__FILE__)).'/assets/config.php');
include(dirname(__FILE__).'/header.php');
?>

		<div class="content-full content-padded">
        <h1 class="content-first">Schools, Colleges, &amp; Departments</h1>
    		<p class="content-last">Berkeley offers some 350 degree programs, listed here in this A-Z index.
		</p>
    	
    	</div>
		
		<div class="menu-full menu-detailed menu-padded">
		<h1 class="menu-first">A-Z</h1>
         <ol>
			<?php 
			foreach(range('a', 'z') as $letter) {
   				 echo '<li><a href="list_academic.php?atoz='. $letter. '" style="text-decoration:underline">' . strtoupper($letter) .'</a></li>';
			}
			?>
			</ol>
		 </div>
		  


    <a class="button-full button-padded" href="index.php">Go to A-Z Index</a>

<?php include(dirname(__FILE__).'/footer.php'); ?>

</body>

</html>
