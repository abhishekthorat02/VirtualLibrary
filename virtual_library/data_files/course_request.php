<?php
session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}

require "database_content.php";
  
$show_course_request = new Content();
$return = $show_course_request -> course_request();
header("Content-type: text/xml");
echo $return;




?>  
