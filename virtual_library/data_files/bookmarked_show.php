<?php
session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}
require "database.php";

$show_bookmark = new vlibDatabase();
$return = $show_bookmark -> show_bookmark();
header("Content-type: text/plain");

echo $return;


?>