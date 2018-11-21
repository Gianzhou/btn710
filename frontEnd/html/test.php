<?php
session_start()
?>
<!DOCTYPE html>
<body>
<?php
    echo $_SESSION["username"];
	echo $_SESSION["id"];
	echo $_SESSION['level'];
foreach($_SESSION as $key => $var){
    echo $key ."=>". $var;
}
?>
</body>
</html>