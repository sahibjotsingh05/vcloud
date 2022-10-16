<?php
//session_start();
include_once 'connection.php';
$sqlquery = "SELECT vid_id, vid_name, extension FROM " . $_SESSION['department'] . " WHERE keyword = 'pending' OR keyword = ''";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sqlquery)) {
    echo ' STATMENT NOT PREPARED' . $stmt->error;
} else {
    if (!mysqli_stmt_execute($stmt)) {
        echo 'STAMENT NOT EXECUTED' . $stmt->error;
    } else {
        $vid_result_get = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($vid_result_get) > 0) {
            echo "<p class='message'>Please Input the keywords for the following</p>";
            $for_document = ['pdf', 'docx', 'jpeg', 'jpg', 'png', 'mp3', 'raw'];
            $folder = '../../data/uploaded_vid/' . $_SESSION['department'];
            while ($data = mysqli_fetch_assoc($vid_result_get)) {
                $name = $data['vid_id'] . "." . $data['extension'];
                $path = $folder . "/" . $name;
                if (strlen($data['vid_name']) > 60) {
                    $vid_name_dis = substr($data['vid_name'], 0, 55) . "...";
                } else {
                    $vid_name_dis = $data['vid_name'];
                }
                echo "<div class='test'>";
                echo "<p class='vid_name hidden'>" . $data['vid_name'] . "</p>";
                echo "<p class='vid_name_dis'>" . $vid_name_dis . "</p>";
                if (in_array($data['extension'], $for_document)) {
                    $for_image = ['jpeg', 'jpg', 'png', 'raw', 'gif'];
                    $for_docs = ['pdf', 'docx', 'pptx'];
                    $for_audio = ['mp3'];
                    $common_path = '../media/icons';
                    $icon_file = 'not_fixed';
                    echo "<a href='" . $path . "' content_type='document' class='video document_link' id='" . $data['vid_id'] . "' target='_blank'>";
                    if (in_array($data['extension'], $for_image)) {
                        $icon_file = 'image.svg';
                    } elseif (in_array($data['extension'], $for_docs)) {
                        $icon_file = 'pdf.svg';
                    } elseif (in_array($data['extension'], $for_audio)) {
                        $icon_file = 'audio.svg';
                    }
                    echo "<img class='document_img' src='" . $common_path . "/" . $icon_file . "' alt='Icon'>";
                    echo "</a>";
                } else {
                    echo "<video content_type='video' type='video/" . $data['extension'] . "' id='" . $data['vid_id'] . "' class='video' src=" . $path . " controls></video>";
                }
                echo "<input type='text' id='keyword' placeholder='Enter Keywords Maximum 5. Use - to separate' name='keywords'>
                          <button class='update' type='submit'>PROCEED</button>";
                echo "</div>";
            }
        } else {
            echo "<p class='message'>Good Job, You wrote all the keywords</p>";
        }
    }
}
