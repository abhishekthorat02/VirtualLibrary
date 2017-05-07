<?php
session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}
require "database_content.php";

$paper_request = new Content();
$return = $paper_request -> research_request();
header("Content-type: text/plain");

echo $return;


?>