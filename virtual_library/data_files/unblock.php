<?php

session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}

require "database_admin.php";
  

$unblock = new Administrator();
$return = $unblock -> unblock_user($_POST['s_id']);






?>