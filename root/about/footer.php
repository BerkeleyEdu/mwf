<?php
/**
 * Footer
 */
$footer = Site_Decorator::berkeley_footer();

$footer->remove_link('About');

$footer->show_powered_by(true);

echo $footer->render();
?>

</body>

</html>