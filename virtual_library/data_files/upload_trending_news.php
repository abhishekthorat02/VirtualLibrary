<?php

session_start();
if (!isset($_SESSION['username'])) {
    session_destroy();
    header("Location: ../index.php");   
}

require "database_author.php";
  
$title = $_POST['title'];
$tags = $_POST['tags'];
$description = $_POST['description'];
$link = $_POST['links'];
$tmpname = $_FILES['file']['tmp_name'];
$file_name = $_FILES['file']['name'];
$copy = 0;
$file_name = $copy.$file_name;

while(file_exists("../file_system/trending/$file_name") == 1) {
				$copy++;				
				$file_name = $_FILES['file']['name'];
				$file_name = $copy.$file_name;
}

$upload = new Author();
$return = $upload -> trending_news($title,$tags,$description,$file_name,$tmpname,$link);
if($return == 1) {
	echo "content added ,redirecting to home page";
	header( "refresh:2;url=../html/home_author.php" );
	}
else {
	echo "Something went wrong,redirecting to home page";
 header( "refresh:2;url=../html/home_author.php" );
}




?>