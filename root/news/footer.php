<?php
/**
 * Footer
 */

$footer = Site_Decorator::footer();

$footer->set_full_site('Full Site', 'http://newscenter.berkeley.edu/');

echo $footer->render();
?>

</body>

</html>