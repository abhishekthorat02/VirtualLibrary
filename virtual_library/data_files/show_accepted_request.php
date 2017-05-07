
<?php
session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}

require "database_content.php";
  
$show_accepted_course = new Content();
$return = $show_accepted_course -> accepted_course_request();
header("Content-type: text/xml");

echo $return;




?>  
