<?php

session_start();

require("database.php");

if(isset($_SESSION['username'])) {
    
    $database = new vlibDatabase();
    $type = $database->gettype($_SESSION['username']);
    if ($type == 1)
        header("Location: ../html/home.php");
    else if ($type == 2)
        header("Location: ../html/home_author.php");
    else if ($type == 3) {
        header("Location: ../html/home_content.php");
    } elseif($type == 4) {
        header("Location: ../html/home_admin.php");
    }
	else {
		header("Location: ../index.php");	
	}
}


$username = $_POST['username'];
$password = $_POST['password'];

$auth = new vlibDatabase();
$return = $auth->auth($username, $password);

if ($return == 1) {
    
    $_SESSION['username'] = $username;
    header("Location: ../html/home.php");
} elseif ($return == 2) {
    
    $_SESSION['username'] = $username;
    header("Location:../html/home_author.php");
} elseif ($return == 3) {
    
    $_SESSION['username'] = $username;
    header("Location:../html/home_content.php");
} elseif ($return == 4) {
    
    $_SESSION['username'] = $username;
    header("Location:../html/home_admin.php");
} elseif ($return == 5) {
    
	 session_destroy();
    header("Location:../index.php?not_approved=1");
} elseif ($return == 6) {
    
	 session_destroy();
    header("Location:../index.php?blocked=1");
}
else {
	 session_destroy();
    header("Location: ../index.php?invalid=1");
}
?>