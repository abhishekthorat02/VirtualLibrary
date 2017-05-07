<?php

session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}

require "database_admin.php";
  

$reject = new Administrator();
$return = $reject -> reject_user($_POST['s_id']);






?>