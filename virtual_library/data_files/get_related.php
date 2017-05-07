<?php

session_start();
if (!isset($_SESSION['username'])){
 session_destroy(); 
    header("Location: ../index.php");
    }
else {
    require("database.php");
    
    $database = new vlibDatabase();
    $result = $database->related_course();
    
    header("Content-type: text/xml");
    echo $result;
}
?>