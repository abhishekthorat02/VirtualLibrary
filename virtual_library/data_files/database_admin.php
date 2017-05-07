<?php

require_once "database.php";

class Administrator {
    
    function __construct() {
        $this->connect = mysqli_connect("localhost", "abhishek", "abhishek", "virtual_library");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        
    }
    
    
    public function number_content_manager() {
        $query  = "select * from content_manager ";
        $result = mysqli_query($this->connect, $query);
        $xml    = "<ul>";
        while ($row = mysqli_fetch_array($result)) {
            
            $xml = $xml . "<li>" . $row['fname'] . " " . $row['lname'] . "<ul><li>" . $row['email'] . "</li><li>" . $row['contact_num'] . "</li></ul></li>";
            
        }
        $xml = $xml . "</ul>";
        return $xml;
    }
    
    public function add_new_department($dept_name) {
    	   $dept_name  = mysql_real_escape_string($dept_name);
        $query  = "select * from department where dept_name = '$dept_name'";
        $result = mysqli_query($this->connect, $query);
        if ($result) {
            $num = mysqli_num_rows($result);
            if ($num == 1) {
                return 0;
            } else {
                $query  = "INSERT INTO department(dept_name) VALUES ('$dept_name')";
                $result = mysqli_query($this->connect, $query);
		if(isset($_POST['check'])) {
                	$query  = "INSERT INTO bulletin(description) VALUES ('$dept_name department has been added')";
                	$result = mysqli_query($this->connect, $query);
		}
                return 1;
            }
        }
    }
    public function add_author($name, $email, $username, $password, $contact_num, $department) {
        $name       = explode(" ", $name);
        $fname      = mysql_real_escape_string($name[0]);
	if(isset($name[1])) {
       	 $lname      = mysql_real_escape_string($name[1]);
	} else {
	 $lname = '';
	}
        $department = mysql_real_escape_string($department);
        $email      = mysql_real_escape_string($email);
        $password   = base64_encode(mysql_real_escape_string($password));
        $username   = mysql_real_escape_string($username);
        $check      = new vlibDatabase();
        $return     = $check->gettype($username);
        $query      = "select dept_id from department where dept_name ='$department'";
        $result     = mysqli_query($this->connect, $query);
        $row        = mysqli_fetch_array($result);
        $dept_id    = $row['dept_id'];
        if ($return == 0) {
            $query  = "INSERT INTO author(fname,lname,email,username,password,contact_num,dept_id) VALUES ('$fname','$lname','$email','$username','$password','$contact_num','$dept_id')";
            $result = mysqli_query($this->connect, $query);
            $path   = "../file_system/author/$username";
            mkdir($path, 0777, true);
            return 1;
        } else {
            return 0;
        }
        
    }
    
    public function get_student_count() {
        
        $query  = "SELECT count(s_id) as dept_count, dept_name FROM student natural join department GROUP BY dept_id";
        $result = mysqli_query($this->connect, $query);
        
        $countArray = array();
        $i          = 0;
        $totalcount = 0;
        while ($row = mysqli_fetch_array($result)) {
            
            
            $countArray[$i++] = $row['dept_name'] . ": " . $row['dept_count'];
            $totalcount += $row['dept_count'];
            
        }
        $countArray[$i] = "Total: " . $totalcount;
        return $countArray;
        
        
        
    }
    public function get_author_count() {
        
        $query      = "SELECT count(a_id) as dept_count, dept_name FROM author natural join department GROUP BY dept_id";
        $result     = mysqli_query($this->connect, $query);
        $countArray = array();
        $i          = 0;
        $totalcount = 0;
        while ($row = mysqli_fetch_array($result)) {
            
            
            $countArray[$i++] = $row['dept_name'] . ": " . $row['dept_count'];
            $totalcount += $row['dept_count'];
            
        }
        $countArray[$i] = "Total: " . $totalcount;
        return $countArray;
        
        
        
    }
    public function add_content_manager($name, $password, $contact_num, $email, $username) {
        
        $name     = mysql_real_escape_string($name);
        $name     = explode(" ", $name);
        $check    = new vlibDatabase();
        $fname    = isset($name[0]) ? $name[0] : "";
        $lname    = isset($name[1]) ? $name[1] : "";
        $email    = mysql_real_escape_string($email);
        $password = base64_encode(mysql_real_escape_string($password));
        $username = mysql_real_escape_string($username);
        $return   = $check->gettype($username);
        if ($return == 0) {
            $query  = "INSERT INTO content_manager(fname, lname, username, password, contact_num, email) VALUES('$fname', '$lname', '$username' ,'$password', '$contact_num', '$email')";
            $result = mysqli_query($this->connect, $query);
            if ($result)
                return 1;
            else
                return 0;
            
        } else {
            
            return 2;
        }
        
    }
    public function user_list() {
        $query  = "select s_id, fname,lname,dept_name,year_name,email,blocked from student natural join department natural join year where approval = '1' ORDER BY dept_id,year_id";
        $result = mysqli_query($this->connect, $query);
        if ($result) {
            
            $xml = "<?xml version='1.0' encoding='utf-8'?><userlist>";
            while ($row = mysqli_fetch_array($result)) {
                
                $xml = $xml . "<user><id>" . $row['s_id'] . "</id><name>" . $row['fname'] . " " . $row['lname'] . "</name><dept_name>" . $row['dept_name'] . "</dept_name><year_name>" . $row['year_name'] . "</year_name><email>" . $row['email'] . "</email><blocked>" . $row['blocked'] . "</blocked></user>";
                
            }
            $xml = $xml . "</userlist>";
            
        }
        return $xml;
        
    }
    
    
    public function get_user_request() {
        
        $query  = "SELECT s_id,fname, lname, dept_name, year_name from student natural join department natural join year where approval = 0";
        $result = mysqli_query($this->connect, $query);
        $xml    = "<?xml version='1.0' encoding='utf-8'?><userrequest>";
        while ($row = mysqli_fetch_array($result)) {
            
            $xml .= "<user><id>" . $row['s_id'] . "</id><name>" . $row['fname'] . " " . $row['lname'] . "</name><dept>" . $row['dept_name'] . "</dept><year>" . $row['year_name'] . "</year></user>";
            
            
        }
        $xml .= "</userrequest>";
        return $xml;
        
    }
    
    public function block_user($id) {
        $query = "UPDATE student SET blocked='1' where s_id='$id'";
        mysqli_query($this->connect, $query);
    }
    public function unblock_user($id) {
        $query = "UPDATE student SET blocked='0' where s_id='$id'";
        mysqli_query($this->connect, $query);
    }
    public function accept_user($id) {
        $query = "UPDATE student SET approval='1' where s_id='$id'";
        if (mysqli_query($this->connect, $query)) {
            $query_mail = "select email,fname,username,password from student where s_id='$id'";
            $result     = mysqli_query($this->connect, $query_mail);
            $row        = mysqli_fetch_array($result);
            $email      = $row['email'];
            $fname      = $row['fname'];
            $username   = $row['username'];
            $password   = base64_decode($row['password']);
            $from       = "library.virtual1@gmail.com";
            mail($email, "Welcome to virtual library", "Dear '$fname' , your account with username:'$username' and password:'$password' has been added to virtual library.you can check out awesome virtual library  ", "FROM:$from");
        }
        
    }
    public function reject_user($id) {
        
        $query    = "select username,email from student where s_id='$id'";
        $result   = mysqli_query($this->connect, $query);
        $row      = mysqli_fetch_array($result);
        $username = $row['username'];
        $email    = $row['email'];
        $query    = "DELETE FROM student WHERE s_id='$id'";
        mysqli_query($this->connect, $query);
        $from = "library.virtual1@gmail.com";
        mail($email, "Virtual library ", "Dear, your account with username:'$username' has been rejected from virtual library ", "FROM:$from");
        $dir   = "../file_system/student/" . $username;
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
    public function show_blocked_users() {
        $query  = "select s_id,fname,lname,dept_name,year_name from student natural join department natural join year where blocked='1' and approval='1' ORDER BY dept_id ";
        $result = mysqli_query($this->connect, $query);
        if ($result) {
            $xml = "<?xml version='1.0' encoding='utf-8'?><blockeduser>";
            while ($row = mysqli_fetch_array($result)) {
                
                $xml .= "<block><id>" . $row['s_id'] . "</id><name>" . $row['fname'] . " " . $row['lname'] . "</name><dept>" . $row['dept_name'] . "</dept><year>" . $row['year_name'] . "</year></block>";
                
                
            }
            $xml .= "</blockeduser>";
            return $xml;
        }
    }
	public function get_count(){
		   $query = "select count(*) as count from student ";
			$query_student_request = "select count(*) as count from student where approval='0'";    
    		$query_blocked = "select count(*) as count from student where blocked='1'";
    		$count = array();
		   $count['user'] = mysqli_fetch_array(mysqli_query($this->connect,$query))['count'];
		   $count['block'] = mysqli_fetch_array(mysqli_query($this->connect,$query_blocked))['count'];
		   $count['request'] = mysqli_fetch_array(mysqli_query($this->connect,$query_student_request))['count'];
		  
		   
		   return $count;	
	
	}    
}
?>
