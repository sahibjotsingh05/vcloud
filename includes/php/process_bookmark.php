<?php
if(isset($_POST['call'])){
	session_start();
	include_once 'connection.php';
	$vid_id = $_POST['for_video'];
	$table = $_SESSION['department'];
	$email = $_SESSION['lg_email'];
	if($_POST['condition']=='set'){
		$sqlquery = "UPDATE ".$table." 
		SET favorite = 
		CONCAT(favorite,CONCAT(',','".$_SESSION['user_id']."')) WHERE vid_id ='".$vid_id."'";
	}
	elseif ($_POST['condition']=='unset') {
		$sqlquery = "UPDATE ".$table." 
		SET favorite = 
		REPLACE(favorite,CONCAT(',','".$_SESSION['user_id']."'),'') WHERE vid_id ='".$vid_id."'";
	}

	$stmt = mysqli_stmt_init($conn);

	if (!mysqli_stmt_prepare($stmt, $sqlquery)) {
		echo "NOT PREPARED :- " . $stmt->error;
	} else {
		if (!mysqli_stmt_execute($stmt)) {
			echo "NOT EXECUTED :- " . $stmt->error;
		} else {
			if($_POST['condition']=='set'){
				echo "bookmarked";
			}else{
				echo "bookmark";
			}
		}
	}
}