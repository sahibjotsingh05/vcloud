<?php
if(isset($_POST['call'])){
	session_start();
	include_once 'connection.php';

	$vid_id = $_POST['vid_id'];
    $sqlquery = 'SELECT * FROM '.$_SESSION['department'].'_history WHERE vid_id=?';
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sqlquery)){
        echo "NOT PREPARED :- ".$stmt->error;
    }else{
        mysqli_stmt_bind_param($stmt, 's', $vid_id);

        if(!mysqli_stmt_execute($stmt)){
            echo "NOT EXECUTED :- ".$stmt->error;
        }else{
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) == 0){
                $secondquery = 'INSERT INTO '.$_SESSION['department'].'_history (vid_id) VALUES (?)';
                $stmt_1 = mysqli_stmt_init($conn);

                if(!mysqli_stmt_prepare($stmt_1, $secondquery)){
                    echo "NOT PREPARED :- ".$stmt_1->error;
                }else{
                    mysqli_stmt_bind_param($stmt_1, 's', $vid_id);

                    if(!mysqli_stmt_execute($stmt_1)){
                        echo "NOT EXECUTED :- ".$stmt_1->error;
                    }else{
                        echo "INSERTED. RECORD CREATED";
                    }
                }
            }else{
                echo "!INSERTED. RECORD EXISTS";
            }
        }
    }
}

// $sqlquery = 'INSERT INTO '.$_SESSION['department_1'].'_history (vid_id) VALUES (?)';


// $sqlquery = 'INSERT INTO '.$_SESSION['department_1'].'_history (vid_id) VALUES (?)';
// $stmt = mysqli_stmt_init($conn);
//
// if(!mysqli_stmt_prepare($stmt, $sqlquery)){
//     echo "NOT PREPARED :- ".$stmt->error;
// }else{
//     mysqli_stmt_bind_param($stmt, 's', $vid_id);
//
//     if(!mysqli_stmt_execute($stmt)){
//         echo "NOT EXECUTED :- ".$stmt->error;
//     }else{
//         echo "success";
//     }
// }
