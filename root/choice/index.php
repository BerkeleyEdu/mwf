<?php

require_once(dirname(dirname(__FILE__)).'/assets/config.php');
include(dirname(__FILE__).'/header.php');
?>
        
         <div class="menu-full menu-detailed menu-padded">
            <h1 class="light menu-first">Select a version:</h1>
             <ol>
    			<li><a href="../index.php">Mobile Site</a></li>     
            <?php
			if ($_SERVER['SERVER_NAME'] == 'mobile-qa.berkeley.edu'  || $_SERVER['SERVER_NAME'] == 'm-qa.berkeley.edu')  // development environment
			{
				print '<li class="menu-last"><a href="http://homepage-dev.berkeley.edu/?ovrrdr=1">Full Dev Site</a></li>';
			}
			else
			{
				print '<li class="menu-last"><a href="http://www.berkeley.edu/?ovrrdr=1">Full Site</a></li>';	
			}
			?>
            </ol>
        </div>

	<div id="footer">
        <p><?php echo Config::get('global', 'copyright_text') ?></p>
    </div>

</body>

</html>
