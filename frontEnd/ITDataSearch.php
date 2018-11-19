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
	
	// 1. Create a database connection
	dbConnection();
	
	if(isset($_SESSION["keyword"])){
		$keyword = addslashes($_SESSION["keyword"]);
		$temp = addslashes($_SESSION["keyword"]);
	}
	
	$keyword = "%".strtolower($keyword)."%";
	// 2. Perform database query
	$query = "SELECT emlpoyee_id, username, access_level ";
	$query .= "FROM system_access_data ";
	$query .= "WHERE LOWER(username) LIKE '$keyword' ";
	$query .= "ORDER BY rating DESC";
	
	$result = mysqli_query(dbConnection(), $query);
	
	if (!$result)
	{
		die ("Database query failed!");
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