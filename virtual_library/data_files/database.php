<?php


class vlibDatabase {
    
    function __construct() {
        $this->connect = mysqli_connect("localhost", "abhishek", "abhishek", "virtual_library");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        
    }

	public function get_bulletin() {
	
		$news = array();
		$query = "SELECT description from bulletin ORDER BY bullet_id DESC LIMIT 5";
		$result = mysqli_query($this->connect, $query);
		while($row = mysqli_fetch_array($result)) {
		
				array_push($news, $row['description']);		
		}
		return $news;
	}
    
    
    public function signUp($fname, $lname, $department, $year, $propic, $email, $password, $username, $file_name) {
        $fname = mysql_real_escape_string($fname);
        $lname = mysql_real_escape_string($lname);
        $department = mysql_real_escape_string($department);
        $year = mysql_real_escape_string($year);
        $propic = mysql_real_escape_string($propic);
        $email = mysql_real_escape_string($email);
        $password = base64_encode(mysql_real_escape_string($password));
        $username = mysql_real_escape_string($username);
        
        if (!empty($fname) && !empty($email) && !empty($password) && !empty($username) && !empty($lname)) {
            
            
            $query = "select * from student where username='$username'";
            $result = mysqli_query($this->connect, $query);
            if ($result) {
                $num_row = mysqli_num_rows($result);
                if ($num_row == 0) {
                	  $path = "../file_system/student/$username";
                	  $path_upload = $path."/papers";
                	  
                	  mkdir($path, 0777, true);
                	  mkdir($path_upload, 0777, true);          	  
                    move_uploaded_file($propic, $path."/$file_name");
                    chmod($path."/$file_name", 0777);
                    $dept_query = "select dept_id from department where dept_name='$department'";
                    $result_dept = mysqli_query($this->connect, $dept_query);
                    $row = mysqli_fetch_array($result_dept);
                    $dept_id = $row['dept_id'];
                    
                    $_SESSION['fname'] = $fname;
                    $_SESSION['lname'] = $lname;
                    $_SESSION['deptid'] = $dept_id;
                    
                    if ($year == "First year") {
                        $year_id = 1;
                    } elseif ($year == "Second year") {
                        $year_id = 2;
                    } elseif ($year == "Third year") {
                        $year_id = 3;
                    } else {
                        $year_id = 4;
                    }
                    $propic = $path."/$file_name";
                    $insert = "INSERT INTO  student (fname, lname, dept_id, year_id, profile_link, email, password, username) VALUES  ('$fname', '$lname', '$dept_id', '$year_id','$propic','$email','$password','$username')";
                    if (mysqli_query($this->connect, $insert)) {
                    		
                        return 1;
                    }
                }
            }
        }
    }
    
    
    public function auth($username, $password) {
        
        $username = mysql_real_escape_string($username);
        $password = base64_encode(mysql_real_escape_string($password));
        if (!empty($username) && !empty($password) ) {
            
            $query = "select * from student where username='$username' and password='$password'";

            $result = mysqli_query($this->connect, $query);
            if ($result) {
                $row_approval = mysqli_fetch_array($result);
                $num_row = mysqli_num_rows($result);
                $approval = $row_approval['approval'];
                $blocked = $row_approval['blocked'];
                if($num_row == 1 &&$approval == 0) {
                
                	return 5;
               
                }
            	 if($num_row == 1 &&$blocked == 1) {
            	 
            	 	return 6;
            	 
            	 }
                if ($num_row == 1 && $approval == 1 && $blocked == 0) {
                    $_SESSION['fname'] = $row_approval['fname'];
                   $_SESSION['lname'] = $row_approval['lname'];
                    $_SESSION['deptid'] = $row_approval['dept_id'];


                    if(isset($_POST['rememberme'])) {

                    setcookie('username', $username, time() + 3600, '/');
                    setcookie('password', $password, time() + 3600, '/');
                    setcookie('img', $row_approval['profile_link'], time() + 3600, '/');
						
                    }
                    return 1;
                    
                } else {
                    $query = "select * from author where username='$username' and password='$password'";
                    $result = mysqli_query($this->connect, $query);
                    if ($result) {
                        $num_row = mysqli_num_rows($result);
                        if ($num_row == 1) {
                            $row = mysqli_fetch_array($result);
                            $_SESSION['fname'] = $row['fname'];
                            $_SESSION['lname'] = $row['lname'];
                            $_SESSION['deptid'] = $row['dept_id'];
                            return 2;
                        } else {
                            $query = "select * from content_manager where username='$username' and password='$password'";
                            $result = mysqli_query($this->connect, $query);
                            if ($result) {
                                $num_row = mysqli_num_rows($result);
                                if ($num_row == 1) {
                                    $row = mysqli_fetch_array($result);
                                    $_SESSION['fname'] = $row['fname'];
                                    $_SESSION['lname'] = $row['lname'];
                                    
                                    return 3;
                                } else {
                                    $query = "select * from administrator where username='$username' and password='$password'";
                                    $result = mysqli_query($this->connect, $query);
                                    if ($result) {
                                        $num_row = mysqli_num_rows($result);
                                        if ($num_row == 1) {
                                            $row = mysqli_fetch_array($result);
                                            $_SESSION['fname'] = $row['fname'];
                                            $_SESSION['lname'] = $row['lname'];
                                            
                                            return 4;
                                        } else {
                                            return 0;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    
    public function gettype($username) {
        $username = mysql_real_escape_string($username);
        
        if (!empty($username)) {
            
            
            
            $query = "select * from student where username='$username'";
            $result = mysqli_query($this->connect, $query);
            if ($result) {
                $num_row = mysqli_num_rows($result);
                if ($num_row == 1) {
                    return 1;
                    
                } else {
                    $query = "select * from author where username='$username'";
                    $result = mysqli_query($this->connect, $query);
                    if ($result) {
                        $num_row = mysqli_num_rows($result);
                        if ($num_row == 1) {
                            return 2;
                        } else {
                            $query = "select * from content_manager where username='$username'";
                            $result = mysqli_query($this->connect, $query);
                            if ($result) {
                                $num_row = mysqli_num_rows($result);
                                if ($num_row == 1) {
                                    return 3;
                                } else {
                                    $query = "select * from administrator where username='$username'";
                                    $result = mysqli_query($this->connect, $query);
                                    if ($result) {
                                        $num_row = mysqli_num_rows($result);
                                        if ($num_row == 1) {
                                            return 4;
                                        } else {
                                            return 0;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    
    
    public function forgotpassword($username) {
        if (!empty($username)) {
        		 $username = mysql_real_escape_string($username);
            $from = "library.virtual1@gmail.com";
            $query = "select student.email,student.password from student where username='$username'";
            $result = mysqli_query($this->connect, $query);
            if ($result) {
                $num_row = mysqli_num_rows($result);
                if ($num_row == 1) {
                    $row = mysqli_fetch_array($result);
                    $email = $row['email'];
                    $password = $row['password'];
                    $password = base64_decode($password);
                    
                    
                    mail($email, "Reset password", "This is automatic generated mail from virtual library server. Your new password for account username '$username' is '$password'", "FROM:$from");
                    
                    
                    
                    return 1;
                    
                } else {
                    return 0;
                }
                
            }
            
        }
    }
    
    public function related_course() {
        $username = $_SESSION['username'];
        $query = "select dept_id, year_id from student where username='$username'";
        $result = mysqli_query($this->connect, $query);
        if ($result) {
            $row = mysqli_fetch_array($result);
            $dept_id = $row['dept_id'];
            $year_id = $row['year_id']; 
        }
        $query_course = "select course.course_id, course.course_name, course.description,author.fname,author.lname from course JOIN teaches ON course.course_id = teaches.course_id JOIN author ON author.a_id = teaches.a_id  where course.dept_id='$dept_id' AND course.year_id='$year_id'AND course.c_approval ='1'";
        $result_course = mysqli_query($this->connect, $query_course);
       
        $xml = "<?xml version='1.0' encoding='utf-8'?><courselist>";
    	  while ($row_course = mysqli_fetch_array($result_course)) {
            $num =  $this->get_applied_course_id($row_course['course_id']);
            $xml = $xml . "<course><id>" . $row_course['course_id'] . "</id><name>" . $row_course['course_name'] . "</name><description>" . $row_course['description'] . "</description><aname>".$row_course['fname']." ".$row_course['lname']."</aname><enrolled>".$num."</enrolled></course>";
            
        }
       $xml = $xml . "</courselist>";
      
       
        return $xml;
    }
    
    public function get_applied_course() {
        
        $username = $_SESSION['username'];
        $query = "select course.course_id, course.course_name from student  join has_enrolled ON student.s_id = has_enrolled.s_id  join course ON has_enrolled.course_id = course.course_id where student.username='$username' AND course.c_approval = '1' ";
        $result = mysqli_query($this->connect, $query);
        $course_list = array();
        if ($result) {

            while ($row = mysqli_fetch_array($result)) {
                
                $course_list[$row['course_id']] = $row['course_name'];
                
            }
            
        }
        return $course_list;
        
    }
    
    public function get_dept() {
        
        $deptid = $_SESSION['deptid'];
        $query = "select dept_name from department where dept_id = $deptid";
        $result = mysqli_query($this->connect, $query);
        $row = mysqli_fetch_array($result);
        return ucwords($row['dept_name']);
    }

    public function enroll_course($course_id){
      	$username = $_SESSION['username'];
      	$query = "select s_id from student where username='$username'";
      	$result = mysqli_query($this->connect,$query);
      	if($result) {  
				$row = mysqli_fetch_array($result);
				$s_id = $row['s_id'];		
    		}
    		$query_check = "select * from has_enrolled where s_id = '$s_id' AND course_id='$course_id'";
    		$result_check = mysqli_query($this->connect,$query_check);	
			if($result_check) {
				$count = mysqli_num_rows($result_check);
				if($count != 0) {
					return "you have already enrolled the course";
				}
				else {
					$query_enroll = "INSERT INTO has_enrolled(s_id,course_id) VALUES ('$s_id','$course_id')";									
					$result_enroll =  mysqli_query($this -> connect, $query_enroll);
					return "success";
				}
		 }	
	}	 		
 	public function all_course($dept_id) {
 	     $username = $_SESSION['username'];
        $query = "select year_id from student where username='$username'";
        $result = mysqli_query($this->connect, $query);
        if ($result) {
            $row = mysqli_fetch_array($result);
            $year_id = $row['year_id'];
        }
        $query_course = "select course_id, course_name from course where dept_id=$dept_id AND year_id=$year_id AND c_approval = '1'";
        $result_course = mysqli_query($this->connect, $query_course);
       
        $xml = "<?xml version='1.0' encoding='utf-8'?><courselist>";
    	  while ($row_course = mysqli_fetch_array($result_course)) {
            $num =  $this->get_applied_course_id($row_course['course_id']);
            $xml = $xml . "<course><num>" . $num . "</num><id>" . $row_course['course_id'] . "</id><name>" . $row_course['course_name'] . "</name></course>";
            
        }
       $xml = $xml . "</courselist>";
      
       
        return $xml;
    }
    
	public function get_friend_list() {
	 $username = $_SESSION['username'];
	 $query = "select dept_name,student.fname,student.lname,student.email,student.vote_count,student.profile_link,dept_id from student NATURAL JOIN department where  approval='1' AND blocked='0' AND student.username <> '$username' AND student.year_id IN(
						select year_id from student where student.username ='$username') ";
	
	 $result = mysqli_query($this->connect,$query);
	 if($result) {
	 	$row_num = mysqli_num_rows($result);	 	
	 }
	 $xml = "<?xml version='1.0' encoding='utf-8'?><friendlist>";
	 while($row = mysqli_fetch_array($result)) {
		$xml = $xml ."<friend><dept_name>".$row['dept_name']."</dept_name><fname>".ucwords($row['fname'])."</fname><lname>".ucwords($row['lname'])."</lname><email>".$row['email']."</email><votecount>".$row['vote_count']."</votecount><propic>".$row['profile_link']."</propic></friend>";						 
	 }
	$xml = $xml . "</friendlist>";
	return $xml;
	}	
	
	 public function get_applied_course_id($course_id) {
        
        $username = $_SESSION['username'];
        $query = "select course.course_id,student.s_id from student join has_enrolled ON student.s_id = has_enrolled.s_id  join course ON has_enrolled.course_id = course.course_id where student.username='$username' AND course.course_id = '$course_id'";
        $result = mysqli_query($this->connect, $query);
        $num = mysqli_num_rows($result);
        if($num == 1) {
       		return 1; 	
  		  }
		  else{
				return 0;		  
		  }
	}

	public function unenroll_course($c_id){
			$username = $_SESSION['username'];
      	$query = "select s_id from student where username='$username'";
      	$result = mysqli_query($this->connect,$query);
      	if($result) {  
				$row = mysqli_fetch_array($result);
				$s_id = $row['s_id'];		
    		}
    		$query  = "DELETE from has_enrolled where s_id ='$s_id' AND course_id = '$c_id'";
    		$result = mysqli_query($this->connect,$query);
	}

	public function get_manager_list() {
	
	$query = "select fname, lname, email, contact_num from content_manager";
	$result = mysqli_query($this->connect,$query);
	$xml = "<?xml version='1.0' encoding='utf-8'?><managerlist>";
	 while($row = mysqli_fetch_array($result)) {
		$xml = $xml ."<manager><fname>".$row['fname']."</fname><lname>".$row['lname']."</lname><email>".$row['email']."</email><contact_num>".$row['contact_num']."</contact_num></manager>";						 
	 }
	$xml = $xml . "</managerlist>";
	return $xml;
	
	}

	public function upload_papers($title,$tags,$description,$tmp_name,$file_name){
			 $title  = mysql_real_escape_string($title);
			 $tags  = mysql_real_escape_string($tags);
			 $description  = mysql_real_escape_string($description);
			 $file_name  = mysql_real_escape_string($file_name);
			$username = $_SESSION['username'];
			$path = "../file_system/student/".$username."/papers/".$file_name;			 
			$query = "select s_id from student where username='$username'";
			$result = mysqli_query($this->connect,$query);
			if($result) {
				$row = mysqli_fetch_array($result);
				$s_id = $row['s_id'];			
			}				
		   $file_name = $path;
			$query_upload = "INSERT INTO upload_research_paper(title,tags,description,path,s_id) Values ('$title','$tags','$description','$file_name','$s_id')";
			$query_result = mysqli_query($this->connect,$query_upload);
			if($query_result) {		
				move_uploaded_file($tmp_name, $path);
				chmod($path, 0777);
				return 1;
			}
			else {
				return 0;		
			}	
	}
	public function get_dept_list() {


	$query = "SELECT dept_name,dept_id from department";
	$department = array();
	$result = mysqli_query($this->connect, $query);
	 
	if ($result) {
          
           while ($row = mysqli_fetch_array($result)) {
                
                $department[$row['dept_id']] = $row['dept_name'];
                
            }
            
   }
   return $department;

	}

	public function get_quiz_list($course_id) {
	
		$query = "SELECT q_id from quiz_list where course_id = '$course_id'";
		$result = mysqli_query($this->connect, $query);

 		if($result) {
			$xml = "<?xml version='1.0' encoding='utf-8'?><quizlist>";				
			while($row = mysqli_fetch_array($result)) {
			
				$xml = $xml . "<quiz><id>". $row['q_id'] ."</id></quiz>";
			
			}
			$xml = $xml . "</quizlist>";
			return $xml;
		}
	
	}


	public function get_quiz_question($qid) {
	
		
		$query = "SELECT question, q_number, option1, option2, option3, option4 from quiz where q_id = '$qid' ORDER BY q_number";
		$result = mysqli_query($this->connect, $query);
		
		if($result) {
			$xml = "<?xml version='1.0' encoding='utf-8'?><quizquestion>";				
			while($row = mysqli_fetch_array($result))		{

				$xml = $xml . "<problem>
				<question>".ucfirst($row['question'])."</question>
				<option1>".ucfirst($row['option1'])."</option1>
				<option2>".ucfirst($row['option2'])."</option2>
				<option3>".ucfirst($row['option3'])."</option3>
				<option4>".ucfirst($row['option4'])."</option4>
				<qnumber>".$row['q_number']."</qnumber>
				</problem>";
			
			}
			$xml = $xml . "</quizquestion>";
			return $xml;
		
		}
	
	}
	
	public function evaluate($qid, $answer_sheet, $qcount) {
		

		$correct = 0;
		$solution_sheet = array();
		
		$query = "SELECT q_number, q_answer from quiz where q_id = '$qid' ORDER BY q_number";
		$result = mysqli_query($this->connect, $query);
		
		while($row = mysqli_fetch_array($result)) {
		
			$solution_sheet[$row['q_number']] = $row['q_answer'];

		}
		
		foreach($answer_sheet as $q_number => $q_answer) {
		
				if( $solution_sheet[$q_number] == $q_answer )
						$correct++;		
		
		}
	
		$correct = ($correct/$qcount)*100;
		
		$username = $_SESSION['username'];
		$query = "SELECT s_id from student where username = '$username'";
		$result = mysqli_query($this->connect, $query);
	
		$row = mysqli_fetch_array($result);
		$s_id = $row['s_id'];
		
		$query = "INSERT INTO has_completed (s_id, q_id, marks) VALUES('$s_id','$qid','$correct')";
		$result = mysqli_query($this->connect, $query);
	
	}

	public function get_course_upload_by_author($course_id) {
		$username = $_SESSION['username'];
	
		$query = "SELECT download,upload_id,title, description, filename from course_upload where approval = '1' AND course_id = '$course_id'";
		$result = mysqli_query($this->connect, $query);
		
		if($result) {	
			$xml = "<?xml version='1.0' encoding='utf-8'?><uploadlist>";				
			while($row = mysqli_fetch_array($result)){
				$num = $this->already_bookmarked($row['upload_id']);
				$num_spam = $this->is_spam($course_id,$row['upload_id']);	
				$num_rate =  $this->is_rated($row['upload_id']);
				$rating_count = $this->get_rating_count($row['upload_id']);
				$xml = $xml . "<upload>
				<title>".ucfirst($row['title'])."</title>
				<description>".ucfirst($row['description'])."</description>
				<filename>".$row['filename']."</filename>
				<id>".$row['upload_id']."</id>
				<num>".$num."</num>
				<download>".$row['download']."</download>
				<spam>".$num_spam."</spam>
				<rate>".$num_rate."</rate>
				<rate_count>".$rating_count."</rate_count>
				</upload>";
			
			}
			$xml = $xml . "</uploadlist>";
			return $xml;
		
		}

	}

	public function post_forum($name,$description,$file_name,$tmpname){
		$name  = mysql_real_escape_string($name);
		$description  = mysql_real_escape_string($description);
		$file_name  = mysql_real_escape_string($file_name);
		$username = $_SESSION['username'];
		$data = time()+(18000-1800);
		$date = date('Y-m-d H:i:s', $data );	
		$short_des  = substr($description, 0, 200);		
		$path  = "../file_system/forum/".$file_name;
	   $query  = "INSERT INTO forum_post(title,content,short_content,date,by_whom,link) VALUES ('$name','$description','$short_des','$date','$username','$path')";
	   $result = mysqli_query($this->connect,$query);
	    if($result) {
	    move_uploaded_file($tmpname , $path); 
		 chmod($path, 0777);
		 return 1;
		 }
	    else {
			return 0;	    
	    }	
	}
	public function post_forum_retrive(){
		$query  = "select * from forum_post order by post_id desc";
		$result = mysqli_query($this->connect,$query);		
		
		  
        $xml = "<?xml version='1.0' encoding='utf-8'?><forum>";
    	  while ($row = mysqli_fetch_array($result)) {
            $xml = $xml . "<forum_post><id>" . $row['post_id'] . "</id><title>" . $row['title'] . "</title><description>" . $row['content'] . "</description><date>". $row['date'] ."</date><whom>". $row['by_whom'] ."</whom><link>". $row['link'] ."</link><short>". $row['short_content'] ."</short></forum_post>";
            
        }
       $xml = $xml . "</forum>";
      
       
        return $xml;
	
	}

	/***Made changes**/
	
	public function get_comment($post_id) {
		

		$query = "SELECT s_id,comment_id, fname, lname, comment from comment join student ON comment.comment_by = student.s_id where post_id = '$post_id' ORDER BY comment_id DESC";
		$result = mysqli_query($this->connect, $query);		
		$xml = "<?xml version='1.0' encoding='utf-8'?><commentlist>";
    	  while ($row = mysqli_fetch_array($result)) {
    	  		$num = $this->already_voted($row['comment_id']);
            $xml = $xml . "<comment_info>
            <id>" . $row['comment_id'] . "</id>
            <name>" . ucwords($row['fname'].' '.$row['lname']) . "</name>
            <comment>" . $row['comment'] . "</comment>
            <s_id>".$row['s_id']."</s_id>
            <num>".$num."</num></comment_info>";
            
        }
       $xml = $xml . "</commentlist>";
       return $xml;

	}

	public function post_comment($post_id, $comment) {
		$username = $_SESSION['username'];
	 	$comment  = mysql_real_escape_string($comment);
      	$query = "select s_id from student where username='$username'";
      	$result = mysqli_query($this->connect,$query);
      	if($result) {  
				$row = mysqli_fetch_array($result);
				$s_id = $row['s_id'];		
    		}
	
			$query = "INSERT INTO comment(comment_by, post_id, comment) VALUES('$s_id','$post_id','$comment')";
			$result = mysqli_query($this->connect, $query);
			if($result)
				return 1;
			else
				return 0;
	
	}
public function retrieve_paper() {
		$query = "select tags,title,description,username,path from upload_research_paper JOIN student ON upload_research_paper.s_id = student.s_id  where paper_approval = '1'";
		$result = mysqli_query($this->connect,$query);				
		$xml = "<?xml version='1.0' encoding='utf-8'?><paper_retrieve>";
		while($row = mysqli_fetch_array($result)) {
			$xml = $xml . "<paper><tags>" . $row['tags'] . "</tags><title>" . $row['title'] . "</title><description>" . $row['description'] . "</description><username>" . $row['username'] . "</username><link>" . $row['path'] . "</link></paper>"; 
		}		
		$xml = $xml . "</paper_retrieve>";
		return $xml;
	}
public function bookmark($upload_id) {
		$username = $_SESSION['username'];
		$query = "select s_id from student where username='$username'";
		$result = mysqli_query($this->connect,$query);
		$row  = mysqli_fetch_array($result);
		$s_id = $row['s_id'];		
		$query_insert = "INSERT INTO bookmark(s_id,upload_id) VALUES ('$s_id','$upload_id')";
		mysqli_query($this->connect,$query_insert); 
	}
public function unbookmark($upload_id) {	
		$query_delete = "DELETE from bookmark where  upload_id = '$upload_id'";
		mysqli_query($this->connect,$query_delete); 
	}
public function already_bookmarked($upload_id){
		$username = $_SESSION['username'];
		$query = "select * from bookmark where upload_id='$upload_id' AND s_id IN 
							(select s_id from student where username='$username')";
		$result = mysqli_query($this->connect,$query);
		$num = mysqli_num_rows($result);
		return $num;
}
public function is_rated($upload_id){
		$username = $_SESSION['username'];
		$query = "select * from rate where upload_id='$upload_id' AND s_id IN 
							(select s_id from student where username='$username')";
		$result = mysqli_query($this->connect,$query);
		$num = mysqli_num_rows($result);
		return $num;
}
public function show_bookmark(){
		$username = $_SESSION['username'];
		$query = "select course_upload.upload_id,filename,title,description from course_upload NATURAL JOIN bookmark where s_id IN
								(select s_id from student where username='$username')";
		$result = mysqli_query($this->connect,$query);
		$xml = "<?xml version='1.0' encoding='utf-8'?><bookmarklist>";
    	  while ($row = mysqli_fetch_array($result)) {
    	
            $xml = $xml . "<bookmark>
            <id>" . $row['upload_id'] . "</id>
            <name>" . ucwords($row['title']). "</name>
            <file>" . $row['filename'] . "</file>
            <description>".$row['description']."</description></bookmark>";
            
        }
       $xml = $xml . "</bookmarklist>";
       return $xml;

}
public function report_spam($upload_id){
	$username = $_SESSION['username'];
	$query_values = "select s_id,course_id from student,course_upload where upload_id='$upload_id' AND username='$username'";
 	$result_query = mysqli_query($this->connect,$query_values);
 	$row = mysqli_fetch_array($result_query);
	$course_id = $row['course_id'];
	$s_id = $row['s_id'];
	$query = "INSERT INTO spam(upload_id,s_id,course_id) VALUES ('$upload_id','$s_id','$course_id')";
	$result = mysqli_query($this->connect,$query);
	if($result) {
		return 1;	
	}	
	return 0;

}
public function is_spam($course_id,$upload_id){
	$query = "select * from spam where upload_id='$upload_id' AND course_id='$course_id'";
	$result = mysqli_query($this->connect,$query);
	$num = mysqli_num_rows($result);
	return $num;
}


public function get_all_post($post_id) {

		if($post_id == 'latest') {
		$query = "select post.post_id, post.title, post.content, post.attach_url, post.link,
		 post.tags, author.fname, author.lname from post join author ON post.post_by = author.a_id ORDER BY post_id DESC LIMIT 5";
	}
		 else {
		 	$query = "select post.post_id, post.title, post.content, post.attach_url, post.link,
		 post.tags, author.fname, author.lname from post join author ON post.post_by = author.a_id WHERE post.post_id < '$post_id' ORDER BY post_id DESC LIMIT 5";
		 }
		 
		$result = mysqli_query($this->connect, $query);
		$xml = "<?xml version='1.0' encoding='utf-8'?><post_array>";
		while($row = mysqli_fetch_array($result)) {

				
			$xml = $xml . "<post>
			<id>".$row['post_id']."</id>
			<title>".$row['title']."</title>
			<content>".$row['content']."</content>
			<attach>".$row['attach_url']."</attach>
			<youlink>".$row['link']."</youlink>
			<tags>".$row['tags']."</tags>
			<postby>".ucwords($row['fname'].' '.$row['lname'])."</postby></post>";
		
		
		}
		$xml = $xml . "</post_array>";
		return $xml;


}
public function statistics() {
	$username = $_SESSION['username'];
	$statistics = array();
	$query = "select marks,course_name from has_completed NATURAL JOIN quiz_list NATURAL JOIN course where s_id IN
						(select s_id from student where username='$username')";
	$result = mysqli_query($this->connect,$query);
	while($row = mysqli_fetch_array($result)) { 
		 $statistics[] = $row['course_name'];
   	 $statistics[] = $row['marks'];   	
	}
	return $statistics;	
}
public function rate_slide($upload_id) {
	$username = $_SESSION['username'];
		$query = "select s_id from student where username='$username'";
		$result = mysqli_query($this->connect,$query);
		$row  = mysqli_fetch_array($result);
		$s_id = $row['s_id'];		
		$query_insert = "INSERT INTO rate(s_id,upload_id) VALUES ('$s_id','$upload_id')";
		mysqli_query($this->connect,$query_insert); 
}
public function unrate_slide($upload_id){
		$query_delete = "DELETE from rate where  upload_id = '$upload_id'";
		mysqli_query($this->connect,$query_delete); 
}
public function get_rating_count($upload_id) {
		$query = "select * from rate where upload_id = '$upload_id'";
		$result = mysqli_query($this->connect,$query);
		$num = mysqli_num_rows($result);
		return $num;	
}
public function like($comment_id){
			$username = $_SESSION['username'];
			$bylike_query = "select s_id from student where username='$username'";
			$bylike_result = mysqli_query($this->connect,$bylike_query);
			$row3 = mysqli_fetch_array($bylike_result);
			$bylike = $row3['s_id'];
			$query = "select vote_count,comment_by from comment where comment_id='$comment_id'";
			$result = mysqli_query($this->connect,$query);
			$row = mysqli_fetch_array($result);
			$s_id = $row['comment_by'];
			$vote_count = $row['vote_count'];
			$vote_count = $vote_count + 1;
			$query_insert = "UPDATE comment SET vote_count ='$vote_count' where comment_id='$comment_id'";
			mysqli_query($this->connect,$query_insert);
			$query2 = "INSERT INTO vote(s_id,comment_id) VALUES('$bylike','$comment_id')";
			mysqli_query($this->connect,$query2);
			$query_update = "select vote_count from student where s_id='$s_id'";
			$result2 = mysqli_query($this->connect,$query_update);
			$row2	= mysqli_fetch_array($result2);
			$vote = $row2['vote_count'];
			$vote = $vote + 1;
			$query_vote = "UPDATE student SET vote_count='$vote' where s_id='$s_id'";
			mysqli_query($this->connect,$query_vote);	
			
} 
public function already_voted($comment_id) {
			$username = $_SESSION['username'];
			$query = "select * from vote where comment_id='$comment_id' and s_id IN
							(select s_id from student where username='$username')";
			$result = mysqli_query($this->connect,$query);
			$num = mysqli_num_rows($result);
			return $num;
}
public function unlike($comment_id){
			$username = $_SESSION['username'];
			$bylike_query = "select s_id from student where username='$username'";
			$bylike_result = mysqli_query($this->connect,$bylike_query);
			$row3 = mysqli_fetch_array($bylike_result);
			$bylike = $row3['s_id'];
			$query = "select vote_count,comment_by from comment where comment_id='$comment_id'";
			$result = mysqli_query($this->connect,$query);
			$row = mysqli_fetch_array($result);
			$s_id = $row['comment_by'];
			$vote_count = $row['vote_count'];
			$vote_count = $vote_count - 1;
			$query_insert = "UPDATE comment SET vote_count ='$vote_count' where comment_id='$comment_id'";
			mysqli_query($this->connect,$query_insert);
			$query2 = "DELETE FROM vote where s_id='$bylike' and comment_id='$comment_id'";
			mysqli_query($this->connect,$query2);
			$query_update = "select vote_count from student where s_id='$s_id'";
			$result2 = mysqli_query($this->connect,$query_update);
			$row2	= mysqli_fetch_array($result2);
			$vote = $row2['vote_count'];
			$vote = $vote - 1;
			$query_vote = "UPDATE student SET vote_count='$vote' where s_id='$s_id'";
			mysqli_query($this->connect,$query_vote);	
			
} 


}
?>