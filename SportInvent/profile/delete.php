<?php
session_start();
include_once('../utils.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['user_id'];

if (!delete_user($id)) {
    $_SESSION['error'] = "Произошла ошибка при удалении профиля";
}

header("Location: index.php");