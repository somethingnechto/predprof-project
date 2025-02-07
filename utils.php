<?php
$db = mysqli_connect("***", "***", "***", "***");

function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function state_to_text($state) {
    switch ($state) {
        case 1:
            return 'Новый';
        case 2:
           	return 'Б/у'; 
        case 3:
            return 'Повреждённый';
        default:
        	return 'Не задано';
    }
}

function role_to_text($role) {
    switch ($role) {
        case 1:
        	return 'Администратор';
        default:
           	return 'Пользователь'; 
    }
}

function status_to_text($status) {
    switch ($status) {
        case 0:
        	return 'Отклонена';
        case 2:
           	return 'Принята';
        default:
            return 'На рассмотрении';
    }
}

function add_user($id, $login, $password, $first_name, $last_name, $photo='../img/users/default.png', $role=0) {
    global $db;
    $sql = mysqli_query($db, "SELECT * FROM `users` WHERE `login` = '$login'");
    if (mysqli_num_rows($sql) > 0) {
        return false;
    }
    
    mysqli_query($db, "INSERT INTO `users` VALUES ($id, '$first_name', '$last_name', '$login', '$password', '$photo', $role)");

    return $id;
}

function add_item($id, $name, $description, $amount, $state, $type = 0, $sport = 0, $photo='../img/items/default.png') {
    global $db;
    mysqli_query($db, "INSERT INTO `items` VALUES ($id, '$name', '$description', $amount, $state, $type, $sport, '$photo')");

    return $id;
}

function add_request($id, $user_id, $item_id, $comment, $amount) {
    global $db;
    mysqli_query($db, "INSERT INTO `requests` VALUES ($id, $user_id, $item_id, '$comment', $amount, 1, now())");

    return $id;
}

function add_order($id, $data, $budget) {
    global $db;
    mysqli_query($db, "INSERT INTO `orders` VALUES ($id, '$data', $budget, now())");

    return $id;
}

function get_user_by_id($id) {
    global $db;
    $sql = mysqli_query($db, "SELECT * FROM `users` WHERE `id`=$id");
    if (mysqli_num_rows($sql) == 0) {
        return false;
    }
    else {
        return mysqli_fetch_assoc($sql);
    }
}

function get_user_by_login($login) {
    global $db;
    $sql = mysqli_query($db, "SELECT * FROM `users` WHERE `login`='$login'");
    if (mysqli_num_rows($sql) == 0) {
        return false;
    }
    else {
        return mysqli_fetch_assoc($sql);
    }
}

function get_item_by_id($id) {
    global $db;
    $sql = mysqli_query($db, "SELECT * FROM `items` WHERE `id`=$id");
    if (mysqli_num_rows($sql) == 0) {
        return false;
    }
    else {
        return mysqli_fetch_assoc($sql);
    }
}

function get_request_by_id($id) {
    global $db;
    $sql = mysqli_query($db, "SELECT * FROM `requests` WHERE `id`='$id'");
    if (mysqli_num_rows($sql) == 0) {
        return false;
    }
    else {
        return mysqli_fetch_assoc($sql);
    }
}

function get_users() {
    global $db;
    $sql = mysqli_query($db, "SELECT * FROM `users`");
        
    return $sql;
}

function get_items() {
    global $db;
    $sql = mysqli_query($db, "SELECT * FROM `items`");
        
    return $sql;
}

function get_requests() {
    global $db;
    $sql = mysqli_query($db, "SELECT * FROM `requests`");
        
    return $sql;
}

function get_user_requests($user_id) {
    global $db;
    $sql = mysqli_query($db, "SELECT * FROM `requests` WHERE `user_id`=$user_id");
        
    return $sql;
}

function get_orders() {
    global $db;
    $sql = mysqli_query($db, "SELECT * FROM `orders`");
        
    return $sql;
}

function update_user($id, $first_name, $last_name, $login, $photo, $role) {
    global $db;
    if (mysqli_query($db, "UPDATE `users` SET `first_name`='$first_name', `last_name`='$last_name', `login`='$login', `photo`='$photo', `role`=$role WHERE `id`=$id")) {
        return true;
    }
    else {
        return false;
    }
}

function delete_user($id) {
    global $db;
    if (mysqli_query($db, "DELETE FROM `users` WHERE `id`=$id")) {
        return true;
    }
    else {
        return false;
    }
}

function update_item($id, $name, $description, $amount, $state, $type, $sport, $photo) {
    global $db;
    if (mysqli_query($db, "UPDATE `items` SET `name`='$name', `description`='$description', `amount`=$amount, `state`=$state, `type`=$type, `sport`=$sport, `photo`='$photo' WHERE `id`=$id")) {
        return true;
    }
    else {
        return false;
    }
}

function delete_item($id) {
    global $db;
    if (mysqli_query($db, "DELETE FROM `items` WHERE `id`=$id")) {
        return true;
    }
    else {
        return false;
    }
}

function update_request($id, $status) {
    global $db;
    if (mysqli_query($db, "UPDATE `requests` SET `status`='$status' WHERE `id`=$id")) {
        return true;
    }
    else {
        return false;
    }
}

function delete_request($id) {
    global $db;
    if (mysqli_query($db, "DELETE FROM `requests` WHERE `id`=$id")) {
        return true;
    }
    else {
        return false;
    }
}

function update_order($id, $data, $budget) {
    global $db;
    if (mysqli_query($db, "UPDATE `orders` SET `data`='$data', `budget`=$budget WHERE `id`=$id")) {
        return true;
    }
    else {
        return false;
    }
}

function delete_order($id) {
    global $db;
    if (mysqli_query($db, "DELETE FROM `orders` WHERE `id`=$id")) {
        return true;
    }
    else {
        return false;
    }
}
?>