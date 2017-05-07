<?php

session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}

require "database.php";


$student = new vlibDatabase();
$return = $student -> get_comment($_POST['post_id']);

header("Content-type: text/xml");

echo $return;


?>