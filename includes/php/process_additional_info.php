<?php
if (isset($_POST['call'])) {
	session_start();
	include_once 'connection.php';
	$vid_id = $_POST['vid_id'];

	$table = $_SESSION['department_1'];
	$sqlquery = "SELECT a.view_count AS view_count, 
	FROM_DAYS(TO_DAYS(b.upload_date)) AS upload_date 
		FROM " . $table . "_info a 
		INNER JOIN " . $table . " b 
		ON a.vid_id = b.vid_id
		WHERE a.vid_id ='" . $vid_id . "'";
	$stmt = mysqli_stmt_init($conn);

	if (!mysqli_stmt_prepare($stmt, $sqlquery)) {
		echo "NOT PREPARED :- " . $stmt->error;
	} else {
		if (!mysqli_stmt_execute($stmt)) {
			echo "NOT EXECUTED :- " . $stmt->error;
		} else {
			$result = mysqli_stmt_get_result($stmt);
			$data = mysqli_fetch_assoc($result);

			echo "<p class='performer_view_holder'>" . $data['view_count'] . "</p>";
			echo "<p class='performer_upload_date_holder'>" . $data['upload_date'] . "</p>";
		}
	}

	if ($_SESSION['department_1'] == $_SESSION['department']) {
		$sqlquery = "SELECT a.vid_id AS vid_id 
			FROM " . $table . " a 
			WHERE a.vid_id = '" . $vid_id . "' AND a.favorite LIKE 
			CONCAT('%',CONCAT(CONCAT(',','" . $_SESSION['user_id'] . "'),'%'))";
		$stmt = mysqli_stmt_init($conn);

		if (!mysqli_stmt_prepare($stmt, $sqlquery)) {
			echo "NOT PREPARED :- " . $stmt->error;
		} else {
			if (!mysqli_stmt_execute($stmt)) {
				echo "NOT EXECUTED :- " . $stmt->error;
			} else {
				$result = mysqli_stmt_get_result($stmt);

				if (mysqli_num_rows($result) > 0) {
					echo "<button for_video='" . $vid_id . "' class='bookmarked'></button>";
				} else {
					echo "<button for_video='" . $vid_id . "' class='bookmark'></button>";
				}
			}
		}
		echo "<p id='bookmarkAvailability' class='functionalityOnly'>TRUE</p>";
	} else {
		echo "<p id='bookmarkAvailability' class='functionalityOnly'>FALSE</p>";
	}
}

// // <img class='bookmark_img' src='../media/icons/bookmarked.svg'>
// <img class='bookmark_img' src='../media/icons/bookmark.svg'>
