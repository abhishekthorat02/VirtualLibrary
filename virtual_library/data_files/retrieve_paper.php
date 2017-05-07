<?php
session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}
require "database.php";

$show_paper = new vlibDatabase();
$return = $show_paper -> retrieve_paper();
header("Content-type: text/plain");

echo $return;


?>