<?php
session_start();
include_once('../utils.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_POST['first_name']) || !isset($_POST['last_name'])) {
	header("Location: ../index.php");
    exit;      
}

$first_name = sanitize(mysqli_real_escape_string($db, $_POST['first_name']));
$last_name = sanitize(mysqli_real_escape_string($db, $_POST['last_name']));
$id = $_SESSION['user_id'];   
$user = get_user_by_id($id);
            
$upload_dir = '../img/users/';
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $photo_path = $upload_dir . basename(strval($id) . '.' . pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
    move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
}
    
if (!update_user($id, $first_name, $last_name, $user['login'], (isset($photo_path)) ? $photo_path : $user['photo'], $user['role'])) {
    $_SESSION['error'] = "Произошла ошибка при изменении профиля";
}

header("Location: index.php");