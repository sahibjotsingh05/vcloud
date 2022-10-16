<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script defer src="../js/Jquery.js"></script>
    <meta charset="UTF-8">
    <title>keyword_pending</title>
    <link type="text/css" rel="stylesheet" href="../css/fonts.css">
    <link type="text/css" rel="stylesheet" href="../css/style.css">
    <link type="text/css" rel="stylesheet" href="../css/keyword.css">
    <link type='text/css' rel='stylesheet' href="../css/header.css">
    <link type='text/css' rel='stylesheet' href="../css/navigation.css">
</head>

<body>
    <aside>
        <?php include_once 'navigation.php'; ?>
    </aside>
    <header>
        <?php include_once 'header.php'; ?>
    </header>
    <?php include_once 'process_keyword_pending.php'; ?>
</body>
<script defer src='../js/keyword_update.js'></script>
<script defer type="text/javascript" src='../js/reaction.js'></script>
<script defer type="text/javascript" src='../js/redirect.js'></script>

</html>