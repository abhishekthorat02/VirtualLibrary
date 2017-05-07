<?php

session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}

require "database_content.php";
  

$accept = new Content();
$return = $accept -> reject_course_upload($_POST['upload_id'], $_POST['file_name']);






?>
