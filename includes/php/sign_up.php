<!DOCTYPE html>
<html>

<head>
    <title>Log In</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <div id="log">
        <form method="post" action='process_signup.php'>
            <h1>REGISTER HERE</h1>
            <label>Name</label>
            <input type="text" name="name" placeholder="Name">
            <label>Email</label>
            <input type="text" name="email" placeholder="Email Id">
            <label>Password</label>
            <input type="password" name="password" placeholder="Password">
            <label>Department</label>
            <select name = 'department'>
                <option>Select your department</option>
                 <!-- FOR DEPARTMENT(s) -->
                <?php include_once 'process_subject.php'; ?>
                <!----------------->
            </select>
            <select name = 'hod'>
                <option>Are you HOD?</option>
                <option value=1>Yes</option>
                <option value=0>No</option>
            </select>
            <input type="submit" name="submit" value="SIGN UP" id="submit">
            <h5><a href="../../index.php">Log In</a></h5>
        </form>
        <div id='message'></div>
        <?php
        if (isset($_GET['signup'])) {
            if ($_GET['signup'] == 'empty') {
                echo "<script>
                        $('#message').html('Please check the input fields');
                    </script>";
            }
            if ($_GET['signup'] == 'invalid') {
                echo "<script>
                        $('#message').html('Please check the Email');
                        $('input[type=email]').val('" . $_GET['name'] . "');
                    </script>";
            }
        }
        ?>
    </div>
</body>

</html>
