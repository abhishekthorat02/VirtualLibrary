<?php
header("Content-type: text/plain");
require("database.php");
$username = $_POST['fpass-user'];
$forgotpassword = new vlibDatabase();
$return = $forgotpassword->forgotpassword($username);
if ($return == 1) {
    
} else {
    
}
?>