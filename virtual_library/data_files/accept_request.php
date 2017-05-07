<?php

session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}

require "database_admin.php";
  

$accept = new Administrator();
$return = $accept -> accept_user($_POST['s_id']);






?>
