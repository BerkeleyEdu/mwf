<?php
/**
 * Footer
 */
$footer = Site_Decorator::berkeley_footer();
$footer->remove_link('A-Z');
$footer->show_powered_by(false);
echo $footer->render();
?>

</body>

</html>