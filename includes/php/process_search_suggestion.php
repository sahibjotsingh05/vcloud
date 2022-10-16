<?php
if (isset($_POST['call'])) {
	session_start();
	include_once 'connection.php';
	$table_name = $_POST['table_name'];
	$to_search = $_POST['to_search'];
	$sqlquery = 'SELECT DISTINCT vid_name FROM ' . $table_name . ' WHERE
	 vid_name LIKE "%' . $to_search . '%" LIMIT 5';
	// OR 
	// Keyword LIKE "%'.$to_search.'%" LIMIT 5';
	$stmt = mysqli_stmt_init($conn);

	if (!mysqli_stmt_prepare($stmt, $sqlquery)) {
		echo "STATEMENT NOT PREPARED. Error:- " . $stmt->error;
	} else {
		if (!mysqli_stmt_execute($stmt)) {
			echo "STATEMENT NOT EXECUTED. Error:- " . $stmt->error;
		} else {
			$result = mysqli_stmt_get_result($stmt);

			if (mysqli_num_rows($result) > 0) {
				while ($data = mysqli_fetch_assoc($result)) {
					echo "<button class='suggestion' value='" . $data['vid_name'] . "'>" . $data['vid_name'] . "</button>";
				}
				echo "<script defer src='../js/proceed.js'></script>";
			} else {
				echo "";
			}
		}
	}
}
