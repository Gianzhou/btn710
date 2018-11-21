<?php
session_start();
?>
<?php
require("lib.php");
logout();
if(isset($_SESSION['username']))
    echo $_SESSION['username'];
else
    header('Location: index.php');

?>