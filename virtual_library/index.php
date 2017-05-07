<?php

if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && isset($_COOKIE['img'])) {

	$username = $_COOKIE['username'];
	$password = base64_decode($_COOKIE['password']);
	$file	= explode('/', $_COOKIE['img']);
	$size = sizeof($file);
	$img = "file_system/student/".$_COOKIE['username']."/".$file[$size-1];

} else {

	$username = '';
	$password = '';
	$img = "images/supermans.png";


}

session_start();

if(isset($_SESSION['username']))  {
	require("data_files/database.php");
	$database = new vlibDatabase();
	$type = $database->gettype($_SESSION['username']);
	if($type == 1)
		header("Location: html/home.php");
	else if($type == 2)
		header("Location: html/home_author.php");
	else if($type == 3) {
		header("Location: html/home_content.php");
	} else if($type == 4) {	
		header("Location: html/home_admin.php");
	}
}

$warning_message = "";


if(isset($_GET['not_approved'])) {
	 $warning_message = "Your account has not been approved yet";

}
else if(isset($_GET['blocked'])) {
	 $warning_message = "You have been blocked. Contact the administrator";

}
else if(isset($_GET['invalid'])) {
	 $warning_message = "Invalid username or password";

} else if(isset($_GET['signedup'])) {
	 $warning_message = "Your account will be confirmed soon";

}

?>
<!DOCTYPE html>
<html data-wf-site="52e5e0a9469249622b00030a">
<head>
  <meta charset="utf-8">
  <title>virtual_lib</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/normalize.css">
  <link rel="stylesheet" type="text/css" href="css/flow.css">
  <link rel="stylesheet" type="text/css" href="css/index.css">
  <script>
    if (/mobile/i.test(navigator.userAgent)) document.documentElement.className += ' w-mobile';
  </script>
  <script src="js/jquery-1.11.0.min.js">
  </script>
  <link rel="shortcut icon" type="image/x-icon" href="images/logo.png">

</head>
<body>
  <div class="header">
    <div class="w-row">
      <div class="w-col w-col-6">
	<img src="images/logo.png" height='60' width='60' style="float:left;margin-top:8px;">
        <h1 style="margin-left:50px">Virtual&nbsp;Library</h1>
      </div>
	      <div class="w-col w-col-6 socials"></div>
    </div>
  </div>
  <div class="w-container">
    <div class="w-form">
      <form class="login" method="post" action="data_files/auth.php">
     	  <h3 class="signup-header">Sign up Form</h3>
        <img src="<?php echo $img; ?>" width="180" height="180" class="profile_pic" alt="52e6371c469249622b0005b3_supermans.png">
        <input class="w-input name" type="text" placeholder="Enter first name" name="name"  ></input>
        <input class="w-input name" type="email"  placeholder="Enter email ID" name="email"  ></input>
         <input class="w-input user" placeholder="Enter username" name="username" value='<?php echo $username; ?>' required></input>
        <input class="w-input pass" type="password" placeholder="Password" name="password" value='<?php echo $password; ?>' required></input>
        <p class="warning_hidden"><?php echo $warning_message?></p>
       <input class="w-input repass" type="password" placeholder="Re-enter password" name="repass"   ></input>
        <div class="w-row">
          <div class="w-col w-col-6">
           <label class="remember_me" style="font-weight:normal"><input name = 'rememberme' class="remember_me" type="checkbox"> Remember me</label>
          </div>
          <div class="w-col w-col-6"><a class="fpass" href="#">Forgot password?</a>
          </div>
        </div>
    
        <input class="w-button signin" type="submit" value="Sign in" ></input>
      </form>
      
    </div>
  </div><a class="signup" href="#">Or Sign up now</a><br>
  <a class="already" href="#">Already have an account?</a><br><br>
  <div class="fpass-modal">

    <div  class="header-fpass">Forgot password form</div>
    <div class="fpass-form-div">
      <p style="color:black">Please submit your username. We will send you an email along with the password.</p>
      <form class="fpass-form" method="post" action="data_files/forgot.php">

        <input class="w-input fpass-input" type="text" placeholder="Enter username" name="fpass-user"   ></input>
        <input class="fpass-submit" type="submit" value="Submit" ></input>
		  <img class="show_load" src="images/loader.gif" alt="" style="display:none;color:#208fdf;">
      </form>

    </div>


  </div>
  <div class="modal-overlay"></div>
  
 
	
  <script type="text/javascript" src="js/flow.js"></script>
  <script type="text/javascript" src="js/index.js"></script>
  <?php
  	if(count($_GET) >= 1)
  		echo "<script> $('.warning_hidden').addClass('warning_show');$('.warning_hidden').removeClass('warning_hidden'); </script>"
  ?>
</body>
</html>
