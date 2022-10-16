<?php
session_start();
include_once 'connection.php';

if (isset($_POST['update'])) {
    $vid_id = $_POST['vid_id'];
    $vid_name = $_POST['vid_name'];
    $keyword = $_POST['keyword'];
    $time_duration = floatval($_POST['time_duration']);
    $sqlquery = 'UPDATE ' . $_SESSION['department'] . '
    SET keyword = ?,
    time_duration = ?
    WHERE vid_name = ? && vid_id = ?';
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sqlquery)) {
        echo "NOT PREPARED" . $stmt->error;
    } else {
        $keyword_to_insert = $keyword;
        mysqli_stmt_bind_param($stmt, 'sdss', $keyword_to_insert, $time_duration, $vid_name, $vid_id);
        if (!mysqli_stmt_execute($stmt)) {
            echo "NOT EXECUTED" . $stmt->error;
        } else {
            echo "updated";
        }
    }
}
