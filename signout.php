<?php
//signin.php
include 'connect.php';
include 'header.php';

session_destroy();

header("Location: signin.php");
    exit();



?>
