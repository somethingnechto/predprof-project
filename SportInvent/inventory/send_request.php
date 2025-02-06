<?php
session_start();
include_once('../utils.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

if (!isset($_GET['item_id']) || !isset($_POST['amount'])) {
    header("Location: ../index.php");
    exit;      
}
        
$item_id = sanitize(mysqli_real_escape_string($db, $_GET['item_id']));
$amount = sanitize(mysqli_real_escape_string($db, $_POST['amount']));

if (isset($_POST['comment'])) {
	$comment = sanitize(mysqli_real_escape_string($db, $_POST['comment']));
}
else {
    $comment = NULL;
}

$item = get_item_by_id($item_id);
if ($item['amount'] < $amount) {
    $_SESSION['error'] = "Вы не можете запросить больше предметов чем есть в наличии";
    header("Location: item.php?id=" . $item_id);
    exit();
}
    
$id = rand(10000000, 99999999);
if (!add_request($id, $_SESSION['user_id'], $item_id, $comment, $amount)) {
	$_SESSION['error'] = "Произошла ошибка при отправке заявки"; 
}
else {
	$_SESSION['success'] = "Заявка успешно отправлена"; 
}
        
header("Location: item.php?id=" . $item_id);
?>