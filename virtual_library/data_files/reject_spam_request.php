<?php

session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}

require "database_content.php";
  


$reject = new Content();
$return = $reject -> reject_spam_request($_POST['u_id']);






?>
