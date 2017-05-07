<?php
session_start();

require("database.php");

if(!isset($_SESSION['username'])) {
     session_destroy(); 
     header("Location: ../index.php");
}

$c_id = $_POST['course_id'];

$enroll = new vlibDatabase();
$return = $enroll->enroll_course($c_id);
header("Contnet-type: text/plain");
echo $return;

?>