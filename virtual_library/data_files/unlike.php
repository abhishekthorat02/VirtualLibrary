<?php
session_start();

require("database.php");

if(!isset($_SESSION['username'])) {
     session_destroy(); 
     header("Location: ../index.php");
}

$comment_id = $_POST['comment_id'];

$unlike = new vlibDatabase();
$return = $unlike->unlike($comment_id);
header("Contnet-type: text/plain");
echo $return;

?>