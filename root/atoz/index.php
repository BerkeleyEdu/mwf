<?php
require_once(dirname(dirname(__FILE__)).'/assets/config.php');
include(dirname(__FILE__).'/header.php');
?>

		<div class="content-full content-padded">
        <div class="content-last">
    	<p>This A-Z Index includes hundreds of official campus sites.</p>  
		<p>See also <strong><a href="academic.php">Schools, Colleges, &amp; Departments</a></strong></p>
        
    	</div>
    	</div>
		
		<div class="menu-full menu-detailed menu-padded">
		<h1 class="menu-first">A-Z</h1>
         <ol>
			<?php 
			foreach(range('a', 'z') as $letter) {
   				 echo '<li><a href="list.php?atoz='. $letter. '" style="text-decoration:underline">' . strtoupper($letter) .'</a></li>';
			}
			?>
			</ol>
		 </div>
		  


    <a class="button-full button-padded" href="..">Go to UCB Mobile</a>

<?php include(dirname(__FILE__).'/footer.php'); ?>

</body>

</html>
