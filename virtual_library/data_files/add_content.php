<?php
session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}

require "database_admin.php";
  
$name = $_POST['name'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$contact_num = $_POST['contact'];

$new_author = new Administrator();
$return = $new_author -> add_content_manager($name, $password, $contact_num, $email,$username);

if($return == 1) {
	echo "Congratulations content manager is added ,redirecting to home page";
	header( "refresh:5;url=../html/home_admin.php" );
	}
else {
	echo "content manager  already exist,redirecting to home page";
	header( "refresh:5;url=../html/home_admin.php" );
}


?>