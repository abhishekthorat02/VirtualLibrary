<?php
session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}
require "database.php";

$post_forum_retrive = new vlibDatabase();
$return = $post_forum_retrive -> post_forum_retrive();
header("Content-type: text/plain");

echo $return;


?>