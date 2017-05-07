<?php

session_start();
if (!isset($_SESSION['username'])) {
    session_destroy(); 
    header("Location: ../index.php");   
}

require "database.php";
  

$student = new vlibDatabase();
$return = $student -> post_comment($_POST['post_id'], $_POST['comment']);

header("Content-type: text/plain");

echo $return;



?>
