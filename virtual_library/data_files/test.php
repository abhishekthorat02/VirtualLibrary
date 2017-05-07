
<?php


require "database_content.php";


$course = new Content();
$array = $course->dept_course_report();


print_r($array);
//echo $array[0]->$departmen0t_name;
?>