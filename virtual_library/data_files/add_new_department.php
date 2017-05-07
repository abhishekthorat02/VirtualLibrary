<?php
session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");

    
}

require "database_admin.php";
 $dept_name = $_POST['dept'];
 

$new_department = new Administrator();
$return = $new_department -> add_new_department($dept_name);
if($return == 1) {
	echo "Congratulations department is added ,redirecting to home page";
	header( "refresh:5;url=../html/home_admin.php" );
	}
else {
	echo "Department already exist,redirecting to home page";
	header( "refresh:5;url=../html/home_admin.php" );
}


?>
