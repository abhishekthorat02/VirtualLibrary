<?php

session_start();

require "database_author.php";

if(!isset($_SESSION['username'])) {
 session_destroy(); 
	header("Location: ../index.php");

}

$i = 0;

$total_questions = $_POST['count'];
$course_id = $_POST['c_id'];


$author = new Author();
$id = -1;
if($total_questions > 0) {
	
$id = $author->add_quiz_to_list($course_id);

}

while($total_questions--) {

	 $question = $_POST["question$i"];
	 $option = array();
	 $option[0] = $_POST["option1$i"];
	 $option[1] = $_POST["option2$i"];
	 $option[2] = $_POST["option3$i"];
	 $option[3] = $_POST["option4$i"];
	 $q_answer = $_POST["qanswer$i"];
	 $q_number = $_POST["qnumber$i"];
	echo $question;
	$author->add_quiz($id, $question, $option, $q_number, $q_answer);
	$i = $i + 1;
}

header("Location: ../html/home_author.php");


?>