<?php

session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}

require "database_content.php";
  

$accept = new Content();
$return = $accept -> get_accepted_course();

header("Content-type: text/xml");

echo $return;




?>
