<?php

session_start();
if(!isset($_SESSION['username'])) {
     session_destroy(); 
     header("Location: ../index.php");
}
require("database.php");
$friend = new vlibDatabase();
$return = $friend -> get_friend_list();
header("Content-type: text/xml");
echo $return;


?>