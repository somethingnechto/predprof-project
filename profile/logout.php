<?php
session_start();

if (isset($_COOKIE['user_id'])) {
    setcookie('user_id', '', time() - 3600, "/");
    unset($_COOKIE['user_id']);
}

if (isset($_SESSION['user_id'])) {
    unset($_SESSION['user_id']);
}

header("Location: ../index.php");
exit;
?>