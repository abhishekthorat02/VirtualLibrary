<?php
session_start();

require("database.php");

if(!isset($_SESSION['username'])) {
     session_destroy(); 
     header("Location: ../index.php");
}

$upload_id = $_POST['upload_id'];

$rate = new vlibDatabase();
$return = $rate->rate_slide($upload_id);
header("Content-type: text/plain");
echo $return;

?>