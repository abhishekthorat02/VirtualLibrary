<?php

session_start();

if(!isset($_SESSION['username'])){ 
 session_destroy(); 
	header("Location: ../index.php");

}

require "database_author.php";


$restrict = new Author();

$return = $restrict->allow_download($_POST['upload_id']);
header("Contnet-type: text/plain");
echo $return;




?>
