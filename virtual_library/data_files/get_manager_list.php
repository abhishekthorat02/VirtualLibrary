<?php 

session_start();
if (!isset($_SESSION['username'])){
 	session_destroy(); 
    header("Location: ../index.php");
 }
else {
    require("database.php");
    
    $database = new vlibDatabase();
    $result = $database->get_manager_list();
    
    header("Content-type: text/xml");
    echo $result;
}
?>