<?php

session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}

require "database_admin.php";
  

$get_list = new Administrator();
$return = $get_list -> user_list();
header("Content-type: text/xml");
echo $return;





?>
