<?php

session_start();
if(!isset($_SESSION['username'])) {

	session_destroy();
	header("Location: ../index.php");

}

require "database.php";


$qid = $_POST['quiz-id'];

$answer_sheet = array();
$i = 0;

while($i < $_POST['qcount']) {


$answer_sheet[$i] = $_POST["option$i"];
$i++;


}

$student = new vlibDatabase();

$result = $student->evaluate($qid, $answer_sheet, $_POST['qcount']);


header("Location: ../html/home.php?evaluated=1");



?>