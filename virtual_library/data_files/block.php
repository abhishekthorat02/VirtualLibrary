<?php

session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}

require "database_admin.php";
  

$block = new Administrator();
$return = $block -> block_user($_POST['s_id']);






?>