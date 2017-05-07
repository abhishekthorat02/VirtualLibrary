<?php
session_start();

require("database.php");

if(!isset($_SESSION['username'])) {
     session_destroy(); 
     header("Location: ../index.php");
}

$c_id = $_POST['course_id'];

$unenroll = new vlibDatabase();
$return = $unenroll->unenroll_course($c_id);
header("Contnet-type: text/plain");
echo $return;






?>