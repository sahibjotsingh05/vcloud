<?php
if (isset($_POST['call'])) {
    session_start();
    include_once 'connection.php';
    $table = $_SESSION['department_1'];
    $sqlquery = "SELECT DISTINCT a.vid_id AS vid_id, 
    a.vid_name AS vid_name, 
    a.extension AS extension 
    FROM " . $table . " a INNER JOIN " . $table . "_info b 
    ON a.vid_id = b.vid_id 
    WHERE a.extension NOT IN ('pdf','docx','mp3','jpg','jpeg','png','raw') 
    AND 
    FROM_DAYS(TO_DAYS(b.recent_view)) 
    BETWEEN FROM_DAYS(TO_DAYS(CURRENT_TIMESTAMP)-4) 
    AND 
    FROM_DAYS(TO_DAYS(CURRENT_TIMESTAMP)) 
    ORDER BY (b.view_count/b.no_of_day) DESC LIMIT 4";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sqlquery)) {
        return "NOT PREPARED " . $stmt->error;
    } else {
        if (!mysqli_stmt_execute($stmt)) {
            return "NOT EXECUTED " . $stmt->error;
        } else {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) {
                $folder = '../../data/uploaded_vid/' . $table;
                echo "<p class='backup_message'>No Related Videos Found :(</p>";
                echo "<p class='suggestion_message'>Our <span class='create_focus'>Suggestion</span>:</p>";
                while ($data = mysqli_fetch_assoc($result)) {
                    $vid_full_name = $data['vid_id'] . '.' . $data['extension'];
                    $path = $folder . '/' . $vid_full_name;

                    if (strlen($data['vid_name']) > 50) {
                        $vid_name_dis = substr($data['vid_name'], 0, 45) . "...";
                    } else {
                        $vid_name_dis = $data['vid_name'];
                    }

                    echo "<div class='suggested'>";
                    echo "<p class='vid_src hidden'>" . $path . "</p>";
                    echo "<video class='suggested_video video' id='" . $data['vid_id'] . "' src='" . $path . "#t=10,20' type='video/" . $data['extension'] . "' muted></video>";
                    echo "<p class='name vid_name'>" . $vid_name_dis . "</p>";
                    echo "</div>";
                }
                // echo "<script defer type='text/javascript' src='../js/stage.js'></script>";
            } else {
                echo "<p class='backup_message'>No Related <span class='create_focus'>Videos</span> Found :(</p>";
            }
        }
    }
}
