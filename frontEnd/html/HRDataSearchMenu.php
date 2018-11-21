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
	
	if(!isset($_SESSION['username'])){
	
		header('Location: login.php');
	}
?>

<?php

	$errors = array();

	if(isset($_POST["HRSubmit"])){
		//While writing to database, sanitize with generic function addslashes()
		$fname = trim($_POST["fname"]);
		$fname_key = letterValid($fname)? addslashes($fname):"";

		$lname = trim($_POST["lname"]);
		$lname_key = letterValid($lname)? addslashes($lname): "";
		
		$employmentid = trim($_POST["employmentid"]);
		$employmentid_key = numValid($employmentid)? $employmentid: "";

		$manager = trim($_POST["manager"]);
		$manager_key = letterWSpaceValid($manager)? addslashes($manager): "";
	
		if(!isPresent($fname_key)&&!isPresent($lname_key)&&!isPresent($employmentid_key)&&!isPresent($manager_key))
		{
			$errors["searchBox"] = "Error: Input keyword.";
		}else{
			$_SESSION["fname"] = $fname_key;
			$_SESSION["lname"] = $lname_key;
			$_SESSION["employmentid"] = $employmentid_key;
			$_SESSION["manager"] = $manager_key;
 			header('Location: HRDataSearch.php');
		}
		
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
		<div id = "HumanResourceDataSearch"><!-- the very top beginning of Human Resource Data Search -->
			<form name = "HumanResourceDataSearch" method = "post" action = "">
			<table>
			<tr>
				<th><p> Human Resource Data Search </p></th>
			</tr>
			<tr>
				<td><label for = "fname">First Name: </label></td><td><input type = "text" name = "fname" id = "fname" size = "20" placeholder = "First Name" value = "<?php echo htmlentities($_POST['fname']);?>"></td>
			</tr>
			<tr>
				<td><label for = "lname">Last Name: </label></td><td><input type = "text" name = "lname" id = "lname" size = "20" placeholder = "Last Name" value ="<?php echo htmlentities($_POST['lname']); ?>"></td>
			</tr>
			<tr>
				<td><label for = "employmentid"> Employment ID: </label></td><td><input type = "number" name = "employmentid" size = "5" placeholder = "Employment ID" value = "<?php echo htmlentities($_POST['employmentid']); ?>"></td>
			</tr>
			<tr>
				<td><label for = "manager"> Manager: </label></td><td><input type = "text" name = "manager" id = "manager" size = "20" plceholder = "manager" value = "<?php echo htmlentities($_POST['manager']); ?>"></td>
			</tr>
			<tr>
				<td></td><td><input type = "submit" name = "HRSubmit" value = "Search"/></td>
			</tr>
			</table>
				<?php errorDisplay("searchBox", $errors)?><br>
			</form>
		</div><!-- the end of Human Resource Data Search -->
			<!--<a href = "logoff.php">Logoff</a>-->
		</div>
	</div>
	
<?php
	include("footer.php");
?>

<?php
	ob_end_flush();
?>