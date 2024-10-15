<?php
session_start();
error_reporting(0);

$_SESSION['auth_user'] = '';
header("Location: login.php");
?>