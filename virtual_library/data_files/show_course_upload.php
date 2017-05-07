<?php

session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}

require "database_author.php";
  
$id = $_POST['id'];
$show = new Author();
$return = $show -> show_course_upload($id);

header("Content-type: text/xml");
echo $return;






?>