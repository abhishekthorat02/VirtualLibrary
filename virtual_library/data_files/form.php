<?php

session_start();
require('database.php');

if(isset($_SESSION['username'])) {

	$database = new vlibDatabase();
   $type = $database->gettype($_SESSION['username']);
   if ($type == 1) {
      header("Location: ../html/home.php");
   }
   else if ($type == 2)
       header("Location: ../html/home_author.html");
   else if ($type == 3) {
       header("Location: ../html/home_content");
   } else {
       header("Location: ../html/home_admin");
   }

}
else{
$name = $_POST['name'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$_SESSION['username'] = $username;
$_SESSION['password'] = $password;
}

?>


<!DOCTYPE html>
<html>
<head>
<title>Virtual library</title>
<meta charset="utf-8" />
<style type="text/css">
body{
background-image:url("../images/form.jpg");
} 
 form {
    width: 50%;
   margin: 0 auto;
	   line-height:40px;	
	   font-size: 17px;
	   font-family: "Comic Sans MS", cursive, sans-serif;
	   color:white;
	  
    }
input{
border:none;
border-bottom: 1px dashed black;
text-align: center;
color:skyblue;
font-size:15px;
font-family: "Comic Sans MS", cursive, sans-serif;
 background-color: transparent;
}
::-webkit-input-placeholder { /* WebKit browsers */
    color:#2b74d4;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
    color:    black;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
    color:    black;
}
:-ms-input-placeholder { /* Internet Explorer 10+ */
    color:    black;
}
input:active{
outline: none;
}
input:focus{
outline: none;
}
select:focus{
outline: none;
}
h2{
text-align: center;
margin-top: 10%;
color: skyblue;
font-family: "Comic Sans MS", cursive, sans-serif;
}
button{
  width: 120px;
  height:30px;
  border:none;
  margin-top: 20px;
  margin-right: 9px;
  margin-left: 280px;
  border-radius: 6px;
  background-color: #3992c6;
  color: white;
  box-shadow: 0px 6px 0px #225776;
  position: relative;
  -webkit-transition: all 0s ease;
}
button:active{
box-shadow: 0px 3px 0px #B3241d;
 top: 6px;
}

.propic{
border:none;
width:180px;
color:gray;
border:none;
background:none;
}

</style>
<title></title>
</head>
<body>
	<h2>Fill up form</h2>
	
	<form method="post" action="../data_files/info.php" enctype="multipart/form-data">
	" I am <input type="text" placeholder="First name" name='fname' value = "<?= $name ?>"  required/>,
	 <input type="text" placeholder="Last name" name='lname' required/> with username
	  <input type="text" placeholder="username" name='username' value = "<?= $username ?>"  required/>
	from institute <input type="text" placeholder="Institute name" required/>
	 department <input type="text" placeholder="Department name" name='dept' required> 
	 in year <select name="year"> <option>First year</option><option>Second year</option><option>Third year</option><option>Final year</option></select>
	 . My email id is <input type="text" placeholder="Email id" name="email" value = "<?= $email ?>"   required/> .I was born in <input type="text" placeholder="eg.12/8/1993" required/>, 
	 <input type="text" placeholder="month " /><input type="text" placeholder="year" required/>
	 , here is my profile pic <input type="file"  class = 'propic' name='propic' required/><br> I would like to join virtual library community "
	<br><button type="submit">Submit</button>	
	</form>
</body>
</html>
