<!DOCTYPE html>
<html>

<head>
    <title>Log In</title>
    <script src='includes/js/Jquery.js'></script>
    <link rel="stylesheet" href="includes/css/fonts.css">
    <link rel="stylesheet" href="includes/css/login.css">
</head>

<body>
    <div class="left_exit">
        <p class="content_left">V</p>
    </div>
    <div class="right_exit">
        <p class="content_right">Cloud</p>
    </div>
    <div id="log" class="login_page">
        <form method="post" action='includes/php/process_login.php'>
            <h1>LOG IN HERE</h1>
            <label>Email</label>
            <input type="email" name="email" placeholder="Email Id" required>
            <label>Password</label>
            <input type="password" name="password" placeholder="Password" id="login" required>
            <input type="submit" name="lgn_submit" value="LOG IN" id="submit">
            <h5><a href="includes/php/sign_up.php">Sign Up</a></h5>
        </form>
        <div id='message'></div>
        <?php
        if (isset($_GET['login'])) {
            if (isset($_GET['errorCode'])) {
                if ($_GET['errorCode'] == 'empty') {
                    echo "<script>
                                $('#message').html('Please check the input fields');
                            </script>";
                }
                if ($_GET['errorCode'] == 'invalid') {
                    echo "<script>
                                $('#message').html('Please check the Email');
                                $('input[type=email]').val('" . $_GET['email'] . "');
                            </script>";
                }
                if ($_GET['errorCode'] == 'notfound') {
                    echo "<script>
                                $('#message').html('Either Email or Password is incorrect');
                                $('input[type=email]').val('" . $_GET['email'] . "');
                            </script>";
                }
            }
            if (isset($_GET['login']) & !isset($_GET['errorCode'])) {
                echo "<script>
                            $('#message').html('Please login and proceed');
                          </script>";
            }
        }
        if (isset($_GET['signup'])) {
            echo "<script>
                        $('input[type=email]').val('" . $_GET['email'] . "');
                      </script>";
        }
        ?>
    </div>
</body>
<script type="text/javascript" src="includes/js/effect.js"></script>

</html>