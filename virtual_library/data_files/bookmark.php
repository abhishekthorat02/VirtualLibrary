<?php
session_start();

require("database.php");

if(!isset($_SESSION['username'])) {
     session_destroy(); 
     header("Location: ../index.php");
}

$upload_id = $_POST['upload_id'];

$bookmark = new vlibDatabase();
$return = $bookmark->bookmark($upload_id);
header("Contnet-type: text/plain");
echo $return;

?>