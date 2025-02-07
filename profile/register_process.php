<?php
session_start();
include_once('../utils.php');

if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['first_name']) && isset($_POST['last_name'])) {
    $login = sanitize(mysqli_real_escape_string($db, $_POST['login']));
    $password = sanitize(mysqli_real_escape_string($db, $_POST['password']));
    $first_name = sanitize(mysqli_real_escape_string($db, $_POST['first_name']));
    $last_name = sanitize(mysqli_real_escape_string($db, $_POST['last_name']));
        
    if (preg_match('/[^A-Za-z0-9]/', $login)) {
        $_SESSION['error'] = "Логин должен содержать только английские буквы и цифры";
        header("Location: register.php");
        exit();
	}
        
    if (strlen($login) < 5) {
        $_SESSION['error'] = "Длина логина должна быть не менее 5 символов";
        header("Location: register.php");
        exit();
    }
        
    if (strlen($password) < 5) {
        $_SESSION['error'] = "Длина пароля должна быть не менее 5 символов";
        header("Location: register.php");
        exit();
    }
    
    $password = md5($password);

    $id = rand(10000000, 99999999);
    if (!add_user($id, $login, $password, $first_name, $last_name)) {
        $_SESSION['error'] = "Пользователь с таким логином уже существует";
        header("Location: register.php");
        exit();
        
    }
        
    header("Location: login.php");
}
?>