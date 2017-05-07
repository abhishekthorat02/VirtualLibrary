<?php
session_start();

require("database.php");

if(!isset($_SESSION['username'])) {
     session_destroy(); 
     header("Location: ../index.php");
}

$comment_id = $_POST['comment_id'];

$like = new vlibDatabase();
$return = $like->like($comment_id);
header("Contnet-type: text/plain");
echo $return;

?>