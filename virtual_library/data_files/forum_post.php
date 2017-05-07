<?php
session_start();
if (!isset($_SESSION['username'])) {
     session_destroy(); 
    header("Location: ../index.php");   
}

require "database.php";
  
$name = $_POST['subject'];
$description = $_POST['description'];
$tmpname = $_FILES['file']['tmp_name'];
$file_name = $_FILES['file']['name'];
$copy = 0;
$file_name = $copy.$file_name;

while(file_exists("../file_system/forum/$file_name") == 1) {
				$copy++;				
				$file_name = $_FILES['file']['name'];
				$file_name = $copy.$file_name;
}

$post_forum = new vlibDatabase();
$return = $post_forum -> post_forum($name, $description,$file_name,$tmpname);

if($return == 1) {
	echo "post added,redirecting to home page";
	header( "refresh:2;url=../html/home.php" );
	}
else {
	echo "something went wrong ,redirecting to home page";
	header( "refresh:2;url=../html/home.php" );
}


?>