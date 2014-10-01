<?php
include_once("php_includes/db_conx.php");

$tbl_users = "CREATE TABLE IF NOT EXISTS users (
              id INT(11) NOT NULL AUTO_INCREMENT,
			  username VARCHAR(16) NOT NULL ,
			  email VARCHAR(255) NOT NULL ,
			  password VARCHAR(255) NOT NULL,	
			  userlevel ENUM('ordinary','expert') NOT NULL DEFAULT 'ordinary',			  
			  ip VARCHAR(255) NOT NULL,
			  signup DATETIME NOT NULL,
			  lastlogin DATETIME NOT NULL,			  
			  activated ENUM('0','1') NOT NULL DEFAULT '0',
              PRIMARY KEY (id),
			  UNIQUE KEY (username),
			  UNIQUE KEY (email)
             );";
$query = mysqli_query($db_conx, $tbl_users);
if ($query === TRUE) {
	echo "<h3>user table created OK :) </h3>"; 
} else {
	echo "<h3>user table NOT created :( </h3>"; 
}
$tbl_bookdetails = "CREATE TABLE IF NOT EXISTS bookdetails (
              BookId INT(11) NOT NULL AUTO_INCREMENT,
			  BookName varchar(255) NOT NULL,
			  Author varchar(255) NOT NULL,
			  Publisher VARCHAR(255) NOT NULL,
			  Language ENUM('Hindi','Telugu','Malayalam') NOT NULL,
			  BookUID INT(4) NOT NULL,
			  CreatorName VARCHAR(255) NOT NULL,			  
			  BookAddress VARCHAR(255) NOT NULL,			  
              PRIMARY KEY (BookId),			  
			  UNIQUE KEY (BookUID),
			  UNIQUE KEY (BookAddress)
             );";
$query = mysqli_query($db_conx, $tbl_bookdetails);
if ($query === TRUE) {
	echo "<h3>bookdetails table created OK :) </h3>"; 
} else {
	echo "<h3>bookdetails table NOT created :( </h3>"; 
}
$tbl_bookmarks = "CREATE TABLE IF NOT EXISTS bookmarks (
              id INT(11) NOT NULL AUTO_INCREMENT,
			  UserId INT(11) NOT NULL,
			  BookId INT(11) NOT NULL,
			  audiofile varchar(255) NOT NULL,
			  bookmarkname VARCHAR(255) NOT NULL,
			  bookmarktime VARCHAR(255) NOT NULL,
              PRIMARY KEY (UserId, BookId, bookmarkname),
			  UNIQUE KEY (id),
			  FOREIGN KEY (UserId)	REFERENCES users(id) ON DELETE CASCADE,
			  FOREIGN KEY (BookId)	REFERENCES bookdetails(BookId) ON DELETE CASCADE
             );";
$query = mysqli_query($db_conx, $tbl_bookmarks);
if ($query === TRUE) {
	echo "<h3>bookmarks table created OK :) </h3>"; 
} else {
	echo "<h3>bookmarks table NOT created :( </h3>"; 
}
$tbl_feedbacks = "CREATE TABLE IF NOT EXISTS feedbacks (
              Id INT(11) NOT NULL AUTO_INCREMENT,
			  UserId INT(11) NOT NULL,
			  BookId INT(11) NOT NULL,
			  audiofile varchar(255) NOT NULL,			  
			  feedbacktime VARCHAR(255) NOT NULL,
			  feedbackValue ENUM('1','2','3','4','5') NOT NULL,
              PRIMARY KEY (Id),			  
			  FOREIGN KEY (UserId)	REFERENCES users(id) ON DELETE CASCADE,
			  FOREIGN KEY (BookId)	REFERENCES bookdetails(BookId) ON DELETE CASCADE
             );";
$query = mysqli_query($db_conx, $tbl_feedbacks);
if ($query === TRUE) {
	echo "<h3>feedbacks table created OK :) </h3>"; 
} else {
	echo "<h3>feedbacks table NOT created :( </h3>"; 
}
$tbl_mybooks = "CREATE TABLE IF NOT EXISTS mybooks (
              Id INT(11) NOT NULL AUTO_INCREMENT,
			  UserId INT(11) NOT NULL,
			  BookId INT(11) NOT NULL,			  
              PRIMARY KEY (UserId, BookId),			  
			  UNIQUE KEY (Id),
			  FOREIGN KEY (UserId)	REFERENCES users(id) ON DELETE CASCADE,
			  FOREIGN KEY (BookId)	REFERENCES bookdetails(BookId) ON DELETE CASCADE
             );";
$query = mysqli_query($db_conx, $tbl_mybooks);
if ($query === TRUE) {
	echo "<h3>mybooks table created OK :) </h3>"; 
} else {
	echo "<h3>mybooks table NOT created :( </h3>"; 
}