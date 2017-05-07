<?php

class DepartmentInfo {
    
    function __construct() {
        
        $this->department_name = '';
        $this->year_name       = array();
        $this->course_upload   = array();
        
    }
    
}

class Content {
    
    
    function __construct() {
        $this->connect = mysqli_connect("localhost", "abhishek", "abhishek", "virtual_library");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        
    }
    
    public function accept_course_upload($id) {
        
        $query = "UPDATE course_upload SET approval = '1' WHERE upload_id='$id'";
        mysqli_query($this->connect, $query);
        
    }
    
    public function reject_course_upload($id, $filename) {
        
        
        $query = "DELETE FROM course_upload WHERE upload_id='$id'";
        mysqli_query($this->connect, $query);
        
        unlink($filename);
        
        
        
    }
    
    public function accept_course($id) {
        
        $query = "UPDATE course SET c_approval = '1' WHERE course_id='$id'";
        mysqli_query($this->connect, $query);
        
    }
    
    
    public function reject_course($id) {
        
        
        $query = "DELETE FROM course WHERE course_id='$id'";
        mysqli_query($this->connect, $query);
        
        $dir   = "../file_system/course/$id";
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
    
    
    
    function number_of_uploads() {
        $query  = "select dept_name,year_name,count(filename) as count from course_upload JOIN course ON course_upload.course_id = course.course_id NATURAL JOIN year NATURAL JOIN department  group by dept_id,year_id";
        $result = mysqli_query($this->connect, $query);
        
        while ($row = mysqli_fetch_array($result)) {
            
            
            $this->report[$row['dept_name']]->course_upload[$row['year_name']] = $row['count'];
            
        }
    }
    function course_request() {
        $query  = "select course_id, course_name, description, dept_name,year_name,c_approval from course NATURAL JOIN department NATURAL JOIN year where c_approval='0'";
        $result = mysqli_query($this->connect, $query);
        
        
        
        if ($result) {
            
            $xml = "<?xml version='1.0' encoding='utf-8'?><course_request>";
            while ($row = mysqli_fetch_array($result)) {
                $query       = "SELECT fname, lname from author natural join teaches where teaches.course_id = " . $row['course_id'];
                $result_name = mysqli_query($this->connect, $query);
                $name_row    = mysqli_fetch_array($result_name);
                $name        = ucwords($name_row['fname']) . " " . ucwords($name_row['lname']);
                $xml         = $xml . "<courselist><title>" . ucwords($row['course_name']) . "</title><description>" . $row['description'] . "</description><dept_name>" . $row['dept_name'] . "</dept_name><year>" . $row['year_name'] . "</year><id>" . $row['course_id'] . "</id><aname>$name</aname></courselist>";
                
            }
            $xml = $xml . "</course_request>";
            return $xml;
            
        }
        
    }
    function accepted_course_request() {
        $query  = "select course_name ,description ,dept_name,year_name,c_approval from course NATURAL JOIN department NATURAL JOIN year where c_approval='1'";
        $result = mysqli_query($this->connect, $query);
        
        if ($result) {
            
            $xml = "<?xml version='1.0' encoding='utf-8'?><course_request>";
            while ($row = mysqli_fetch_array($result)) {
                $xml = $xml . "<course_list><title>" . ucwords($row['course_name']) . "</title><description>" . $row['description'] . "</description><dept_name>" . $row['dept_name'] . "</dept_name><year>" . $row['year_name'] . "</year></course_list>";
                
            }
            $xml = $xml . "</course_request>";
            return $xml;
            
        }
        
        
    }
    
    public function dept_course_report() {
        
        
        $query  = "SELECT dept_name, year_name, count(course_id) as count from course 
			natural join department natural join year group by dept_id, year_id ";
        $result = mysqli_query($this->connect, $query);
        
        $this->report = array();
        $row          = mysqli_fetch_array($result);
        if ($row) {
            $department                               = new DepartmentInfo();
            $department->department_name              = $row['dept_name'];
            $department->year_name[$row['year_name']] = $row['count'];
        }
        
        $this->report[$row['dept_name']] = $department;
        
        while ($row = mysqli_fetch_array($result)) {
            if (isset($this->report[$row['dept_name']])) {
                
                $this->report[$row['dept_name']]->year_name[$row['year_name']] = $row['count'];
                
            } else {
                
                $department                               = new DepartmentInfo();
                $department->department_name              = $row['dept_name'];
                $department->year_name[$row['year_name']] = $row['count'];
                
                $this->report[$row['dept_name']] = $department;
                
            }
            
        }
        return $this->report;
    }
    
    function get_accepted_course() {
        $query  = "select course_id, course_name, description, dept_name,year_name,c_approval from course NATURAL JOIN department NATURAL JOIN year where c_approval='1'";
        $result = mysqli_query($this->connect, $query);
        
        
        
        if ($result) {
            
            $xml = "<?xml version='1.0' encoding='utf-8'?><course_request>";
            while ($row = mysqli_fetch_array($result)) {
                $query       = "SELECT fname, lname from author natural join teaches where teaches.course_id = " . $row['course_id'];
                $result_name = mysqli_query($this->connect, $query);
                $name_row    = mysqli_fetch_array($result_name);
                $name        = ucwords($name_row['fname']) . " " . ucwords($name_row['lname']);
                $xml         = $xml . "<courselist><title>" . ucwords($row['course_name']) . "</title><description>" . $row['description'] . "</description><dept_name>" . $row['dept_name'] . "</dept_name><year>" . $row['year_name'] . "</year><id>" . $row['course_id'] . "</id><aname>$name</aname></courselist>";
                
            }
            $xml = $xml . "</course_request>";
            return $xml;
            
        }
        
    }
    
    function get_accepted_course_upload($c_id) {
        
        $query  = "select upload_id, title, description, filename from course_upload where course_id = $c_id AND approval='0'";
        $result = mysqli_query($this->connect, $query);
        
        if ($result) {
            
            $xml = "<?xml version='1.0' encoding='utf-8'?><courseupload>";
            while ($row = mysqli_fetch_array($result)) {
                $xml = $xml . "<upload><title>" . ucwords($row['title']) . "</title><description>" . $row['description'] . "</description><filename>" . $row['filename'] . "</filename><id>" . $row['upload_id'] . "</id></upload>";
                
            }
            $xml = $xml . "</courseupload>";
            return $xml;
            
        }
        
        
    }
    
    public function research_request() {
        $query  = "select paper_id,title,description,username,path from upload_research_paper JOIN student ON upload_research_paper.s_id = student.s_id  where paper_approval = '0'";
        $result = mysqli_query($this->connect, $query);
        $xml    = "<?xml version='1.0' encoding='utf-8'?><paper_retrieve>";
        while ($row = mysqli_fetch_array($result)) {
            $xml = $xml . "<paper><id>" . $row['paper_id'] . "</id><title>" . $row['title'] . "</title><description>" . $row['description'] . "</description><username>" . $row['username'] . "</username><link>" . $row['path'] . "</link></paper>";
        }
        $xml = $xml . "</paper_retrieve>";
        return $xml;
        
    }
    
    public function accept_paper_request($id) {
        
        $query = "UPDATE upload_research_paper SET paper_approval = '1' WHERE paper_id='$id'";
        mysqli_query($this->connect, $query);
        
    }
    
    
    public function reject_paper_request($id) {
        $query  = "select path from upload_research_paper where paper_id='$id'";
        $result = mysqli_query($this->connect, $query);
        $row    = mysqli_fetch_array($result);
        $link   = $row['path'];
        $query  = "DELETE FROM upload_research_paper WHERE paper_id='$id'";
        $result = mysqli_query($this->connect, $query);
        if ($result) {
            unlink($link);
        }
    }
  	  public function show_spam_request() { 
  			$query = "select author.fname,author.lname,student.username,spam.course_id,spam.upload_id,title,course_upload.description,filename,course_name from course_upload NATURAL JOIN spam JOIN course on course.course_id = spam.course_id JOIN student ON student.s_id = spam.s_id,author where a_id IN
  									(select a_id from teaches JOIN course_upload)";
  			$result = mysqli_query($this->connect,$query);
  			 $xml    = "<?xml version='1.0' encoding='utf-8'?><spam_list>";
        	while ($row = mysqli_fetch_array($result)) {
            $xml = $xml . "<spam><author_name>".$row['fname'] ." ". $row['lname']."</author_name><course_name>".$row['course_name']."</course_name><upload_id>". $row['upload_id'] ."</upload_id><course_id>" . $row['course_id'] . "</course_id><title>" . $row['title'] . "</title><description>" . $row['description'] . "</description><username>" . $row['username'] . "</username><link>" . $row['filename'] . "</link></spam>";
        }
        $xml = $xml . "</spam_list>";
        return $xml;
  	}
      public function reject_spam_request($id) {
        
        $query = "DELETE FROM spam  WHERE upload_id='$id'";
        $result = mysqli_query($this->connect, $query);
        if($result) {
        	return 1;
        }	
        
    }
    
    
    public function accept_spam_request($id) {
        $query  = "select filename from course_upload where upload_id='$id'";
        $result = mysqli_query($this->connect, $query);
        $row    = mysqli_fetch_array($result);
        $link   = $row['filename'];
        $query  = "DELETE FROM course_upload WHERE upload_id='$id'";
        $result = mysqli_query($this->connect, $query);
        if ($result) {
            unlink($link);
            return 1;
        }
    } 
    public function all_count(){
			$query = "select count(*) as count from spam ";
			$query_course_request = "select count(*) as count from course where c_approval='0'";    
    		$query_accepted_course = "select count(*) as count from course_upload where approval='0'";
    		$query_research_paper = "select count(*) as count from upload_research_paper where paper_approval='0'";
    		$count = array();
		   $count['spam'] = mysqli_fetch_array(mysqli_query($this->connect,$query))['count'];
		   $count['course'] = mysqli_fetch_array(mysqli_query($this->connect,$query_course_request))['count'];
		   $count['course_upload'] = mysqli_fetch_array(mysqli_query($this->connect,$query_accepted_course))['count'];
		   $count['paper_upload'] = mysqli_fetch_array(mysqli_query($this->connect,$query_research_paper))['count'];
		   
		   return $count;
				
    }  
}
?>