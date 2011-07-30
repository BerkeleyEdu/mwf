<?php
/**
 * Footer
 */
$footer = Site_Decorator::footer();

$footer->set_about('', '');

$footer->show_powered_by(true);

echo $footer->render();
?>

</body>

</html>