<?php
ob_start();
session_start();

require_once ("functions.php");

if (checkLoggedin())
{
	echo "<H2>You are already logged in - <A href = \"login.php?do=logout\">logout</A></h2><h3>Welcome to the password secure website</h3>";
}else
{
	echo "<H2>Welcome to session based login Server. HTTP and HTTPS support</H2>";
	echo "<H3>You are not logged in - <A href = \"login.php\">login</A></H3>";
	echo "<H3>You are not logged in - <A href = \"https://$_SERVER[SERVER_ADDR]/login.php\">secure login</A></H3>";
}
?>
