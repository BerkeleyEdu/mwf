<?php
/**
 * Footer
 */
$footer = Site_Decorator::footer();

$footer->set_full_site('Full Site', 'https://calnet.berkeley.edu/directory/');

echo $footer->render();
?>