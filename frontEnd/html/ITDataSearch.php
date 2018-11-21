
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

	$errors = array();
	$message="";
	$query = "select employee_id, username, access_level ";
	$query .= "from system_access_data where ";
	// 1. Create a database connection
	$db = dbConnection();
	
	if($db){
		$message = "Connection Successful!";
		
	}
	$or_name = false;
	$or_id = false;
	$or_level = false;
	
	//username
	if(session_validation($_SESSION["username"])){
		$username = addslashes($_SESSION["username"]);
		$temp = addslashes($_SESSION["username"]);
	
		$or_name = true;
		$username = strtolower($username);
		// 2. Perform database query
	
		$query .= "LOWER (username) = '$username' ";
		
	
	}
	
	
	//id
	if(session_validation($_SESSION['id'])){
		$id = $_SESSION["id"];
		$or_id = true;
		if($or_name)
			$query .= " Or ";
		$query .="employee_id = $id";
	}

	//level
	if(session_validation($_SESSION['level'])){
		$level = $_SESSION['level'];
		if($or_name||$or_id)
			$query .=" Or ";
		$query .="access_level = $level";
	}
	
	$message.=$query;
//	echo $message;
	$result = mysqli_query($db, $query);
	
	if (!$result)
	{
		die ("Database query failed!");
//		$message.= " Database query failed!";
	}
	
	if(mysqli_num_rows($result) === 0){
			$errors["nomatch"] = "Error: No IT data Found with the keyword '$temp'.";
	}

?>



<?php

	include("header.php");
	//echo "<p id = 'welcome'>Welcome " . $username  . "!</p>";
?>
    <div class = "ITDataSearchMain">
		<div class = "search">
			<pre>
				<?php
					if(count($errors) === 0){
						//3. Process with query result if any
						echo "<table> ";
						echo "<caption><h2>System Access Data</h2></caption>";
						echo "<tr>";
						echo "<th> Employee ID </th>";
						echo "<th> Username </th>";
						echo "<th> Access Level </th>";
						echo "</tr>";
//					echo $message;
						while ($row = mysqli_fetch_array($result))
						{
							$employeeID = urlencode($row["employee_id"]);
						
							//output data from each row
							echo "<tr>";
							echo "<td>".htmlspecialchars($row["employee_id"])."</td>";
							echo "<td>".htmlspecialchars($row["username"])."</td>";
							echo "<td>".htmlspecialchars($row["access_level"])."</td>";
							//echo "<td>"."<a href='viewDetails.php?bookID=$bookID'>View Details</a>"."</td>";
							echo "</tr>";
							//$_SESSION["bookID"] = $bookID;
						}
						echo "</table><br><br>";	
					}else{
						errorDisplay2("nomatch", $errors);
					}
				?>
			</pre>
		</div>
	</div>
<?php

	include("footer.php");
?>

<?php 
	//4. Release returned data
	mysqli_free_result($result);
	
	//5. close database connection
	mysqli_close(dbConnection());
?>

<?php
	ob_end_flush();
?>