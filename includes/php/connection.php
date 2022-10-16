<?php
//ONLY FOR CONNECTION
$host = $_SERVER['HTTP_HOST'];
$db = 'vcloud';
$uname = 'root';
$pass = '';

$conn = mysqli_connect($host, $uname, $pass, $db);

if (!$conn) {
	echo "UNABLE TO CONNECT TO DATABASE. ERROR:-" . mysqli_connect_error();
}
