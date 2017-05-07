<?php

session_start();

if(!isset($_SESSION['username'])){ 
 session_destroy(); 
	header("Location: ../index.php");

}

require "database_author.php";


$database = new Author();

$return = $database->delete_course($_POST['course_id']);

header("Location: ../html/home_author.php");



?>
