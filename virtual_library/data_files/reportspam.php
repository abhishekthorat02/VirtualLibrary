<?php
session_start();

require("database.php");

if(!isset($_SESSION['username'])) {
     session_destroy(); 
     header("Location: ../index.php");
}

$upload_id = $_POST['upload_id'];

$spam = new vlibDatabase();
$return = $spam->report_spam($upload_id);
header("Contnet-type: text/plain");
echo $return;

?>