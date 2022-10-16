<?php
include_once 'connection.php';
if (isset($_GET['show'])) {
    $table = $_GET['show'];
    $not_from_department = FALSE;
    $_SESSION['department_1'] = $table;
    if ($_SESSION['department'] !== $_SESSION['department_1']) {
        $not_from_department = TRUE;
    }
    if ($_GET['condition'] === 'default') {
        $condition = '0.40*(b.view_count / b.no_of_day) + 0.60*(b.recommended) DESC';

        $sqlquery = "SELECT a.vid_id AS vid_id, a.vid_name AS vid_name, a.extension AS extension
            FROM " . $table . " a
            INNER JOIN " . $table . "_info b
            ON a.vid_id = b.vid_id
            WHERE a.extension NOT IN ('pdf','docx','mp3','jpg','jpeg','png','raw') 
            ORDER BY " . $condition . ", a.time_duration, a.upload_date DESC LIMIT 20";
    }

    if ($_GET['condition'] === 'fast_growth') {
        $condition = '(b.view_count / b.no_of_day) DESC, 
        b.recent_view DESC, 
        a.time_duration ASC';

        $sqlquery = "SELECT a.vid_id AS vid_id, 
        a.vid_name AS vid_name, 
        a.extension AS extension
            FROM " . $table . " a
            INNER JOIN " . $table . "_info b
            ON a.vid_id = b.vid_id 
            WHERE a.extension NOT IN ('pdf','docx','mp3','jpg','jpeg','png','raw') 
            AND 
            b.recent_view 
            BETWEEN 
            CONCAT(
                FROM_DAYS(TO_DAYS((SELECT MAX(recent_view) FROM " . $table . "_info))-7), 
                CONCAT(
                    ' ',
                    MAKETIME(
                        EXTRACT(HOUR FROM (SELECT MAX(recent_view) FROM " . $table . "_info)), 
                        EXTRACT(MINUTE FROM (SELECT MAX(recent_view) FROM " . $table . "_info)), 
                        EXTRACT(SECOND FROM (SELECT MAX(recent_view) FROM " . $table . "_info))
                    )
                )
            )  
            AND  
            (SELECT MAX(recent_view) FROM " . $table . "_info)  
            ORDER BY " . $condition . " LIMIT 20";
    }

    if ($_GET['condition'] === 'document') {
        $sqlquery = "SELECT a.vid_id AS vid_id, 
        a.vid_name AS vid_name, 
        a.extension AS extension 
        FROM " . $table . " a 
        WHERE a.extension IN ('pdf','docx','mp3','jpg','jpeg','png','raw') 
        ORDER BY a.extension";
    }

    if ($_GET['condition'] === 'search') {
        $sqlquery = "SELECT a.vid_id AS vid_id, 
            a.vid_name AS vid_name, 
            a.extension AS extension
            FROM " . $table . " a
            INNER JOIN " . $table . "_info b
            ON a.vid_id = b.vid_id
            WHERE (a.vid_name LIKE '%" . $_GET['searchFor'] . "%') 
            OR 
            (a.keyword LIKE '%-" . $_GET['searchFor'] . "%' 
                OR 
            a.keyword LIKE '" . $_GET['searchFor'] . "%' 
            OR 
            a.keyword LIKE '%-%" . $_GET['searchFor'] . "%' 
            OR 
            a.keyword LIKE '%" . $_GET['searchFor'] . "%') 
            ORDER BY a.time_duration, a.upload_date DESC LIMIT 20";
    }

    if ($_GET['condition'] === 'history') {
        $table = $_SESSION['department'];
        $sqlquery = "SELECT a.vid_id AS vid_id, 
            a.vid_name AS vid_name, 
            a.extension AS extension 
            FROM " . $table . " a
                INNER JOIN " . $table . "_history b
                ON a.vid_id = b.vid_id 
                WHERE a.extension NOT IN ('pdf','docx','mp3','jpg','jpeg','png','raw') 
                ORDER BY b.watch_date DESC";
    }

    if ($_GET['condition'] === 'latest') {
        $sqlquery = "SELECT a.vid_id AS vid_id, a.vid_name AS vid_name, a.extension AS extension
                FROM " . $table . " a 
                WHERE a.extension NOT IN ('pdf','docx','mp3','jpg','jpeg','png','raw') 
                AND 
                FROM_DAYS(TO_DAYS(upload_date)) 
                BETWEEN 
                    (SELECT FROM_DAYS(TO_DAYS(MAX(upload_date))- 15) FROM " . $table . ") 
                AND 
                    (SELECT FROM_DAYS(TO_DAYS(MAX(upload_date))) FROM " . $table . ") 
                ORDER BY a.upload_date DESC LIMIT 20";
    }

    if ($_GET['condition'] === 'bookmark') {
        $sqlquery = "SELECT a.vid_id AS vid_id, a.vid_name AS vid_name, a.extension AS extension
                FROM " . $table . " a 
                WHERE a.favorite LIKE 
                CONCAT('%',CONCAT(CONCAT(',','" . $_SESSION['user_id'] . "'),'%'))
                ORDER BY a.upload_date DESC LIMIT 20";
    }

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sqlquery)) {
        echo "NOT PREPARED :-" . $stmt->error;
    } else {
        if (!mysqli_stmt_execute($stmt)) {
            echo "NOT EXECUTED :-" . $stmt->error;
        } else {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $folder = '../../data/uploaded_vid/' . $table;
                if ($_GET['condition'] === 'default' && $not_from_department) {
                    echo "<div class='pseudo_holder'>";
                    echo "<button class='pseudo_feature' id='document' value='" . $_SESSION['department_1'] . "'>Access Documents</button>";
                    echo "</div>";
                }
                if ($_GET['condition'] === 'document' && $not_from_department) {
                    echo "<button class='pseudo_feature' id='default' value='" . $_SESSION['department_1'] . "'>Return Back</button>";
                }
                while ($data = mysqli_fetch_assoc($result)) {
                    $vid_full_name = $data['vid_id'] . "." . $data['extension'];
                    $path = $folder . "/" . $vid_full_name;
                    if (strlen($data['vid_name']) > 60) {
                        $vid_name_dis = substr($data['vid_name'], 0, 55) . "...";
                    } else {
                        $vid_name_dis = $data['vid_name'];
                    }

                    $for_document = ['pdf', 'docx', 'jpeg', 'jpg', 'png', 'mp3', 'raw'];

                    if (in_array($data['extension'], $for_document)) {
                        $for_image = ['jpeg', 'jpg', 'png', 'raw', 'gif'];
                        $for_docs = ['pdf', 'docx', 'pptx'];
                        $for_audio = ['mp3', 'wav'];
                        $common_path = '../media/icons';
                        $icon_file = 'not_fixed';
                        echo "<div class='document_holder'>";
                        echo "<a href='" . $path . "' class='document_link' target='_blank'>";
                        if (in_array($data['extension'], $for_image)) {
                            $icon_file = 'image.svg';
                        } elseif (in_array($data['extension'], $for_docs)) {
                            $icon_file = 'pdf.svg';
                        } elseif (in_array($data['extension'], $for_audio)) {
                            $icon_file = 'audio.svg';
                        }
                        echo "<img class='document_img' src='" . $common_path . "/" . $icon_file . "' alt='Icon'";
                        echo "</a>";
                        echo "<p class='document_name_dis'>" . ucfirst($vid_name_dis) . "</p>";
                        echo "</div>";
                    } else {
                        echo "<div class = 'tile'>";
                        echo "<p class='vid_src hidden'>" . $path . "</p>";
                        echo "<video id='" . $data['vid_id'] . "' class='video' src=" . $path . "#t=10,15 type='video/" . $data['extension'] . "' muted></video>";
                        echo "<p class='vid_name hidden'>" . $data['vid_name'] . "</p>";
                        echo "<p class='vid_name_dis'>" . ucfirst($vid_name_dis) . "</p>";
                        echo "</div>";
                    }
                }
                echo "<script defer type='text/javascript' src='../js/tile.js'></script>";
            } else {
                if ($_GET['condition'] === 'document') {
                    $item_name = '<span class="create_focus">documents</span> Have';
                } elseif ($_GET['condition'] === 'search') {
                    $item_name = 'content for <span class="create_focus">' . $_GET['searchFor'] . '</span> Has';
                } else {
                    $item_name = '<span class="create_focus">content</span> Has';
                }
                echo "<p class='error_message'>Seems like :- No " . $item_name . " Been Found :(</p>";
                echo "<div class='pseudo_holder'>";
                if ($not_from_department && $_GET['condition'] === 'document') {
                    echo "<button class='pseudo_feature' id='default' value='" . $_SESSION['department_1'] . "'>Return Back</button>";
                } else {
                    echo "<button class='pseudo_feature' id='default' value='" . $_SESSION['department'] . "'>Return to home</button>";
                }
                echo "</div>";
            }
        }
    }
}
