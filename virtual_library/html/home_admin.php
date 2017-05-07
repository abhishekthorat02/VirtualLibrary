<?php
session_start();

if (!isset($_SESSION['username'])) {
	header("Location: ../index.php");
}
else {
	if (isset($_SESSION['username'])) {
		require ("../data_files/database.php");

		$database = new vlibDatabase();
		$type = $database->gettype($_SESSION['username']);
		if ($type == 1) header("Location: home.php");
		else
		if ($type == 2) header("Location: home_author.php");
		else
		if ($type == 3) {
			header("Location: home_content.php");
		}
	}
}

$name = $_SESSION['fname'];

if (isset($_SESSION['lname'])) $name = $name . " " . $_SESSION['lname'];
$name = ucwords($name);

require ("../data_files/database_admin.php");

$admin = new Administrator();
$student_count = $admin->get_student_count();
$author_count = $admin->get_author_count();
$content_info = $admin->number_content_manager();
$count = array();
$count = $admin->get_count();
?>


<!DOCTYPE html>

<html data-wf-site="52f63971e05df6404d000810">

<head>
    <meta charset="utf-8">

    <title>Virtual library</title>
    <link href="../fonts/font-awesome-4.0.3/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="../css/home_normalize.css" rel="stylesheet" type="text/css">
    <link href="../css/home_flow.css" rel="stylesheet" type="text/css">
    <link href="../css/home.css" rel="stylesheet" type="text/css">
     <link href="../css/css_admin.css" rel="stylesheet" type="text/css">
    <script>
        if (/mobile/i.test(navigator.userAgent)) document.documentElement.className += ' w-mobile';
    </script>
	<link rel="shortcut icon" type="image/x-icon" href="../images/logo.png">
   
</head>

<body>
    <div class="header">
        <div class="w-row">
            <div class="w-col w-col-5 title-column">
                <img class="logo_virtual" height='60' src="../images/logo.png" width='60'>

                <h1>Virtual&nbsp;Library</h1>
            </div>

          

            <div class="w-col w-col-1 logout-column">
                <a class="logout" href="../data_files/logout.php"><img src="../images/logout.png" alt=""></a>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="menu-column">
            <div class="w-container userinfo-container">
               <div class="w-container userinfo-container">
                <h1 class="username"><?php echo $name; ?></h1>
                <p class="branch">Administrator</p>

            </div>
            </div>
					 <div id="logo">
         	
          </div>
            <div class="w-container search-container">

 <form name="email-form" data-name="Email Form">
            <input class="w-input search-input" type="text" placeholder="Search course or student" name="course_name" data-name="course_name" required="required"></input>
          </form>
            </div>
            <div class="w-container menu-container">
                <nav id="top">
                    <ul>
                        <li class='outer'>
                            <a class="toplink" href="#">Home</a>

                            <ul>
                            
                                <li><a href="home_admin.php">Reports</a>
                                </li>
                                <li><a href="#" class="ulist">Users list <a class="roll" title="Total users <?php echo $count['user'] ?> "><?php echo $count['user'] ?></a></a>
                                </li>

                                <li><a href="#" class="blocked">Blocked users <a class="roll" title="<?php echo $count['block'] ?> Blocked users"><?php echo $count['block'] ?></a></a>
                                </li>

                                <li><a href="#" class="user_req">User requests <a class="roll" title="you have <?php echo $count['request'] ?> request pending"><?php echo $count['request'] ?></a></a>
                                </li>
                            </ul>
                        </li>

                         <li class='outer'>
                            <a class="toplink" href="#">Contact</a>

                            <ul>
                             
                                <li><a href="#">Developers</a>
                                </li>
                            </ul>
                        </li>

							<li class='outer'>
                            <a class="toplink" href="#">About</a>
										 <ul>
                                <li><a href="#">About us</a>
                                </li>

                                <li><a href="#">Virtual library</a>
                                </li>

                                <li><a href="#">Help</a>
                                </li>
                            </ul>
                         </li>
                        <li class='outer'><a class="loglink" href="#">Logout</a>
                        </li>
                    </ul>
                </nav>
            </div>

       


            <div class="w-container copyright-container">
                <h4>CopyLeft</h4>

                <p>&#169; Virtual library project is developed for credit suisse intracollege competition by Faiz halde and Abhishek thorat.</p>
            </div>
        </div>

        <div class="post-content">
            	<div class="report">
						<h2>Report</h2>
							<div class="student">
							<h4> <i class="fa fa-list-ul"></i> Students report</h4>
								<ul class="student_report">
									<?php	foreach($student_count as $dept){	echo "<li>$dept</li>";}?>
								</ul>
							</div>
							<div class="hr"></div>
							<div class="content_manager">
								<h4> <i class="fa fa-list-ul"></i> Content manager report</h4>	
								<?php echo $content_info; ?>
														
							</div>
							
						<div class="hr"></div>
							<div class="Author">
								<h4> <i class="fa fa-list-ul"></i> Author report</h4>	
								<ul>
									<?php	foreach($author_count as $dept){	echo "<li>$dept</li>";}?>
								</ul>
													
							</div>
							
							<div class="hr"></div>
							<div class="add_department">
								<h4><i class="fa fa-building-o"></i> Add new department </h4><br>
									<form class="dept" method="POST" action="../data_files/add_new_department.php">
										<input  type="text" placeholder="Enter the department name" name="dept" class="w-input"></input>
									<label><input type="checkbox" name="check">Add to  bulletin</label>
									<input type="submit" value="Submit" class="submit"></input>
									
									</form>
							</div>
							<div class="hr"></div>
							<a class="open_content" href="#"><h4><i class="fa fa-user"></i> Add content manager </h4></a>
							<div class="add_content_manager">
									
									<form class="content" method="POST" action="../data_files/add_content.php">
										<input type="text" placeholder="Enter  name" name="name" class="w-input"></input>
										<input type="text" placeholder="Enter email" name="email" class="w-input"></input>
										<input type="text" placeholder="Enter username" name="username" class="w-input"></input>
										<input type="text" placeholder="Enter contact number" name="contact" name='contact' class="w-input"></input>
										<input type="password" placeholder="Enter password" name="password" class="w-input"></input>
										<input type="password" placeholder="Re-enter password" class="w-input"></input>	
										<input type="submit" value="Submit" class="submit"></input>																																										
									</form>
						  </div>
						<div class="hr"></div>
						  	<a class="open_author"  href="#"><h4><i class="fa fa-user"></i> Add Author </h4></a>
						  <div class="add_author">
						  		
									<form class="author" method="POST" action="../data_files/add_author.php">
										<input type="text" placeholder="Enter  name" name="name" class="w-input"></input>
										<input type="text" placeholder="Enter email" name="email" class="w-input"></input>
										<input type="text" placeholder="Enter username" name="username" class="w-input"></input>
										<input type="password" placeholder="Enter password" name="password" class="w-input"></input>
										<input type="password" placeholder="Re-enter password" class="w-input"></input>	
										<input type="text" placeholder="Enter the department name" name='department' class="w-input"></input>
										<input type="text" placeholder="Enter contact number" name='contact' class="w-input"></input>
										<input type="submit" value="Submit" class="submit"></input>																																										
									</form>
							</div>
					</div>
					
					<div class="userlist">
								<h2 style="text-align:center">User list</h2>
							<ul>									
							</ul>
					
					</div>
						<div class="user_request">
								<h2 style="text-align:center">User request</h2>
							<ul>									
							</ul>
					
					</div>
						<div class="blocked_user">
								<h2 style="text-align:center">Blocked users</h2>
							<ul>									
							</ul>
					
					</div>
					
					
            <div class="copyrightDiv">

                <h3 style="text-align:center;font-family: 'Roboto Slab' ,sans-serif;">CopyLeft</h3> 

                <p style="text-align:center;margin-top:10px; line-height:28px;font-family: joseFont; font-size: 17px;">
                    © Virtual library project is developed for credit suisse intracollege competition by Faiz halde and Abhishek thorat.</p>


            </div>
        </div>
    </div>


    <script src="../js/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script src="../js/webflow.js" type="text/javascript"></script>
    <script src="../js/home_index.js" type="text/javascript"></script>
    <script src="../js/home_admin.js" type="text/javascript"></script>
</body>
</html>
