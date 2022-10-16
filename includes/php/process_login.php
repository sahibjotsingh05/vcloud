<?php
if (isset($_POST['lgn_submit'])) {
    session_start();
    include_once 'connection.php';
    $email = mysqli_real_escape_string($conn, $_POST['email']); //GETTING VALUES AND CLEARING SPACES
    $password = mysqli_real_escape_string($conn, $_POST['password']); //GETTING VALUES AND CLEARING SPACES

    if (empty($email) || empty($password)) {  //Checking if the fields are empty
        header("Location: ../../index.php?login=false&errorCode=empty&email=" . $email);
        exit();
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  //VALIDATING EMAIL
            header("Location: ../../index.php?login=false&errorCode=invalid&email=" . $email);
            exit();
        } else {
            $sqlquery = "SELECT a.user_id AS 'user_id', a.name AS 'name',
             a.dept_id AS 'dept_id',
             a.user_pass AS 'password',
             a.hod AS 'hod_status',
             b.name AS 'department'
            FROM user_account a
            INNER JOIN department b
            ON a.dept_id = b.id
            WHERE a.email = ?";
            $stmt = mysqli_stmt_init($conn); //INITIALIZING CONNECTION

            if (!mysqli_stmt_prepare($stmt, $sqlquery)) { //CHECKING IF THE STATMENT IS PREPARED OR NOT.
                echo "NOT PREPARED FIRST QUERY" . $stmt->error;
                exit();
            } else {
                //BINDING PARAMETERS TO THE PREPARED STATEMENT
                mysqli_stmt_bind_param($stmt, 's', $email);

                if (!mysqli_stmt_execute($stmt)) { //EXECUTING STATEMENT
                    echo "NOT EXECUTED FIRST QUERY" . $stmt->error;
                    exit();
                } else {
                    $result = mysqli_stmt_get_result($stmt); //FETCHING RESULT
                    if (mysqli_num_rows($result) > 0) {
                        $data = mysqli_fetch_assoc($result);
                        if ($password == $data['password']) {
                            $_SESSION['login'] = true; //LOGIN SESSION==TRUE
                            $_SESSION['lg_email'] = $email;
                            $_SESSION['name'] = $data['name'];
                            $_SESSION['dept_id'] = $data['dept_id'];
                            $_SESSION['department'] = $data['department'];
                            $_SESSION['user_id'] = $data['user_id'];
                            if ($data['hod_status'] == 1) {
                                $_SESSION['hod_status'] = $data['hod_status'];
                            }
                            // POST CHECKING THE PASSWORD
                            $second_query = 'SELECT update_detail() AS returned';
                            $stmt = mysqli_stmt_init($conn); //INITIALIZING CONNECTION

                            if (!mysqli_stmt_prepare($stmt, $second_query)) { //CHECKING IF THE STATMENT IS PREPARED OR NOT.
                                echo "NOT PREPARED SECOND QUERY" . $stmt->error;
                                exit();
                            } else {
                                if (!mysqli_stmt_execute($stmt)) { //EXECUTING STATEMENT
                                    echo "NOT EXECUTED SECOND QUERY" . $stmt->error;
                                    exit();
                                } else {
                                    $result = mysqli_stmt_get_result($stmt);
                                    $data = mysqli_fetch_assoc($result);

                                    if($data['returned']){
                                        $third_query = 'SELECT name AS department_name FROM department';
                                        $stmt = mysqli_stmt_init($conn); //INITIALIZING CONNECTION

                                        if (!mysqli_stmt_prepare($stmt, $third_query)) { //CHECKING IF THE STATMENT IS PREPARED OR NOT.
                                            echo "NOT PREPARED THIRD QUERY" . $stmt->error;
                                            exit();
                                        } else {
                                            if (!mysqli_stmt_execute($stmt)) { //EXECUTING STATEMENT
                                                echo "NOT EXECUTED THIRD QUERY" . $stmt->error;
                                                exit();
                                            } else {
                                                $result = mysqli_stmt_get_result($stmt);
                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($data = mysqli_fetch_assoc($result)) {
                                                        $fourth_query = 'UPDATE ' . $data['department_name'] . '_info SET first_view = 0';
                                                        $stmt = mysqli_stmt_init($conn); //INITIALIZING CONNECTION

                                                        if (!mysqli_stmt_prepare($stmt, $fourth_query)) { //CHECKING IF THE STATMENT IS PREPARED OR NOT.
                                                            echo "NOT PREPARED FOURTH QUERY" . $stmt->error;
                                                            exit();
                                                        } else {
                                                            if (!mysqli_stmt_execute($stmt)) { //EXECUTING STATEMENT
                                                                echo "NOT EXECUTED FOURTH QUERY" . $stmt->error;
                                                                exit();
                                                            } else { }
                                                        }
                                                    }
                                                    header("Location: content.php?show=" . $_SESSION['department'] . "&condition=default&firstlogin");
                                                    exit();
                                                }
                                            }
                                        }
                                    }else{
                                        header("Location: content.php?show=" . $_SESSION['department'] . "&condition=default&!firstlogin");
                                        exit();
                                    }
                                }
                            }
                        } else {
                            header("Location: ../../index.php?login=false&errorCode=notfound&email=" . $email);
                            exit();
                        }
                    } else {
                        header("Location: ../../index.php?login=false&errorCode=notfound&email=" . $email);
                        exit();
                    }
                }
            }
        }
    }
} else {
    header("Location: ../../index.php");
}


// header("Location: content.php?show=".$_SESSION['department']."&condition=default");
// exit();
