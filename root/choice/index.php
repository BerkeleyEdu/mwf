<?php

require_once(dirname(dirname(__FILE__)).'/assets/config.php');
include(dirname(__FILE__).'/header.php');
?>

		<div class="content-full content-padded">
        <h1 class="menu-first">Select a version:</h1>
        <ol> 
			<a href="../index.php">Mobile Site</a>
		</ol>
         <ol>       
            <?php
			if ($_SERVER['SERVER_NAME'] == 'mobile-qa.berkeley.edu'  || $_SERVER['SERVER_NAME'] == 'm-qa.berkeley.edu')  // development environment
			{
				print '<a href="http://homepage-dev.berkeley.edu/?ovrrdr=1">Full Dev Site</a>';
			}
			else
			{
				print '<a href="http://www.berkeley.edu/?ovrrdr=1">Full Site</a>';	
			}
			?>
		 </ol>          
		 </div>

	<div id="footer">
        <p><?php echo Config::get('global', 'copyright_text') ?></p>
    </div>

</body>

</html>
