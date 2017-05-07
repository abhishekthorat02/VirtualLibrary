<?php

session_start();

if(!isset($_SESSION['username'])) {
   session_destroy(); 
	header("Location: ../index.php");

}

require("database.php");

$id = $_GET['dept_id'];
$database = new vlibDatabase();
$result = $database->all_course($id);
header("Content-type: text/xml");
echo $result;


?>
