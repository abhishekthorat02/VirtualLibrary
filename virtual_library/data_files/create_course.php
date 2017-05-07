<?php
session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}

require "database_author.php";

$title = $_POST['title'];
$description = $_POST['description'];
$dept_name = $_POST['dept'];
$year = $_POST['year'];

$create_course = new Author();
$return = $create_course -> create_course($title,$description,$dept_name,$year);

if($return == 1) {
	echo "Congratulations new course is added ,redirecting to home page";
	header( "refresh:2;url=../html/home_author.php" );
	}
else {
	echo "course  already exist,redirecting to home page";
	header( "refresh:2;url=../html/home_author.php" );
}

?>