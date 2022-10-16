<?php
if (isset($_POST['call'])) {
	session_start();
	include_once 'connection.php';
	$folder = '../../data/uploaded_vid/' . $_SESSION['department_1'];
	function related_search($keyword)
	{
		$sqlquery = "SELECT DISTINCT a.vid_id AS vid_id, 
						a.vid_name AS vid_name, 
						a.extension AS extension 
					FROM " . $_SESSION['department_1'] . " a
					INNER JOIN " . $_SESSION['department_1'] . "_info b
					ON a.vid_id = b.vid_id 
					WHERE a.extension NOT IN ('pdf','docx','mp3','jpg','jpeg','png','raw') 
					AND
					 (a.keyword LIKE '%-" . $keyword . "%' OR a.keyword LIKE '" . $keyword . "%') 
    				AND 
    				a.vid_id != ? 
    				ORDER BY (b.view_count / b.no_of_day) DESC, 
    				a.upload_date DESC LIMIT 3";
		global $conn;
		$stmt = mysqli_stmt_init($conn);

		if (!mysqli_stmt_prepare($stmt, $sqlquery)) {
			echo "NOT PREPARED :- " . $stmt->error;
		} else {
			mysqli_stmt_bind_param($stmt, 's', $_POST['vid_id']);
			if (!mysqli_stmt_execute($stmt)) {
				echo "NOT EXECUTED :- " . $stmt->error;
			} else {
				$result = mysqli_stmt_get_result($stmt);
				if (mysqli_num_rows($result) > 0) {
					global $folder;
					while ($data = mysqli_fetch_assoc($result)) {
						$vid_full_name = $data['vid_id'] . '.' . $data['extension'];
						$path = $folder . '/' . $vid_full_name;

						if (strlen($data['vid_name']) > 50) {
							$vid_name_dis = substr($data['vid_name'], 0, 45) . "...";
						} else {
							$vid_name_dis = $data['vid_name'];
						}

						echo "<div class='related'>";
						echo "<p class='vid_src hidden'>" . $path . "</p>";
						echo "<video class='related_video video' id='" . $data['vid_id'] . "' src='" . $path . "#t=10,20' type='video/" . $data['extension'] . "' muted></video>";
						echo "<p class='name vid_name'>" . $vid_name_dis . "</p>";
						echo "</div>";
					}
				}
			}
		}
	}


	$sqlquery = "SELECT keyword 
				 FROM " . $_SESSION['department_1'] . " 
				 WHERE vid_id = ?";
	$stmt = mysqli_stmt_init($conn);

	if (!mysqli_stmt_prepare($stmt, $sqlquery)) {
		echo "NOT PREPARED :- " . $stmt->error;
	} else {
		mysqli_stmt_bind_param($stmt, 's', $_POST['vid_id']);

		if (!mysqli_stmt_execute($stmt)) {
			echo "NOT EXECUTED :- " . $stmt->error;
		} else {
			echo "<div class='actor'>";
			echo "<video id='" . $_POST['vid_id'] . "' class='performing' src='" . $_POST['vid_src'] . "' controls></video>";
			echo "<div id='name'>" . $_POST['vid_name'] . "</div>";
			echo "<div class='additional_info'></div>";
			echo "</div>";

			$result = mysqli_stmt_get_result($stmt);
			$keyword_array = mysqli_fetch_assoc($result);

			$keyword_separated = explode('-', $keyword_array['keyword']);
			echo "<div class='relatives'>";
			for ($i = 0; $i < count($keyword_separated); $i++) {
				related_search($keyword_separated[$i]);
			}
			echo "</div>";
			// echo "<script type='text/javascript' src='../js/duplicate_filter.js'></script>";
			// echo "<script type='text/javascript' src='../js/additional_info.js'></script>";
			if ($_SESSION['department'] == $_SESSION['department_1']) {
				// echo "<script defer type='text/javascript' src='../js/history.js'></script>";
				echo "<p id='historyAvailability' class='functionalityOnly'>TRUE</p>";
			} else {
				echo "<p id='historyAvailability' class='functionalityOnly'>FALSE</p>";
			}
			// echo "<script defer type='text/javascript' src='../js/stage.js'></script>";
		}
	}
}
