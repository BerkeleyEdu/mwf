<?php
/**
 * Footer
 */

$footer = Site_Decorator::berkeley_footer();
$footer->show_powered_by(false);
$footer->change_link('Full Site', 'http://newscenter.berkeley.edu/');
echo $footer->render();
?>

</body>

</html>