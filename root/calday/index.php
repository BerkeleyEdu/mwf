<?php

require_once(dirname(dirname(__FILE__)).'/assets/config.php');

include(dirname(__FILE__).'/header.php');

?>


        <div class="menu-full menu-detailed menu-padded">
         <ol>
             <li><a href="locations.php">Locations</a></li>
        </ol>
    	</div>


    <a class="button-full button-padded" href="..">Go to UCB Mobile</a>

	<div id="footer">
        <p><?php echo Config::get('global', 'copyright_text') ?><br />
           <a href="<?php echo Config::get('frontpage', 'contact_url') ?>">Contact</a>&nbsp;|&nbsp;<a href="http://calday.berkeley.edu?ovrrdr=1">View Full Site</a></p>
    </div>

</body>

</html>