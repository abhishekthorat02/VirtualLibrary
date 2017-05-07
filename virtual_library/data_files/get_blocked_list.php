<?php

session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}

require "database_admin.php";
  

$get_blocked = new Administrator();
$return = $get_blocked -> show_blocked_users();
header("Content-type: text/xml");
echo $return;





?>