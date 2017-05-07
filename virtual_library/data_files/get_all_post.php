<?php

session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}

require "database.php";
  

$accept = new vlibDatabase();
$return = $accept -> get_all_post($_GET['id']);

header("Content-type: text/xml");

echo $return;

?>
