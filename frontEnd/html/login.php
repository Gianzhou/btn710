<?php
session_start();
?>

<?php
require("lib.php");
$error = "";

if(isset($_POST['login'])){
    
    $post_user = trim($_POST["username"]); 
    $user_name = letterNumValid($post_user)? addslashes($post_user): "";
   
    

    $post_pwd = trim($_POST['password']);
    $pwd = letterNumValid($post_pwd)? addslashes($post_pwd): "";

    if(isset($user_name)&&isset($pwd)){
        echo "hello";
         $db = dbConnection();
         if(!$db) 
            $error = "connected success!!";

  /*           
		$query = "select * from system_access_data where LOWER(username) = '$user_name' and password = '$pwd'";
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result))
            echo $query;
   */           
            if(authentication($db, $user_name, $pwd))
            header('Location: index.php');
            else
            echo "authentication error";
          
    }
    else
        echo "world";

    $error = "Incorrect Username or Password.";
  
}  
?>

<?php
include("header.php");
?>
<div class = "main">

    <div id = "login-form">
        <h2> Sign In</h2>
        <form name = "login" method="post" action = "">
        
        <table>
        <tr>
            <td><label for = "usename">Username: </label></td><td><input type = "text" name = "username" value = "<?php echo $_POST['username'];?>"/></td>
        </tr>
        <tr>
            <td><label for = "password">Password: </label></td><td><input type = "password" name = "password" value = "<?php echo $_POST['password']; ?>"/></td>
        </tr>
        <tr>
            <td> </td><td><input type = "submit" name = "login" value = "Sign In"/></td>
        </tr>
        </table>
        <div style = "color: red;">
            <p><?php echo $error;?></p>
        </div>
        </form>

    </div>


</div>





