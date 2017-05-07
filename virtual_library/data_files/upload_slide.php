<?php

session_start();
if (!isset($_SESSION['username'])) {
    session_destroy();
    header("Location: ../index.php");   
}

require "database_author.php";
  
$title = $_POST['form-title'];
$id = $_POST['id'];
$description = $_POST['description'];
$tmpname = $_FILES['file']['tmp_name'];
$file_name = $_FILES['file']['name'];
$copy = 0;
$file_name = $copy.$file_name;

while(file_exists("../file_system/course/".$id."/slide/$file_name") == 1) {
				$copy++;				
				$file_name = $_FILES['file']['name'];
				$file_name = $copy.$file_name;
}

$upload = new Author();
$return = $upload -> upload_content($title,$id,$description,$file_name,$tmpname);
if($return == 1) {
	echo "Slide added ,redirecting to home page";
	header( "refresh:2;url=../html/home_author.php?upload_success=1" );
	}
else {
	echo "Something went wrong,redirecting to home page";
	header( "refresh:2;url=../html/home_author.php?upload_fail=1" );
}




?>