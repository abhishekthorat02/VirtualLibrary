<?php

session_start();
if(!isset($_SESSION['username'])) {

	session_destroy();
	header("Location: ../index.php");

}

require "database.php";

$student = new vlibDatabase();

$result = $student->get_course_upload_by_author($_POST['course_id']);

header("Content-type: text/xml");

echo $result;


?>