<?php
if (isset($_POST['submit'])) {
    include_once 'connection.php';
    //VARIABLES
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $hod = mysqli_real_escape_string($conn, $_POST['hod']);
    if (empty($name) || empty($email) || empty($password) || empty($department)) {  //Checking if the fields are empty
        header("Location: sign.php?signup=empty");
        exit();
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  //Validating Email
            header("Location: sign.php?signup=invalid&name=" . $name . "&value=" . $department);
            exit();
        } else {
            $sqlquery = "INSERT INTO user_account(user_id, name, email, user_pass, dept_id, hod) VALUES(?,?,?,?,?,?);";
            $stmt = mysqli_stmt_init($conn); //INITIALIZING CONNECTION

            if (!mysqli_stmt_prepare($stmt, $sqlquery)) {  //CHECKING IF THE STATMENT IS PREPARED OR NOT.
                echo ("STATEMENT NOT PREPARED" . $stmt->error);
                exit();
            } else {
                //GENERATING A RANDOM ID
                $user_id = 'dav'.mt_rand(0, 47).mt_rand(0, 4747); 

                //BINDING PARAMETERS TO THE PREPARED STATEMENT
                mysqli_stmt_bind_param($stmt, 'ssssii', $user_id, $name, $email, $password, $department, $hod);

                if (!mysqli_stmt_execute($stmt)) { //EXECUTING STATEMENT
                    echo ("STATEMENT NOT EXECUTED" . $stmt->error);
                    exit();
                } else {
                    header("Location: ../../index.php?signup=success&email=".$email);
                    exit();
                }
            }
        }
    }
}
