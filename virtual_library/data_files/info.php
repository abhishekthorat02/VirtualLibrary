<?php
session_start();

if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");  
}

require("database.php");
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$department = $_POST['dept'];
$year = $_POST['year'];
$propic = $_FILES['propic']['tmp_name'];
$file_name = $_FILES['propic']['name'];
$email = $_POST['email'];
$password = $_SESSION['password'];
$username = $_SESSION['username'];

$signUp = new vlibDatabase();
$status = $signUp->signUp($fname, $lname, $department, $year, $propic, $email, $password, $username, $file_name);
unset($_SESSION['password']);

if ($status == 1) {
	 session_destroy();
    header("Location: ../index.php?signedup=1");
} elseif ($status == 0) {
	 echo "sorry something went wrong";
    header('refresh:2s url:"../index.php"');
	 session_destroy(); 
}
?>