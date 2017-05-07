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
		if ($type == 3) header("Location: home_content.php");
		else
		if ($type == 4) {
			header("Location: home_admin.php");
		}
	}
}

$name = $_SESSION['fname'];

if (isset($_SESSION['lname'])) $name = $name . " " . $_SESSION['lname'];
$name = ucwords($name);
$dept = $database->get_dept();

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
    <link href="../css/home_author.css" rel="stylesheet" type="text/css">
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

            

            <div class="w-col w-col-1 logout-column">
                <a class="logout" href="../data_files/logout.php"><img src="../images/logout.png" alt=""></a>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="menu-column">
            <div class="w-container userinfo-container">
                <h1 class="username"><?php echo $name; ?></h1>
                <p class="branch">Author</p>
                <p class="branch"><?php echo $dept." Engineering"; ?></p>
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
                            <a class="toplink" href="#">Home</a>

                            <ul>
                                <li><a href="#" class="course">Create course</a>
                                </li>

                                <li><a class="display_course" href="#">My courses</a>
                                </li>

                                 <li><a class="trending" href="#">Trending news</a>
                                </li>
                            </ul>
                        </li>

                    
                     
                        
                          <li class='outer'>
                            <a class="toplink" href="#">Contact</a>

                            <ul>
                                <li><a href="#">Contact Author</a>
                                </li>

                                <li><a href="#">Contact content manager</a>
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
        
        
        		<div class="create_course" >
        		
      			<h2>Create course</h2>
					<form method="POST" action="../data_files/create_course.php" >
						<input type="text" name="title" placeholder="Course name" class="w-input"></input>
						<textarea  name='description' placeholder="Description of the course" class="w-input" style="max-width:715px; min-height:150px"></textarea>
						<input name='dept' type="text" class="w-input" placeholder="Department"></input>
						<label class="w-input" style="border:none"><input name='bullet' type="checkbox" placeholder="Department"></input> Add to bulletin</label>	
						<label class="w-input" style="border:none">Year: <select name="year" >
		
							<option>FY</option>						
							<option>SY</option>						
							<option>TY</option>						
							<option>Final</option>						
						
						
						</select></label>
						<input type="submit" class="submit" value="Create course">							
					</form>			
		        		
        		
        		
        		</div>
        		
        		<div class="create_quiz" >
        				<h2 style="text-align:center">Create quiz</h2>
        				<div class="question_wrapper">
        					<h5></h5>
        					<form class="quiz" method="POST" action="../data_files/quiz.php">
        						<div class="question">
        							<textarea  name="question0" placeholder="Enter question" class="w-input q_text" style="margin-bottom:10px;width:100%; max-width:717px; min-height:100px;max-height:196px;"></textarea>
        							<b>1. </b><input name="option10" type="text" placeholder="enter option 1" class="w-input option1"></input>
        							<b>2. </b><input name="option20" type="text" placeholder="enter option 2" class="w-input option2"></input>	
       		 					<b>3. </b><input name="option30" type="text" placeholder="enter option 3" class="w-input option3"></input>	
        							<b>4. </b><input name="option40" type="text" placeholder="enter option 4" class="w-input option4"></input>		
        							<input name="qnumber0" type="hidden" class="w-input qnumber" value="0"></input>		
        							<label class="w-input" style="border:none">Correct option: <select name="qanswer0" class="qanswer">
										<option>1</option>						
										<option>2</option>						
										<option>3</option>						
										<option>4</option>						
									</select></label>	
								</div>
						 		<input type="submit" class="submit" value="Create quiz">
						 		<input name="count" type="hidden" class="w-input qcount" value="1"></input>		
						 		<input name="c_id" type="hidden" class="w-input c_id" value="1"></input>		
				         </form>
				      </div>
				     <input type="button" value='+'  class="new_question submit" style="margin-left:0px;width:25px;" >
				     
        		</div>    

        		<div class="my_course">
        						<h2 style="text-align:center">My courses</h2>
        						
        						<ul>
								<!----<li>
										<h4><i class="fa fa-book"></i> Discrete structure</h4>										
										
										<div class="course_content">
												<h5>CT:20333</h5>
												<h5>Strength:73</h5>
										</div>     
										<button class="block">Add slides</button>
										<button class="block">Add quiz</button>   						
										<button class="block">Delete course</button>   		
										</li>---->				
        						</ul>
        			
        				        		
       		</div>
       		
       			<div class="posts_trending">
						<h2>Trending news</h2>
					<form method="POST" action="../data_files/upload_trending_news.php" enctype="multipart/form-data">
					<input type="text" name="title" placeholder="Title " class="w-input"></input>
					<input type="text" name="tags" placeholder="Tags or interest" class="w-input"></input>
					<input type="text" name="links" placeholder="Add youtube links " class="w-input"></input>
					<textarea  name='description' placeholder="Brief description about news" class="w-input" style="max-width:715px; min-height:270px"></textarea>
					<input name='file' type="file" class="w-input"></input>		
					<input type="submit" class="submit" value="Upload research paper">							
					
					
					</form>				
				
				
				</div>
				
				<div class="course_upload_slides">
							<h2></h2><br>
							<form method="POST" action="../data_files/upload_slide.php" enctype="multipart/form-data"> 
								<input type="hidden" name="id" class="form-id"  ></input>
								<input type="text" name="form-title" class="w-input" placeholder="slide title"></input>
								<textarea  name='description' placeholder="Brief description about slide" class="w-input" style="max-width:715px; min-height:300px"></textarea>
								<input type="file" name="file" class="w-input form-file" ></input>
								<input type="submit" class="submit" value="Add slide"></input>
							</form>
				</div>
				
				<div class="showUpload">
							<h2 style="text-align:center">Course uploads</h2>
							<ul>
																
							</ul>
					
					</div>
       		
       		
        </div>
    </div>
   


    <script src="../js/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script src="../js/webflow.js" type="text/javascript"></script>
    <script src="../js/home_index.js" type="text/javascript"></script>
    <script src="../js/home_author.js" type="text/javascript"></script>
    <?php
    	 if(isset($_GET['upload_success']) || isset($_GET['upload_fail']))
   	 	echo "<script >$('.display_course').trigger('click');</script>";
   	
    ?>
</body>




</html>
