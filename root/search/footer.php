<?php
/**
 * Footer
 */
$footer = Site_Decorator::berkeley_footer();

$footer->remove_link('Search');

$footer->show_powered_by(false);

echo $footer->render();
?>

</body>

</html>