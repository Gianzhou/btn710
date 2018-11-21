
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
$query = "select first_name, last_name, employment_id, manager ";
$query .= "from staff_data where ";
// 1. Create a database connection
$db = dbConnection();

if($db){
    $message = "Connection Successful!";
    
}
$or_fname = false;
$or_lname = false;
$or_manager = false;
$or_employmentid = false;

//echo $_SESSION['fname'];
//fname
if(session_validation($_SESSION["fname"])){
    $fname = addslashes($_SESSION["fname"]);
    $temp = addslashes($_SESSION["fname"]);
    $or_fname = true;
    $username = strtolower($fname);
    // 2. Perform database query

    $query .= "LOWER (first_name) = '$fname' ";
    

}


//lname
if(session_validation($_SESSION['lname'])){
    $lname = $_SESSION["lname"];
    $or_lname = true;
    if($or_fname)
        $query .= " Or ";
    $query .="LOWER(last_name) = '$lname' ";
}

//employmentid
if(session_validation($_SESSION['employmentid'])){
    $employmentid = $_SESSION['employmentid'];
    $or_employmentid = true;
    if($or_fname||$or_lname)
        $query .=" Or ";
    $query .="employment_id = $employmentid";
}

//manager
if(session_validation($_SESSION['manager'])){
    $manager = $_SESSION['manager'];
    $or_manager = true;
    if($or_fname||$or_lname||$or_employmentid)
        $query .= " Or ";
    $query .="LOWER(manager) = '$manager' ";
}

//$message.=$query;
//echo $message;

$result = mysqli_query($db, $query);

if (!$result)
{
    die ("Database query failed!");
//    $message.= " Database query failed!";
}

if(mysqli_num_rows($result) === 0){
        $errors["nomatch"] = "Error: No IT data Found with the keyword '$temp'.";
}

?>



<?php

include("header.php");
//echo "<p id = 'welcome'>Welcome " . $username  . "!</p>";


?>
<div class = "HRDataSearchMain">
    <div class = "search">
        <pre>
            <?php
                if(count($errors) === 0){
                    //3. Process with query result if any
                    echo "<table> ";
                    echo "<caption><h2>Human Resource Data</h2></caption>";
                    echo "<tr>";
                    echo "<th> First Name </th>";
                    echo "<th> Last Name </th>";
                    echo "<th> Employment Id </th>";
                    echo "<td> Manager </th>";
                    echo "</tr>";
//					echo $message;
                    while ($row = mysqli_fetch_array($result))
                    {
 //                       $ID = urlencode($row["id"]);
                    
                        //output data from each row
                        echo "<tr>";
                        echo "<td>".htmlspecialchars($row["first_name"])."</td>";
                        echo "<td>".htmlspecialchars($row["last_name"])."</td>";
                        echo "<td>".htmlspecialchars($row["employment_id"])."</td>";
                        echo "<td>".htmlspecialchars($row["manager"])."</td>";
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