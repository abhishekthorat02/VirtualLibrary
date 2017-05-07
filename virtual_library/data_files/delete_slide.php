<?php

session_start();

if(!isset($_SESSION['username'])){ 
 session_destroy(); 
	header("Location: ../index.php");

}

require "database_author.php";


$delete = new Author();

$return = $delete->delete_slide($_POST['upload_id']);





?>
