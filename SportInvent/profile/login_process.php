<?php
session_start();
include_once('../utils.php');

if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = sanitize(mysqli_real_escape_string($db, $_POST['login']));
    $password = md5(sanitize(mysqli_real_escape_string($db, $_POST['password'])));

    $user = get_user_by_login($login);

    if (!$user || $user['password'] != $password) {
        $_SESSION['error'] = "Неверный логин или пароль";
        header("Location: login.php");
        exit();
    }
        
    $_SESSION['user_id'] = $user['id'];
    if (isset($_POST['remember_me'])) {
        setcookie('user_id', $user['id'], time() + (86400 * 30), "/");
    }

    header("Location: index.php");
}
?>