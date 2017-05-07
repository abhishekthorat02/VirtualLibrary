<?php
session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}

require "database_content.php";
  
$show_spam = new Content();
$return = $show_spam -> show_spam_request();
header("Content-type: text/xml");
echo $return;




?>  
