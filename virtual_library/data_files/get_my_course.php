<?php

session_start();

if(!isset($_SESSION['username'])){
 session_destroy(); 
	header("Location: ../index.php");
}	
require "database_author.php";


$database = new Author();

$result = $database->my_course();
header("Content-type: text/xml");

echo $result;	

?>