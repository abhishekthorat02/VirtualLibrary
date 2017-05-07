<?php


class Author {
    
    
    function __construct() {
        $this->connect = mysqli_connect("localhost", "abhishek", "abhishek", "virtual_library");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        
    }
    
    function create_course($title, $description, $dept_name, $year) {
        $title         = mysql_real_escape_string($title);
        $dept_name     = mysql_real_escape_string($dept_name);
        $year          = mysql_real_escape_string($year);
        $description   = mysql_real_escape_string($description);
        $username      = $_SESSION['username'];
        $query_get     = "select dept_id from  department where dept_name ='$dept_name' ";
        $query_execute = mysqli_query($this->connect, $query_get);
        if ($query_execute) {
            $row     = mysqli_fetch_array($query_execute);
            $dept_id = $row['dept_id'];
            if ($year == 'FY') {
                $year_id = 1;
            } elseif ($year == "SY") {
                $year_id = 2;
            } elseif ($year == 'TY') {
                $year_id = 3;
            } else {
                $year_id = 4;
            }
            $query     = "INSERT INTO course(course_name,description,dept_id,year_id) values ('$title','$description','$dept_id','$year_id')";
            $result    = mysqli_query($this->connect, $query);
           
            $query_id  = "SELECT last_insert_id()";
            $result_id = mysqli_query($this->connect, $query_id);
            $row       = mysqli_fetch_array($result_id);
            $id        = $row['last_insert_id()'];
             if(isset($_POST['bullet'])) {
            $query     = "INSERT INTO bulletin(description) values ('$title course has been added for $year $dept_name')";
            $result    = mysqli_query($this->connect, $query);
         }
            mkdir("../file_system/course/" . $id, 0777, true);
            mkdir("../file_system/course/" . $id . "/slide", 0777, true);
            $query  = "select a_id from author where username='$username' ";
            $result = mysqli_query($this->connect, $query);
            $row    = mysqli_fetch_array($result);
            $a_id   = $row['a_id'];
            $query  = "INSERT INTO teaches(course_id,a_id) values ('$id','$a_id')";
            $result = mysqli_query($this->connect, $query);
            return 1;
        } else {
            return 0;
        }
    }
    
    function get_course_list() {
        $username  = $_SESSION['username'];
        $query     = "select a_id from author where username = '$username'";
        $result    = mysqli_query($this->connect, $query);
        $row       = mysqli_fetch_array($result);
        $a_id      = $row['a_id'];
        $query_get = "select course_name,description,dept_name,year_name from course natural join department natural join year  where course_id IN
									(select course_id from teaches where a_id = '$a_id' )";
        $result    = mysqli_query($this->connect, $query_get);
        
        $xml = "<?xml version='1.0' encoding='utf-8'?><courselist>";
        while ($row = mysqli_fetch_array($result)) {
            
            $xml = $xml . "<course_list><name>" . $row['course_name'] . "</name><description>" . $row['description'] . "</description><dept_name>" . $row['dept_name'] . "</dept_name><year_name>" . $row['year_name'] . "</year_name></course_list>";
            
        }
        $xml = $xml . "</courselist>";
        
        
        return $xml;
        
    }
    function add_quiz_to_list($course_id) {
        
        $query  = "INSERT INTO quiz_list(course_id) values ('$course_id')";
        $result = mysqli_query($this->connect, $query);
        
        $query  = "select last_insert_id()";
        $result = mysqli_query($this->connect, $query);
        
        $row = mysqli_fetch_array($result);
        $id  = $row['last_insert_id()'];
        
        return $id;
        
    }
    
    function add_quiz($id, $question, $option, $q_number, $q_answer) {
        $id  = mysql_real_escape_string($id);
        $question  = mysql_real_escape_string($question);
        $option[0]  = mysql_real_escape_string($option[0]);
        $option[1]  = mysql_real_escape_string($option[1]);
        $option[2]  = mysql_real_escape_string($option[2]);
        $option[3]  = mysql_real_escape_string($option[3]);
        $query  = "INSERT INTO quiz(q_id, question, option1, option2, option3, option4, q_number, q_answer) values ('$id', '$question','" . $option[0] . "','" . $option[1] . "','" . $option[2] . "','" . $option[3] . "', '$q_number', '$q_answer')";
        $result = mysqli_query($this->connect, $query);
    }
    
    function my_course() {
        $username = $_SESSION['username'];
        $query    = "select course.course_id,course.course_name, course.c_approval from course join teaches ON course.course_id = teaches.course_id where teaches.a_id IN
									(select a_id from author where username = '$username')";
        $result   = mysqli_query($this->connect, $query);
        if ($result) {
            
            $xml = "<?xml version='1.0' encoding='utf-8'?><mycourse>";
            while ($row = mysqli_fetch_array($result)) {
                $query_student = "select count(has_enrolled.s_id) as count from has_enrolled where course_id = " . $row['course_id'];
                
                $result_query = mysqli_query($this->connect, $query_student);
                $row_count    = mysqli_fetch_array($result_query);
                $count        = $row_count['count'];
                $xml          = $xml . "<course><id>" . $row['course_id'] . "</id><name>" . $row['course_name'] . "</name><count>" . $count . "</count><approved>" . $row['c_approval'] . "</approved></course>";
                
            }
            $xml = $xml . "</mycourse>";
            return $xml;
            
        }
    }
    
    
    function upload_content($title, $id, $description, $file_name, $tmp_name) {
    		$title   = mysql_real_escape_string($title);
    		$description  = mysql_real_escape_string($description);
    		$file_name = mysql_real_escape_string($file_name);
        $username = $_SESSION['username'];
        $path     = "../file_system/course/" . $id . "/slide/" . $file_name;
        $query    = "select a_id from author where username = '$username'";
        $result   = mysqli_query($this->connect, $query);
        if ($result) {
            $row   = mysqli_fetch_array($result);
            $a_id  = $row['a_id'];
            $query = "INSERT INTO course_upload(course_id,filename,title,description) VALUES ('$id','$path','$title','$description')";
            mysqli_query($this->connect, $query);
            move_uploaded_file($tmp_name, $path);
            chmod($path, 0777);
            return 1;
        } else {
            return 0;
        }
    }
    
    function delete_course($course_id) {
        $query = "DELETE FROM course WHERE course_id='$course_id'";
        mysqli_query($this->connect, $query);
        $dir   = "../file_system/course/$course_id";
        $it    = new RecursiveDirectoryIterator($dir);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->getFilename() === '.' || $file->getFilename() === '..') {
                continue;
            }
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
            
        }
        rmdir($dir);
    }
    function delete_slide($upload_id) {
        $query    = "select filename from course_upload where upload_id ='$upload_id'";
        $result   = mysqli_query($this->connect, $query);
        $row      = mysqli_fetch_array($result);
        $filename = $row['filename'];
        $query    = "DELETE FROM course_upload WHERE upload_id='$upload_id'";
        mysqli_query($this->connect, $query);
        unlink($filename);
        
    }
    function show_course_upload($c_id) {
        $query  = "select download,upload_id, title, description, filename, approval from course_upload where course_id = $c_id";
        $result = mysqli_query($this->connect, $query);
        
        if ($result) {
            
            $xml = "<?xml version='1.0' encoding='utf-8'?><courseupload>";
            while ($row = mysqli_fetch_array($result)) {
                $xml = $xml . "<upload><download>".$row['download']."</download><title>" . ucwords($row['title']) . "</title><description>" . $row['description'] . "</description><filename>" . $row['filename'] . "</filename><id>" . $row['upload_id'] . "</id><approved>" . $row['approval'] . "</approved></upload>";
                
            }
            $xml = $xml . "</courseupload>";
            return $xml;
            
        }
        
    }
    function trending_news($title, $tags, $description, $file_name, $tmpname, $link) {
    	  $title  = mysql_real_escape_string($title);
    	  $tags  = mysql_real_escape_string($tags);
    	  $description  = mysql_real_escape_string($description);
    	  $file_name  = mysql_real_escape_string($file_name);
    	  $link  = mysql_real_escape_string($link);
        $username = $_SESSION['username'];
        $path     = "../file_system/trending/" . $file_name;
        $query    = "select a_id from author where username = '$username'";
        $result   = mysqli_query($this->connect, $query);
        $row      = mysqli_fetch_array($result);
        $a_id     = $row['a_id'];
        
        $query  = "INSERT INTO post(post_by,content,title,attach_url,link,tags) VALUES ('$a_id','$description','$title','$path','$link','$tags')";
        $result = mysqli_query($this->connect, $query);
        
        if ($result) {
            move_uploaded_file($tmpname, $path);
            chmod($path, 0777);
            return 1;
        }
    }
    
  	 function restrict_download($upload_id){
			$query = "UPDATE course_upload SET download='0' where upload_id='$upload_id'";
			$result = mysqli_query($this->connect,$query);
			if($result) {
				return 1;			
			}	  	 
  	 		else {
				return 0;  	 		
  	 		}	
  	 }	
  	 	 function allow_download($upload_id){
			$query = "UPDATE course_upload SET download='1' where upload_id='$upload_id'";
			$result = mysqli_query($this->connect,$query);
			if($result) {
				return 1;			
			}	  	 
  	 		else {
				return 0;  	 		
  	 		}	
  	 }	   
    
}

?>