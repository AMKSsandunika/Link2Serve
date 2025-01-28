<?php
include 'connect.php';

if (!isset($_COOKIE['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

$user_id = $_COOKIE['user_id'];

$select_unread_messages = $conn->prepare("SELECT COUNT(*) as unread_count FROM `chats` WHERE receiver = ? AND status = 'unread'");
$select_unread_messages->execute([$user_id]);
$unread_messages = $select_unread_messages->fetch(PDO::FETCH_ASSOC);

echo json_encode(['status' => 'success', 'unread_count' => $unread_messages['unread_count']]);
?>
