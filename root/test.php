<?php
require_once(dirname(__FILE__).'/assets/config.php');
require_once(dirname(__FILE__).'/assets/lib/user_agent.class.php');

echo "this is a test of User_Agent";

if(User_Agent::is_webkit())
{
	echo "<br />is_webkit";
}
else
{
	echo "<br />not webkit";
}


?>
