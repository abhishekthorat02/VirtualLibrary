<?php

session_start();
if (!isset($_SESSION['username'])) {
    session_destroy(); 
    header("Location: ../index.php");   
	
}

require "database_admin.php";
  

$get_user_request = new Administrator();
$return = $get_user_request -> get_user_request();
header("Content-type: text/xml");
echo $return;

?>