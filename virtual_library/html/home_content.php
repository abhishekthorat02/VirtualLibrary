<?php
session_start();

if (!isset($_SESSION['username'])) {
		session_destroy();
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
		if ($type == 4) {
			header("Location: home_admin.php");
		}
	}
}

require "../data_files/database_content.php";
$name = $_SESSION['fname'];

if (isset($_SESSION['lname'])) $name = $name . " " . $_SESSION['lname'];
$name = ucwords($name);

$content = new Content();

$report = $content->dept_course_report();
$content->number_of_uploads();
$count = array();
$count = $content->all_count();

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
    <link href="../css/home_content.css" rel="stylesheet" type="text/css">
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
                <h1 class="username"><?php echo $name; ?></h1>
                <p class="branch">Content Manager</p>
            </div>
				 <div id="logo">
           <a onclick='smooth();' href="#" data-title="Home" class="home" id="home"><img src="../images/home.png" alt="" ></img></a>
          <a href="#" data-title="Home" class="home" id="search"><img src="../images/search.png" alt="" ></img></a>
           <a href="#" onclick='toCourse();' data-title="Home" class="home"  ><img src="../images/reader.png" alt="" ></img></a>
           <a href="#" onclick='toStats();' data-title="Home" class="home"  ><img src="../images/statistics.png" width='12px' height='13px'alt=""></img></a>
          </div>
            <div class="w-container search-container">

 <form name="email-form" data-name="Email Form">
            <input class="w-input search-input" type="text" placeholder="Search course " name="course_name" data-name="course_name" required="required"></input>
          </form>
            </div>
            <div class="w-container menu-container">
                <nav id="top">
                    <ul>
                        
                        <li class='outer'>
                            <a class="toplink" href="#">Courses</a>

                            <ul>
                            </li>
                                 <li><a href="home_content.php" class="library-course-report">Report</a>
                                </li>
                            <li><a href="#" class="course-request-show" >Course requests <a class="roll" title="you have <?php echo $count['course'] ?> request pending"><?php echo $count['course'] ?></a></a>
                                </li>
                                 <li><a href="#" class="reseach-paper-request" >Research paper requests <a class="roll" title="you have <?php echo $count['paper_upload'] ?> request pending"><?php echo $count['paper_upload'] ?></a></a>
                                </li>
                                <li><a href="#" class="spam-show" >Spam <a class="roll" title="you have <?php echo $count['spam'] ?> request pending"><?php echo $count['spam'] ?></a></a>
                                </li>
                                 <li><a href="#" class="course-accepted-show">Accepted courses <a class="roll" title="you have <?php echo $count['course_upload']?> request pending"><?php echo $count['course_upload']?></a></a>
                                </li>
                            </ul>
                        </li>

                       
                          <li class='outer'>
                            <a class="toplink" href="#">Contact</a>

                            <ul>
                                <li><a href="#">Contact Author</a>
                                </li>
                                <li><a href="#">Contact developers</a>
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
            <div id="stat" class="w-container statistics-container">
                <h4>
                Statistics</h4>

                <p>here information is shown about student progress bar and completion status</p>
            </div>

            <div class="w-container copyright-container">
                <h4>CopyLeft</h4>

                <p>&#169; Virtual library project is developed for credit suisse intracollege competition by Faiz halde and Abhishek thorat.</p>
            </div>
        </div>

        <div class="post-content">
      			
          		<div class="report-course">
				 <h2>Course Report</h2> 
				 <div class="report-department-wrapper">         		
					      <ul>
					<?php

						foreach($report as $department) {

							echo "<li class='report-department'>";
							echo "<h4><i class='fa fa-building-o'></i> ".ucwords($department->department_name)."</h4>";
							echo "<ul>";
							foreach($department->year_name as $year => $course_count) {

								echo "<li><i class='fa fa-caret-right'></i> $year</li>";
								echo "<ul>";
								echo "<li><i class='fa fa-book'></i> Courses - $course_count</li>";
								if(isset($department->course_upload[$year]))
									echo "<li><i class='fa fa-upload'></i> Uploads - ".$department->course_upload[$year]."</li>";
								else
									echo "<li><i class='fa fa-upload'></i> Uploads - 0</li>";
								echo "</ul>";

							}
							echo "</ul></li>";	

						}







						?>
					      	<!---<li class="report-department">
					      	<h4><i class="fa  fa-building-o"></i> Computer engineering</h4>
						      	<ul>
						      	<li><i class="fa fa-book "></i> FY</li>
						      		<ul>
											<li><i class="fa  fa-user "></i> Courses : 23</li>						      		
											<li><i class="fa  fa-upload"></i> upload : 6</li>						      		
						      		</ul>
						      	<li><i class="fa  fa-book"></i> SY: 21</li>
						      		<ul>
											<li><i class="fa  fa-user "></i> Courses : 23</li>						      		
											<li><i class="fa  fa-upload"></i> upload : 6</li>						      		
						      		</ul>
						      	<li><i class="fa   fa-book"></i> TY: 21</li>
						      		<ul>
											<li><i class="fa  fa-user "></i>  Courses : 23</li>						      		
											<li><i class="fa  fa-upload"></i> upload : 6</li>						      		
						      		</ul>
						      	<li><i class="fa   fa-book"></i> B.Tech: 12</li>
						      		<ul>
											<li><i class="fa  fa-user "></i>  Courses : 23</li>						      		
											<li><i class="fa  fa-upload"></i> upload : 6</li>						      		
						      		</ul>
						        </ul>					      	
					      	</li>-->
					      	
					      </ul>  
					       		
          				</div>
          		</div>
          		
          		
        		<div class="course_request_show_div">
        						<h2 style="text-align:center">Course requests</h2>
        						
        						<ul>
									
        						</ul>
        			
        				        		
       		</div>
       		<div class="spam_request_show_div">
        						<h2 style="text-align:center">Spam</h2>
        						
        						<ul>
									
        						</ul>
        			
        				        		
       		</div>
       		
       		<div class="course_accepted_show_div">
        						<h2 style="text-align:center">Accepted courses</h2>
        						
        						<ul>
									
        						</ul>
        			
        				        		
       		</div>
       		<div class="research_request_show_div">
        						<h2 style="text-align:center">Research paper requests</h2>
        						
        						<ul>
									
        						</ul>
        			
        				        		
       		</div>
       		
				<div class="course_uploads_show_div">
        						<h2 style="text-align:center"></h2>
        						
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
    <script src="../js/home_content.js" type="text/javascript"></script>
</body>

</html>
