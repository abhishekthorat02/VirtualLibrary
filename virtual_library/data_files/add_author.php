<?php
session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}

require "database_admin.php";
  
$name = $_POST['name'];
$department = $_POST['department'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$contact_num = $_POST['contact'];

$new_author = new Administrator();
$return = $new_author -> add_author($name,$email,$username,$password,$contact_num,$department);
if($return == 1) {
	echo "Congratulations new author is added ,redirecting to home page";
	header( "refresh:2;url=../html/home_admin.php" );
	}
else {
	echo "author  already exist,redirecting to home page";
	header( "refresh:2;url=../html/home_admin.php" );
}


?>