<?php
/**
 * Footer
 */

$footer = Site_Decorator::footer();

$footer->set_full_site('Full Site', 'http://newscenter.berkeley.edu/');
$footer->show_powered_by(false);
echo $footer->render();
?>

</body>

</html>