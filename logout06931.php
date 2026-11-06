<?php
session_start();

$_SESSION = [];

session_destroy();

header('Location: login06931.php');
exit();
?>
