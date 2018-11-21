<?php
ob_start();
session_start();

require_once ("functions.php");

echo "<center>";

if (checkLoggedin())
{
    echo "<H2>You are already logged in - <A href = \"login.php?do=logout\" align=center>logout</A></H2><br><H3><p>Welcome to the SSL secured web server</p></H3><br>";
} else
{
    echo "<H2>You are not logged in - <A href = \"login.php\">login</A></H2>;
}
echo "</center>";
?> 
