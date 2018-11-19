<?php
	ob_start(); 
	session_start();
?>

<?php
	require("lib.php");
	
	/*if(isset($_SESSION["username"])){
		$username = $_SESSION["username"];
	}else{
		header('Location: login.php');
	}*/
?>

<?php
	$errors = [];
	
	if($_POST){
		//While writing to database, sanitize with generic function addslashes()
		$keyword = addslashes(trim($_POST["searchBox"]));
		
		if(!isPresent($keyword))
		{
			$errors["searchBox"] = "Error: Input keyword.";
		}else{
			$_SESSION["keyword"] = $keyword;
			header('Location: ITDataSearch.php');
		}
	}
?>

<?php
	include("header.php");
	//echo "<p id = 'welcome'>Welcome " . $username  . "!</p>";
?>
    <div class = "main">
		<div class = "menu">
			<h3>IT Data Search:</h3>
				
			<h4>Search by Username:</h4>
			<form name = "ITDataSearchMenu" method = "post" action = "ITDataSearchMenu.php">
				<input type="text" name="searchBox"  size="20" placeholder="Search By Username" onclick='this.value = "";'>
				<input type="submit" value="Search"><br>
				<?php errorDisplay("searchBox", $errors)?><br>
			</form>
			
			<!--<a href = "logoff.php">Logoff</a>-->
		</div>
	</div>
	<br>
<?php
	include("footer.php");
?>

<?php
	ob_end_flush();
?>