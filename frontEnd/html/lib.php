<?php
	function isPresent($var)
	{
        $trimVar = trim($var);
		return isset($var) && !empty($trimVar);
	}
	function get_current_path()
	{
		return getcwd();
	}
	function session_validation($var){
		return isset($var) && trim($var) != "";
	}
	
	function dateValid($var)
	{
		$pattern = "/^(0?[1-9]|1[012])[\/](0?[1-9]|[12][0-9]|3[01])[\/]\d{4}$/";
		return preg_match($pattern, $var) == 1;
	}
	function numValid($var){
			return preg_match("/^(?:0|[1-9][0-9]*)$/", $var)? true: false; 
	}
	function letterValid($var){
		return preg_match("/^[a-zA-Z]+$/", $var)? true: false;
	}
	function letterNumValid($var){
		return preg_match("/^[a-zA-Z\d]+$/", $var)? true: false;
	}
	function letterWSpaceValid($var){
		return preg_match("/^[a-zA-Z][a-zA-Z\s\']*[a-zA-Z]$/", $var)? true: false;
	}
	
	function isbnLen($num)
	{
		return strlen(trim($num)) < 13 && is_numeric($num);
	}
	
	function postNum($num)
	{
		return is_numeric(trim($num)) && trim($num) > 0;
	}
	
	/*function isbnExist($var)
	{
		return mysqli_num_rows($var) != 0;
	}*/
	
	function errorDisplay($errArrKey, $errArr)
	{
		if(array_key_exists($errArrKey, $errArr))
		{
			echo "<span style = 'color:red'> * ";
			echo $errArr[$errArrKey];
			echo "</span>";
		}
	}
	
	function errorDisplay2($errArrKey, $errArr)
	{
		if(array_key_exists($errArrKey, $errArr))
		{
			echo "<h2 style = 'color:red'> * ";
			echo $errArr[$errArrKey];
			echo "</h2>";
		}
	}
//version 1	
	function dbConnection()
	{
		$lines=file('./topsecret.text');
	
		$dbhost=trim($lines[0]);
		$dbuser=trim($lines[1]);
		$dbpass=trim($lines[2]);
		$dbname=trim($lines[3]);
	
		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
		
		if (mysqli_connect_errno())
		{
			die("Database connection failed: ".
				mysqli_connect_error().
				" ( ". mysqli_connect_errno(). " )"
			);
		}
		
		return $connection;
	}

	function authentication($db, $user, $pwd){
		$mdpwd = md5($pwd);
		$connect = false;
		$query = "select * from system_access_data where LOWER(username) = '$user' and password = '$mdpwd'";
		$result = mysqli_query($db, $query);
		if(mysqli_num_rows($result)){
			$connect = true;
			$_SESSION['username'] = md5($user).time();
		}

		return $connect;
	}

	function logout(){
		unset($_SESSION["username"]);
		if(isset($_SESSION['username']))
			return false;
		return true;
	}

//	
	
	
	class DB{
		private $dbHost;
		private $dbUser;
		private $dbPassword;
		private $dbName;
		private $dbConnection;
		private $dbError;
		
		public function connectDB(){
			$lines=file('/home/bti320_163b24/secret/topsecret.txt');
			
			$this->dbHost = trim($lines[0]);
			$this->dbUser = trim($lines[1]);
			$this->dbPassword = trim($lines[2]);
			$this->dbName = trim($lines[3]);
			
			/*$connection = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);
			
			if (mysqli_connect_errno())
			{
				$this->dbError="Database connection failed: ".
					mysqli_connect_error().
					" ( ". mysqli_connect_errno(). " )";
					
				die("Database connection failed: ".
					mysqli_connect_error().
					" ( ". mysqli_connect_errno(). " )");
			}*/
			
			$connection = new mysqli($this->dbHost, $this->dbUser, $this->dbPassword, $this->dbName);
			
			/*if ($connection->connect_errno){
				$this->dbError="Database connection failed: ".
					mysqli_connect_error().
					" ( ". mysqli_connect_errno(). " )";
			}*/
			
			$this->connectionCheck($connection);
			return $connection;
		}
		
		public function connectionCheck($connect){
			if ($connect->connect_errno){
				$this->dbError="Database connection failed: ".
					mysqli_connect_error().
					" ( ". mysqli_connect_errno(). " )";
			}
		}
		
		public function __construct(){
			$this->dbHost = "";
			$this->dbUser = "";
			$this->dbPassword = "";
			$this->dbName = "";
			$this->dbConnection = $this->connectDB();
			$this->dbError = "";
		}
		
		
		
		public function query($queryStr){
			//$result = mysqli_query($dbConnection, $queryStr);
			$result = $this->dbConnection->query($queryStr);
			if (!$result)
			{
				$this->dbError="Database query failed!";
				// die ("Database query failed!");
			}
			return $result;
		}
		
		public function getErrorMsg(){
			return $this->dbError;
		}
		
		public function __destruct(){
			/*if($dbConnection){
				mysqli_close($dbConnection);
			}*/
			if($this->dbConnection){
				$this->dbConnection->close();
				//echo "Disconnected!<br>";
			}
		}
		
		public function num_rows($resultSet){
			$val = $resultSet->num_rows;
			return $val;
		}
	}
?>
