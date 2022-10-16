<?php
session_start();
if (isset($_SESSION['login'])) {
	if (!$_SESSION['login']) {
		header('Location: ../../index.php?login=false');
		exit();
	}
} else {
	header('Location: ../../index.php?login=false');
	exit();
}
?>

<!DOCTYPE html>
<html>

<head>
	<script defer src='../js/Jquery.js'></script>
	<title>VCloud</title>
	<!-- <link href='https://fonts.googleapis.com/css2?family=Acme' rel='stylesheet'> -->
	<link href='../css/fonts.css' type='text/css' rel='stylesheet'>
	<link href='../css/style.css' type='text/css' rel='stylesheet'>
	<link href='../css/header.css' type='text/css' rel='stylesheet'>
	<link href='../css/navigation.css' type='text/css' rel='stylesheet'>
</head>

<body>
	<aside>
		<?php include_once 'navigation.php'; ?>
	</aside>
	<header>
		<?php include_once 'header.php'; ?>
	</header>
	<main>
		<div class='tiles'>
			<?php include_once 'process_display_algorithm.php'; ?>
		</div>
		<div class='stage'></div>
	</main>
</body>
<script defer type='text/javascript' src='../js/reaction.js'></script>

</html>
<!-- <script type='text/javascript' src='../js/redirect.js'></script> -->