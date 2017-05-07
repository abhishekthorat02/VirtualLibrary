<?php

session_start();

require("database.php");

if(!isset($_SESSION['username'])) {
	  session_destroy();    
     header("Location: ../index.php");
}

$title = $_POST['title'];
$tag = $_POST['tags'];
$description = $_POST['description'];
$tmp_name = $_FILES['file']['tmp_name'];
$file_name = $_FILES['file']['name'];
$copy = 0;
$file_name = $copy.$file_name;


while(file_exists("../file_system/student/".$_SESSION['username']."/papers/$file_name") == 1) {
				$copy++;				
				$file_name = $_FILES['file']['name'];
				$file_name = $copy.$file_name;
}

$upload = new vlibDatabase();
$return = $upload->upload_papers($title, $tag, $description, $tmp_name, $file_name);
if($return == 1) {
header("Location: ../html/home.php?upload=1");
}
else {
	header("Location: ../html/home.php?upload=0");
}

?>