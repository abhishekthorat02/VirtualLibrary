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
		if ($type == 2) header("Location: home_author.php");
		else
		if ($type == 3) header("Location: home_content.php");
		else
		if ($type == 4) {
			header("Location: home_admin.php");
		}
	}
}

$database = new vlibDatabase();
$course_list = array();
$course_list = $database->get_applied_course();
$name = $_SESSION['fname'];
$department = $database->get_dept_list();
if (isset($_SESSION['lname'])) $name = $name . " " . $_SESSION['lname'];
$name = ucwords($name);
$dept = $database->get_dept();
$stats = array();
$stats = $database->statistics();
$news = array();
$news = $database->get_bulletin();

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

            <div class="w-col w-col-6 marquee-column">
                <div class="marquee-div">
                    <marquee scrollamount="5" direction='left' height="50"><ul>
                      <?php foreach($news as $simple_news )	echo "<li><i class='fa fa-rss' style='color: #333'></i> $simple_news.</li>"; ?>
                    </ul></marquee>
                </div>
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
                <p class="branch">Student</p>
                <p class="branch"><?php echo $dept." Engineering"; ?></p>
            </div>
			<div id="logo" class="w-container" style="color: white;">
				
           <i style="cursor: pointer;" onclick='smooth();' title="Home" href="#" data-title="Home" class="home fa fa-home fa-1x" id="home"></i>
           <i style="cursor: pointer;" data-title="Home" title="Search" class="home fa fa-search fa-1x" id="search"></i>
           <i style="cursor: pointer;" onclick='toCourse();' title="My courses" data-title="Home" class="home fa fa-book fa-1x"  ></i>
           <i style="cursor: pointer;" onclick='toStats();' title="statistics" data-title="Home" class="home fa fa-bar-chart-o fa-1x"  ></i>
           <i style="cursor: pointer;"  title="bookmarks" data-title="Home" class="home fa fa-bookmark fa-1x bookmarked-show"  ></i>
         
          </div>
            <div class="w-container search-container">

 <form name="email-form" data-name="Email Form">
            <input class="w-input search-input" type="text" placeholder="Search course" name="course_name" data-name="course_name" required="required"></input>
          </form>
            </div>
            <div class="w-container menu-container">
                <nav id="top">
                    <ul>
                        <li class='outer'>
                            <i class="fa fa-home" style="color:white;"></i><a class="toplink" href="#">Home</a>

                            <ul>
                            <li><a class="show-news" href="#">News</a>
                                </li>
                             <li><a class="show-friends" href="#">Friends</a>
                                </li>
                                <li><a class="upload-research" href="#">Upload research paper</a>
                                </li>
                                <li><a class="show-research" href="#">Research paper</a>
                                </li>
                                 <li><a class="discuss-forum" href="#">Forum</a>
                                </li>
                                <li><a class="search-book" href="#">Search books</a>
                                </li>
                                

                               
                            </ul>
                        </li>

                        <li class='outer'>
                            <i class="fa fa-book" style="color:white;"></i><a class="toplink" href="#">Courses</a>

                            <ul>
                                <li><a class="related" href="#">Related courses</a>
                                </li>

                                <li><a class="display-all-course" href="#">All courses</a>
                                </li>
                            </ul>
                        </li>

                        <li class='outer'>
                            <i class="fa fa-phone" style="color:white;"></i><a class="toplink" href="#">Contact</a>

                            <ul>
                                <li><a href="#author">Author</a>
                                </li>

                                <li><a class="managers" href="#">Content manager</a>
                                </li>

                                <li><a class="devs" href="#">Developers</a>
                                </li>
                            </ul>
                        </li>
                        <li class='outer'>
                            <i class="fa fa-info-circle" style="color:white;"></i><a class="toplink" href="#">About</a>

                            <ul>
                                <li><a href="#" class="about-us">About us</a>
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

            <div class="w-container course-container student-course" id="course">
                <h4 >My courses</h4>
                
                <nav>
                    <ul>
                    	<?php foreach($course_list as $id => $course) { echo "<li><a data-title='$id' href=#>".ucfirst($course)."</a></li>";} ?>
                      
                    </ul>
                </nav>
            </div>
   <div id="stat" class="w-container statistics-container">
                <h4 > Statistics</h4>
                		<h5 class="fa fa-certificate"> For certification click on course name below</h5>
                		<h5 class="des">Course name</h5>
                		<h5 class="des" style="margin-left:20%">Marks(In %)</h5>
                		<ul id="course_id">
							<?php
								
								foreach($stats as $index => $inner_array)	{
										echo "<li class='stats' data-title='".$inner_array."' style='cursor:pointer'>".($inner_array)."</li>";		
														
									}
													
							?>
               		</ul>
            </div>

            <div class="w-container copyright-container">
                <h4>CopyLeft</h4>

                <p>&#169; Virtual library project is developed for credit suisse intracollege competition by Faiz halde and Abhishek thorat.</p>
            </div>
        </div>

        <div class="post-content">
            <div class="news">
               
            </div>
            
            <div class="tile-course">
            							<h2>Related courses</h2>
            </div>   
            
            <div class="all-course">
            							<h2><i class="fa fa-th-large"></i> All courses</h2>
				            <ul>
				                 <?php
				            
				            	foreach($department as $dept_id => $dept_name) {
				            		
											echo "<li><h3 data-title='$dept_id'><i class='fa fa-book'></i> ".ucfirst($dept_name)." courses</h3><div></div></li>";

				            	}
				            
				            ?>
          
				            </ul>
            </div>
           
				<div class="friend-list">
							<h2>Friends</h2>
							
				
				</div>
				
				<div class="upload_paper">
						<h2><i class="fa fa-file-o"></i> Upload research paper</h2>
					<form method="POST" action="../data_files/upload.php" enctype="multipart/form-data">
					<input type="text" name="title" placeholder="Title for research paper" class="w-input"></input>
					<input type="text" name="tags" placeholder="Tags or Research interest" class="w-input"></input><br>
					<textarea  name='description' placeholder="Brief description about your research paper" class="w-input" style="max-width:715px; min-height:300px"></textarea>
					<input name='file' type="file" class="w-input"></input>		
					<input type="submit" class="submit" value="Upload research paper">							
					
					
					</form>				
				
				
				</div>
				
				<div class="quiz-list">
				
							<h2></h2>
							<div class="quiz-div">
							<h3><i class="fa fa-question-circle"></i> Quizes</h2>
							<ul>
							</ul>
							</div>
							<div class="upload-div">
							<h3><i class="fa fa-cloud-upload"></i> Uploads</h2>
							<ul>
							</ul>
							
							</div>
				
				
				</div>
				<div class="retrieve_paper">
						<h2 style="text-align:center"><i class="fa fa-files-o"></i> Research papers</h2>
						<ul>
						
						</ul>
				</div>
				<div class="bookmark_show">
						<h2 style="text-align:center">Bookmarks</h2>
						<ul>
						
						</ul>
				</div>
				
				<div class="forum-wrapper">
					<h2 style="color:#333;text-align:center"><i class="fa  fa-users"></i> Discussion forum</h2>
					<a class="forum-post-window-open" href="#"><h3 class="w-input" style="color:#333;text-align:center;"><i class="fa  fa-comment-o " ></i> Click here to add new topic </h3></a>
							
							<div class="forum-text-area">
									
									<form class="content" method="POST" action="../data_files/forum_post.php" enctype="multipart/form-data">
										<input type="text" placeholder="Subject" name="subject" class="w-input" required></input>
										<textarea  name='description' placeholder="Message" class="w-input" style="max-width:715px; min-height:300px" required></textarea>
										<input name='file' type="file" class="w-input"></input>
										<input type="submit" value="Submit" class="submit"></input>																																										
									</form>
						  </div>
						  <div class="forum-post" >
						  			<ul>
						  							  			
						  			</ul>
						 
						  </div>
				</div>
				
				<div class="actual-quiz">
				
						<h2></h2>
						<form method="POST" class="quiz-form" action="../data_files/evaluate.php">

					
								<input type="submit" class="submit" value="Submit">
						 		<input name="quiz-id" type="hidden" class="w-input qid" value=""></input>		


						</form>

				</div>
				
				<div class="forum-thread">
				
						<h2></h2>
						<h4 class='creator'></h4>
						<h4 class='response'></h4>
						<h4 class='date'></h4>
						<p class='desc'></p>
						<a href="#" download></a>
						<form action="../data_files/post_comment.php" method="POST">
							<input type="hidden" name='post_id' value="" class="post_id" />
							<textarea type='text' name='comment' class='w-input' style='max-width:715px;min-height:100px;margin-top:15px;' placeholder='What do you think .....' required></textarea>
							<button type='submit' class='block'>Comment</button>
							<img class='loading' src='../images/loader1.gif' style='margin-left:70px;display:none'></img>
						</form>
						<div class="comment">
						
						</div>

				</div>
				
				<div class='quickbooklook' style="display: none;">
				<iframe src="../quickbooklook/index.html" style="width: 100%; height: 550px; border:none; overflow-x:hidden">
				
				
				</iframe>
				</div>
				
        </div> <!-- end of post -->
    


  </div>
  
	<div class="dev-contact-modal">
				<div class="header-dev">Developers Information</div>
				<div>
					<ul>					
						<li>Abhishek Thorat
							<ul>
								<li>Cell number: 9011439399</li>				
								<li>Email ID: abhishekthorat02@gmail.com</li>
							</ul>			
						</li>
						
						<li>Faiz Halde
							<ul>
								<li>Cell number: 9665806995</li>				
								<li>Email ID: faiz_84123@yahoo.com</li>
							</ul>	
						</li>
					</ul>					
				</div>
	</div>
	
	<div class="manager-contact-modal">
				<div class="header-manager">Content Managers</div>
				<div class="mlist">					
				</div>
	</div>
		    
   <div class="modal-overlay"></div>

    <script src="../js/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="../js/jquery.qrcode.min.js"></script>
    <script src="../js/webflow.js" type="text/javascript"></script>
    <script src="../js/home_index.js" type="text/javascript"></script>
</body>

</html>
