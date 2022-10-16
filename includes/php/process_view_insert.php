<?php
if(isset($_POST['call'])){
    session_start();
    include_once 'connection.php';
    $vid_id = $_POST['vid_id'];
    $sqlquery = 'SELECT * FROM '.$_SESSION['department'].'_info WHERE vid_id = ? AND first_view = 0';
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sqlquery)){
        echo "STATEMENT NOT PREPARED ERROR MAIN QUERY:-".$stmt->error;
    }else{
        mysqli_stmt_bind_param($stmt, 's', $vid_id);
        if(!mysqli_stmt_execute($stmt)){
            echo "STATEMENT NOT EXECUTED ERROR MAIN QUERY:-".$stmt->error;
        }else{
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result)>0){
                $second_query = 'UPDATE '.$_SESSION['department'].'_info
                SET first_view = 1,
                 no_of_day = no_of_day + 1,
                 view_count = view_count + 1,
                 recent_view = NOW()  
                WHERE vid_id = ?';
            }else{
                $second_query = 'UPDATE '.$_SESSION['department'].'_info
                SET view_count = view_count + 1, recent_view = NOW() WHERE vid_id = ?';
            }
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $second_query)){
                echo "STATEMENT NOT PREPARED ERROR SECOND QUERY:-".$stmt->error;
            }else{
                mysqli_stmt_bind_param($stmt, 's', $vid_id);
                if(!mysqli_stmt_execute($stmt)){
                    echo "STATEMENT NOT EXECUTED ERROR SECOND QUERY:-".$stmt->error;
                }else{
                    echo "INFO UPDATED";
                }
            }
        }
    }
}
