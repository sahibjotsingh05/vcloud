<?php
include_once '../includes/php/connection.php';
$subjects = array('science', 'math','social_science');
//'punjabi', 'science', 'math', //'social_science', 'commerce', 'humanities', 'junior', 'generals');

function auto_server_detail(){
	$sqlquery = "CREATE TABLE server_detail(
	active_for int(255),
	server_date datetime DEFAULT CURRENT_TIMESTAMP,
	first_login boolean DEFAULT 0) ENGINE='InnoDB'";

	global $conn;
	mysqli_query($conn, $sqlquery);
	echo $conn->error;

	$sqlquery_1 = "INSERT INTO server_detail(active_for, first_login) VALUES(0,0)";

	global $conn;
	mysqli_query($conn, $sqlquery_1);
	echo $conn->error;
}

function auto_department(){
    $sqlquery = "CREATE TABLE department(
    name varchar(200),
    id int(11),
    CONSTRAINT department_name_U UNIQUE(name),
    CONSTRAINT department_id_PK PRIMARY KEY(id)) ENGINE='InnoDB'";

    global $conn;
	mysqli_query($conn, $sqlquery);
    echo $conn->error;
}

function auto_user(){
    $sqlquery = "CREATE TABLE user_account(
	user_id varchar(200),
    name varchar(200),
    email varchar(200),
    dept_id int(11),
    creation datetime DEFAULT CURRENT_TIMESTAMP,
    user_pass varchar(200),
    hod tinyint(1) DEFAULT 0,
    CONSTRAINT user_account_user_id_PK PRIMARY KEY(user_id),
    CONSTRAINT user_account_email_U UNIQUE(email),
    CONSTRAINT user_account_dept_id_FK FOREIGN KEY(dept_id)
    REFERENCES department(id)
    ON UPDATE CASCADE ON DELETE CASCADE) ENGINE='InnoDB'";

    global $conn;
	mysqli_query($conn, $sqlquery);
    echo $conn->error;
}

function auto_subject($mention_subject){
    $sqlquery = "CREATE TABLE ".$mention_subject."(
    vid_id varchar(200),
    vid_name varchar(200),
    keyword varchar(200),
    extension varchar(200),
    upload_date datetime DEFAULT CURRENT_TIMESTAMP,
    time_duration double(10,4) DEFAULT 0,
    favorite varchar(255) NOT NULL,
    CONSTRAINT ".$mention_subject."_vid_id_PK PRIMARY KEY(vid_id))  ENGINE='InnoDB'";
	global $conn;
	mysqli_query($conn, $sqlquery);
    echo $conn->error;
}

function auto_history($mention_subject){
	$sqlquery = "CREATE TABLE ".$mention_subject."_history(
    vid_id varchar(200),
    watch_date datetime DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT ".$mention_subject."_history_vid_id_FK FOREIGN KEY(vid_id)
    REFERENCES ".$mention_subject."(vid_id)
    ON UPDATE CASCADE ON DELETE CASCADE) ENGINE='InnoDB'";

	global $conn;
	mysqli_query($conn, $sqlquery);
    echo $conn->error;
}

function auto_info($mention_subject){
$sqlquery ='CREATE TABLE '.$mention_subject.'_info(
    vid_id varchar(200),
    view_count int(20),
    recommended int(10),
    no_of_day int(10) DEFAULT 0,
    first_view boolean DEFAULT false,
    recent_view datetime,
    CONSTRAINT '.$mention_subject.'_info_vid_id_U UNIQUE(vid_id),
    CONSTRAINT '.$mention_subject.'_info_vid_id_FK FOREIGN KEY(vid_id)
    REFERENCES '.$mention_subject.'(vid_id) ON DELETE CASCADE ON UPDATE CASCADE) ENGINE="InnoDB"';
	global $conn;
	mysqli_query($conn, $sqlquery);
	echo $conn->error;
}

function auto_insert_subject($mention_subject, $subject_id){
$sqlquery =
'INSERT INTO department(name, id) VALUES("'.$mention_subject.'","'. $subject_id.'")';
	global $conn;
	mysqli_query($conn, $sqlquery);
	echo $conn->error;
}
#auto_server_detail();
auto_department();
#auto_user();
for($i = 0; $i<count($subjects); $i++){
   #auto_insert_subject($subjects[$i], $i+1);
   auto_subject($subjects[$i]);
   auto_history($subjects[$i]);
   auto_info($subjects[$i]);
}
