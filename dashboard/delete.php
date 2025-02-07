<?php
session_start();
include_once('../utils.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

if (!isset($_GET['table']) || !isset($_GET['id'])) {
    header("Location: ../index.php");
    exit;
}


$table = sanitize(mysqli_real_escape_string($db, $_GET['table']));
$id = sanitize(mysqli_real_escape_string($db, $_GET['id']));

if ($table == 0) {
    if (!delete_user($id)) {
        $_SESSION['error'] = "Произошла ошибка при удалении пользователя"; 
    }
        
    header("Location: index.php?table=" . $table);
}
else if ($table == 1) {
    if (!delete_item($id)) {
        $_SESSION['error'] = "Произошла ошибка при удалении предмета"; 
    }
        
    header("Location: index.php?table=" . $table);
}
else if ($table == 2) {
    if (!delete_request($id)) {
        $_SESSION['error'] = "Произошла ошибка при удалении заявки"; 
    }
        
    header("Location: index.php?table=" . $table);
}
else if ($table == 3) {
    if (!delete_order($id)) {
        $_SESSION['error'] = "Произошла ошибка при удалении закупки"; 
    }
        
    header("Location: index.php?table=" . $table);
}
else {
    header("Location: ../index.php");
    exit;
}
?>