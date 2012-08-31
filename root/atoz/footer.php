<?php
/**
 * Footer
 */
$footer = Site_Decorator::footer();

$footer->set_atoz('', '');
$footer->show_powered_by(false);
echo $footer->render();
?>

</body>

</html>