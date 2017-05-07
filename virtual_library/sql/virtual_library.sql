-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 11, 2014 at 01:32 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `virtual_library`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE IF NOT EXISTS `administrator` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(64) NOT NULL,
  `lname` varchar(64) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  `contact_num` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `contact_num` (`contact_num`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`admin_id`, `fname`, `lname`, `username`, `password`, `contact_num`, `email`) VALUES
(1, 'abhishek', 'thorat', 'scooby02', 'TW9oYW4xMjMk', '9096333203', 'abhishekthorat02@gmail.com'),
(2, 'faiz', 'halde', 'faizhalde', 'c3R1ZGVudA==', '9665806995', 'faiz_84123@yahoo.com');

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE IF NOT EXISTS `author` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(64) NOT NULL,
  `lname` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  `contact_num` varchar(10) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `vote_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`a_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `contact_num` (`contact_num`),
  KEY `dept_id` (`dept_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`a_id`, `fname`, `lname`, `email`, `username`, `password`, `contact_num`, `dept_id`, `vote_count`) VALUES
(2, 'abhijit', 'meenakshi', 'abhijit@gmail.com', 'abhijit', 'YWJoaWppdA==', '9665806995', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE IF NOT EXISTS `bookmark` (
  `upload_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  UNIQUE KEY `upload_id` (`upload_id`,`s_id`),
  UNIQUE KEY `upload_id_2` (`upload_id`,`s_id`),
  UNIQUE KEY `upload_id_4` (`upload_id`,`s_id`),
  KEY `upload_id_3` (`upload_id`),
  KEY `s_id` (`s_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bulletin`
--

CREATE TABLE IF NOT EXISTS `bulletin` (
  `bullet_id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(512) NOT NULL,
  PRIMARY KEY (`bullet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `bulletin`
--

INSERT INTO `bulletin` (`bullet_id`, `description`) VALUES
(1, 'management department has been added'),
(3, 'Operating systems course has been added for TY computer'),
(4, 'Data structures course has been added for TY computer');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `comment_by` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `vote_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`),
  KEY `post_id` (`post_id`),
  KEY `comment_by` (`comment_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_by`, `post_id`, `comment`, `comment_id`, `vote_count`) VALUES
(46, 1, 'hellp', 1, 0),
(46, 1, 'csadfasd', 2, 0),
(45, 1, 'hello', 3, 1),
(45, 1, 'asd', 4, 1),
(46, 2, 'coola\n', 5, 1),
(46, 2, 'awesome\n', 6, 0),
(46, 2, 'cool', 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `content_manager`
--

CREATE TABLE IF NOT EXISTS `content_manager` (
  `cm_id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(64) NOT NULL,
  `lname` varchar(64) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  `contact_num` varchar(10) NOT NULL,
  `email` varchar(64) NOT NULL,
  PRIMARY KEY (`cm_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `contact_num` (`contact_num`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `content_manager`
--

INSERT INTO `content_manager` (`cm_id`, `fname`, `lname`, `username`, `password`, `contact_num`, `email`) VALUES
(1, 'vinayak', 'malhotra', 'vinayak', 'c2Frc2hp', '9405587621', 'vinayak.malhotra20@gmail.com'),
(2, 'siddhesh', 'narvekar', 'siddhesh', 'bXVnZGhh', '9773158934', 'siddhesh.narvekar@gmail.com'),
(6, 'Mohan', 'Thorat', 'Mohan', 'bW9oYW4=', '9405050536', 'mohan.thorat1998@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(64) NOT NULL,
  `description` varchar(512) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `c_approval` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`course_id`),
  KEY `dept_id` (`dept_id`),
  KEY `year_id` (`year_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `description`, `dept_id`, `year_id`, `c_approval`) VALUES
(2, 'Operating systems', 'good course', 1, 3, 1),
(3, 'Data structures', 'Cool subject ,but includes awesome pointers concepts', 1, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `course_upload`
--

CREATE TABLE IF NOT EXISTS `course_upload` (
  `upload_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `filename` varchar(256) NOT NULL,
  `title` varchar(64) NOT NULL,
  `description` varchar(512) NOT NULL,
  `approval` int(11) NOT NULL DEFAULT '0',
  `download` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`upload_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `course_upload`
--

INSERT INTO `course_upload` (`upload_id`, `course_id`, `filename`, `title`, `description`, `approval`, `download`) VALUES
(2, 2, '../file_system/course/2/slide/0credit_u.tar.gz', 'credit_suisse', '"Cool project written in php"\r\n\r\n"No of lines : 32k"', 1, 1),
(3, 2, '../file_system/course/2/slide/0Action Scripting In Macromedia Flash Mx.pdf', 'chapter1', 'You asked, Font Awesome delivers with 11 shiny new icons in version 4.0. Want to request new icons? Here''s how. Need vectors or want to use on the desktop? Check the cheatsheet.', 1, 1),
(4, 2, '../file_system/course/2/slide/0DBMS.PDF', 'chapter2', 'You asked, Font Awesome delivers with 11 shiny new icons in version 4.0. Want to request new icons? Here''s how. Need vectors or want to use on the desktop? Check the cheatsheet.', 1, 1),
(5, 2, '../file_system/course/2/slide/0RDBMS Fundamentals.pdf', 'chapter3', 'You asked, Font Awesome delivers with 11 shiny new icons in version 4.0. Want to request new icons? Here''s how. Need vectors or want to use on the desktop? Check the cheatsheet.', 1, 1),
(6, 2, '../file_system/course/2/slide/0_Beginner PHP Tutorial - 4 - Creating Your First PHP File_â€.mp4', 'chapter4', 'You asked, Font Awesome delivers with 11 shiny new icons in version 4.0. Want to request new icons? Here''s how. Need vectors or want to use on the desktop? Check the cheatsheet.', 1, 1),
(7, 2, '../file_system/course/2/slide/0_Beginner PHP Tutorial - 12 - Embedding PHP Inside HTML_â€.mp4', 'chapter5', 'You asked, Font Awesome delivers with 11 shiny new icons in version 4.0. Want to request new icons? Here''s how. Need vectors or want to use on the desktop? Check the cheatsheet.', 1, 1),
(8, 3, '../file_system/course/3/slide/0â–¶ Buckys C++ Programming Tutorials - 60 - class Templates - YouTube [360p].mp4', 'chapter1', 'You asked, Font Awesome delivers with 11 shiny new icons in version 4.0. Want to request new icons? Here''s how. Need vectors or want to use on the desktop? Check the cheatsheet.', 1, 1),
(9, 3, '../file_system/course/3/slide/0Buckys C++ Programming Tutorials - 2 - Understanding a Simple C++ Program.mp4', 'chapter2', 'You asked, Font Awesome delivers with 11 shiny new icons in version 4.0. Want to request new icons? Here''s how. Need vectors or want to use on the desktop? Check the cheatsheet.', 1, 1),
(10, 3, '../file_system/course/3/slide/002 - Bewakoofiyaan - Khamakhaan [DJMaza.Info].mp3', 'chapter3', 'You asked, Font Awesome delivers with 11 shiny new icons in version 4.0. Want to request new icons? Here''s how. Need vectors or want to use on the desktop? Check the cheatsheet.', 1, 1),
(11, 3, '../file_system/course/3/slide/0File Handling.c', 'chapter4', '', 0, 1),
(12, 3, '../file_system/course/3/slide/0Time Complexity.txt', 'chapter5', 'You asked, Font Awesome delivers with 11 shiny new icons in version 4.0. Want to request new icons? Here''s how. Need vectors or want to use on the desktop? Check the cheatsheet.', 0, 1),
(13, 3, '../file_system/course/3/slide/0Queue.txt', 'chapter6', 'You asked, Font Awesome delivers with 11 shiny new icons in version 4.0. Want to request new icons? Here''s how. Need vectors or want to use on the desktop? Check the cheatsheet.', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `dept_id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(64) NOT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dept_id`, `dept_name`) VALUES
(1, 'computer'),
(2, 'electrical'),
(3, 'entc'),
(4, 'civil'),
(5, 'production'),
(6, 'metallurgy'),
(7, 'Instrumentation'),
(8, 'Mechanical'),
(9, 'town planning'),
(13, 'management');

-- --------------------------------------------------------

--
-- Table structure for table `forum_post`
--

CREATE TABLE IF NOT EXISTS `forum_post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `content` longtext NOT NULL,
  `date` datetime NOT NULL,
  `by_whom` varchar(64) NOT NULL,
  `link` varchar(256) NOT NULL,
  `short_content` varchar(128) NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `by_whom` (`by_whom`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `forum_post`
--

INSERT INTO `forum_post` (`post_id`, `title`, `content`, `date`, `by_whom`, `link`, `short_content`) VALUES
(1, 'asd', 'asd', '2014-03-10 13:26:46', 'abhithecool', '../file_system/forum/0', 'asd'),
(2, 'cool', 'cool', '2014-03-10 20:51:51', 'abhithecool', '../file_system/forum/0', 'cool');

-- --------------------------------------------------------

--
-- Table structure for table `has_completed`
--

CREATE TABLE IF NOT EXISTS `has_completed` (
  `s_id` int(11) NOT NULL,
  `q_id` int(11) NOT NULL,
  `marks` float NOT NULL DEFAULT '0',
  UNIQUE KEY `s_id` (`s_id`,`q_id`),
  KEY `s_id_2` (`s_id`),
  KEY `q_id` (`q_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `has_completed`
--

INSERT INTO `has_completed` (`s_id`, `q_id`, `marks`) VALUES
(45, 1, 0),
(46, 1, 0),
(46, 2, 100),
(51, 1, 100);

-- --------------------------------------------------------

--
-- Table structure for table `has_enrolled`
--

CREATE TABLE IF NOT EXISTS `has_enrolled` (
  `s_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  UNIQUE KEY `s_id` (`s_id`,`course_id`),
  KEY `s_id_2` (`s_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `has_enrolled`
--

INSERT INTO `has_enrolled` (`s_id`, `course_id`) VALUES
(45, 2),
(46, 2),
(51, 2);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_by` int(11) NOT NULL,
  `content` varchar(1024) NOT NULL,
  `title` varchar(64) NOT NULL,
  `attach_url` varchar(512) NOT NULL,
  `link` varchar(1024) NOT NULL,
  `tags` varchar(128) NOT NULL,
  PRIMARY KEY (`post_id`),
  UNIQUE KEY `attach_url` (`attach_url`),
  KEY `post_by` (`post_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `post_by`, `content`, `title`, `attach_url`, `link`, `tags`) VALUES
(1, 2, 'Looking forward', 'Two states', '../file_system/trending/0Queue.txt', 'http://www.youtube.com/watch?v=CGyAaR2aWcA', 'ali bhatt '),
(2, 2, 'My favorite player ....open source player ', 'Leo messi -the greatest player', '../file_system/trending/0images.jpg', 'http://www.youtube.com/watch?v=8cBIAwh4EjA', 'Messi,Barcelona,'),
(3, 2, 'how news are shown to students', 'cool', '../file_system/trending/0', 'http://www.youtube.com/watch?v=wsf78BS9VE0', 'best programming ever '),
(4, 2, 'ASD', 'ASD', '../file_system/trending/1images.jpg', 'https://www.youtube.com/watch?v=RnH_Um49GNo', 'ASD'),
(8, 2, 'asd', 'asd', '../file_system/trending/0dump1.py', 'https://www.youtube.com/watch?v=dZOOSby1qec', 'asd');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE IF NOT EXISTS `quiz` (
  `q_id` int(11) NOT NULL,
  `question` varchar(128) NOT NULL,
  `option1` varchar(64) NOT NULL,
  `option2` varchar(64) NOT NULL,
  `option3` varchar(64) NOT NULL,
  `option4` varchar(64) NOT NULL,
  `q_number` int(11) NOT NULL,
  `q_answer` int(11) NOT NULL,
  UNIQUE KEY `question` (`question`,`option1`,`option2`,`option3`,`option4`,`q_answer`),
  KEY `q_id` (`q_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`q_id`, `question`, `option1`, `option2`, `option3`, `option4`, `q_number`, `q_answer`) VALUES
(2, 'cool', 'cool', 'cool', 'cool', 'coll', 0, 1),
(1, 'what is sheduler', 'for sheduling process', 'option 1', 'option 2', 'all', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_list`
--

CREATE TABLE IF NOT EXISTS `quiz_list` (
  `q_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  PRIMARY KEY (`q_id`),
  UNIQUE KEY `q_id` (`q_id`,`course_id`),
  KEY `q_id_2` (`q_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `quiz_list`
--

INSERT INTO `quiz_list` (`q_id`, `course_id`) VALUES
(1, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE IF NOT EXISTS `rate` (
  `upload_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  UNIQUE KEY `upload_id` (`upload_id`,`s_id`),
  UNIQUE KEY `upload_id_2` (`upload_id`,`s_id`),
  KEY `s_id` (`s_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rate`
--

INSERT INTO `rate` (`upload_id`, `s_id`) VALUES
(6, 46);

-- --------------------------------------------------------

--
-- Table structure for table `spam`
--

CREATE TABLE IF NOT EXISTS `spam` (
  `upload_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  UNIQUE KEY `upload_id` (`upload_id`,`course_id`),
  UNIQUE KEY `upload_id_3` (`upload_id`,`course_id`),
  KEY `upload_id_2` (`upload_id`),
  KEY `course_id` (`course_id`),
  KEY `s_id` (`s_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(64) NOT NULL,
  `lname` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  `profile_link` varchar(512) NOT NULL,
  `approval` tinyint(1) NOT NULL DEFAULT '0',
  `vote_count` int(11) NOT NULL DEFAULT '0',
  `blocked` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`s_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `year_id` (`year_id`),
  KEY `dept_id` (`dept_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`s_id`, `fname`, `lname`, `email`, `dept_id`, `year_id`, `username`, `password`, `profile_link`, `approval`, `vote_count`, `blocked`) VALUES
(45, 'faiz', 'halde', 'cr7lmessi10@gmail.com', 1, 3, 'faiz', 'ZmFpeg==', '../file_system/student/faiz/faizu.jpg', 1, 2, 0),
(46, 'Abhishek', 'Thorat', 'abhishekthebuddy@gmail.com', 1, 3, 'abhithecool', 'YWJoaXNoZWs=', '../file_system/student/abhithecool/profile.jpg', 1, 2, 0),
(47, 'vinayak', 'malhotra', 'vin.malhotra@gmail.com', 1, 3, 'vinayak', 'dmluYXlhaw==', '../file_system/student/vinayak/vin.jpg', 1, 0, 0),
(48, 'abhishek', 'Badhe', 'badheabhishek@gmail.com', 4, 3, 'abhishek', 'YWJoaXNoZWs=', '../file_system/student/abhishek/abhi.jpg', 1, 0, 0),
(49, 'Ketan', 'Vazirabadkar', 'ketan.vazir@gmail.com', 1, 3, 'kets', 'a2V0YW4=', '../file_system/student/kets/kets.jpg', 1, 0, 0),
(50, 'Ajay', 'Wavhale', 'ajaywavhale@gmail.com', 3, 3, 'ajay', 'YWpheQ==', '../file_system/student/ajay/wav.jpg', 1, 0, 0),
(51, 'dipak', 'nan', 'dipak@gmail.com', 4, 3, 'dipak', 'ZGlwYWs=', '../file_system/student/dipak/images.jpg', 1, 0, 0),
(52, 'ajlf343', 'lajdflj', 'aljdflj@c.com', 1, 1, 'anu', 'YW51', '../file_system/student/anu/images.jpg', 1, 0, 0),
(54, 'siddhesh', 'Narvekar', 'sid@gmail.com', 1, 3, 'sid', 'c2lk', '../file_system/student/sid/62779_556745527693491_263368179_n.jpg', 1, 0, 0),
(55, 'manoj', 'siddhewad', 'manoj@b.com', 2, 3, 'manoj', 'bWFub2o=', '../file_system/student/manoj/1658471_548990588531447_184211916_o.jpg', 1, 0, 0),
(56, 'akash', 'shirsath', 'aka@gm.com', 8, 3, 'akash', 'YWthc2g=', '../file_system/student/akash/1240466_1389123051351981_1009310166_n.jpg', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `teaches`
--

CREATE TABLE IF NOT EXISTS `teaches` (
  `course_id` int(11) NOT NULL,
  `a_id` int(11) NOT NULL,
  UNIQUE KEY `course_id` (`course_id`,`a_id`),
  KEY `course_id_2` (`course_id`),
  KEY `a_id` (`a_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teaches`
--

INSERT INTO `teaches` (`course_id`, `a_id`) VALUES
(2, 2),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `upload_research_paper`
--

CREATE TABLE IF NOT EXISTS `upload_research_paper` (
  `title` varchar(128) NOT NULL,
  `tags` varchar(128) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `path` varchar(256) NOT NULL,
  `s_id` int(11) NOT NULL,
  `paper_id` int(11) NOT NULL AUTO_INCREMENT,
  `paper_approval` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`paper_id`),
  KEY `s_id` (`s_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `upload_research_paper`
--

INSERT INTO `upload_research_paper` (`title`, `tags`, `description`, `path`, `s_id`, `paper_id`, `paper_approval`) VALUES
('no file', 'nothing', 'You asked, Font Awesome delivers with 11 shiny new icons in version 4.0. Want to request new icons? Here''s how. Need vectors or want to use on the desktop? Check the cheatsheet.', '../file_system/student/faiz/papers/0File Handling.c', 45, 1, 1),
('prepartion', 'mid sem', 'You asked, Font Awesome delivers with 11 shiny new icons in version 4.0. Want to request new icons? Here''s how. Need vectors or want to use on the desktop? Check the cheatsheet.', '../file_system/student/faiz/papers/0Preparatory notes for Mid-Semester Exam', 45, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE IF NOT EXISTS `vote` (
  `s_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  UNIQUE KEY `s_id` (`s_id`,`comment_id`),
  UNIQUE KEY `s_id_2` (`s_id`,`comment_id`),
  KEY `comment_id` (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`s_id`, `comment_id`) VALUES
(46, 3),
(46, 4),
(46, 5),
(46, 7);

-- --------------------------------------------------------

--
-- Table structure for table `year`
--

CREATE TABLE IF NOT EXISTS `year` (
  `year_id` int(11) NOT NULL AUTO_INCREMENT,
  `year_name` varchar(64) NOT NULL,
  PRIMARY KEY (`year_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `year`
--

INSERT INTO `year` (`year_id`, `year_name`) VALUES
(1, 'FY'),
(2, 'SY'),
(3, 'TY'),
(4, 'Final');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `author`
--
ALTER TABLE `author`
  ADD CONSTRAINT `author_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD CONSTRAINT `bookmark_ibfk_1` FOREIGN KEY (`upload_id`) REFERENCES `course_upload` (`upload_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookmark_ibfk_2` FOREIGN KEY (`s_id`) REFERENCES `student` (`s_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `forum_post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`comment_by`) REFERENCES `student` (`s_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `course_ibfk_2` FOREIGN KEY (`year_id`) REFERENCES `year` (`year_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `course_upload`
--
ALTER TABLE `course_upload`
  ADD CONSTRAINT `course_upload_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `forum_post`
--
ALTER TABLE `forum_post`
  ADD CONSTRAINT `forum_post_ibfk_1` FOREIGN KEY (`by_whom`) REFERENCES `student` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `has_completed`
--
ALTER TABLE `has_completed`
  ADD CONSTRAINT `has_completed_ibfk_1` FOREIGN KEY (`s_id`) REFERENCES `student` (`s_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `has_completed_ibfk_2` FOREIGN KEY (`q_id`) REFERENCES `quiz_list` (`q_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `has_enrolled`
--
ALTER TABLE `has_enrolled`
  ADD CONSTRAINT `has_enrolled_ibfk_1` FOREIGN KEY (`s_id`) REFERENCES `student` (`s_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `has_enrolled_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`post_by`) REFERENCES `author` (`a_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`q_id`) REFERENCES `quiz_list` (`q_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz_list`
--
ALTER TABLE `quiz_list`
  ADD CONSTRAINT `quiz_list_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rate`
--
ALTER TABLE `rate`
  ADD CONSTRAINT `rate_ibfk_1` FOREIGN KEY (`upload_id`) REFERENCES `course_upload` (`upload_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rate_ibfk_2` FOREIGN KEY (`s_id`) REFERENCES `student` (`s_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `spam`
--
ALTER TABLE `spam`
  ADD CONSTRAINT `spam_ibfk_1` FOREIGN KEY (`upload_id`) REFERENCES `course_upload` (`upload_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `spam_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `spam_ibfk_3` FOREIGN KEY (`s_id`) REFERENCES `student` (`s_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`year_id`) REFERENCES `year` (`year_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `teaches`
--
ALTER TABLE `teaches`
  ADD CONSTRAINT `teaches_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teaches_ibfk_2` FOREIGN KEY (`a_id`) REFERENCES `author` (`a_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `upload_research_paper`
--
ALTER TABLE `upload_research_paper`
  ADD CONSTRAINT `upload_research_paper_ibfk_1` FOREIGN KEY (`s_id`) REFERENCES `student` (`s_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `vote_ibfk_1` FOREIGN KEY (`s_id`) REFERENCES `student` (`s_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vote_ibfk_2` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`comment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
