<?php
//version 1.0
//1. create the form to get the user entered data
//2. pass to the global variable like post and session
?>
<?php
	ob_start(); 
	session_start();
?>

<?php
	require("lib.php");
	
	if(isset($_SESSION["username"])){
		$username = $_SESSION["username"];
	}else{
		header('Location: login.php');
	}
?>

<?php

	$errors = array();
	
	if($_POST){
		//While writing to database, sanitize with generic function addslashes()
		//
		$employid = trim($_POST["employid"]);
		$id_key = numValid($employid)? $employid: "";
		

		$username = trim($_POST["username"]);
		$user_key = letterNumValid($username)? addslashes($username): "";
		
		$alevel = trim($_POST['alevel']);
		$level_key = numValid($alevel)? $alevel: "";
		
		
		if(!isPresent($id_key)&&!isPresent($user_key)&&!isPresent($level_key))
		
		{
			$errors["searchBox"] = "Error: Input keyword.";
		}else{
			$_SESSION["id"] = $id_key;
			$_SESSION["username"] = $user_key;
			$_SESSION["level"] = $level_key;
 			header('Location: ITDataSearch.php');
		}
/*
$db = dbConnection();
$result = mysqli_query($db, "select password from system_access_data");
	while ($row = mysqli_fetch_array($result)){
		echo $row['password']."<br />";
	}
*/
		
	}
	
?>

<?php
	include("header.php");
	//echo "<p id = 'welcome'>Welcome " . $username  . "!</p>";
?>
	
    <div class = "main">
		<div class = "logout">
			<a href='/logout.php'>Log-Out</a>
		</div>
		<div class = "search-form">
		<div id = "ITDataSearch"> <!-- the top beginning of IT Data Search -->
			<h3>IT Data Search:</h3>
			<form name = "ITDataSearchMenu" method = "post" action = "">
			<table>
			<tr>
				<th><p>IT Data Search</p></th>
			</tr>
			<tr>
				<td><label for="employid">Employ ID: </label></td><td><input type="number" name="employid"  id = "employid" size="20" placeholder="Employ ID" value="<?php echo htmlentities($_POST['employid']); ?>" ></td>
			<tr>	
				<td><label for="username"> User Name: </label></td><td><input type="text" name="username" id = "username" size="20" placeholder="username" value="<?php echo htmlentities($_POST['username']); ?>"></td>
			</tr>
			<tr>
				<td><label for="alevel"> Access Level: </label></td><td><input type="number" name="alevel" id = "alevel" size="3" min="0" max="20" value="<?php echo htmlentities($_POST['alevel']); ?>"></td>
			</tr>	
				<td></td><td><input type="submit" value="Search"></td>
			</table>	
				<?php errorDisplay("searchBox", $errors)?><br>
			</form>
		</div> <!-- the end of ITDataSearch -->	

		
			<!--<a href = "logoff.php">Logoff</a>-->
		</div>
	</div>
	
<?php
	include("footer.php");
?>

<?php
	ob_end_flush();
?>