<?php
session_start();
include_once('../utils.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

if (!isset($_GET['table'])) {
    header("Location: ../index.php");
    exit;
}


$table = sanitize(mysqli_real_escape_string($db, $_GET['table']));

if ($table == 0) {
    if (!isset($_POST['first_name']) || !isset($_POST['last_name']) || !isset($_POST['login']) || !isset($_POST['password']) || !isset($_POST['role'])) {
        header("Location: ../index.php");
        exit;      
    }
        
    $first_name = sanitize(mysqli_real_escape_string($db, $_POST['first_name']));
    $last_name = sanitize(mysqli_real_escape_string($db, $_POST['last_name']));
    $login = sanitize(mysqli_real_escape_string($db, $_POST['login']));
    $password = md5(sanitize(mysqli_real_escape_string($db, $_POST['password'])));
    $role = sanitize(mysqli_real_escape_string($db, $_POST['role']));
    
    $id = rand(10000000, 99999999);
    $upload_dir = '../img/users/';
    
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photo_path = $upload_dir . basename(strval($id) . '.' . pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
    }
    else {
        $photo_path = $upload_dir . 'default.png';
    }  
    
    if (!add_user($id, $login, $password, $first_name, $last_name, $photo_path, $role)) {
        $_SESSION['error'] = "Произошла ошибка при добавлении пользователя"; 
    }
        
    header("Location: index.php?table=" . $table);
}
else if ($table == 1) {
    if (!isset($_POST['name']) || !isset($_POST['description']) || !isset($_POST['amount']) || !isset($_POST['state']) || !isset($_POST['type']) || !isset($_POST['sport'])) {
        header("Location: ../index.php");
        exit;      
    }
        
    $name = sanitize(mysqli_real_escape_string($db, $_POST['name']));
    $description = sanitize(mysqli_real_escape_string($db, $_POST['description']));
    $amount = sanitize(mysqli_real_escape_string($db, $_POST['amount']));
    $state = sanitize(mysqli_real_escape_string($db, $_POST['state']));
    $type = sanitize(mysqli_real_escape_string($db, $_POST['type']));
    $sport = sanitize(mysqli_real_escape_string($db, $_POST['sport']));
        
    $id = rand(10000000, 99999999);
    $upload_dir = '../img/items/';
    
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photo_path = $upload_dir . basename(strval($id) . '.' . pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
    }
    else {
        $photo_path = $upload_dir . 'default.png';
    }  
    
    if (!add_item($id, $name, $description, $amount, $state, $type, $sport, $photo_path)) {
        $_SESSION['error'] = "Произошла ошибка при добавлении предмета";
    }
        
    header("Location: index.php?table=" . $table);
        
}
else if ($table == 3) {
    if (!isset($_POST['data']) || !isset($_POST['budget'])) {
        header("Location: ../index.php");
        exit;      
    }
        
    $data = sanitize(mysqli_real_escape_string($db, $_POST['data']));
    $budget = sanitize(mysqli_real_escape_string($db, $_POST['budget']));

    $id = rand(10000000, 99999999);
    
    if (!add_order($id, $data, $budget)) {
        $_SESSION['error'] = "Произошла ошибка при добавлении закупки";
    }
        
    header("Location: index.php?table=" . $table);
}
else {
    header("Location: ../index.php");
    exit;
}

?>